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

$user_id = $_SESSION['user_id'];
global $conn;

$avatars = [];
$closet_avatars = [];
$error_message = '';

try {
    // Verificar se a tabela avatar_table existe
    $check_table = $conn->query("SHOW TABLES LIKE 'avatar_table'");
    $table_exists = $check_table && $check_table->num_rows > 0;
    
    if ($table_exists) {
        // Buscar avatares do chest
        $stmt = $conn->prepare("SELECT c.*, a.Name, a.Type, a.Gender FROM chest c LEFT JOIN avatar_table a ON c.Item = a.cod_num WHERE c.Owner = ? ORDER BY COALESCE(a.Name, c.Item) ASC");
        if ($stmt) {
            $stmt->bind_param("s", $user_id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    // Garantir que temos pelo menos o nome do item se não houver na tabela avatar_table
                    if (empty($row['Name'])) {
                        $row['Name'] = 'Item ' . $row['Item'];
                    }
                    if (empty($row['Type'])) {
                        $row['Type'] = 'Unknown';
                    }
                    $avatars[] = $row;
                }
            }
            $stmt->close();
        }
        
        // Buscar avatares do closet
        $stmt = $conn->prepare("SELECT c.*, a.Name, a.Type, a.Gender FROM closet c LEFT JOIN avatar_table a ON c.Item = a.cod_num WHERE c.Owner = ? ORDER BY COALESCE(a.Name, c.Item) ASC");
        if ($stmt) {
            $stmt->bind_param("s", $user_id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    // Garantir que temos pelo menos o nome do item se não houver na tabela avatar_table
                    if (empty($row['Name'])) {
                        $row['Name'] = 'Item ' . $row['Item'];
                    }
                    if (empty($row['Type'])) {
                        $row['Type'] = 'Unknown';
                    }
                    $closet_avatars[] = $row;
                }
            }
            $stmt->close();
        }
    } else {
        // Se a tabela não existir, buscar apenas do chest e closet
        $stmt = $conn->prepare("SELECT * FROM chest WHERE Owner = ? ORDER BY Item ASC");
        if ($stmt) {
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $row['Name'] = 'Item ' . $row['Item'];
                $row['Type'] = 'Unknown';
                $avatars[] = $row;
            }
            $stmt->close();
        }
        
        $stmt = $conn->prepare("SELECT * FROM closet WHERE Owner = ? ORDER BY Item ASC");
        if ($stmt) {
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $row['Name'] = 'Item ' . $row['Item'];
                $row['Type'] = 'Unknown';
                $closet_avatars[] = $row;
            }
            $stmt->close();
        }
    }
    
    echo json_encode([
        'success' => true,
        'avatars' => $avatars,
        'closet_avatars' => $closet_avatars,
        'message' => ''
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao carregar avatares: ' . $e->getMessage(),
        'avatars' => [],
        'closet_avatars' => []
    ]);
}

