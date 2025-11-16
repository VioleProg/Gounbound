<?php
require_once '../config.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos']);
    exit;
}

if (login($username, $password)) {
    echo json_encode(['success' => true, 'message' => 'Login realizado com sucesso!', 'redirect' => 'dashboard.php']);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuário ou senha incorretos']);
}

