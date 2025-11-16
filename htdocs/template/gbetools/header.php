<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="imagetoolbar" content="no" />
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title><?=$config['server_name']?></title>
<link rel="stylesheet" href="template/gbetools/css/main.css" />

	<!-- START Fx.Slide -->
    <!-- Mootools - the core -->
	<script type="text/javascript" src="js/mootools-1.2-core-yc.js"></script>
    <!--Toggle effect (show/hide login form) -->
	<script type="text/javascript" src="js/mootools-1.2-more.js"></script>
	<script type="text/javascript" src="js/fx.slide.js"></script>
	<!-- END Fx.Slide -->

</head>
<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
<!--[if lte IE 6]>
	<script type="text/javascript" src="template/gbetools/js/unitpngfix.js"></script>
	<link rel="stylesheet" type="text/css" href="template/gbetools/css/ie6.css" />
<![endif]-->
<script type="text/javascript" src="template/gbetools/js/main.js" ></script>
<!--script type="text/javascript" language="JavaScript" src="template/gbetools/js/stmenu.js"></script-->

<div id="wrapper">
	<div id="wrapper2" style="background-image: url('template/gbetools/images/top_visual.jpg');">		<div id="page">
			<div id="header">
      	<!--
				Header Area!
				  
                                <div style="background-color: #fff; padding: 20px;">
                                <a href="/?m=game">GAME</a> |
                                <a href="/?m=community">COMMUNITY</a> |
                                <a href="/?m=shop">ITEM SHOP</a> |
                                <a href="/?m=media">MEDiA</a>
                                </div>
        -->
<div style="position:absolute; z-index:9; left:140px; top:-70px; width:188px; height:2px"><script language="javascript">flashWrite('template/gbetools/swf/logo.swf',300,250,'','','transparent')</script></div>
<div style="position:absolute; z-index:9; left:569px; top:15px; width:188px; height:2px">
<script src="template/gbetools/js/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','540','height','280','src','novidades','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','menu','false','wmode','transparent','movie','novidades' ); //end AC code
</script><noscript>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="540" height="280">
          <param name="movie" value="template/gbetools/swf/novidades.swf" />
          <param name="quality" value="high" />
          <param name="menu" value="false" />
          <param name="wmode" value="transparent" />
          <embed src="template/gbetools/swf/novidades.swf" width="540" height="280" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed>
</object>
</noscript>
</div> 

 <div style="position:absolute; z-index:10; top:253px;left:97px"><script type="text/javascript" language="JavaScript1.2" src="template/gbetools/js/menubody.js"></script></div>

			</div>
			
<?PHP
					    if (@$config['user_login'] == 'ok') {
						include "logado.php";
				        }else{
				           include "deslogado.php";
				        }
					
					?>			
			<div id="content">
<div id="left">
	
<div class="column_box" id="left_menu">
	        <div class="column_box_top">
	                <img src="template/gbetools/images/left_title_community.png" />
	        </div>
	        <div class="column_box_content">
	                <div class="left_menu_items">
	                        <div class="menu_divider"></div>
	                        <div class="clear"></div>
<a href="home.jsp"><img src="template/gbetools/images/left_1.png" /><span style="display: none;"></span></a>
<a href="comojogar.jsp"><img src="template/gbetools/images/left_2.png" /><span style="display: none;"></span></a>
<a href="ranking.jsp"><img src="template/gbetools/images/left_3.png" /><span style="display: none;"></span></a>
<a href="download.jsp"><img src="template/gbetools/images/left_8.png" /><span style="display: none;"></span></a>
<a href="forum.jsp"><img src="template/gbetools/images/left_4.png" class="selected" /><span style="display: none;"></span></a>
<a href="tabela.jsp"><img src="template/gbetools/images/left_5.png" class="selected" /><span style="display: none;"></span></a>
<a href="loja.jsp"><img src="template/gbetools/images/left_6.png" class="selected" /><span style="display: none;"></span></a>
<a href="suporte.jsp"><img src="template/gbetools/images/left_7.png" class="selected" /><span style="display: none;"></span></a>

	                 </div>
	                 </div>
	                 <div class="column_box_bottom"></div>
                  <!-- Facebook Fan Box -->
	<div class="column_box" id="advertisements_container">
		<div class="column_box_top"><img src="template/gbetools/images/column_title_top10.png" /></div>		
    <div class="column_box_content">
			<div class="column_box_sub">
				<div class="column_box_sub_top">          
        </div>
				<div class="column_box_sub_content" id="advertisements">					

					<div style="margin:0 auto; text-align:right;">
          <div style="font-size:8pt; padding-left:0px;"><?php include "modules/top_rank.php"; ?></div>  
					</div>

				</div>
				<div class="column_box_sub_bottom"></div>
			</div>
		</div>
		<div class="column_box_bottom"></div>
	</div>
	<?PHP if ($config['admin_login'] == 'ok') {
					?>	 
	<div class="column_box" id="advertisements_container">
		<div class="column_box_top"><img src="template/gbetools/images/column_title_adm.png" /></div>		
    <div class="column_box_content">
			<div class="column_box_sub">
				<div class="column_box_sub_top">          
        </div>
				<div class="column_box_sub_content" id="advertisements">					

					<div style="margin:0 auto; text-align:left;">
          <div style="font-size:8pt; padding-left:0px;">
<table border="0" width="100%">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="admin.jsp" style="text-decoration: none"><font color="#000000">Painel de
</font> <b><font color="#000000">controle</font></b></a></td>
</tr>
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="ban.jsp" style="text-decoration: none"><font color="#000000">Painel de
</font> <b><font color="#000000">banidos</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table7">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="rank_update.jsp" style="text-decoration: none"><font color="#000000">Atualizar 
</font> <b><font color="#000000">ranking</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table12">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="atualizartop200.jsp" style="text-decoration: none">
<font color="#000000">Atualizar </font> <b><font color="#000000">Top200</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table2">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="add_avataruser.jsp" style="text-decoration: none">
<font color="#000000">Adicionar </font> <b><font color="#000000">avatar user</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table3">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="add_vip.jsp" style="text-decoration: none"><font color="#000000">Adicionar 
</font> <b><font color="#000000">vip</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table4">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="add_cash.jsp" style="text-decoration: none"><font color="#000000">Adicionar 
</font> <b><font color="#000000">cash</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table5">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="add_gcoin.jsp" style="text-decoration: none"><font color="#000000">Adicionar 
</font> <b><font color="#000000">créditos</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table6">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="editacc.jsp" style="text-decoration: none"><font color="#000000">Editar 
</font> <b><font color="#000000">conta</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table8">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="gbe_noticias_new-topico.jsp" style="text-decoration: none">
<font color="#000000">Postar </font> <b><font color="#000000">notícia</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table9">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="fevento_new-topico.jsp" style="text-decoration: none">
<font color="#000000">Postar </font> <b><font color="#000000">evento</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table10">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="add_avatarlist.jsp" style="text-decoration: none">
<font color="#000000">Postar </font> <b><font color="#000000">avatar no shop</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table11">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="add_credvip.jsp" style="text-decoration: none"><font color="#000000">Postar 
</font> <b><font color="#000000">pacotes no credvip</font></b></a></td>
</tr>
</table>
<table border="0" width="100%" id="table13">
<tr>
<td align="middle" width="26"><img src="images/img_larger.gif" align="middle"></td>
<td align="middle">
<a href="current.jsp" style="text-decoration: none"><font color="#000000">Últimos 
</font> <b><font color="#000000">Logins</font></b></a></td>
</tr>
</table>
			</div>  
					</div>

				</div>
				<div class="column_box_sub_bottom"></div>
			</div>
		</div>
		<div class="column_box_bottom"></div>
	</div>
 <? } ?>	 	
	         </div>	<div class="column_box" id="quicklinks">
		<div class="column_box_top">
			<img src="template/gbetools/images/column_title_quicklinks.png" />
		</div>
		<div class="column_box_content">
			<a href="forum.jsp"><img src="template/gbetools/images/quicklink_forum.png" /></a>
			<a href="download.jsp"><img src="template/gbetools/images/quicklink_gameinfo.png" /></a>
		</div>
		<div class="column_box_bottom"></div>
	</div>  
  

  


</div>