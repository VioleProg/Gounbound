<?php
require_once '../config.php';
require_once '../includes/functions.php';

// Garantir que a sessão está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit;
}

$action = $_POST['action'] ?? '';
$user_id = $_SESSION['user_id'];

global $conn;

switch ($action) {
    case 'update_nickname':
        $new_nickname = trim($_POST['nickname'] ?? '');
        
        if (empty($new_nickname)) {
            echo json_encode(['success' => false, 'message' => 'Nickname não pode estar vazio']);
            exit;
        }
        
        if (!validateUsername($new_nickname)) {
            echo json_encode(['success' => false, 'message' => 'Nickname inválido. Use 6-12 caracteres alfanuméricos']);
            exit;
        }
        
        // Verificar se o nickname já está em uso
        $stmt = $conn->prepare("SELECT Id FROM game WHERE Nickname = ? AND Id != ?");
        $stmt->bind_param("ss", $new_nickname, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Este nickname já está em uso']);
            exit;
        }
        $stmt->close();
        
        // Atualizar nickname na tabela game
        $stmt = $conn->prepare("UPDATE game SET Nickname = ? WHERE Id = ?");
        $stmt->bind_param("ss", $new_nickname, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Nickname alterado com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao alterar nickname: ' . $stmt->error]);
        }
        $stmt->close();
        break;
        
    case 'update_password':
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        
        if (empty($current_password) || empty($new_password)) {
            echo json_encode(['success' => false, 'message' => 'Preencha todos os campos']);
            exit;
        }
        
        if (strlen($new_password) < 6 || strlen($new_password) > 12) {
            echo json_encode(['success' => false, 'message' => 'A senha deve ter entre 6 e 12 caracteres']);
            exit;
        }
        
        // Verificar senha atual
        $stmt = $conn->prepare("SELECT Password FROM gunwcuser WHERE Id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            if ($row['Password'] !== $current_password) {
                echo json_encode(['success' => false, 'message' => 'Senha atual incorreta']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
            exit;
        }
        $stmt->close();
        
        // Atualizar senha
        $stmt = $conn->prepare("UPDATE gunwcuser SET Password = ? WHERE Id = ?");
        $stmt->bind_param("ss", $new_password, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Senha alterada com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao alterar senha: ' . $stmt->error]);
        }
        $stmt->close();
        break;
        
    case 'update_email':
        $new_email = trim($_POST['email'] ?? '');
        
        if (empty($new_email)) {
            echo json_encode(['success' => false, 'message' => 'Email não pode estar vazio']);
            exit;
        }
        
        if (!validateEmail($new_email)) {
            echo json_encode(['success' => false, 'message' => 'Email inválido']);
            exit;
        }
        
        // Verificar se o email já está em uso
        $stmt = $conn->prepare("SELECT Id FROM gunwcuser WHERE E_Mail = ? AND Id != ?");
        $stmt->bind_param("ss", $new_email, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Este email já está em uso']);
            exit;
        }
        $stmt->close();
        
        // Atualizar email
        $stmt = $conn->prepare("UPDATE gunwcuser SET E_Mail = ? WHERE Id = ?");
        $stmt->bind_param("ss", $new_email, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Email alterado com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao alterar email: ' . $stmt->error]);
        }
        $stmt->close();
        break;
        
    case 'update_avatar':
        $avatar_url = trim($_POST['avatar_url'] ?? '');
        
        // Se estiver vazio, remover a foto de perfil
        if (empty($avatar_url)) {
            $stmt = $conn->prepare("UPDATE gunwcuser SET imagem_perfil = NULL WHERE Id = ?");
            $stmt->bind_param("s", $user_id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Foto de perfil removida com sucesso!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao remover foto: ' . $stmt->error]);
            }
            $stmt->close();
            exit;
        }
        
        // Validar URL
        if (!filter_var($avatar_url, FILTER_VALIDATE_URL)) {
            echo json_encode(['success' => false, 'message' => 'URL inválida']);
            exit;
        }
        
        // Verificar se a URL é de imagem (opcional - pode ser removido se quiser aceitar qualquer URL)
        $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $url_lower = strtolower($avatar_url);
        $is_image = false;
        foreach ($image_extensions as $ext) {
            if (strpos($url_lower, '.' . $ext) !== false) {
                $is_image = true;
                break;
            }
        }
        
        // Atualizar foto de perfil
        $stmt = $conn->prepare("UPDATE gunwcuser SET imagem_perfil = ? WHERE Id = ?");
        $stmt->bind_param("ss", $avatar_url, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Foto de perfil alterada com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao alterar foto: ' . $stmt->error]);
        }
        $stmt->close();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Ação inválida']);
}
?>

