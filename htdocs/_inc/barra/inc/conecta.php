<?php
/******************************************************
            [ Conexão com o Banco de dados ]
 ******************************************************/
$id = $_GET["nick"];
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "gbwc";

$connection = mysql_connect($db_host, $db_username, $db_password) or die(mysql_error());
$db = mysql_select_db($db_name, $connection);
?>