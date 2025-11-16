<?php
require_once '../config.php';
require_once '../includes/functions.php';

// Garantir que a sessão está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Você precisa estar logado para resgatar tokens']);
    exit;
}

$user_id = $_SESSION['user_id'];
$token_code = trim($_POST['token_code'] ?? '');

if (empty($token_code)) {
    echo json_encode(['success' => false, 'message' => 'Código do token é obrigatório']);
    exit;
}

global $conn;

try {
    // Buscar token - tentar primeiro por token_code, depois por token
    $stmt = $conn->prepare("SELECT * FROM tokens WHERE token_code = ? OR token = ?");
    $stmt->bind_param("ss", $token_code, $token_code);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $stmt->close();
        echo json_encode(['success' => false, 'message' => 'Token inválido ou não encontrado']);
        exit;
    }
    
    $token = $result->fetch_assoc();
    $stmt->close();
    
    // Verificar se token expirou
    if ($token['expires_at'] && strtotime($token['expires_at']) < time()) {
        echo json_encode(['success' => false, 'message' => 'Este token expirou']);
        exit;
    }
    
    // Verificar se ainda tem usos disponíveis
    $stmt = $conn->prepare("SELECT COUNT(*) as used FROM token_logs WHERE token_id = ?");
    $stmt->bind_param("i", $token['id']);
    $stmt->execute();
    $used_result = $stmt->get_result();
    $used_data = $used_result->fetch_assoc();
    $times_used = $used_data['used'] ?? 0;
    $stmt->close();
    
    if ($times_used >= $token['uses_left']) {
        echo json_encode(['success' => false, 'message' => 'Este token já foi usado todas as vezes disponíveis']);
        exit;
    }
    
    // Verificar se o usuário já resgatou este token
    $stmt = $conn->prepare("SELECT id FROM token_logs WHERE token_id = ? AND redeemed_by = ?");
    $stmt->bind_param("is", $token['id'], $user_id);
    $stmt->execute();
    $already_redeemed = $stmt->get_result();
    if ($already_redeemed->num_rows > 0) {
        $stmt->close();
        echo json_encode(['success' => false, 'message' => 'Você já resgatou este token']);
        exit;
    }
    $stmt->close();
    
    // Iniciar transação
    $conn->begin_transaction();
    
    try {
        $chest_id = null;
        
        // Processar recompensa baseado no tipo
        if ($token['type'] === 'cash') {
            // Adicionar cash
            $stmt = $conn->prepare("SELECT Cash FROM cash WHERE ID = ?");
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $cash_result = $stmt->get_result();
            $token_quantity = $token['quantity'] ?? $token['value'] ?? 1;
            if ($cash_row = $cash_result->fetch_assoc()) {
                $new_cash = ($cash_row['Cash'] ?? 0) + $token_quantity;
                $stmt->close();
                $stmt = $conn->prepare("UPDATE cash SET Cash = ? WHERE ID = ?");
                $stmt->bind_param("is", $new_cash, $user_id);
            } else {
                $stmt->close();
                $stmt = $conn->prepare("INSERT INTO cash (ID, Cash) VALUES (?, ?)");
                $stmt->bind_param("si", $user_id, $token_quantity);
            }
            $stmt->execute();
            $stmt->close();
            
        } elseif ($token['type'] === 'gold') {
            // Adicionar gold
            $token_quantity = $token['quantity'] ?? $token['value'] ?? 1;
            $stmt = $conn->prepare("UPDATE game SET Money = Money + ? WHERE Id = ?");
            $stmt->bind_param("is", $token_quantity, $user_id);
            $stmt->execute();
            $stmt->close();
            
        } elseif ($token['type'] === 'avatar' || $token['type'] === 'item') {
            // Inserir item no CHEST
            $expire_date = null;
            if ($token['expire_days'] && $token['expire_days'] > 0) {
                $expire_date = date('Y-m-d H:i:s', strtotime('+' . $token['expire_days'] . ' days'));
            }
            
            // Obter quantidade do token (pode ser 'quantity' ou 'value')
            $item_quantity = $token['quantity'] ?? $token['value'] ?? 1;
            
            // Inserir múltiplos itens se quantity > 1
            // Cada item individual tem Volume = 1 na tabela CHEST
            for ($i = 0; $i < $item_quantity; $i++) {
                $stmt = $conn->prepare("INSERT INTO chest (Owner, Item, Wearing, Acquisition, Volume, Expire, ExpireType) VALUES (?, ?, '0', 'G', 1, ?, 'W')");
                $stmt->bind_param("sis", $user_id, $token['item_id'], $expire_date);
                $stmt->execute();
                if ($i == 0) {
                    $chest_id = $conn->insert_id;
                }
                $stmt->close();
            }
        }
        
        // Registrar log de resgate
        $stmt = $conn->prepare("INSERT INTO token_logs (token_id, token_code, redeemed_by, item_inserted, chest_id) VALUES (?, ?, ?, ?, ?)");
        $item_inserted = ($token['type'] === 'avatar' || $token['type'] === 'item') ? 1 : 0;
        $stmt->bind_param("issii", $token['id'], $token_code, $user_id, $item_inserted, $chest_id);
        $stmt->execute();
        $stmt->close();
        
        // Commit
        $conn->commit();
        
        $reward_text = '';
        $token_quantity = $token['quantity'] ?? $token['value'] ?? 1;
        if ($token['type'] === 'cash') {
            $reward_text = $token_quantity . ' Cash';
        } elseif ($token['type'] === 'gold') {
            $reward_text = $token_quantity . ' Gold';
        } elseif ($token['type'] === 'avatar' || $token['type'] === 'item') {
            $reward_text = $token_quantity . ' ' . ($token['type'] === 'avatar' ? 'Avatar(s)' : 'Item(s)');
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Token resgatado com sucesso! Você recebeu: ' . $reward_text
        ]);
        
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Erro ao processar resgate: ' . $e->getMessage()]);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao resgatar token: ' . $e->getMessage()]);
}
?>

