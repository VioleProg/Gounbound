<?php
require_once '../config.php';
require_once '../includes/functions.php';

// Habilitar exibição de erros para debug (remover em produção)
error_reporting(E_ALL);
ini_set('display_errors', 0);

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
$gender = $_POST['gender'] ?? '0';

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

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode('<br>', $errors)]);
    exit;
}

try {
    $result = register($login, $nick, $email, $password, $gender);
    if ($result['success']) {
        // Fazer login automático após registro
        if (login($login, $password)) {
            echo json_encode(['success' => true, 'message' => 'Conta criada com sucesso!', 'redirect' => 'dashboard.php']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Conta criada, mas não foi possível fazer login automaticamente. Tente fazer login manualmente.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => $result['message']]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao processar registro: ' . $e->getMessage()]);
}

