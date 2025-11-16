<?PHP
if (@$config['user_login'] == 'ok') {
		
	$error = 0;
	switch (@$_GET['url']) {
	default:
	header('location: index.jsp');
	break;
	
case 'avatar':

if ($_POST['credito'] == 0 or NULL) {	
$msg_avt = "<font color='red'>Este pacote não pode ser comprado!</font>"; 
}
elseif ($credito['Credito'] < $_POST['credito']) {
$msg_avt = "<font color='red'>Seu credito é insuficiente.</font>";
}
else {

					$result = $db->Execute("SELECT No FROM `chest` order by `No` desc LIMIT 1"); 
                    $rank = $result->GetArray(); 
                    $rankmax = $rank[0]['No']; 
                            $rankmax++; 
							
							$result = $db->Execute("insert into `chest`(No, Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, ?, '1', 'C', NULL, '1', '0', '0', ?, 'I')",
							array($rankmax,$_POST['avt'],$user_auth->username));
							
					$result1 = $db->Execute("SELECT No FROM `chest` order by `No` desc LIMIT 1"); 
                    $rank = $result1->GetArray(); 
                    $rankmax = $rank[0]['No']; 
                            $rankmax++; 
                            
                            $result1 = $db->Execute("insert into `chest`(No, Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, ?, '1', 'C', NULL, '1', '0', '0', ?, 'I')",
							array($rankmax,$_POST['avt1'],$user_auth->username));
							
					$result2 = $db->Execute("SELECT No FROM `chest` order by `No` desc LIMIT 1"); 
                    $rank = $result2->GetArray(); 
                    $rankmax = $rank[0]['No']; 
                            $rankmax++; 
                            
                            $result2 = $db->Execute("insert into `chest`(No, Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, ?, '1', 'C', NULL, '1', '0', '0', ?, 'I')",
							array($rankmax,$_POST['avt2'],$user_auth->username));
							
					$result3 = $db->Execute("SELECT No FROM `chest` order by `No` desc LIMIT 1"); 
                    $rank = $result3->GetArray(); 
                    $rankmax = $rank[0]['No']; 
                            $rankmax++; 
                            
							$result3 = $db->Execute("insert into `chest`(No, Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, ?, '1', 'C', NULL, '1', '0', '0', ?, 'I')",
							array($rankmax,$_POST['avt3'],$user_auth->username));
							
					$result4 = $db->Execute("SELECT No FROM `chest` order by `No` desc LIMIT 1"); 
                    $rank = $result4->GetArray(); 
                    $rankmax = $rank[0]['No']; 
                            $rankmax++; 
                            
							$result4 = $db->Execute("insert into `chest`(No, Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, ?, '1', 'C', NULL, '1', '0', '0', ?, 'I')",
							array($rankmax,$_POST['avt4'],$user_auth->username));
							
					$result5 = $db->Execute("SELECT No FROM `chest` order by `No` desc LIMIT 1"); 
                    $rank = $result5->GetArray(); 
                    $rankmax = $rank[0]['No']; 
                            $rankmax++; 
                            
							$result5 = $db->Execute("insert into `chest`(No, Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, ?, '1', 'C', NULL, '1', '0', '0', ?, 'I')",
							array($rankmax,$_POST['avt5'],$user_auth->username));
							
                            $db->Execute('update game set CountryGrade = ? where ID = ?', array('21',$user_auth->username));

                            $db->Execute('update game set TotalGrade = ? where ID = ?', array('21',$user_auth->username));

                            $db->Execute('update game set SeasonGrade = ? where ID = ?', array('21',$user_auth->username));

                            $db->Execute('update game set NoRankUpdate = ? where ID = ?', array('1',$user_auth->username));

                            $db->Execute('update cash set Cash = Cash + ? where ID = ?', array($_POST['cash'],$user_auth->username));
							
                            $msg_avt = "<font color='green'>Parabens, o pacote foi adquirido com sucesso!!!</font>";
							if ($db->Affected_Rows()== 1) {								 
							}
								$db->Execute("Update credito set Credito = Credito - ? where Id = ?", array($_POST['credito'],$user_auth->username));
                                $db->Execute('Update shop_avatar set qtd = qtd - ? where id = ?', array(1,$_POST['id']));

							echo "";
							if ($db->Affected_Rows()== 1) {
								 echo "";
								 header('Refresh: 10; url=meuavatar.jsp');
							}
		
							writelog("Login: ".$user['Id'] ." Comprou: ".$_POST['nome']." - ".$_POST['codigo'], 'CredShop'); 
						}
					}
				
				}

		
		
			echo "";
			if ($credito['Credito'] >= $_POST['credito']) { 
				echo " ";
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
				
			$msg_avt =  "<font color='red'><i>Você não possui credito ou não está logado.</i></font>";
			}
			echo "";
 ?><div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_loja.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center><head>
<link href="css/forum.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_main.css" rel="stylesheet" type="text/css" />
<link href="template/www.johan.com.br/images/portal.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_content.css" rel="stylesheet" type="text/css" />

<script language="JavaScript">
function valid(value){
    open("avatarshop3-"+value+".jsp")
}

<!--
function bluring(){
if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG") 
	document.body.focus();
}
document.onfocusin=bluring;
// -->
</script>
<style type="text/css">
<!--
.opcoesrank {
	color: #993300;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body onload="MM_preloadImages('template/gbetools/images/topbtforum_r1_c2.jpg','template/gbetools/images/topbtforum_r1_c04.jpg','template/gbetools/images/topbtforum_r1_c06.jpg','template/gbetools/images/topbtforum_r1_c08.jpg','template/gbetools/images/topbtforum_r1_c10.jpg')">
      <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
        <!-- fwtable fwsrc="topbtforum.png" fwbase="topbtforum.jpg" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
        <tr>
          <td width="50"><img src="template/gbetools/images/spacer.gif" width="50" height="1" border="0" alt="" /></td>
          <td width="132"><img src="template/gbetools/images/spacer.gif" width="132" height="1" border="0" alt="" /></td>
          <td width="26"><img src="template/gbetools/images/spacer.gif" width="15" height="1" border="0" alt="" /></td>
          <td width="135"><img src="template/gbetools/images/spacer.gif" width="135" height="1" border="0" alt="" /></td>
          <td width="26"><img src="template/gbetools/images/spacer.gif" width="17" height="1" border="0" alt="" /></td>
          <td width="137"><img src="template/gbetools/images/spacer.gif" width="137" height="1" border="0" alt="" /></td>
          <td><img src="template/gbetools/images/spacer.gif" width="95" height="1" border="0" alt="" /></td>
          <td><img src="template/gbetools/images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
        </tr>
        <tr>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg"><img src="template/gbetools/images/topbtforum_r1_c1.jpg" alt="" name="topbtforum_r1_c1"  width="50" height="37" border="0" id="topbtforum_r1_c1" /></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg"><a href="avatarshop.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('avatarshop1','','template/gbetools/images/topbtshop_r1_c2.jpg',1)"><img src="template/gbetools/images/topbtshop_r1_c2.jpg" alt="Avatar Shop" name="avatarshop1" border="0" id="avatarsho1" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg"><a href="avatarshop.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('avatarshop2','','template/gbetools/images/topbt_r0.jpg',1)"><img src="template/gbetools/images/topbt_r0.jpg" alt="Avatar Shop 2" name="avatarshop2" border="0" id="avatarshop2" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg"><a href="avatarshop.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('avatarshop3','','template/gbetools/images/topbt_r0.jpg',1)"><img src="template/gbetools/images/topbt_r0.jpg" alt="Avatar Shop 3" name="avatarshop3" border="0" id="avatarshop3" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg"><a href="avatarshop.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('avatarshop4','','template/gbetools/images/topbt_r0.jpg',1)"><img src="template/gbetools/images/topbt_r0.jpg" alt="Avatar Shop 4" name="avatarshop4" border="0" id="avatarshop4" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="8%">
		  <img src="template/gbetools/images/topbtforum_r1_c7.jpg" alt="" name="topbtforum_r1_c7" width="95" height="37" border="0" id="topbtforum_r1_c7" align="right" /></td>
      </table>
     </td></tr> <tr>
        <td height="40" valign="top" >
		<table width="13%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="574" border="0" align="center" class="ranksch">
        <tr>
          <td width="568"><tr>
<td width="100%" align="center" colspan="2">
<span class="opcoesrank"><strong>Ver Pacotes:</strong></span>
<a href="credvip-masculino.jsp"><span class="opcoesrank">Masculino</span></a> <img src="images/settop.gif" width="9" height="6">
<a href="credvip-feminino.jsp"><span class="opcoesrank">Feminino</span></a>
</td>
</tr></td>
        </tr>
      </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="10">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="text1" id="table2">
            <tr>
              <td> 
              <center><table width="615" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="6"><img src="image/07_avatar/a_05.gif" width="6" height="8"></td>
                      <td width="95" background="image/07_avatar/a_06.gif"><img src="image/07_avatar/a_06.gif" width="2" height="8"></td>
                      <td width="13" background="image/07_avatar/a_06.gif"><img src="image/07_avatar/a_07.gif" width="1" height="8"></td>
                      <td width="495" background="image/07_avatar/a_06.gif"><img src="image/07_avatar/a_06.gif" width="2" height="8"></td>
                      <td width="6"><img src="image/07_avatar/a_08.gif" width="6" height="8"></td>
                    </tr>
                    
                    
                    <tr>
                      <td width="6" background="image/07_avatar/a_09.gif">&nbsp;</td>
                      <td width="95" align="center"><img src="images/cred_vip.jpg"></td>
                      <td width="13" valign="top"><img src="image/07_avatar/a_10.gif" width="1" height="100"></td>
                      <td width="495"><table width="481" border="0" cellpadding="0" cellspacing="0" class="text1">
                          <tr>
 <td height="23">
							<p align="left"><img src="image/07_avatar/deco_02.gif" width="7" height="7">
							<strong><?=$msg_avt?></font></strong><br><br>
							<br>
							<br></td>
                          </tr>
                          <tr>
                            <td height="1" bgcolor="#E0E0E0"><img src="image/00_img/00.gif" width="1" height="1"></td>
                          </tr>
                          <tr>
                            <td height="23"><table width="480" border="0" cellpadding="0" cellspacing="0" class="text1">
                                <tr>
                                  <td width="134"><img src="image/07_avatar/deco_02.gif" width="7" height="7"> <strong><font color="#024A60">Nome do pacote :</font></strong><p>&nbsp;</td>
								  <td width="340" > <strong><font color="#024A60">&nbsp;</font></strong><?=$_POST['nome']?> <img src="image/07_avatar/icon_sex_<?=$_POST['sexo']?>.gif" align="absmiddle"> </td>
                                  <td width="5">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="134"><img src="image/07_avatar/deco_03.gif" width="5" height="5" align="absmiddle">
									<strong><font color="#024A60">Duração do 
									pacote:</font></strong></td>
								  <td width="340" ><?=number_format($_POST['duracao'])?> dias</td>
                                  <td width="5">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="134"><img src="image/07_avatar/deco_03.gif" width="5" height="5" align="absmiddle">
									<strong><font color="#024A60">Itens do 
									pacote:</font></strong><p>&nbsp;</td>
                                  <td width="340" >
									<p align="center"><br>
									<br>
									Adquirindo este pacote você receberá:<br>
&nbsp;</p>
									<p align="left"><b>Cash:</b> <?=number_format($_POST['cash'])?></p>
									<p align="center"><b><br>
									Avatares</b></p>
									<p align="left"><b>Cabeça: </b><?=$_POST['cabeca']?><b><br>
									Corpo: </b><?=$_POST['corpo']?><b><br>
									Óculos: </b><?=$_POST['oculos']?><b><br>
									Bandeira: </b><?=$_POST['bandeira']?><b><br>
									Ex: </b><?=$_POST['ex']?><b><br>
									Ex2: </b><?=$_POST['ex2']?><br>
									<br>
									<b>Obs:</b> os avatares são eternos 
									independente da duração do pacote vip!<br>
&nbsp;</td>
                                  <td width="5">&nbsp;</td>
                                </tr>
                               </table></td>
                          </tr>
                          <tr>
                            <td height="1" bgcolor="#E0E0E0"><img src="image/00_img/00.gif" width="1" height="1"></td>
                          </tr>
                          <tr>
                            <td height="23">&nbsp;</td>
                          </tr>
                      </table></td> <td width="6" background="image/07_avatar/a_11.gif">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="6"><img src="image/07_avatar/a_12.gif" width="6" height="9"></td>
                      <td width="95" background="image/07_avatar/a_13.gif"><img src="image/07_avatar/a_13.gif" width="2" height="9"></td>
                      <td width="13" background="image/07_avatar/a_13.gif"><img src="image/07_avatar/a_13.gif" width="2" height="9"></td>
                      <td width="495" background="image/07_avatar/a_13.gif"><img src="image/07_avatar/a_13.gif" width="2" height="9"></td>
                      <td width="6"><img src="image/07_avatar/a_14.gif" width="6" height="9"></td>
                   <br></table></td>
        </tr>
      </table></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>