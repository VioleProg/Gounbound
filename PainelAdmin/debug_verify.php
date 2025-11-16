<?php
// Arquivo temporário para debug - REMOVER DEPOIS
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../mesh.php");

echo "<h2>Debug Info:</h2>";
echo "SESSION user_id: " . ($_SESSION['user_id'] ?? 'NOT SET') . "<br>";
echo "SESSION user: " . ($_SESSION['user'] ?? 'NOT SET') . "<br>";

$user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? null;

if (!$user_id) {
    echo "<p style='color:red;'>ERRO: Nenhum user_id encontrado na sessão!</p>";
    echo "<p><a href='../index.php'>Voltar ao site</a></p>";
    exit();
}

echo "User ID sendo usado: " . htmlspecialchars($user_id) . "<br><br>";

// Verificar em gunwcuser
$sql = mysql_query("SELECT Authority FROM gunwcuser WHERE Id='".mysql_real_escape_string($user_id)."'");
$sqlly = mysql_fetch_assoc($sql);

echo "<h3>Verificação em gunwcuser:</h3>";
if ($sqlly) {
    echo "Authority encontrada: " . $sqlly['Authority'] . "<br>";
} else {
    echo "Nenhum registro encontrado em gunwcuser<br>";
}

// Verificar em game
$sql2 = mysql_query("SELECT Authority FROM game WHERE Id='".mysql_real_escape_string($user_id)."'");
$sqlly2 = mysql_fetch_assoc($sql2);

echo "<h3>Verificação em game:</h3>";
if ($sqlly2) {
    echo "Authority encontrada: " . $sqlly2['Authority'] . "<br>";
} else {
    echo "Nenhum registro encontrado em game<br>";
}

$authority = isset($sqlly['Authority']) ? (int)$sqlly['Authority'] : (isset($sqlly2['Authority']) ? (int)$sqlly2['Authority'] : 0);

echo "<h3>Authority final: " . $authority . "</h3>";
echo "<p>Authority >= 98? " . ($authority >= 98 ? "SIM - PODE ACESSAR" : "NÃO - SERÁ REDIRECIONADO") . "</p>";

ob_flush();
?>

