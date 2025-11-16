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

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$user_id = $_SESSION['user_id'];

global $conn;

// Criar tabela closet se não existir
$conn->query("CREATE TABLE IF NOT EXISTS closet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Owner VARCHAR(16) NOT NULL,
    Item VARCHAR(20) NOT NULL,
    Volume INT DEFAULT 1,
    Expire DATETIME,
    Acquisition VARCHAR(10) DEFAULT 'G',
    Wearing VARCHAR(10) DEFAULT '0',
    ExpireType VARCHAR(10) DEFAULT 'W',
    moved_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_owner (Owner),
    INDEX idx_item (Item)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

switch ($action) {
    case 'move_to_closet':
        $item = $_POST['item'] ?? '';
        if (empty($item)) {
            echo json_encode(['success' => false, 'message' => 'Item não especificado']);
            exit;
        }
        
        // Verificar se o item existe no chest do usuário
        $stmt = $conn->prepare("SELECT * FROM chest WHERE Owner = ? AND Item = ? LIMIT 1");
        $stmt->bind_param("ss", $user_id, $item);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Item não encontrado']);
            exit;
        }
        
        $chest_item = $result->fetch_assoc();
        
        // Mover para closet
        $stmt = $conn->prepare("INSERT INTO closet (Owner, Item, Volume, Expire, Acquisition, Wearing, ExpireType) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissss", 
            $user_id, 
            $chest_item['Item'], 
            $chest_item['Volume'] ?? 1,
            $chest_item['Expire'] ?? null,
            $chest_item['Acquisition'] ?? 'G',
            $chest_item['Wearing'] ?? '0',
            $chest_item['ExpireType'] ?? 'W'
        );
        
        if ($stmt->execute()) {
            // Remover do chest
            $stmt2 = $conn->prepare("DELETE FROM chest WHERE Owner = ? AND Item = ? LIMIT 1");
            $stmt2->bind_param("ss", $user_id, $item);
            $stmt2->execute();
            
            echo json_encode(['success' => true, 'message' => 'Avatar movido para o closet']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao mover para closet']);
        }
        break;
        
    case 'recover_from_closet':
        $item = $_POST['item'] ?? '';
        if (empty($item)) {
            echo json_encode(['success' => false, 'message' => 'Item não especificado']);
            exit;
        }
        
        // Verificar se o item existe no closet do usuário
        $stmt = $conn->prepare("SELECT * FROM closet WHERE Owner = ? AND Item = ? LIMIT 1");
        $stmt->bind_param("ss", $user_id, $item);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Item não encontrado no closet']);
            exit;
        }
        
        $closet_item = $result->fetch_assoc();
        
        // Mover de volta para chest
        $stmt = $conn->prepare("INSERT INTO chest (Owner, Item, Volume, Expire, Acquisition, Wearing, ExpireType) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissss", 
            $user_id, 
            $closet_item['Item'], 
            $closet_item['Volume'] ?? 1,
            $closet_item['Expire'] ?? null,
            $closet_item['Acquisition'] ?? 'G',
            $closet_item['Wearing'] ?? '0',
            $closet_item['ExpireType'] ?? 'W'
        );
        
        if ($stmt->execute()) {
            // Remover do closet
            $stmt2 = $conn->prepare("DELETE FROM closet WHERE Owner = ? AND Item = ? LIMIT 1");
            $stmt2->bind_param("ss", $user_id, $item);
            $stmt2->execute();
            
            echo json_encode(['success' => true, 'message' => 'Avatar recuperado do closet']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao recuperar do closet']);
        }
        break;
        
    case 'delete':
        $item = $_POST['item'] ?? '';
        $from_closet = $_POST['from_closet'] ?? '0';
        
        if (empty($item)) {
            echo json_encode(['success' => false, 'message' => 'Item não especificado']);
            exit;
        }
        
        if ($from_closet == '1') {
            // Deletar do closet
            $stmt = $conn->prepare("DELETE FROM closet WHERE Owner = ? AND Item = ? LIMIT 1");
        } else {
            // Deletar do chest
            $stmt = $conn->prepare("DELETE FROM chest WHERE Owner = ? AND Item = ? LIMIT 1");
        }
        
        $stmt->bind_param("ss", $user_id, $item);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Avatar deletado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao deletar']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Ação inválida']);
}

