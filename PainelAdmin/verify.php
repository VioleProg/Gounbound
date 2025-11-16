<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../mesh.php");

// Verificar se o usuário está logado (compatibilidade com ambos os sistemas)
$user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? null;

if (!$user_id) {
    header("Location: ../index.php");
    exit();
}

// Getting authority - verificar em gunwcuser primeiro (tabela principal), depois em game
$sql = mysql_query("SELECT Authority FROM gunwcuser WHERE Id='".mysql_real_escape_string($user_id)."'");
$sqlly = mysql_fetch_assoc($sql);

if (!$sqlly) {
    // Tentar em game
    $sql = mysql_query("SELECT Authority FROM game WHERE Id='".mysql_real_escape_string($user_id)."'");
    $sqlly = mysql_fetch_assoc($sql);
}

$authority = isset($sqlly['Authority']) ? (int)$sqlly['Authority'] : 0;

// Permitir acesso para Authority >= 98 (98 = GM, 99+ = Admin)
if($authority < 98) {
    header("Location: ../index.php");
    exit();
}

// Definir $_SESSION['user'] para compatibilidade com código antigo
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = $user_id;
}
?>