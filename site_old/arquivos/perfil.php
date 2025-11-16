<div id="info_page"><div id="info_page_texto" align="center">Status</div></div><div id="center_bg_topo"><div id="centro_logotipo"><img src="images/icone_centro_topo.png" width="24" height="24" /></div> <div id="centro_titulo"><img src="images/titulos/gbound.png" /></div>
</div> <div id="center_conteudo_meio">
  <div id="centro_meio_conteudo"><?php
require_once("blockpage.php"); // Requere a página onde está a função
checapagina( basename(__FILE__) ); // Chama a função
if (!isset($_SESSION["s_usuario"]) || !checasessao()){
	die("Voce nao tem permissao para acessar....");

}

function getVitorias($usuario){
$sqlvitoria = mysql_query("select sum(win) from mobilerecord where Id='$usuario'");
$vitorias = mysql_fetch_array($sqlvitoria);
return $vitorias["sum(win)"];

} 

function getDerrotas($usuario){
$sqlderrota = mysql_query("select sum(lose) from mobilerecord where Id='$usuario'");
$derrotas = mysql_fetch_array($sqlderrota);
return $derrotas["sum(lose)"];

} 

function getTaxa($usuario){
$w = getVitorias($usuario);
$l = getDerrotas($usuario);
$t = ($w*100)/($w + $l);
return (int)$t;

} 

function getNumAvatar($usuario){
$sql2 = mysql_query("Select Count(*) as total from chest where Owner='$usuario'");
$quant = mysql_result($sql2, 0, 'total');
return $quant;

} 

function mediaDeAcerto($usuario){
$AccumDamage = mysql_query("select AccumDamage, AccumShot from game where Id='$usuario'");
$a = mysql_fetch_array($AccumDamage);
$AccumDamage = $a["AccumDamage"];
$AccumShot = $a["AccumShot"];
$media = $AccumDamage/$AccumShot;
return (int)$media;

} 

function getGpExtra($usuario){
$sql = mysql_query("select SeasonScore from game where Id='$usuario'");
$gp = mysql_fetch_array($sql);
return $gp["SeasonScore"]*0.30;

}

?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody><tr>
        <td align="left"><table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
              <td align="center" height="19"><img src="images/po.gif" height="9" width="9"> <a href="http://www.safemidia.com/beta/index.php?page=perfil&amp;p=status"><strong>Meus dados </strong></a></td>
              <td align="center"><img src="images/po.gif" height="9" width="9"><a href="http://www.safemidia.com/beta/index.php?page=perfil&amp;p=editar"> <strong> Editar </strong></a></td>
              <td align="center"><img src="images/comunidade_img/beta2_newtop_point3.gif" height="9" width="9"> <a href="http://www.safemidia.com/beta/index.php?page=cash"><strong> Comprar Cash </strong></a></td>
              <td align="center"><img src="images/comunidade_img/beta2_newtop_point3.gif" height="9" width="9"><a href="http://www.safemidia.com/beta/index.php?page=perfil&amp;p=historico"><strong> Histórico</strong></a></td>
			   <td align="center"><img src="images/comunidade_img/beta2_newtop_point3.gif" height="9" width="9"> <a href="http://www.safemidia.com/beta/index.php?page=perfil&amp;p=punicoes"><strong>Punições </strong></a></td>
			   <td align="center"><img src="images/comunidade_img/beta2_newtop_point3.gif" height="9" width="9"><a href="http://www.safemidia.com/beta/index.php?page=perfil&amp;p=shop&amp;url=Helm"><strong> Avatar Shop </strong></a></td>
            </tr>
        </tbody></table></td>
      </tr>
    </tbody></table><br>
      <div id="info_page"><div id="info_page_texto" align="center">Meus dados</div></div>
    <div align="center">
      <div style="background-color:#FFFF00; color:#FF0000; padding:5px; border:1px dotted #993300;"> <span title="Clique para mostrar traduções alternativas">No início</span>&nbsp;<span title="Clique para mostrar traduções alternativas">desta</span>&nbsp;<span title="Clique para mostrar traduções alternativas">temporada </span><span title="Clique para mostrar traduções alternativas">todos</span>&nbsp;<span title="Clique para mostrar traduções alternativas">estarão recebendo</span>&nbsp;<span title="Clique para mostrar traduções alternativas">50</span><span title="Clique para mostrar traduções alternativas">% de GPS</span><br>
        <span title="Clique para mostrar traduções alternativas">De acordo com o</span>&nbsp;<span title="Clique para mostrar traduções alternativas">montante de</span>&nbsp;<span title="Clique para mostrar traduções alternativas">GPS ganhos</span>&nbsp;<span title="Clique para mostrar traduções alternativas">durante o dia.</span><br>
        <span title="Clique para mostrar traduções alternativas"><strong>Independente</strong></span><strong> de VIP</strong> </div>
      <br>
      <table align="center" border="0" cellpadding="0" cellspacing="0" width="42">
        <tbody>
          <tr>
            <td colspan="3"><img src="images/perfil/01.png" height="50" width="647"></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20" width="127"><strong>Game ID</strong></td>
            <td width="13">&nbsp;</td>
            <td width="507"><?=getNick($_SESSION["s_usuario"]);?>              &nbsp;<a href="index.php?page=perfil&amp;p=editar">[<u>Editar]</u></a></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>Sexo</strong></td>
            <td>&nbsp;</td>
            <td><font color="#000000">#</font></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>Pais</strong></td>
            <td>&nbsp;</td>
            <td><font color="#666666">#</font></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>IP </strong></td>
            <td>&nbsp;</td>
            <td>#</td>
          </tr>
          <tr align="right">
            <td colspan="3" height="20"><img src="images/perfil/0.png" height="50" width="647"></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>Nivel</strong></td>
            <td>&nbsp;</td>
            <td><?=getImgLevel($_SESSION["s_usuario"]);?>              &nbsp;<span class="style2"><?=getRank($_SESSION["s_usuario"]);?>: (<?=getGP($_SESSION["s_usuario"]);?>
            GP) /  Semanal: 
            <?=getRankSemanal($_SESSION["s_usuario"]);?>: (<?=getRankSemanal($_SESSION["s_usuario"]);?> GP) </span></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>Rank</strong></td>
            <td>&nbsp;</td>
            <td>166</td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>Guild</strong></td>
            <td>&nbsp;</td>
            <td>                            <?
			$user = $_SESSION['s_usuario'];
			$get_clan = mysql_query("select Guild from game where Id='$user'");
			$rq = mysql_fetch_array($get_clan);
			$clan = $rq['Guild'];
			if($clan == '' or NULL){
			?>
            <a href="index.php?page=#">Lista de clãns</a>
                <? }else{
					$get_id_clan = mysql_query("select * from guildweb where guild='$clan'");
					$rw = mysql_fetch_array($get_id_clan);
					$id = $rw['Id'];
					$guild = $rw['guild'];
					 ?>
                <a href="index.php?page=#"><?=$id?><?=$guild?></a>
                <? } ?></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>Average Damage</strong></td>
            <td>&nbsp;</td>
            <td><font color="#666666">
              </font></td>
          </tr>
          <tr align="right">
            <td colspan="3" height="20"><img src="images/perfil/02.png" height="50" width="647"></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>Gold</strong></td>
            <td>&nbsp;</td>
            <td><span class="style3"><?=getGold($_SESSION["s_usuario"]);?></span></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>Cash</strong></td>
            <td>&nbsp;</td>
            <td class="style3"><span class="style3"><?=getCash($_SESSION["s_usuario"]);?></span> </td>
          </tr>
          <tr align="right">
            <td colspan="3" height="20"><img src="images/perfil/03.png" height="50" width="647"></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>Classe</strong></td>
            <td>&nbsp;</td>
            <td><?php
			if (isVip($_SESSION["s_usuario"])){
				
				$id = $_SESSION["s_usuario"];
				$sql = mysql_query("select * from vip where usuario='$id'");
				$row = mysql_fetch_array($sql);

			echo 'VIP ( ' .$row["dias"] . ' dias restantes! )';
			} else {
				echo 'Normal';
			}
			?></td>
          </tr>
          <tr>
            <td class="gameid_status" align="right" height="20"><strong>GP Vip </strong></td>
            <td>&nbsp;</td>
            <td class="style2"><?=getGpExtra($_SESSION["s_usuario"]);?> GP (+30%) </td>
          </tr>
        </tbody>
      </table>
            </div> 

</div>
<div id="center_conteudo_footer">&nbsp;<div id="centro_footer_texto_topo"><a href="#btopo" title="Topo"><img src="index.php_arquivos/up.png" height="26" width="18"></a></div>