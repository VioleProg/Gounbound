<?php
require_once '../config.php';
require_once '../includes/functions.php';

// Garantir que a sessão está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    // Atualizar missão de login diário
    if (isLoggedIn()) {
        require_once '../includes/mission_functions.php';
        updateMissionProgress($_SESSION['user_id'], 'daily_login', 1);
    }
    
    echo json_encode(['success' => true, 'message' => 'Login realizado com sucesso!', 'redirect' => 'dashboard.php']);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuário ou senha incorretos']);
}

