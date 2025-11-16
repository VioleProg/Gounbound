<style type="text/css">
<!--
.linkforumred a:link
{ 
	color: #FF0000; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size: 10px;
	font-weight: bold;
}

.linkforumred a:visited
{ 
	color: #FF0000; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}

.linkforumred a:active
{ 
	color: #FF0000; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

.linkforumred a:hover
{ 
	color: #FF0000; 
	text-decoration: underline; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

/* AZUL */

.linkforumblue a:link
{ 
	color: #0033CC; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size: 10px;
	font-weight: bold;
}

.linkforumblue a:visited
{ 
	color: #0033CC; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}

.linkforumblue a:active
{ 
	color: #0033CC; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

.linkforumblue a:hover
{ 
	color: #0033CC; 
	text-decoration: underline; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

/* normal */

.linkforumnormal a:link
{ 
	color: #333333; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size: 10px;

}

.linkforumnormal a:visited
{ 
	color: #333333; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;

}

.linkforumnormal a:active
{ 
	color: #333333; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

.linkforumnormal a:hover
{ 
	color: #333333; 
	text-decoration: underline; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
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

while($r = mysql_fetch_array($y)) {
echo'
<table align="left">
<tr>
<td align="center"><img src="images/drop_bullet.gif"> </td>
<td align="left" class="'.$r['class'].'"> <a href="fevento-comments-'.$r['Id'].'.jsp"> '.$r['Title'].'</a>
</td>
</tr>
</table>
';
 }
 $anterior = $pc -1;
 $proximo = $pc +1;
 if($pc>1) {
 }
}
else {
echo('
<table align="left"><tr>
<td align="center"><img src="images/drop_bullet.gif"> </td>
<td align="left" class="linkforumnormal"> Nada encontrado! </td>
</tr></table>
');
}
?>