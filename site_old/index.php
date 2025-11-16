<?php

session_start();

header('P3P: CP="CAO PSA OUR"');

ini_set('session.use_only_cookies', 1); 

$verde = 0;

$msg = "";

require_once "_inc/scretmysql_.php";
require_once "_inc/login.php";
require_once "_inc/usuarios.php";
require_once "_inc/validation.php";
require_once "_inc/log.php";

if (isset($_POST["usuario"]) && isset($_POST["usuario"])){
$verde = login($_POST["usuario"], $_POST["senha"]);


	if ($verde <> 1){
		$msg="O nome de usuário e a senha não correspondem.";
	}
}

if (isset($_GET["logout"])){
session_destroy();
$_SESSION["s_usuario"] = "";
$_SESSION["s_senha"] = "";
header("location:index.php");
deslogar();

  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gunbound Thors Hammer ::</title>
<link rel="stylesheet" href="gbound.css" type="text/css">
<style TYPE="text/css">
<!--

-->
</style>
</head>

<body>   

	
	
<div id="btopo">
  <div id="btopo_texto">
   <div id="btopo_left"></div>
   <div id="btopo_right"></div>
		<div id="btopo_conteudo_registrar">		<?php if (checasessao()){
		echo '<img src="images/botoes/registrese_off.png"/>';
		} else {
		echo '<a href="index.php?page=registrar"><img src="images/botoes/registrese.png"/></a>';		
		}
		?> 	</div><form method='post' action='index.php?page=ranking&amp;rank=total'>   
  	<div id="buscar_ranking_topo"><div id="buscar_ranking_info"></div><div id="buscar_ranking_bg"><div id="buscar_ranking_form">
	  <input name='busca' type='text' class='buscarrank' id="busca"/> </div><div id="buscar_ranking_botao">
	    <input src='images/botoes/next.png' name='Submit' type='image'  /></div> </form>
		
	</div>
	</div><div id="softnyxlogo"></div>
     <!-- <div id="download_botao"><a href="index.php?page=download"><img src="images/download.png" width="157" height="32" border="0" /></a></div> --> 
	 	<div id="botao_buddy">
		<?php if (checasessao()){
		echo '<img src="images/botoes/buddy.png"/>';
		} else {
		echo '<img src="images/botoes/buddy_off.png"/>';		
		}
		?>
        </div> 
		<div id="botao_avatar"><a href="#"><img src="images/botoes/avatar.png" width="107" height="46" border="0" /></a></div>
  </div>
</div><div id="fundo"> <div id="topo"><div id="topo_logotipo"></div><div id="icone_logo"></div>
<?php 
		if (checasessao()){
		include("arquivos/logado.php");
				} else {
		include("arquivos/login.php");
			if ($msg !=""){
				echo "<SCRIPT LANGUAGE=\"JavaScript\">
				<!--
				alert(\"" . $msg ."\")
				//-->
				</SCRIPT>";
			}
		}
		?>
<div id="bg_menu"> 
  <div id="menuItem"><a href="index.php?page=home" id="menuItem_botao"><img src="images/botoes/home.png" /></a></div>
  <div id="menuItem"><a href="index.php?page=guia&amp;pg=introducao" id="menuItem_botao"><img src="images/botoes/gunbound.png" border="0" /></a></div>
  <div id="menuItem"><a href="?page=forum" id="menuItem_botao"><img src="images/botoes/forum.png" border="0" /></a></div>
  <div id="menuItem"><a href="index.php?page=ranking&amp;rank=total&amp;next=1" id="menuItem_botao"><img src="images/botoes/rank.png" border="0" /></a></div>
  <div id="menuItem"><a href="index.php?page=cla" id="menuItem_botao"><img src="images/botoes/guild.png" border="0" /></a></div>
   <div id="menuItem"><a href="index.php?page=suporte" id="menuItem_botao"><img src="images/botoes/help.png" border="0" /></a></div>
  </div>
</div>
</div>
<div id="centro">	
<div id="centro_left">
<div id="left_bg_topo">
<div id="left_logotipo"><img src="images/icones/01.png" width="24" height="22" /></div>
<div id="left_titulo"><a href="index298c.html?page=download"><img src="images/botao_download.png" width="124" height="26" border="0" /></a></div>
</div>
<div style="clear:both; height: 5px;"></div>
<!-- Inicio -->
<div id="left_conteudo_topo">
<div id="left_bg_topo_outro_topo">
<div id="left_outro_logotipo"><img src="images/icones/02.png" width="35" height="20" /></div> 
<div id="left_outro_titulo"><img src="images/titulos/event.png" border="0" /></div>
</div>
<div id="left_bg_topo_outro_meio">
<div id="left_bg_topo_outro_meio_conteudo">
  <p align="center"><a href="#"><img src="images/event/01.jpg" width="199" height="105" border="0" /></a></p>
  </div>
</div>
<div id="left_bg_topo_outro_footer"></div>
</div>
<!-- Fim --><!-- Inicio -->
<div style="clear:both; height: 5px;"></div>
<div id="left_conteudo_topo">
<div id="left_bg_topo_outro_topo"></div>
<div id="left_bg_topo_outro_meio">
<div id="left_bg_topo_outro_meio_conteudo">
  <div align="center"><img src="images/global_gb.png" width="183" height="14" border="0" usemap="#Map" />
<map name="Map" id="Map"><area shape="rect" coords="2,2,18,10" href="http://gunbound.softnyx.net/" target="_blank" />
<area shape="rect" coords="29,3,46,12" href="http://gunbound.softnyx.com/" target="_blank" />
<area shape="rect" coords="56,3,74,11" href="http://gunbound.softnyx-korea.net/" target="_blank" />
<area shape="rect" coords="83,3,103,11" href="http://gunbound.softnyxbrasil.com/" target="_blank" />
<area shape="rect" coords="112,3,131,12" href="http://gb.softnyx.co.id/" target="_blank" />
<area shape="rect" coords="137,3,157,11" href="http://gunbound.softnyx.ph/" target="_blank" />
<area shape="rect" coords="163,3,183,11" href="http://www.gboundth.com/" target="_blank" />
</map></div>
</div>
</div>
<div id="left_bg_topo_outro_footer"></div><div id="gb_left_logotipo"><img src="images/icones/01.png" width="24" height="22" /></div>
<div id="gb_left_titulo"><img src="images/titulos/download_client.png" width="166" height="22" border="0" /></div>

</div>
<!-- Fim -->
<!-- Inicio -->
<div style="clear:both; height: 5px;"></div>
<div id="left_conteudo_topo">
<div id="left_bg_topo_outro_topo">
<div id="left_outro_logotipo"><img src="images/icones/05.png" width="35" height="25" /></div> 
<div id="left_outro_titulo"><img src="images/titulos/toprank.png" width="106" height="25" border="0" /></div>
</div>
<div id="left_bg_topo_outro_meio">
<? include'arquivos/top_5.php' ?>
</div>
<div id="left_bg_topo_outro_footer"></div><div style="clear:both; height: 5px;"></div>

</div>
<!-- Fim -->
<!-- Inicio -->
<div id="left_conteudo_topo">
<div id="left_bg_topo_outro_topo">
<div id="left_outro_logotipo"><img src="images/icones/07.png" width="35" height="22" /></div> 
<div id="left_outro_titulo"><img src="images/titulos/avatar.png" border="0" /></div>
</div>
<div id="left_bg_topo_outro_meio">
<div id="left_bg_topo_outro_meio_conteudo"><p>
  <div align="center">
    <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center"></table>  </div></p>
</div>
</div>
<div id="left_bg_topo_outro_footer"></div>
</div>
<!-- Fim -->


</div>
<div id="lado_direito_info"> </div>
<div id="centro_center"><style type="text/css">
<!--

#bg_news_titulo {
background-image:url(images/bg_news.jpg); background-repeat:repeat-x;
width:661px;
height:26px;
position: relative;
margin: 0px auto;
border:1px solid #9E7001;
}
#bg_news_titulo_rank {
	width:30px;
	height:20px;
	position: absolute;
	background-image:url(ranks/rank_20.gif);
	background-repeat:no-repeat;
	top: 6px;
	left: 8px;
}
#bg_news_titulo_texto {
	width:613px;
	height:20px;
	position: absolute;
	top: 4px;
	left: 40px;
	font-size:14px;
	color:#FFFFFF;
	font-weight:bold;
}

#bg_news_texto {
width:650px;
position: relative;
margin: 0px auto;
color:#011054;
padding:5px;
}
#lertudo a{
color:#0000FF;
}

-->
</style>
<?
		if (checasessao()){
		$usuario = $_SESSION["s_usuario"];
		}
	$page = !isset($_GET['page']) ? "home" : $_GET['page'] ;

		if (strpos($_GET['page'], "/") || strpos($_GET['page'], "\\")){
		$page = "construcao";
		}
		if (substr($_GET['page'],0,4) == "clans"){
		$tpage = $page;
		$page = "clan/" . $pagee;
		}
		if (is_file("arquivos/".$page.".php")) {

		include("arquivos/".$page.".php");

   } else {	
		include("arquivos/construcao.php");
   }

   ?> 
</div>
</div>
</div>
<div style="clear:both; height: 20px;"></div>
<div id="footer_bg"></div><!-- 
<div id="layer_pop" style="top: 0px; left: 0px; width: 100%; padding:100px 0px; margin: 0px auto; background-image:url(images/bg_anunncied.png); background-repeat:repeat;">
  <div class="inner">
	<div class="layer_notice">
    </div>
	  <div align="center"><a href="#" onClick="confirmGameLangLayer(''); return false;" ><img src="images/ico_close.png" alt="Close" width="100" height="24" border="0" class="btn_close"></a> </div>
  </div>
</div>

 -->
 
</body>


</html>
