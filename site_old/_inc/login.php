<?php
	function login($usuario, $senha){
	$usuario1 = $usuario;
	$senha1= $senha;

	$sql="SELECT * FROM user WHERE user='$usuario1' and Password='$senha1'";
	$result = mysql_query($sql);

	
	$count=mysql_num_rows($result);
	

	if($count==1){
	
	$_SESSION["s_usuario"] = $usuario1;
	$_SESSION["s_senha"] = $senha1;
	
	
	
	return true;

	} else {

	return false;

	}

}


function checasessao(){

$usuario1  = $_SESSION["s_usuario"];
$senha1 = $_SESSION["s_senha"];

$sqla="SELECT * FROM user WHERE user='$usuario1' and Password='$senha1'";
$result=mysql_query($sqla);


$count=mysql_num_rows($result);

	

if($count==1){
return true;

} else {

return false;

}

}

?>