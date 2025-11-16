<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_ranking.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>

<head>
<link href="images/portal.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_content.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_main.css" rel="stylesheet" type="text/css" />
<SCRIPT LANGUAGE="JavaScript">
function valid(value){
    open("index.php?op=playlog&url="+value,"chkuser")
}

<!--



function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<style type="text/css">
<!--
.style2 {font-weight: bold}
.style3 {	color: #666666;
	font-family: "Century Gothic";
	font-size: 14px;
}
.style4 {	font-size: 24px;
	color: #999900;
	font-family: "Century Gothic";
}
.style5 {font-size: 24px; color: #999900; font-family: "Century Gothic"; font-weight: bold; }
-->
</style>
</head>

<body>
<?PHP if ($config['admin_login'] == 'ok') {
					?>
					<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  </tr>
</table>
<table width="706" border="0">
  <tr>
    <td width="584" align="center">
      <table cellspacing="0" cellpadding="0" width="422" border="0">
        <tr>
          <td height="10" colspan="2" align="center"><table width="420">
              <tr>
                <td width="129"><table width="147" border="2" cellpadding="0" cellspacing="0" bordercolor="#F4F4F4">
                    <tr>
                      <td width="141"><div align="left"><span class="admin">ADM: </span>
                            <?=getminirank($game['TotalGrade']); ?>
                              <strong>
                              <?=$user['Id']?>
                              </strong></div></td>
                    </tr>
                    <tr>
                      <td><div align="left"><span class="admin">Ip:</span><span class="RankMenu stylejohanstats style2">
                          <?=$_SERVER['REMOTE_ADDR'];?>
                      </span></div></td>
                    </tr>
                    <tr>
                      <td height="28" align="center"><div align="center"><a href="home.jsp?logout=1">Logout (Sair) </a></div></td>
                    </tr>
                </table></td>
                <td width="279" align="center" class="register"><!-- MENU-LOCATION=NONE -->
                    <!-- MENU-LOCATION=NONE -->
                    <!-- MENU-LOCATION=NONE -->
                    <table width="265" border="1" cellpadding="0" cellspacing="0" bordercolor="#F4F4F4">
                      <tr>
                        <td width="111"><table width="111" align="center" bgcolor="#FFFFFF">
                            <tr>
                              <td width="101" height="21" align="center" valign="bottom" bgcolor="#FFFFFF" class="style3">&nbsp;Buscar</td>
                            </tr>
                            <tr>
                              <td height="31" valign="top" bgcolor="#FFFFFF"><div align="right" class="style4">Conta!</div></td>
                            </tr>
                        </table></td>
                        <td width="142"><?PHP
							  if (isset($_POST) && valid_account($_POST['Id']) == true) 			
$where = '';
	if (isset($_POST['name'])) {
		if (clean_variable($_POST['name'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['name'];
		}
	} 
	echo "<form method='post' action='ranking-search.jsp'> 
  <input type=text name='name' class='textfield' value='World Ranking' size='15' maxlenght='10' >
  <input name='Submit' type='image' src='images/bt_ok.gif'></form>";
?>
                            <br/>
                          
                            <?PHP
							  if (isset($_POST) && valid_account($_POST['Id']) == true) 			
$where = '';
	if (isset($_POST['name'])) {
		if (clean_variable($_POST['name'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['name'];
		}
	} 
	echo "<form method='post' action='editacc-search.jsp'> 
  <input type=text name='name' class='textfield' value='Editar' size='15' maxlenght='10' >
  <input name='Submit' type='image' src='images/bt_ok.gif'></form>";
?>
                            <br>
                            <form action="admin.jsp" method=post>
                            <input name="username" type="text" class='textfield' size='15' value="logs por LOGIN">
                            <span>
						
                            <input name="button" type='image' src='images/bt_ok.gif' onClick="valid(this.form.username.value)" value="Buscar"></span></form>
                            </span><br>
							</td>
                      </tr>
                  </table></td>
              </tr>
            </table>
              <table width="420">
                <tr>
                  <td width="173" valign="top">
					<table width="210" bgcolor="#FBFBFB">
                      <tr>
                        <td width="10" class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<a href="ban.jsp" style="text-decoration: none">
							<font color="#000000">Painel de Banidos</font></a></div></td>
                      </tr>
                      <tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<strong style="font-weight: 400">
							<a href="rank_update.jsp" style="text-decoration: none">
							<font color="#000000">Atualizar Ranking</font></a></strong></div></td>
                      </tr>
						<tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<strong style="font-weight: 400">
							<a href="add_avataruser.jsp" style="text-decoration: none">
							<font color="#000000">Adicionar AvatarUser</font></a></strong></div></td>
                      </tr>
						<tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<strong style="font-weight: 400">
							<a href="add_vip.jsp" style="text-decoration: none">
							<font color="#000000">Adicionar Membro Vip</font></a></strong></div></td>
                      </tr>
                      <tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<a href="add_cash.jsp" style="text-decoration: none">
							<font color="#000000">Adicionar Cash</font></a></div></td>
                      </tr>
                      <tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<a href="add_gcoin.jsp" style="text-decoration: none">
							<strong style="font-weight: 400">
							<font color="#000000">Adicionar Moedas-G</font></strong></a></div></td>
                      </tr>
                      <tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<a href="editacc.jsp" style="text-decoration: none">
							<font color="#000000">Editar conta</font></a></div></td>
                      </tr>
                      <tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao">
						<a href="gbe_noticias_new-topico.jsp" style="text-decoration: none">
						<font color="#000000">Postar Notícia</font></a></td>
                      </tr>
                      <tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<a href="fevento_new-topico.jsp" style="text-decoration: none">
							<strong style="font-weight: 400">
							<font color="#000000">Postar Evento</font></strong></a></div></td>
                      </tr>
                      <tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<a href="add_avatarlist.jsp" style="text-decoration: none">
							<font color="#000000">Adicionar AvatarShop </font> </a></div></td>
                      </tr>
                      <tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<a href="add_credvip.jsp" style="text-decoration: none">
							<font color="#000000">Adicionar Pacotes CredVip 
							</font> </a></div></td>
                      </tr>
                      <tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao"><div align="left">
							<a href="atualizartop200.jsp" style="text-decoration: none">
							<font color="#000000">Atualizar Top200</font></a></div></td>
                      </tr>
                      <tr>
                        <td class="linkBotao"><img src="template/<?=$config['template'];?>/images/settop.gif" width="6" height="6" /></td>
                        <td class="linkBotao">
						<a href="current.jsp" style="text-decoration: none">
						<font color="#000000">Últimos Logins</font></a></td>
                      </tr>
                  </table></td>
                  <td width="252" align="center" valign="top"><table width="252" border="2" cellpadding="0" cellspacing="0" bordercolor="#FBFBFB" class="PontilhadoMenu3">
                      <tr>
                        <td width="122" class="normal"><div align="left">Total de contas:</div></td>
                        <td width="107" class="normal"><div align="left"><strong>
                            <?PHP
			echo ' <img src="images/settop.gif">';
			$rs = $db->Execute("Select user from user");
			echo $rs->RecordCount();
	?>
                        </strong></div></td>
                      </tr>
                      <tr>
                        <td class="normal"><div align="left">Total de jogos: </div></td>
                        <td class="normal"><div align="left"><strong>
                            <?PHP
			echo ' <img src="images/settop.gif">';
			$plays = $db->Execute('Select count(*) as count from playlog');
			if ($db->Affected_Rows() > 0) {
			$pr = $plays->GetArray();
			echo ''.$pr[0]['count'] .'';
			}
	?>
                        </strong></div></td>
                      </tr>
                      <tr>
                        <td class="normal"><div align="left">Avatares Comprados:</div></td>
                        <td class="normal"><div align="left"><strong>
                            <?PHP
			echo ' <img src="images/settop.gif">';
			$plays = $db->Execute('Select count(*) as count from receiptbuy');
			if ($db->Affected_Rows() > 0) {
			$pr = $plays->GetArray();
			echo ''.$pr[0]['count'] .'';
			}
	?>
                        </strong></div></td>
                      </tr>
                    <td class="normal"><div align="left">Total de Logins:</div></td>
                  <td class="normal"><div align="left"><strong>
                      <?PHP
			echo ' <img src="images/settop.gif">';
			$plays = $db->Execute('Select count(*) as count from loginlog');
			if ($db->Affected_Rows() > 0) {
			$pr = $plays->GetArray();
			echo ''.$pr[0]['count'] .'';
			}
	?>
                  </strong></div></td>
                    <tr>
                      <td class="normal"><div align="left">Total de Banidos :</div></td>
                      <td class="normal"><div align="left"><strong>
                        <?PHP
			echo ' <img src="images/settop.gif">';
			$plays = $db->Execute('Select count(*) as Id from banlog');
			if ($db->Affected_Rows() > 0) {
			$pr = $plays->GetArray();
			echo ''.$pr[0]['Id'] .'';
			}
	?>
                      </strong></div></td>
                    </tr>
                    </table>
                      <br>
                      <table width="252" border="2" cellpadding="0" cellspacing="0" bordercolor="#FBFBFB" class="PontilhadoMenu3">
                        <tr>
                          <td width="139" class="normal"><div align="left">Broker Stats:</div></td>
                          <td width="105" class="normal"><div align="left"><strong>
                              <?PHP
		
			echo '<img src="images/settop.gif">';
			$fp = @fsockopen($config['server_ip'],$config['brokerport'],$errno, $errstr, .02);
			$broker = !$fp ?  'Offline' : 'Online';
			@fclose($fp);
			echo "$broker</span>";
			
	?>
                          </strong></div></td>
                        </tr>
                        <tr>
                          <td class="normal"><div align="left">Center Stats:</div></td>
                          <td class="normal"><div align="left"><strong>
                              <?PHP
		
			echo '<img src="images/settop.gif">';
			$fp = @fsockopen($config['server_ip'],$config['centerport'],$errno, $errstr, .02);
			$broker = !$fp ?  'Offline' : 'Online';
			@fclose($fp);
			echo "$broker</span>";
			
	?>
                          </strong></div></td>
                        </tr>
                        <tr>
                          <td class="normal"><div align="left">Buddy Center: </div></td>
                          <td class="normal"><div align="left"><strong>
                              <?PHP
		
			echo '<img src="images/settop.gif">';
			$fp = @fsockopen($config['server_ip'], $config['buddycenter'],$errno, $errstr, .02);
			$center = !$fp ?  'Offline' : 'Online';
			@fclose($fp);
			echo "$center</span>";
			
	?>
                          </strong></div></td>
                        </tr>
                        <tr>
                          <td class="normal"><div align="left">Buddy Server: </div></td>
                          <td class="normal"><div align="left"><strong>
                              <?PHP
		
			echo '<img src="images/settop.gif">';
			$fp = @fsockopen($config['server_ip'], $config['buddyserv'],$errno, $errstr, .02);
			$center = !$fp ?  'Offline' : 'Online';
			@fclose($fp);
			echo "$center</span>";
			
	?>
                          </strong></div></td>
                        </tr>
                        <tr>
                          <td class="normal"><div align="left">Servidor 1:</div></td>
                          <td class="normal"><div align="left"><strong>
                              <?PHP
		
			
			echo '<img src="images/settop.gif"><span class=vblue>';
			$fp = @fsockopen($config['server_ip'], $config['server8360'],$errno, $errstr, .02);
			$server = !$fp ?  'Offline' : 'Online';
			@fclose($fp);
			echo "$server</span>";
			
	?>
                          </strong></div></td>
                        </tr>
  <td class="normal"><div align="left">Servidor 2: </div></td>
      <td class="normal"><div align="left"><strong>
        <?PHP
		
			
			echo '<img src="images/settop.gif"><span class=vblue>';
			$fp = @fsockopen($config['server_ip'], $config['server8361'],$errno, $errstr, .02);
			$server = !$fp ?  'Offline' : 'Online';
			@fclose($fp);
			echo "$server</span>";
			
	?>
      </strong></div></td>
  <tr>
    <td class="normal"><div align="left">Servidor 3: </div></td>
    <td class="normal"><div align="left"><strong>
        <?PHP
		
			
			echo '<img src="images/settop.gif"><span class=vblue>';
			$fp = @fsockopen($config['server_ip'], $config['server8362'],$errno, $errstr, .02);
			$server = !$fp ?  'Offline' : 'Online';
			@fclose($fp);
			echo "$server</span>";
			
	?>
    </strong></div></td>
  </tr>
  <tr>
    <td class="normal"><div align="left">Servidor 4: </div></td>
    <td class="normal"><div align="left"><strong>
      <?PHP
		
			
			echo '<img src="images/settop.gif"><span class=vblue>';
			$fp = @fsockopen($config['server_ip'], $config['server8363'],$errno, $errstr, .02);
			$server = !$fp ?  'Offline' : 'Online';
			@fclose($fp);
			echo "$server</span>";
			
	?>
    </strong></div></td>
  </tr>
                      </table>
                      <!-- MENU-LOCATION=NONE --></td>
                </tr>
              </table>
              </form>
<table width="417">
                <tr>
                  <td width="409" height="38"><table width="229" align="left" bgcolor="#FFFFFF">
                      <tr>
                        <td width="40" height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
                        <td width="177" align="center" bgcolor="#FFFFFF" class="style5"><span class="style3">Ultimos &nbsp;</span>Banidos! </td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><?php
include("modules/top_ban.php")
?>
                    &nbsp;</td>
                </tr>
              </table>
            <?PHP } else {
		echo '<script language="JavaScript">

alert("Você não tem permissão para acessar esta pagina!");

</SCRIPT>
';
		header('Refresh: 2; url=index.jsp');
	
	} ?>
              <p>&nbsp;</p></td>
        </tr>
        <tr>
          <td width="12" valign="top"></td>
          <td width="410" align="center" valign="top">&nbsp;</td>
        </tr>
      </table>      <p>&nbsp;</p></td><td width="1"></td>
    <td width="71"><br />
      <br />
      <br />
    <br />    </td>
    <td width="23">&nbsp;</td>
  </tr>
</table></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>