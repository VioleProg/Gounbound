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
$test_count = 0;
$table_exists = false;

// Debug: verificar se user_id está definido
if (empty($user_id)) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuário não identificado',
        'avatars' => [],
        'closet_avatars' => []
    ]);
    exit;
}

try {
    // Verificar se a tabela menu existe
    $check_table = $conn->query("SHOW TABLES LIKE 'menu'");
    $table_exists = $check_table && $check_table->num_rows > 0;
    
    // Primeiro, verificar quantos itens tem no chest
    $stmt_test = $conn->prepare("SELECT COUNT(*) as total FROM chest WHERE Owner = ?");
    if ($stmt_test) {
        $stmt_test->bind_param("s", $user_id);
        if ($stmt_test->execute()) {
            $test_result = $stmt_test->get_result();
            $test_data = $test_result->fetch_assoc();
            $test_count = $test_data['total'] ?? 0;
        }
        $stmt_test->close();
    }
    
    // Buscar avatares do chest - Owner é o username (Id da tabela gunwcuser)
    $stmt = $conn->prepare("SELECT * FROM chest WHERE Owner = ? ORDER BY Item ASC");
    if ($stmt) {
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                // Buscar nome do item na tabela MENU
                // Item1 contém o ID do item e menu_name contém o nome
                $item_code = intval($row['Item']);
                $stmt_menu = $conn->prepare("SELECT menu_name FROM menu WHERE Item1 = ? LIMIT 1");
                if ($stmt_menu) {
                    $stmt_menu->bind_param("i", $item_code);
                    if ($stmt_menu->execute()) {
                        $menu_result = $stmt_menu->get_result();
                        if ($menu_row = $menu_result->fetch_assoc()) {
                            $row['Name'] = $menu_row['menu_name'];
                        } else {
                            $row['Name'] = 'Item ' . $item_code;
                        }
                    } else {
                        $row['Name'] = 'Item ' . $item_code;
                    }
                    $stmt_menu->close();
                } else {
                    $row['Name'] = 'Item ' . $item_code;
                }
                // Tipo não está na tabela MENU, então usamos Unknown
                $row['Type'] = 'Unknown';
                $avatars[] = $row;
            }
        } else {
            $error_message = "Erro ao executar query chest: " . $stmt->error;
            error_log($error_message);
        }
        $stmt->close();
    } else {
        $error_message = "Erro ao preparar query chest: " . $conn->error;
        error_log($error_message);
    }
    
    // Buscar avatares do closet - Owner é o username
    $stmt = $conn->prepare("SELECT * FROM closet WHERE Owner = ? ORDER BY Item ASC");
    if ($stmt) {
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                // Buscar nome do item na tabela MENU
                $item_code = intval($row['Item']);
                $stmt_menu = $conn->prepare("SELECT menu_name FROM menu WHERE Item1 = ? LIMIT 1");
                if ($stmt_menu) {
                    $stmt_menu->bind_param("i", $item_code);
                    if ($stmt_menu->execute()) {
                        $menu_result = $stmt_menu->get_result();
                        if ($menu_row = $menu_result->fetch_assoc()) {
                            $row['Name'] = $menu_row['menu_name'];
                        } else {
                            $row['Name'] = 'Item ' . $item_code;
                        }
                    } else {
                        $row['Name'] = 'Item ' . $item_code;
                    }
                    $stmt_menu->close();
                } else {
                    $row['Name'] = 'Item ' . $item_code;
                }
                $row['Type'] = 'Unknown';
                $closet_avatars[] = $row;
            }
        } else {
            error_log("Erro ao executar query closet: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("Erro ao preparar query closet: " . $conn->error);
    }
    
    echo json_encode([
        'success' => true,
        'avatars' => $avatars,
        'closet_avatars' => $closet_avatars,
        'message' => $error_message ?: '',
        'debug' => [
            'user_id' => $user_id,
            'avatars_count' => count($avatars),
            'closet_count' => count($closet_avatars),
            'test_count' => $test_count ?? 0,
            'table_exists' => $table_exists ?? false
        ]
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao carregar avatares: ' . $e->getMessage(),
        'avatars' => [],
        'closet_avatars' => []
    ]);
}

