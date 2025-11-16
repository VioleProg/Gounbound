<?php
$total_reg = "10"; // número de registros por página

if (!@$pagina) {
   $pc = "1";
} else {
   $pc = $pagina;
}

$inicio = $pc - 1;
$inicio = $inicio * $total_reg;

$todos = mysql_query("SELECT * FROM `game` ORDER BY TotalRank");
$tr = mysql_num_rows($todos);
$tp = $tr / $total_reg;
$y = mysql_query("SELECT * FROM `game` ORDER BY TotalRank LIMIT $inicio,$total_reg");
$x = mysql_num_rows($y);
if($x != 0) {

 echo "<table border=\"0\" width=\"100%\">
";
 while($r = mysql_fetch_array($y)) {
 echo'<tr>
 <td align="center"><img src="images/'.$r['TotalRank'].'.gif"></td>
 <td align="center" width="10">'.getminirank($r['TotalGrade']).'</td>
   <td align="center" class="topranking" width="40"> <b><font face="Arial" size="1" color="#333333"> <span>'.$r['NickName'].'</span></font></b>
   <td align="center" class="toprankingGP"><font face="Arial" size="1" color="#333333">
'
	   .number_format($r['TotalScore']).' <strong>GP</strong></font></td>
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