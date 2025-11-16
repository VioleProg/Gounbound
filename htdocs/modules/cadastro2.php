<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_myacc.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>
				


<head>
<link href="template/syslink/images/portal.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">

<!--
.gc {font-family: Arial;
	font-size: 11px;
	color: #666666;
}
-->
</style>
</head>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="586">
  <tr>
    <td><img src="images/spacer.gif" width="586" height="1" border="0" alt="" /></td>
    <td><img src="images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>
  <tr>
    <td background="template/syslink/images/modules_r1_c1.gif">&nbsp;</td>
    <td><img src="images/spacer.gif" width="1" height="34" border="0" alt="" /></td>
  </tr>
  <tr>
    <td align="left" valign="top" background="template/syslink/images/modules_r2_c1.gif"><?PHP
//if (!stristr($_SERVER['PHP_SELF'], "bone.php") AND !stristr($_SERVER['SCRIPT_NAME'], "bone.php")) { die ("Access Denied"); }

//print_r($_POST);


function reg_form() {
global $config;
$reg_form = '';
if (isset($_POST)) { $POST= $_POST; }
if ($config['reg_mail_check'] == 1) $reg_form .= notice('Admin Has enabled Email Verification...<br> After registration it is required that u will have to click on the <b>Registration LINK</b> that is sent to your email address. <br> It is Important that you input a valid email address above!','Email Verification Required');

$reg_form .= '<form method="POST" action="cadastro_2.jsp">
	  
	  <table width="560" height="57" border="0" align="center">
          <tr>
            <td valign="top"><fieldset>
              <legend><strong>GUNBOUND</strong></legend>
              <table width="486" border="0" align="center">
                <tr>
                  <td valign="top"><table width="206" border="0">
                    <tr>
                      <td height="27" align="right">Login:</td>
                      <td width="148" align="right"><input class="textfield" name="fname" type="text" size="20" style="border-style: solid; border-color: #E8E8E8; font-family: Arial; font-size: 10pt;  color: #2E2E2E; width: 110px; height: 16px; background-color:#FEFFF0;"/>                      </td>
                    </tr>
                    <tr>
                      <td align="right">NickName:</td>
                      <td align="right"><input class="textfield" name="nickname" type="text" size="20" style="border-style: solid; border-color: #E8E8E8; font-family: Arial; font-size: 10pt;  color: #2E2E2E; width: 110px; height: 16px; background-color:#FEFFF0;"/>                      </td>
                    </tr>
                    <tr>
                      <td align="right">Sexo:</td>
					  <td height="27" align="right"><select id="gender" name="gender" class="cselect" style="border-style: solid; border-color: #E8E8E8; font-family: Arial; font-size: 10pt;  color: #2E2E2E; width: 115px; height: 25px; background-color:#FEFFF0;">
        <option value="" selected="selected">Selecione</option>
        <option value="0">Masculino</option>
        <option value="1">Feminino</option>
      </select></td>
                    </tr>
                  </table></td>
                  <td align="right"><table width="225" border="0">
                    <tr>
                      <td width="103" height="26" align="right">Senha</td>
                      <td width="112" align="right"><input class="textfield"  name="pass1" type="password" size="20" style="border-style: solid; border-color: #E8E8E8; font-family: Arial; font-size: 10pt;  color: #2E2E2E; width: 110px; height: 16px; background-color:#FEFFF0;"/>                      </td>
                    </tr>
                    <tr>
                      <td height="40" align="right">Repetir Senha:</td>
                      <td align="right"><input class="textfield"  name="pass2" type="password" size="20" style="border-style: solid; border-color: #E8E8E8; font-family: Arial; font-size: 10pt;  color: #2E2E2E; width: 110px; height: 16px; background-color:#FEFFF0;"/>                      </td>
                    </tr>

                  </table>
                    <table width="225" border="0">
                      <tr>
                        <td width="103" height="26" align="right">Pais:</td>
                        <td width="112" align="right"><select class="textfield" name="country" size="1" style="border-style: solid; border-color: #E8E8E8; font-family: Arial; font-size: 10pt;  color: #2E2E2E; width: 173px; height: 25px; background-color:#FEFFF0;">
						  ';
  $c = getcountry('get');
  foreach ($c as $cc => $v) {
  $reg_form .= "<option value=$cc>$v</option>";
  
  }
  

$reg_form .= '
    
    </select>                                </td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </fieldset>
              <br />
              <fieldset>
              <legend><strong>SEGURAN&Ccedil;A</strong> </legend>
              <table width="531" border="0" align="center">
                <tr>
                  <td width="222" valign="top">
					<table width="220" border="0" id="table1">
                    <tr>
                      <td width="58" align="right">E-Mail:</td>
					  <td width="152" align="right"><input class="textfield" name="email" type="text" size="20" maxlength="40" style="border-style: solid; border-color: #E8E8E8; font-family: Arial; font-size: 10pt;  color: #2E2E2E; width: 135px; height: 16px; background-color:#FEFFF0;"/>                     </td>
                    </tr>
                  </table>
				    <br>
				    <span class="gc">Ao me cadastrar irei receber '.$config['user_gold'].' em Gold, e '.$config['user_cash'].' em Cash.</span></td>
                  <td width="299" align="right" valign="top">
					<table width="287" border="0" id="table2">
                    <tr>
                      <td width="115" height="26" align="right">Pergunta Secreta:</td>
                      <td align="right"><select id="Pergunta" name="Pergunta" class="cselect" style="border-style: solid; border-color: #E8E8E8; font-family: Arial; font-size: 10pt;  color: #2E2E2E; width: 155px; height: 25px; background-color:#FEFFF0;">
                        <option value="">Selecione</option>
                        <option value="0">Nome da m&atilde;e</option>
                        <option value="1">Animal de estima&ccedil;&atilde;o</option>
                        <option value="2">Qualidade</option>
                        <option value="3">N&atilde;o suporto</option>
                        <option value="4">Desejo</option>
                                                                                        </select></td>
                    </tr>
                    <tr>
                      <td height="40" align="right">Resposta Secreta:</td>	
                      <td align="right"><input class="textfield"  name="Resposta" type="text" size="20" style="border-style: solid; border-color: #E8E8E8; font-family: Arial; font-size: 10pt;  color: #2E2E2E; width: 150px; height: 20px; background-color:#FEFFF0;"/>                      </td>
                    </tr>

                  </table>
					<p>&nbsp;</p>
					<p>&nbsp;</td>
                </tr>
				<tr>
                  <td width="222" valign="top">
					<p align="right"><b>Confirme a imagem:</b></td>
                  <td width="299" align="right" valign="top">
					<p align="left">
					<input class=editbox name="verify_image" maxlength=6 size=8 style="float: left"> <label><img src="_inc/image_verify.php"></label></td>
                </tr>
              </table>
            </fieldset></td>
          </tr>
        </table>
<br />
<table  border="0" align="center">
  <tr>
    <td align="left"><input name="submit" src="images/termo_3.gif" border="0"  width="185" height="37" type="submit" value="Registrar agora!"></td>
  </tr>
</table>

</form>';

return $reg_form;

}

/****************************************/
/* register codes		        */
/****************************************/
if (isset($_GET['activate'])) {

$uname = clean_variable(md5_decrypt($_GET['activate']));
echo notice("<strong>$uname</strong> Sua conta foi registrada com sucesso!!");

$activate = $GLOBALS['db']->Execute("Update Memb_info set bloc_code = 0, mail_chek=1 where mail_chek=0 and bloc_code = 1 and memb___id = ?",array($uname));
writelog("$uname successfull activation","regsiter");

mailer('', "Registro ativado",$uname. " Sua conta foi ativada com sucessonnObrigado!",$uname);

} else {

 if (!isset($_POST['submit'])) {
	echo reg_form();
 } elseif (isset($_POST['submit'])) {
	$elems[] = array('name'=>'fname','label'=>'Login Invalido ('.$config['reg_min_len'].'-'.$config['reg_max_len'].' Alpha-Numeric Characters)', 'type'=>'text','uname'=>'true', 'required'=>true, 'len_min'=>$config['reg_min_len'],'len_max'=>$config['reg_max_len'], 'cont' =>'alpha');
	$elems[] = array('name'=>'nickname','label'=>'Nickname Invalido ('.$config['reg_min_len'].'-'.$config['reg_max_len'].' Alpha-Numeric Characters)', 'type'=>'text','uname'=>'true', 'required'=>true, 'len_min'=>$config['reg_min_len'],'len_max'=>$config['reg_max_len'], 'cont' =>'alpha');
	$elems[] = array('name'=>'email', 'label'=>'Email invalido (ex. email@email.com MAX: '.$config['reg_max_mail'].')', 'type'=>'text', 'required'=>true, 'len_max'=>$config['reg_max_mail'], 'cont' => 'email');
	$elems[] = array('name'=>'pass1', 'label'=>'Senha Invalida ('.$config['reg_min_len'].'-'.$config['reg_max_len'].' Alpha-Numeric Characters)', 'type'=>'text', 'required'=>true, 'len_min'=>$config['reg_min_len'],'len_max'=>$config['reg_max_len'], 'cont' =>'alpha');
	$elems[] = array('name'=>'pass2', 'label'=>'Senha Invalida','type'=>'text', 'required'=>true, 'len_min'=>$config['reg_min_len'],'len_max'=>$config['reg_max_len'], 'cont' =>'alpha','equal'=> array('pass1'));
	
	$f = new FormValidator($elems);
	$err = $f->validate($_POST);
	
	if ( $err === true ) {
		
		$valid = $f->getValidElems();
		
		foreach ( $valid as $k => $v ) {
			
			if ( $valid[$k][0][1] == false ) {
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
		
	} else {
		$error = 0;
		if (valid_account($_POST['fname']) === true) {
		echo notice("O Login que voce tentou usar ja se encontra em uso.");
		
		$error = 1;
		}
		if (valid_email($_POST['email']) === true) {
		echo notice("O E-mail que voce tentou usar ja se encontra em uso.");
		
		$error = 1;
		}
		if (valid_NickName($_POST['nickname']) === true) {
		echo notice("O Nick que voce tentou usar ja se encontra em uso.");
		
		$error = 1;
		}
		if ($_SESSION['verify_image'] != md5($_POST['verify_image'])) {
		echo notice("Falha na verificação de imagem! <br> Confirme a imagem de verificação na caixa ao lado");
		$error = 1;			
		}
		if ($config['reg_allow'] == 0 ) { 
		echo notice("A Op&ccedil;&atilde;o de registro est&aacute; temporariamente desabilitada. Por favor contacte o administrador pelo email @ " .$config['admin_mail'], "ALERT REGISTRATION CLOSE");
		$error = 1;
		}	
		if ($error!=1) {
			if ($config['reg_mail_check'] == 1) {	
	    

		
				writeLog('Register Needs Activate: '. $_POST['fname'],'register');
				echo 
				notice('<br><h3>'. $_POST['fname']. 
					' Sua conta foi registrada com sucesso.!</h3>
					Visite nosso parceiro: http://www.johan.com.br',"Email Activation Needed");
			
			} else {
				
				
					$result = $db->Execute("SELECT TotalRank FROM `game` order by `TotalRank` desc LIMIT 1");
	                $rank = $result->GetArray();
					$rankmax = $rank[0]['TotalRank'];
	                        $rankmax++;
	            $result = $db->Execute("insert into `game`(Id, NickName, Money, TotalScore, SeasonScore, TotalGrade, SeasonGrade, Country, CountryGrade, TotalRank, SeasonRank, CountryRank) values (?, ?, ?, '1000', '0', '19', '19', ?, 19, ?, ?, ?)", 
				 array($_POST['fname'], $_POST['nickname'], $config['user_gold'], $_POST['country'], $rankmax, $rankmax, $rankmax));
				if ($db->Affected_Rows() > 0) {
						 
	                      $result = $db->Execute("insert into `cash` (ID, Cash) values (?,?)", array($_POST['fname'],$config['user_cash']));
						  
	                        $db->Execute("insert into `user`(Id, user, Gender, NickName, Password, Status, MuteTime, RestrictTime, Authority, E_Mail, Country, User_Level, Authority2, Pergunta, Resposta) values (?, ?, ?, ?, ?, '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', ?, ?, 1, 1, ?, ?)", 
                            array($_POST['fname'],$_POST['fname'],$_POST['gender'], $_POST['nickname'], $_POST['pass1'],$_POST['email'], $_POST['country'],$_POST['Pergunta'], $_POST['Resposta'])); 
							
							$db->Execute("insert into `gunwcuser` (Id, user, Gender, NickName, User_Level, Authority2, Password, Status, MuteTime,  RestrictTime, Authority, E_Mail, Country, AuthorityBackup) values (?, ?, ?, ?, 1, 1, ?, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, ?, ?, 0)", 
                            array($_POST['fname'],$_POST['fname'],$_POST['gender'], $_POST['nickname'], $_POST['pass1'],$_POST['email'], $_POST['country']));  
				
                            $db->Execute("insert into `credito` (ID, Credito) values (?,?)", 
                            array($_POST['fname'],$config['creditos']));   

					$mail = "Veja os dados da sua conta abaixo;nn Login: ". $_POST['fname'] ."nn Senha: ". $_POST['pass2'];
					if (mailer($_POST['email'], "Bem-Vindo(a)", $mail) == true) echo notice('Foi enviado um e-mail com os dados de sua conta (voce nao precisa confirmar sua conta no email) e apenas infomando login e senha.');
					writeLog('Register: '. $_POST['fname'],'register');
					echo notice('<br><h3>'. $_POST['fname']. 
						' Carregando!</h3>');
							header('Refresh: 1; url=entrar.jsp');
				} else {
					notice('Database has encountered an Error.<br> Do not worry Database will be fixed.<br> Please try your registration again.','ERROR');
					$db->Execute('ALTER TABLE `game` ADD `NickName` VARCHAR( 15 ) NOT NULL');
				
				}
			}

		} else { 
			echo reg_form();
		}
	
	}

}


}




?>      <a href="comprar_credito.jsp"></a><a href="addvip.jsp"></a>
        <map name="support" id="support">
    </map></td>
    <td><img src="images/spacer.gif" width="1" height="262" border="0" alt="" /></td>
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