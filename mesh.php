<?php
// Arquivo de compatibilidade para o painel admin
// Redireciona para usar config.php e mysqli
require_once __DIR__ . '/config.php';

// Criar variável global $conn para compatibilidade com código antigo
// O $conn já está definido em config.php como mysqli

// Função helper para compatibilidade com código antigo que usa mysql_query
function mysql_query($query) {
    global $conn;
    return $conn->query($query);
}

// Função helper para mysql_fetch_assoc
function mysql_fetch_assoc($result) {
    if ($result instanceof mysqli_result) {
        return $result->fetch_assoc();
    }
    return false;
}

// Função helper para mysql_fetch_row
function mysql_fetch_row($result) {
    if ($result instanceof mysqli_result) {
        return $result->fetch_row();
    }
    return false;
}

// Função helper para mysql_real_escape_string
function mysql_real_escape_string($string) {
    global $conn;
    return $conn->real_escape_string($string);
}

// Função helper para mysql_num_rows
function mysql_num_rows($result) {
    if ($result instanceof mysqli_result) {
        return $result->num_rows;
    }
    return 0;
}

// Função helper para mysql_affected_rows
function mysql_affected_rows() {
    global $conn;
    return $conn->affected_rows;
}

// Função helper para mysql_error
function mysql_error() {
    global $conn;
    return $conn->error;
}
?>

