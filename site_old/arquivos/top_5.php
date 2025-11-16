<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<div id="left_bg_topo_outro_meio_conteudo_verde"><div id="top_rank_bgrank"></div>
<?
$sql = mysql_query("select * from game order by TotalScore DESC Limit 0,5");

while($row = mysql_fetch_array($sql))
{
	$user = $row['Id'];
	$get_sexo = mysql_query("select Gender from user where Id='$user'");
	$r = mysql_fetch_array($get_sexo);
	echo'<div id="left_bg_topo_outro_rank"><div id="top_rank_gender"><img src="images/gender_'.$r[0].'.jpg" width="28" height="25" /></div><div id="top_rank_nivel"><img src="ranks/02/rank_'.$row['CountryGrade'].'.gif" width="15" height="25" /></div><div id="top_rank_guild">'.$row['Guild'].'</div><div id="top_rank_nickname">'.$row['NickName'].'</div>
</div>';
}
?>
	
  </div>