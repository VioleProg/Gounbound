<?php
require_once 'config.php';

$item = $_GET['item'] ?? '';

if (empty($item)) {
    header('Content-Type: image/png');
    readfile('Assets/images/no_avatar.png');
    exit;
}

global $conn;

// Buscar informações do avatar
$stmt = $conn->prepare("SELECT cod_num, Name FROM avatar_table WHERE cod_num = ? LIMIT 1");
$stmt->bind_param("s", $item);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Content-Type: image/png');
    readfile('Assets/images/no_avatar.png');
    exit;
}

$avatar = $result->fetch_assoc();

// Tentar encontrar a imagem do avatar
// Pode estar em diferentes locais dependendo da estrutura
$image_paths = [
    'Assets/avatar/' . $item . '.png',
    'Assets/avatar/' . $item . '.gif',
    'Assets/avatar/' . $item . '.jpg',
    'site_old/images/avatar/' . $item . '.png',
    'site_old/images/avatar/' . $item . '.gif',
];

foreach ($image_paths as $path) {
    if (file_exists($path)) {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        header('Content-Type: image/' . ($ext == 'jpg' ? 'jpeg' : $ext));
        readfile($path);
        exit;
    }
}

// Se não encontrou, retornar imagem padrão
header('Content-Type: image/png');
readfile('Assets/images/no_avatar.png');

