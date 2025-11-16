<?php
require_once '../config.php';
require_once '../includes/functions.php';

// Garantir que a sessão está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir header JSON antes de qualquer output
header('Content-Type: application/json; charset=utf-8');

// Função para retornar JSON e sair
function returnJson($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isLoggedIn()) {
    returnJson(['success' => false, 'message' => 'Não autorizado']);
}

$action = $_POST['action'] ?? '';
$user_id = $_SESSION['user_id'];

global $conn;

// Tratamento de erro global
try {

switch ($action) {
    case 'update_nickname':
        $new_nickname = trim($_POST['nickname'] ?? '');
        
        if (empty($new_nickname)) {
            returnJson(['success' => false, 'message' => 'Nickname não pode estar vazio']);
        }
        
        if (!validateUsername($new_nickname)) {
            returnJson(['success' => false, 'message' => 'Nickname inválido. Use 6-12 caracteres alfanuméricos']);
        }
        
        // Verificar se o nickname já está em uso (verificar em gunwcuser e game)
        $stmt = $conn->prepare("SELECT Id FROM gunwcuser WHERE NickName = ? AND Id != ?");
        $stmt->bind_param("ss", $new_nickname, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $stmt->close();
            returnJson(['success' => false, 'message' => 'Este nickname já está em uso']);
        }
        $stmt->close();
        
        // Verificar também na tabela game
        $stmt = $conn->prepare("SELECT Id FROM game WHERE Nickname = ? AND Id != ?");
        $stmt->bind_param("ss", $new_nickname, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $stmt->close();
            returnJson(['success' => false, 'message' => 'Este nickname já está em uso']);
        }
        $stmt->close();
        
        // Atualizar nickname na tabela gunwcuser (PRINCIPAL)
        $stmt = $conn->prepare("UPDATE gunwcuser SET NickName = ? WHERE Id = ?");
        $stmt->bind_param("ss", $new_nickname, $user_id);
        
        if (!$stmt->execute()) {
            $error_msg = $stmt->error;
            $stmt->close();
            returnJson(['success' => false, 'message' => 'Erro ao alterar nickname: ' . $error_msg]);
        }
        $stmt->close();
        
        // Também atualizar na tabela game para manter sincronizado
        $stmt = $conn->prepare("UPDATE game SET Nickname = ? WHERE Id = ?");
        $stmt->bind_param("ss", $new_nickname, $user_id);
        $stmt->execute(); // Não verificar erro aqui, pois gunwcuser é o principal
        $stmt->close();
        
        returnJson(['success' => true, 'message' => 'Nickname alterado com sucesso!']);
        
    case 'update_password':
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        
        if (empty($current_password) || empty($new_password)) {
            returnJson(['success' => false, 'message' => 'Preencha todos os campos']);
        }
        
        if (strlen($new_password) < 6 || strlen($new_password) > 12) {
            returnJson(['success' => false, 'message' => 'A senha deve ter entre 6 e 12 caracteres']);
        }
        
        // Verificar senha atual
        $stmt = $conn->prepare("SELECT Password FROM gunwcuser WHERE Id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            if ($row['Password'] !== $current_password) {
                $stmt->close();
                returnJson(['success' => false, 'message' => 'Senha atual incorreta']);
            }
        } else {
            $stmt->close();
            returnJson(['success' => false, 'message' => 'Usuário não encontrado']);
        }
        $stmt->close();
        
        // Atualizar senha
        $stmt = $conn->prepare("UPDATE gunwcuser SET Password = ? WHERE Id = ?");
        $stmt->bind_param("ss", $new_password, $user_id);
        
        if ($stmt->execute()) {
            $stmt->close();
            returnJson(['success' => true, 'message' => 'Senha alterada com sucesso!']);
        } else {
            $error_msg = $stmt->error;
            $stmt->close();
            returnJson(['success' => false, 'message' => 'Erro ao alterar senha: ' . $error_msg]);
        }
        
    case 'update_email':
        $new_email = trim($_POST['email'] ?? '');
        
        if (empty($new_email)) {
            returnJson(['success' => false, 'message' => 'Email não pode estar vazio']);
        }
        
        if (!validateEmail($new_email)) {
            returnJson(['success' => false, 'message' => 'Email inválido']);
        }
        
        // Verificar se o email já está em uso
        $stmt = $conn->prepare("SELECT Id FROM gunwcuser WHERE E_Mail = ? AND Id != ?");
        $stmt->bind_param("ss", $new_email, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $stmt->close();
            returnJson(['success' => false, 'message' => 'Este email já está em uso']);
        }
        $stmt->close();
        
        // Atualizar email
        $stmt = $conn->prepare("UPDATE gunwcuser SET E_Mail = ? WHERE Id = ?");
        $stmt->bind_param("ss", $new_email, $user_id);
        
        if ($stmt->execute()) {
            $stmt->close();
            returnJson(['success' => true, 'message' => 'Email alterado com sucesso!']);
        } else {
            $error_msg = $stmt->error;
            $stmt->close();
            returnJson(['success' => false, 'message' => 'Erro ao alterar email: ' . $error_msg]);
        }
        
    case 'update_avatar':
        $avatar_url = trim($_POST['avatar_url'] ?? '');
        
        // Se estiver vazio, remover a foto de perfil
        if (empty($avatar_url)) {
            $stmt = $conn->prepare("UPDATE gunwcuser SET imagem_perfil = NULL WHERE Id = ?");
            $stmt->bind_param("s", $user_id);
            
            if ($stmt->execute()) {
                $stmt->close();
                returnJson(['success' => true, 'message' => 'Foto de perfil removida com sucesso!']);
            } else {
                $error_msg = $stmt->error;
                $stmt->close();
                returnJson(['success' => false, 'message' => 'Erro ao remover foto: ' . $error_msg]);
            }
        }
        
        // Validar URL
        if (!filter_var($avatar_url, FILTER_VALIDATE_URL)) {
            returnJson(['success' => false, 'message' => 'URL inválida']);
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
            $stmt->close();
            returnJson(['success' => true, 'message' => 'Foto de perfil alterada com sucesso!']);
        } else {
            $error_msg = $stmt->error;
            $stmt->close();
            returnJson(['success' => false, 'message' => 'Erro ao alterar foto: ' . $error_msg]);
        }
        
    default:
        returnJson(['success' => false, 'message' => 'Ação inválida']);
}

} catch (Exception $e) {
    returnJson(['success' => false, 'message' => 'Erro interno: ' . $e->getMessage()]);
}
?>

