<?php

function gravaLOG($modulo, $usuario, $horario, $msg,$arg1, $arg2){
$horario = date ("Y-m-d");
$result = mysql_query("INSERT INTO logsite(modulo, usuario, horario, msg, arg1, arg2) values ('$modulo', '$usuario', '$horario', '$msg','$arg1','$arg2')");
if (mysql_affected_rows() > 0){
	} else{
	echo "erro1" .  mysql_error();
	}
}

?>
