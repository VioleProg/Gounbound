<?php
// Configuração do Banco de Dados
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', 'viole123');
define('DB_NAME', 'gunbound');

// Configuração do Site
define('SITE_NAME', 'Gunbol');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$script_dir = dirname($_SERVER['SCRIPT_NAME']);
$base_path = rtrim(str_replace('\\', '/', $script_dir), '/');
define('SITE_URL', $protocol . $host . $base_path);

// Iniciar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexão com o banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Definir charset
$conn->set_charset("utf8mb4");
?>

