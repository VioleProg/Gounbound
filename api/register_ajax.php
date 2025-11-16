<?php
require_once '../config.php';
require_once '../includes/functions.php';

// Habilitar exibição de erros para debug (remover em produção)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Garantir que a sessão está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$login = trim($_POST['login'] ?? '');
$nick = trim($_POST['nick'] ?? '');
$email = trim($_POST['email'] ?? '');
$email_confirm = trim($_POST['email_confirm'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';
$gender = $_POST['gender'] ?? '1';
$country = trim($_POST['country'] ?? '');

$errors = [];

// Validações
if (empty($login)) {
    $errors[] = 'Login é obrigatório';
} elseif (!validateUsername($login)) {
    $errors[] = 'Login deve ter entre 6 e 12 caracteres alfanuméricos';
}

if (empty($nick)) {
    $errors[] = 'Nick é obrigatório';
} elseif (!validateUsername($nick)) {
    $errors[] = 'Nick deve ter entre 6 e 12 caracteres alfanuméricos';
}

if (empty($email)) {
    $errors[] = 'Email é obrigatório';
} elseif (!validateEmail($email)) {
    $errors[] = 'Email inválido';
}

if ($email !== $email_confirm) {
    $errors[] = 'Os emails não coincidem';
}

if (empty($password)) {
    $errors[] = 'Senha é obrigatória';
} elseif (strlen($password) < 6 || strlen($password) > 12) {
    $errors[] = 'Senha deve ter entre 6 e 12 caracteres';
}

if ($password !== $password_confirm) {
    $errors[] = 'As senhas não coincidem';
}

if (empty($country)) {
    $errors[] = 'País é obrigatório';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode('<br>', $errors)]);
    exit;
}

try {
    // Converter nome do país para código (por enquanto usar o nome como código)
    // Se necessário, criar um mapeamento de nomes para códigos numéricos
    $country_code = $country; // Usar o nome do país como código por enquanto
    
    $result = register($login, $nick, $email, $password, $gender, $country_code);
    if ($result['success']) {
        $user_number = isset($result['user_number']) ? $result['user_number'] : 0;
        $message = 'Conta criada com sucesso!';
        if ($user_number > 0) {
            $message = 'Você é o número ' . $user_number . '! Conta criada com sucesso!';
        }
        
        // Buscar informações do item inicial (46984698)
        global $conn;
        $item_id = 46984698;
        $item_name = 'Item Inicial';
        $stmt_item = $conn->prepare("SELECT menu_name FROM MENU WHERE Item1 = ?");
        if ($stmt_item) {
            $stmt_item->bind_param("i", $item_id);
            $stmt_item->execute();
            $result_item = $stmt_item->get_result();
            if ($row_item = $result_item->fetch_assoc()) {
                $item_name = $row_item['menu_name'] ?? 'Item Inicial';
            }
            $stmt_item->close();
        }
        
        // Valores iniciais que o usuário recebe
        $initial_cash = 50000;
        $initial_money = 300000;
        $item_expire_days = 1000;
        
        // Fazer login automático após registro
        if (login($login, $password)) {
            echo json_encode([
                'success' => true, 
                'message' => $message, 
                'user_number' => $user_number,
                'redirect' => 'dashboard.php',
                'registration_info' => [
                    'login' => $login,
                    'nick' => $nick,
                    'email' => $email,
                    'cash' => $initial_cash,
                    'money' => $initial_money,
                    'item_name' => $item_name,
                    'item_expire_days' => $item_expire_days
                ]
            ]);
        } else {
            echo json_encode([
                'success' => true, 
                'message' => $message . ' Faça login para continuar.', 
                'user_number' => $user_number,
                'redirect' => 'index.php',
                'registration_info' => [
                    'login' => $login,
                    'nick' => $nick,
                    'email' => $email,
                    'cash' => $initial_cash,
                    'money' => $initial_money,
                    'item_name' => $item_name,
                    'item_expire_days' => $item_expire_days
                ]
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => $result['message']]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao processar registro: ' . $e->getMessage()]);
}

