<?php
$total_reg = "4"; // número de registros por página

if (!@$pagina) {
   $pc = "1";
} else {
   $pc = $pagina;
}

$inicio = $pc - 1;
$inicio = $inicio * $total_reg;

$todos = mysql_query("SELECT * FROM `fevento` ORDER BY Date");
$tr = mysql_num_rows($todos);
$tp = $tr / $total_reg;
$y = mysql_query("SELECT * FROM `fevento` ORDER By Date DESC LIMIT  $inicio,$total_reg");
$x = mysql_num_rows($y);
if($x != 0) {

 echo "<table border=\"0\" width=\"100%\">
";
 while($r = mysql_fetch_array($y)) {
 echo'<tr>
 <td align="center"><img src="images/iconen.gif"> </td>
	   <td align="left" class="'.$r['class'].'"> <a href="fevento-comments-'.$r['Id'].'.jsp"> '.$r['Title'].'</a></td>
	   ';
   echo '</td>
   </tr>';
 }
 echo "</table>";
 $anterior = $pc -1;
 $proximo = $pc +1;
 if($pc>1) {
 }
}
else {
echo("Nada encontrado!");
}
?>