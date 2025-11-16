<style>
#cla
{
	border:1px solid #84c369;
	background:#b9e8a5;
}
#cla th
{
	font-weight:bold;
	text-align:left;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	color:#1650e3;
}
</style>
<div id="info_page">
  <div id="info_page_texto" align="center">Lista de Cl&atilde;s</div></div><div id="center_bg_topo"><div id="centro_logotipo"></div> <div id="centro_titulo"></div>
</div> <div id="center_conteudo_meio">
  <div id="centro_meio_conteudo">
    <div align="center"></div><br />
    <div id="bg_news_texto">
    <?
	if (!isset($_SESSION["s_usuario"]) || !checasessao()){
	die("Voce nao tem permissao para acessar....");

}

	?>
    <table width="559" border="0" align="center">
      <tr>
        <td width="553"><strong>Procurar um Cl&atilde;: </strong><em><br />
        </em></td>
      </tr>
      <tr>
        <td>Localizar atrav&eacute;s do:
          <input type="radio" name="radio" id="radio" value="master" />
          <em>Cl&atilde; Master</em>
          <input type="radio" name="radio" id="radio2" value="cla" />
          <em> Nome do Cl&atilde;</em></td>
      </tr>
      <tr>
        <td><input height="25" name="lookfor" type="text" id="lookfor" maxlength="10" />
          <input type="submit" name="lookinfor" id="lookinfor" value="Buscar" /></td>
      </tr>
    </table>
    <a href="?page=criar_cla"><br />
    <strong>Criar Cl&atilde;</strong><br />
    <br />
    </a>
    <table width="550" cellpadding="0" cellspacing="0" border="0" align="center" id="cla">
      <tr>
        <th width="91">&nbsp;</td>
        <th width="263">Nome do Cl&atilde;</td>
        <th width="111">Cl&atilde; Master</td>
        <th width="65">Membros</td>
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



$numreg = 12;
$inicial = $pg * $numreg;
$sql2 = mysql_query("Select Count(*) as total from guildweb");
$quantreg = mysql_result($sql2, 0, 'total');

if(isset($_POST['lookfor']))
{
	if($_POST['radio'] == 'master')
	{
		$pesquisa = $_POST['lookfor'];
		$ids = getIdByNick($_POST['lookfor']);
		$sql = mysql_query("select * from guildweb where G_Master='$ids'");
	}
	if($_POST['radio'] == 'cla')
	{
		$pesquisa = $_POST['lookfor'];
		$sql = mysql_query("select * from guildweb where guild like '%$pesquisa%' order by id_clan");
	}
}else
{
		$sql = mysql_query("select * from guildweb order by id_clan LIMIT $inicial,$numreg");
}

while($row = mysql_fetch_array($sql))
{
	$cuenta_rows = mysql_query("SELECT COUNT(*) AS TOTAL FROM game where Guild='".$row['guild']."'");
	$result = mysql_fetch_array($cuenta_rows);
	$total_membros = $result['TOTAL'];

	  echo"<tr onclick=location='?page=clan&id=".$row['id_clan']."#showmember&guild=".base64_encode($row['guild'])."' style='cursor:pointer ;' onMouseOver=javascript:this.style.backgroundColor='#FFF0CC' onMouseOut=javascript:this.style.backgroundColor='#FFFFFF'>\n";
	  echo"<td><IMG src='".$row['foto']."' width=80 height=66></td>\n";
	  echo"<td><b>".$row['guild']."</b></td>\n";
	  echo"<td>".getNick($row['G_Master'])."</td>\n";
	  echo"<td>".$total_membros."</td>\n";
	  echo"</tr>\n";
	  echo"<tr><td colspan='8' style='background: url(http://img585.imageshack.us/img585/2517/burank.gif) repeat scroll 0% 0% transparent;' height='1'></td></tr>";

}

?>
    </table>
    <table align="center" width="400" border="0">
  <tr>
    <td><?

if(!isset($_POST['lookfor'])){

    $quant_pg = ceil($quantreg/$numreg);
    $quant_pg++;
    // Verifica se esta na primeira página, se nao estiver ele libera o link para anterior
    if ( $pg > 0) {
        echo "<a href=".$PHP_SELF."?page=lista_clans&pg=".($pg-1) ."class=pg><b>&laquo; anterior</b></a>";
    } else {
        echo "<font color=#CCCCCC>&laquo; anterior</font>";
    }
       if (($pg - 3) < 1 ){
    $ant = 1;
    } else {
    $ant = $pg - 3;
    }
    if (($pg + 6) > $quant_pg ) {
    $pos = $quant_pg;
    } else {
    $pos = $pg + 13;
    }

    for($i_pg=$ant;$i_pg < $pos;$i_pg++) {

        if ($pg == ($i_pg-1)) {
            echo "&nbsp;<span class=pgoff>[$i_pg]</span>&nbsp;";

        } else {

            $i_pg2 = $i_pg-1;
            echo "&nbsp;<a href=".$PHP_SELF."?page=lista_clans&pg=$i_pg2 class=pg><b>$i_pg</b></a>&nbsp;";
        }
    }

    if (($pg+2) < $quant_pg) {
        echo "<a href=".$PHP_SELF."?page=lista_clans&pg=".($pg+1)." class=pg><b>próximo &raquo;</b></a>";
    } else {
        echo "<font color=#CCCCCC>próximo &raquo;</font>";
    }
}
 ?></td>
  </tr>
</table>
    </div> 

</div>
<div id="center_conteudo_footer"> <div id="centro_footer_texto_topo"><a href="#btopo" title="Topo"><img src="images/botoes/up.png" width="18" height="26" /></a></div>
</div>