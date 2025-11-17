<?php
require_once '../config.php';
require_once '../includes/functions.php';
require_once '../includes/rank_functions.php';

// Garantir que a sessão está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? 'get';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

global $conn;

// Não tentar criar/verificar tabela aqui - deve ser criada manualmente via SQL
// Apenas garantir charset da conexão
$conn->query("SET NAMES 'utf8mb4'");
$conn->query("SET CHARACTER SET utf8mb4");

if ($action === 'send') {
    if (!isLoggedIn()) {
        echo json_encode(['success' => false, 'message' => 'Você precisa estar logado para enviar tweets']);
        exit;
    }
    
    // Verificar se o usuário está bloqueado do chat
    $stmt_check = $conn->prepare("SELECT Status FROM gunwcuser WHERE Id = ?");
    $stmt_check->bind_param("s", $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($row_check = $result_check->fetch_assoc()) {
        // Status = '2' significa bloqueado do chat
        if ($row_check['Status'] == '2') {
            $stmt_check->close();
            echo json_encode(['success' => false, 'message' => 'Você está bloqueado do chat. Entre em contato com um administrador.']);
            exit;
        }
    }
    $stmt_check->close();
    
    $message = trim($_POST['message'] ?? '');
    
    if (empty($message)) {
        echo json_encode(['success' => false, 'message' => 'A mensagem não pode estar vazia']);
        exit;
    }
    
    if (strlen($message) > 100) {
        echo json_encode(['success' => false, 'message' => 'A mensagem não pode ter mais de 100 caracteres']);
        exit;
    }
    
    // Verificar se o usuário tem cash suficiente (10000 cash por mensagem)
    $cash_cost = 10000;
    $stmt_cash = $conn->prepare("SELECT Cash FROM cash WHERE ID = ?");
    $stmt_cash->bind_param("s", $user_id);
    $stmt_cash->execute();
    $result_cash = $stmt_cash->get_result();
    
    $current_cash = 0;
    if ($row_cash = $result_cash->fetch_assoc()) {
        $current_cash = intval($row_cash['Cash'] ?? 0);
    }
    $stmt_cash->close();
    
    if ($current_cash < $cash_cost) {
        echo json_encode([
            'success' => false, 
            'message' => "Você precisa de {$cash_cost} cash para enviar uma mensagem. Você possui {$current_cash} cash."
        ]);
        exit;
    }
    
    // Buscar nickname do usuário
    $user_info = getUserInfo($user_id);
    $nickname = $user_info['Nickname'] ?? $user_info['NickName'] ?? $user_id;
    
    // Iniciar transação para garantir que tanto o tweet quanto a dedução de cash aconteçam juntos
    $conn->begin_transaction();
    
    try {
        // Inserir tweet
        $stmt = $conn->prepare("INSERT INTO tweets (user_id, nickname, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_id, $nickname, $message);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir tweet: " . $stmt->error);
        }
        $stmt->close();
        
        // Deduzir cash do usuário
        $new_cash = $current_cash - $cash_cost;
        $stmt_update = $conn->prepare("UPDATE cash SET Cash = ? WHERE ID = ?");
        $stmt_update->bind_param("is", $new_cash, $user_id);
        
        if (!$stmt_update->execute()) {
            throw new Exception("Erro ao deduzir cash: " . $stmt_update->error);
        }
        $stmt_update->close();
        
        // Commit da transação
        $conn->commit();
        
        // Registrar gasto de cash e atualizar missões
        require_once '../includes/mission_functions.php';
        recordCashSpending($user_id, $cash_cost, 'Envio de tweet');
        updateMissionProgress($user_id, 'send_tweets', 1);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Tweet enviado com sucesso!',
            'cash_remaining' => $new_cash
        ]);
        exit;
        
    } catch (Exception $e) {
        // Rollback em caso de erro
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Erro ao enviar tweet: ' . $e->getMessage()]);
        exit;
    }
    
} else {
    // Buscar tweets (últimos 50)
    try {
        $limit = intval($_GET['limit'] ?? 50);
        $limit = min(max($limit, 1), 100); // Limitar entre 1 e 100
        
        // Converter explicitamente os campos para UTF8 antes do JOIN para evitar erro de collation
        // Buscar também a foto de perfil do usuário
        $stmt = $conn->prepare("SELECT t.*, g.TotalScore, g.TotalRank, gw.imagem_perfil 
                                FROM tweets t 
                                LEFT JOIN game g ON CONVERT(t.user_id USING utf8mb4) = CONVERT(g.Id USING utf8mb4)
                                LEFT JOIN gunwcuser gw ON CONVERT(t.user_id USING utf8mb4) = CONVERT(gw.Id USING utf8mb4)
                                ORDER BY t.created_at DESC LIMIT ?");
        if (!$stmt) {
            throw new Exception("Erro ao preparar query: " . $conn->error);
        }
        
        $stmt->bind_param("i", $limit);
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar query: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        
        $tweets = [];
        while ($row = $result->fetch_assoc()) {
            // Calcular rank do usuário
            $gp = intval($row['TotalScore'] ?? 0);
            $rank_info = getCurrentRank($gp);
            
            $tweets[] = [
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'nickname' => $row['nickname'],
                'message' => $row['message'],
                'created_at' => $row['created_at'],
                'rank_name' => $rank_info['name'] ?? 'Sem Rank',
                'rank_grade' => $rank_info['grade'] ?? -4,
                'rank_image' => getRankImageName($rank_info['grade'] ?? -4),
                'profile_image' => $row['imagem_perfil'] ?? ''
            ];
        }
        $stmt->close();
        
        echo json_encode([
            'success' => true,
            'tweets' => $tweets
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        
    } catch (Exception $e) {
        error_log("Erro ao buscar tweets: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao carregar tweets: ' . $e->getMessage(),
            'tweets' => []
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
?>

