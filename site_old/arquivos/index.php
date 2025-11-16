<? require'essencial.php'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="google-site-verification" content="lZR8OVAj0M7VIMm4iR1FwunYOth33op1f5etWSgIywU" />
<meta name="description" content="Bem-vindo a um novo mundo de Gunbound, onde você realmente faz a diferença! Cadastre-se já." />
<meta name='keywords' content="Gunbound, GBeyond, Gunbound Season 1, GBWC, GBS, Gunbound Brasil, GB Pirata, GB Server, GBeyond Season 1" />

<!--CSS-->
		<link rel="stylesheet" type="text/css" href="gbeyond/common/stylesheets/global.css"  webstripperwas="/gbeyond/common/stylesheets/global.css" >				
		<link rel="stylesheet" type="text/css" href="gbeyond/common/javascript/shadowbox/shadowbox.css"  webstripperwas="/gbeyond/common/javascript/shadowbox/shadowbox.css" >
        <!--span title-->
        <script type="text/javascript" src="js/unitip.js"></script>
        <script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="js/ajax.js"></script>
        <link href="css/unitip.css" rel="stylesheet" type="text/css" /> 
        <!--keep css-->
        <link rel="stylesheet" type="text/css" href="estilo.css"  webstripperwas="estilo.css" >
		<!--[if IE 6]><link rel="stylesheet" type="text/css" href="gbeyond/common/stylesheets/main_ie6.css"  webstripperwas="/gbeyond/common/stylesheets/main_ie6.css" /><![endif]-->		
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="gbeyond/common/stylesheets/main_ie7.css"  webstripperwas="/gbeyond/common/stylesheets/main_ie7.css" /><![endif]-->		
      	<!--[if IE 8]><link rel="stylesheet" type="text/css" href="gbeyond/common/stylesheets/main_ie7.css"  webstripperwas="/gbeyond/common/stylesheets/main_ie7.css" /><![endif]--><!--[if IE 9]><link rel="stylesheet" type="text/css" href="gbeyond/common/stylesheets/main_ie7.css"  webstripperwas="/gbeyond/common/stylesheets/main_ie7.css" /><![endif]-->	
        <!--ENDCSS-->
<title>GBeyondWC - Definitavamente &uacute;nico e para voc&ecirc;!</title>
<script language="JavaScript">
<!-- //Courier New,Courier,fixed,
function OnLoad() {
if (document.getElementById) // IE5 NN6
document.getElementById("loading").style.visibility="hidden";
else if (document.layers) // NN4
document.loading.visibility="hidden";
else if (document.all) // IE4
document.all.loading.style.visibility="hidden";
}
-->
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];

  _gaq.push(['_setAccount', 'UA-16024315-1']);

  _gaq.push(['_trackPageview']);

  (function() {

    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

  })();
</script>
		<script type="text/javascript" src="gbeyond/common/javascript/shadowbox/shadowbox.js"></script>	
        <script type="text/javascript">
		$(document).ready(function(){$.preloadCssImages();});
		</script>
		<!--[if IE 6]><script type="text/javascript" src="gbeyond/common/javascript/jquery.pngFix.js"  webstripperwas="/gbeyond/common/javascript/jquery.pngFix.js" ></script><![endif]-->
		<!--<style>body{background-attachment:fixed;background-repeat:no-repeat;background-color:#c9eafa;background-image:url("http://img811.imageshack.us/img811/2449/halloweenbg3.jpg");}</style>-->
<style>
		body{background-attachment:scroll;background-repeat::no-repeat;background-color:#c2e5f5;background-image:url("http://imagem.gbeyondwc.com/corpo/fundo2_tiny.jpg");}.style5 {font-family: Geneva, Arial, Helvetica, sans-serif}

b1 {color: #F60;}
</style>
</head>
<body>
  <?php

function redirecionar($url, $tempo)

{

    $url = str_replace('&amp;', '&', $url);

        

    if($tempo > 0)

    {

        header("Refresh: $tempo; URL=$url");

    }

    else

    {

        @ob_flush();

        @ob_end_clean();

        header("Location: $url");

        exit;

    }

}

?>
<script type="text/javascript" src="js/MainFlash.js"></script>									
<div align="center" id="gbeyond_bar">
<div class="bar"><? include"arquivos.php/menu.php"; ?></div>
</div>
<div id="container">
<? include'topo.php' ?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="985" height="59">
 
<param name="movie" value="swf/menu_normal.swf" />
<param name="menu" value="false" />
<param name="wmode" value="transparent" />
<embed src="swf/menu_normal.swf" width="985" height="59" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed>
</object>
		  <div id="column_left">

		    <div class="block white promos">

			  <div class="content">

							<div class="t"></div>	

							<div class="clear">

							</div>

                            <h3>Top 5 Players <a href="?page=rank">(+)</a></h3>

							<ul><? include'arquivos.php/top10.php' ?></ul>

					<div style="height:1px;"></div>														

			  </div>

						<div class="b">

							<div></div>

						</div>

	  </div>		

      <div class="block white promos">

				  <div class="content">

							<div class="t"></div>	

							<div class="clear">

							</div>

					<div>

                            <h3>Top 5 Semanal <a href="?page=rank_semanal">(+)</a></h3>

							<ul><? include'arquivos.php/top10_semanal.php' ?>

</ul>

					</div>

					<div style="height:1px;"></div>														

		</div>

						<div class="b">

							<div></div>

						</div>

	  </div>	
       <div class="block white promos">

				  <div class="content">

							<div class="t"></div>	

							<div class="clear">

							</div>

			  <div>

<h3>Black List (1x1)<a href="?page=rank_semanal"></a></h3>

							<ul>
                            <body onload="OnLoad()">
                            <div align="center" id="loading" style="width: 45px; height: 20px; position: absolute; top: 1; left: 46px;">
                              <p><img src="http://imagem.gbeyondwc.com/hospedagem/3163ccb83b.gif" width="24" height="24" />
                              </p>
                              <p>Getting Player</p>
</div>                       <iframe  allowtransparency="1" src="blacklist.php" frameborder="0" width="160px" height="200px"></iframe>
</body>
                            </ul>

					</div>

					<div style="height:1px;"></div>														

		</div>

						<div class="b">

							<div></div>

						</div>

	  </div>	

   
					

</div>

			<div id="column_center">
			  <p>
			    <script type="text/javascript" src="gbeyond/common/javascript/jquery-ui.js"  webstripperwas="/gbeyond/common/javascript/jquery-ui.js" ></script>
			    
  <span class="style5">
			      <?

		if (checasessao()){

		$usuario = $_SESSION["s_usuario"];

		}



	$page = !isset($_GET['page']) ? "inicio" : $_GET['page'] ;

		if (strpos($_GET['page'], "/") || strpos($_GET['page'], "\\")){

		$page = "paginanaoecontrada";

		}

		

		if (substr($_GET['page'],0,4) == "clans"){

		$tpage = $page;

		$page = "clan/" . $pagee;

		}

		







		if (is_file("arquivos.php/".$page.".php")) {

		include("arquivos.php/".$page.".php");

		

	

   } else {	



		include("arquivos.php/paginanaoecontrada.php");

   }

   ?></span>      
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>        
</div>

				

				<div id="column_right">

				  <div class="block white authentication">

						<div class="content">

						  <div class="t"></div>

						  <p>

						     <?php 

                if (checasessao()){

                include("arquivos.php/logado.php");

                }

                else {

                include("arquivos.php/login.php");
				}

                ?>

						  </p>

						</div>

						<div class="b">

							<div></div>

						</div>

				  </div>
               

													<div class="block white weekly">

						<div class="content">

						  <div class="t"></div>							

						  <h3>Quick Link						  </h3>
						  <p><a href="?page=cadastro">Registre-se</a></p>
						  <p><a href="?page=download">Download</a></p>
						  <p><a href="?page=avatar_semanal" target="_self">Avatar da Semana</a></p>
						  <p><a href="http://www.orkut.com.br/Main#Community?cmm=99172169" target="_new">Comunidade Orkut</a></p>
                          <p><a href="?page=problemas_solucoes"><img src="http://imagem.gbeyondwc.com/erros/t_solution.jpg" width="210" height="70" /></a></p>

						</div>

						<div class="b">

							<div></div>

						</div>

				  </div>	
                  
<? 
$user = $_SESSION['s_usuario'];
$sql_propaganda = mysql_query("select TotalGrade from game where Id='$user'");
$rsv = mysql_fetch_array($sql_propaganda);
$vip = $rsv['TotalGrade'];
if($vip != '37'){
 ?>
                    <div class="block white weekly">

						<div class="content">

							<div class="t"></div>							

						  <h3>Publicidade</h3>
					      <table bgcolor="#CCCCCC" width="200" border="0">

  <tr>

    <td>                          <script type="text/javascript"><!--

google_ad_client = "ca-pub-0211186737484423";

/* GBeyond Site */

google_ad_slot = "2989698228";

google_ad_width = 200;

google_ad_height = 90;

//-->

</script>

<script type="text/javascript"

src="http://pagead2.googlesyndication.com/pagead/show_ads.js">

</script></td>

  </tr>

</table>

			

					      </p>						

					  <p>&nbsp;</p>

						</div>

						<div class="b">

							<div></div>

						</div>

				  </div>	
<? } ?>						
				

</div>				




</div>			

			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
<p>&nbsp;</p>
			<p>&nbsp;</p>
<div id="footer">
<p>&nbsp;</p>
<p><a href="http://gbeyondwc.com" ><img src="http://img299.imageshack.us/img299/5606/16009558.png" name="logo_gbeyond" id="logo_goacom"  webstripperwas="/gbeyond/common/images/logo_goacom.jpg" ></a></p>
			  <p>&nbsp; </p>
<p class="menu">&nbsp;</p>
<p class="menu">&nbsp;</p>
<p class="menu"><br/>
  </p>
<p class="comm">GBeyondWC - Todos os Direitos Reservados 2010 &reg;</p>
				<p>&nbsp;</p>
<p class="copyright">GBeyondWC 2010-2011<br/> 
			  Gunbound é uma marca registrada pela SoftNyx.</p>
<p class="copyright">&nbsp;</p>
<p class="copyright">&nbsp;</p>
<p class="copyright">&nbsp;</p></div>
</body>

</html>

<?php 

mysql_close($link);

?>