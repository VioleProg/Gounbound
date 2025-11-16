<?PHP
ob_start();
session_start();
include("../mesh.php");
//Getting authority
$sql = mysql_query("SELECT * FROM game WHERE Id='".$_SESSION['user']."'");
$sqlly = mysql_fetch_assoc($sql);
$authority = $sqlly['Authority'];
if($authority <= 98)
{
header("Location: http://gbomega.com");
}
elseif(!$_SESSION['user'])
{
header("Location: http://gbomega.com");
}
ob_flush();
?>