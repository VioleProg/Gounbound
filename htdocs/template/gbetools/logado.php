
<head>
<meta http-equiv="Content-Language" content="pt-br">
</head>

<div id="login_main">
  <!-- Deslogado -->
	<div class="login_box" id="login_container">
		<div class="login_box_top"><img src="template/gbetools/images/login_title2.png" /></div>		
    <div class="login_box_content">
			<div class="login_box_sub">
				<div class="login_box_sub_top">          
        &nbsp;</div>
				<div class="login_box_sub_content" id="login" style="width: 297px; height: 100px">					

					<div style="margin:0 auto; text-align:center;">
          <div style="font-size:8pt; padding-left:-5px; padding-right:5px;">
			<table border="0" width="103%" id="table1">
				<tr>
					<td width="36" valign="top">
					<img src="images/perfil_logado.gif" width="36" height="30" /></td>
					<td width="113" valign="top" align="left" rowspan="2">
				 <font color="#333333" size="1" face="Arial">Olá!<?=getminirank($game['CountryGrade']); ?></font> <b><?=$user['Id']?></b><br />
                 <img src="images/img_larger.gif" width="9" height="8" /><font face="Arial" size="1" color="#333333"><?=$game['TotalRank'];?>° (<?=$game['TotalScore'];?> GP)</font><br />
                 <img src="images/img_larger.gif" width="9" height="8" /><font face="Arial" size="1" color="#333333"> Moedas-G: 100</font><br />
				 <img src="images/img_larger.gif" width="9" height="8" /><font color="#333333" size="1" face="Arial"> Gold: <?=number_format($game['Money']);?></font><br />
				 <img src="images/img_larger.gif" width="9" height="8" /><font color="#333333" size="1" face="Arial"> Cash: <?=number_format($cash['Cash']);?></font><br />
              </td>
					<td rowspan="2" valign="top" align="left">
				 <img src="images/edit.gif" width="12" height="12"><b><font face="Arial" size="1"> </font><a href="stats.jsp" style="text-decoration: none"><font face="Arial" size="1" color="#000000">Ver minha conta</font></a></b><br>
				 <img src="images/logined06.gif" width="12" height="12"><b><font face="Arial" size="1"> </font><a href="pontos.jsp" style="text-decoration: none"><font face="Arial" size="1" color="#000000">Trocar pontos</font></a></b><br>
					<img border="0" src="images/byimds.gif" width="75" height="26"><br>
					<a href="home.jsp?logout=1"><img border="0" src="images/icone_sair.gif" width="59" height="14" align="right"></a><br />
						</td>
				</tr>
				<tr>
					<td width="36" align="right" height="21">&nbsp;</td>
				</tr>
			</table>					

			</div>  
					</div>

				</div>
				<div class="login_box_sub_bottom">
					<p align="left">
					<b>
					<a href="#" id="toggleMenu" style="text-decoration: none">
					<font face="Arial" size="4" color="#0066CC">+</font></a></b></div>
			</div>
		</div>
		<div class="login_box_bottom"></div>
	</div>
  


</div>