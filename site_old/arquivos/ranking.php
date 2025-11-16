<style>
#ranking
{
	border:1px solid #68905f;
	text-align:left;
}
#ranking th
{
	background-color:#aad69f;
}
#ranking td
{
	background-color:#ffffff;
	margin-top:3px;
	height:20px;
}
</style>
<div id="info_page">
  <div id="info_page_texto" align="center">Ranking</div></div><div id="center_bg_topo"><div id="centro_logotipo"></div> <div id="centro_titulo"></div>
</div> <div id="center_conteudo_meio">
  <div id="centro_meio_conteudo">
    <div align="center"></div><br />
    <div id="bg_news_texto">
      <table cellpadding="0" cellspacing="0" width="600" border="0" align="center" id="ranking">
        <tr>
            <th width="50">&nbsp;#</td>
            <th width="91">Guild</td>
            <th width="265">NickName</td>
            <th width="76">GP</td>
            <th width="116">B&ocirc;nus GP</td>
        </tr>
  <?php 
 if (!isset($_GET["pg"])) {

        $pg = 0;

    } else{

	if (!is_numeric($_GET["pg"])){

	$pg = 0;

	}

	$pg = $_GET["pg"];

	}

$numreg = 20;

$inicial = $pg * $numreg;

$sql2 = mysql_query("Select Count(*) as total From game ", $link);

$quantreg = mysql_result($sql2, 0, 'total');
if($_GET['rank'] == 'total'){
	$module = 'TotalScore DESC';
}elseif ($_GET['rank'] == 'semanal'){
	$module = 'SeasonScore DESC';
}
if(isset($_POST['busca']))
{
	$sql = mysql_query("SELECT * from game where NickName like '%".$_POST['busca']."%' order by ".$module." LIMIT $inicial,$numreg");
}else{
	$sql = mysql_query("SELECT * from game order by ".$module." LIMIT $inicial,$numreg");
}


while($row = mysql_fetch_array($sql))

  {

	  echo "<tr>\n";
	  echo "<td>&nbsp;" . $row['TotalRank'] . "</td>\n";
	  echo"<td><b>" . $row['Guild'] . "</b></td>\n";
	  echo"<td>".getLevel($row['Id'])." " . $row['NickName'] . "</td>\n";
	  echo"<td>" . number_format($row['TotalScore']) . "</td>\n";
	  echo"<td>" . number_format($row['SeasonScore'] * 0.3) . "</td>\n";
	  echo "</tr>\n";

  }
?>

      </table>
      <span style="text-align:center;"><?php
    $quant_pg = ceil($quantreg/$numreg);
    $quant_pg++;

    if ( $pg > 0) {
        echo "<a href='?page=ranking&rank=".$_GET['rank']."&pg=".($pg-1) ."&class=pg' class=pg><b>&laquo; anterior</b></a>";
    } else {
        echo "<font color=#CCCCCC>&laquo; anterior</font>";
    }

    if (($pg - 3) < 1 ){
    $ant = 1;
    } else {
    $ant = $pg - 3;
    }
    if (($pg + 4) > $quant_pg ) {
    $pos = $quant_pg;
    } else {
    $pos = $pg + 7;
    }
    for($i_pg=$ant;$i_pg < $pos;$i_pg++) {
        if ($pg == ($i_pg-1)) {
            echo "&nbsp;<span class=pgoff>[$i_pg]</span>&nbsp;";
        } else {
            $i_pg2 = $i_pg-1;
            echo "&nbsp;<a href='?page=ranking&rank=".$_GET['rank']."&pg=$i_pg2' class=pg><b>$i_pg</b></a>&nbsp;";
        }
    }
    // Verifica se esta na ultima p&#303;gina, se nao estiver ele libera o link para pr&oacute;xima
    if (($pg+2) < $quant_pg) {
        echo "<a href='?page=ranking&rank=".$_GET['rank']."&pg=".($pg+1)."' class=pg><b>pr&oacute;ximo &raquo;</b></a>";
    } else {
        echo "<font color=#CCCCCC>pr&oacute;ximo &raquo;</font>";
    }

?></span>
    </div> 

</div>
<div id="center_conteudo_footer"> <div id="centro_footer_texto_topo"><a href="#btopo" title="Topo"><img src="images/botoes/up.png" width="18" height="26" /></a></div>
</div>