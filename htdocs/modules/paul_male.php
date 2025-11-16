<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_evento.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>



<head>
<link href="template/jsplink/images/portal.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style17 {
	font-family: Arial;
	font-size: 12px;
	color: #990000;
}
.style18 {
	color: #666666;
	font-family: Arial;
	font-size: 13px;
	font-weight: bold;
}
-->
</style>
</head>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  </tr>
</table>
            <table cellspacing="0" cellpadding="0" width="509" border="0">
              <tr>
                <td colspan="4" background="img/bgreg.jpg">&nbsp;</td>
              </tr>
              <tr>
                <td width="21" background="img/bgreg.jpg"></td>
                <td align="center"  bgcolor="#FFFFFF"><table cellspacing="0" cellpadding="0" width="434" border="0">
                    <tr>
                      <td colspan="2" height="10"></td>
                    </tr>
                    <tr>
                      <td height="10" colspan="2" align="center" class="register"><div align="center"></div></td>
                    </tr>
                    <?PHP 
if (@$config['user_login'] == 'ok') {
		

	?>
                    <tr>
                      <td width="13" valign="top"></td>
                      <td width="417" align="center" valign="top"><div align="left">
                          <?PHP
if (@$config['user_login'] == 'ok') {
		
	$error = 0;
	switch (@$_GET['url']) {
	default:
	header('location: index.jsp');
	break;
	
	case 'ponto';
	
		switch(@$_GET['do']) {
		case 'trocar':
		
						if ($game['EventScore0'] < $config['evento_avatar']) {
						echo notice("Seus pontos s&atilde;o insuficientes.");
						} else {
// In&iacute;cio do c&oacute;digo de avatares
// Cabe&ccedil;a
						$result = $db->Execute("SELECT No FROM `chest` order by `No` desc LIMIT 1"); 
                    $rank = $result->GetArray(); 
                    $rankmax = $rank[0]['No']; 
                            $rankmax++; 
							
							 $result = $db->Execute("insert into `chest`(No, Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, '98440', '1', 'C', NULL, 1, '7500', 0, ?, 'I')",
							array($rankmax,$user_auth->username));
// Corpo
						$result = $db->Execute("SELECT No FROM `chest` order by `No` desc LIMIT 1"); 
                    $rank = $result->GetArray(); 
                    $rankmax = $rank[0]['No']; 
                            $rankmax++; 
							
							 $result = $db->Execute("insert into `chest`(No, Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, '32904', '1', 'C', NULL, 1, '7500', 0, ?, 'I')",
							array($rankmax,$user_auth->username));
// Fundo		
						$result = $db->Execute("SELECT No FROM `chest` order by `No` desc LIMIT 1"); 
                    $rank = $result->GetArray(); 
                    $rankmax = $rank[0]['No']; 
                            $rankmax++; 
							
							 $result = $db->Execute("insert into `chest`(No, Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, '229640', '1', 'C', NULL, 1, '7500', 0, ?, 'I')",
							array($rankmax,$user_auth->username));
// Fim do c&oacute;digo de avatares

							echo "<br><b>Parabens,</b> Seus pontos foram trocados com Sucesso.!!! <br>";
							if ($db->Affected_Rows()== 1) {								 
							}
								$db->Execute("Update game set  EventScore0 = EventScore0 - ? where Id = ?", array($config['evento_avatar'],$user_auth->username));
							echo "";
							if ($db->Affected_Rows()== 1) {
								 echo "";
								 header('Refresh: 1; url=index.jsp');
							}
		
							writelog("OLD: ".$user['NickName'] ." New: ".$_POST['nickname'], 'pontos_CHANGE'); 
							$game['EventScore0'] -= $config['evento_avatar'];
						}
					}
				
				}
			}
		
		}
			echo "
				  
				 &laquo; Para fazer a troca voc&ecirc; precisa haver no minimo <strong>".$config['evento_avatar']."</strong> Pontos<br>
				 &laquo; Ao fazer a troca voc&ecirc; receber&aacute; um SET <br><strong>Paul e a bandeira Valentine Candy (RARO)</strong> <br>
				 &laquo; Possuo: <b>".$game['EventScore0']." </b>Pontos de Evento<br><br>";
			if ($game['EventScore0'] >= $config['evento_avatar']) { 
				echo "
				
				  <form method='post' action='´paul_male-ponto-trocar.jsp'>
								
								<input type=submit class='buttons' name=submit value='Trocar pontos por Avatar'>
								</form>";
			} else {
	
	$f = new FormValidator($elems);
	$err = $f->validate($_POST['ponto']);
	
	if ( $err === true ) {
		
		$valid = $f->getValidElems();
		
		foreach ( $valid as $k => $v ) {
			
			if ( $valid[$k][0][1] == true ) {
				// Empty label field
				if ( empty($valid[$k][0][2]) ) {
					// then echo the form name of a field
					echo notice($valid[$k][0][2]);
				}
				else {
					echo notice($valid[$k][0][2]);
				}
			}
		}
	}
				
			echo '<i><br> Voc&ecirc; n&atilde;o possui pontos o bastante para fazer a troca.</i>';
			}
			echo "";
			?></td>
                    </tr>
                    <tr> </tr>
                    <tr>
                      <td colspan="2" height="10">&nbsp;</td>
                    </tr>
                  </table>
                    <p>&nbsp;</p></td>
                <td width="1" background="img/bgreg.jpg" bgcolor="#d8d8d8"></td>
                <td width="3" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
            </table>
			</center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>