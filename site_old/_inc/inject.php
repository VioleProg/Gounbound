<?php 

function AI($str)

{

$str = preg_replace(sql_regcase("/(\n|\r|%0a|%0d|Content-Type:|bcc:|to:|cc:|Autoreply:|from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "", $str);
$str = trim($str); # Remove espaços vazios.
$str = strip_tags($str); # Remove tags HTML e PHP.
$str = addslashes($str); # Adiciona barras invertidas à uma string.
return $str;

} 