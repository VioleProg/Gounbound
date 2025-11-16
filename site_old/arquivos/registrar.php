<div id="info_page">
  <div id="info_page_texto" align="center">Cadastrar</div></div><div id="center_bg_topo"><div id="centro_logotipo"></div> <div id="centro_titulo"></div>
</div> <div id="center_conteudo_meio">
  <div id="centro_meio_conteudo">
    <div align="center"></div><br />
    <div id="bg_news_texto">
       <p>
                 <?

$errors = array(); // set the errors array to empty, by default
$fields = array(); // stores the field values
$success_message = "";


	if (isset($_POST["submit"]))
	{
   	$_POST["login"] = (get_magic_quotes_gpc ()) ? stripslashes ($_POST["login4654"]) : $_POST["login4654"]; 
	$_POST["nick"] = (get_magic_quotes_gpc ()) ? stripslashes ($_POST["nickg57841"]) : $_POST["nickg57841"]; 
	$email = (get_magic_quotes_gpc ()) ? stripslashes ($_POST["email4421"]) : $_POST["email4421"]; 
	$pais = '28'; 
	$senha = (get_magic_quotes_gpc ()) ? stripslashes ($_POST["senha"]) : $_POST["senha"]; 
	$genero = $_POST["sexo"]; 
	$psecreta = '';
	$rsecreta = '';

	$rules = array();
	
	/* campo login */
	$rules[] = "required,login4654,Campo Login requerido.";
	$rules[] = "length=6-12,login4654,Entre com um valor entre 6 e 12 para login.";
	$rules[] = "is_alpha,login4654,Utilize somente letras e n&uacute;meros no login.";
	$rules[] = "existe_login,login4654,Login j&aacute; est&aacute; sendo usando por outro usu&aacute;rio. Escolha outro!";
	
	/* campo nick */
	$rules[] = "required,nickg57841,Campo Nick requerido.";
	$rules[] = "length=6-12,nickg57841,Entre com um valor entre 6 e 12 para nick.";
	$rules[] = "is_alpha,nickg57841,Utilize somente letras e n&uacute;meros no nick.";
	$rules[] = "existe_nick,nickg57841,Nick j&aacute; est&aacute; sendo usando por outro usu&aacute;rio. Escolha outro.";
	
	/* campo senha */
	$rules[] = "required,senhag154,Campo Senha requerido.";
	$rules[] = "is_alpha,senhag154,Utilize somente letras e n&uacute;meros na senha.";
	$rules[] = "length=6-12,senhag154,Entre com um valor entre 6 e 12 para a senha.";
	$rules[] = "same_as,senhag154,csenhag154, Senha e Confirmar senha devem ser iguais";

	/* campo email*/

	$rules[] = "required,email4421,Campo E-mail requerido.";
	$rules[] = "length<80,email4421,Campo E-mail n&#259;o pode ultrapassar a 80 caracteres.";
	$rules[] = "valid_email,email4421, Digite um e-mail v&aacute;lido.";
	$rules[] = "existe_email,email4421,E-mail j&aacute; se encontra cadastro em nossa base de dados!.";
	$rules[] = "same_as,email4421,cemail4421, Os e-mails devem ser iguais!";

	/* campo sexo */
	$rules[] = "required,sexo,Campo Sexo requerido.";
	$rules[] = "length=1,sexo,Campo Sexo requerido: Masculino ou Feminino.";
	$rules[] = "range=0-1,sexo,Sexo inv&aacute;lido.";
	
	/* campo captcha */
	$rules[] = "capt,ccod,C&oacute;digo de seguran&ccedil;a inv&aacute;lido.";

	$errors = validateFields($_POST, $rules);

	  // if there were errors, re-populate the form fields
	  if (!empty($errors))
	  {  
		$fields = $_POST;
	  }
	  
	  // no errors! redirect the user to the thankyou page (or whatever)
	  else 
	  {
		$message =  "Parab&eacute;ns, sua conta foi criada com sucesso. N&atilde;o esque&ccedil;a de verificar sua conta! Olha no Spam do seu e-mail, a mensagem pode estar l&aacute;";
		alerta("Confirme seu cadastro através do e-mail que lhe foi enviado");
	  }
	}


function addUsuario2(){
	$rankmax = getLastRank();
	$rankmax++;
	  
	$login = mysql_real_escape_string((get_magic_quotes_gpc ()) ? stripslashes ($_POST["login4654"]) : $_POST["login4654"]); 
	$nick = mysql_real_escape_string((get_magic_quotes_gpc ()) ? stripslashes ($_POST["nickg57841"]) : $_POST["nickg57841"]); 
	$email = mysql_real_escape_string((get_magic_quotes_gpc ()) ? stripslashes ($_POST["email4421"]) : $_POST["email4421"]); 
	$pais = '28'; 
	$senha = mysql_real_escape_string((get_magic_quotes_gpc ()) ? stripslashes ($_POST["senhag154"]) : $_POST["senhag154"]); 
	$genero = $_POST["sexo"];
	$psecreta = '';
	$rsecreta = '';
	

	
	
    $result = mysql_query("insert into game(Id, NickName, Money, TotalScore, SeasonScore, TotalGrade, SeasonGrade, Country, CountryGrade, TotalRank, SeasonRank, CountryRank) values ('$login', '$nick', '500000', '1000', '0', '-3', '-3', '300', -3, '$rankmax', '$rankmax', '$rankmax')");
	if (mysql_affected_rows() > 0){

	}

	$codigo = sha1($login);
	$result33 = mysql_query("insert into user(Id, user, Gender, NickName, Password, Status, MuteTime, RestrictTime, Authority, E_Mail, Country, User_Level, Authority2, AuthorityBackup) values ('$login', '$login', $genero, '$nick', '$senha', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '$email', '$pais', 1, '1', '0')");

$to  = ''.$email.'';
$subject = 'Confirmar Cadastro';
$message = '
<html>
<head>
  <title>Confirma&ccedil;ao de Cadastro</title>
</head>
<body>
<table width="508" border="0" align="center" style="background-color:#b5cafa; border: 1px dotted rgb(153, 0, 0);">
  <tr>
    <td><p><img src="http://beta.gbmdv.net/imagem/logo/mdv_logo.png" /></p>
      <p style="text-align:center;">Ol&aacute;,<b> '.getNick($login).' .</b><br />
        Ficamos felizes de t&ecirc;-lo em nossa comunidade.<br />
        N&oacute;s lhe desejamos um bom divertimento em nosso servidor!<br />
      </p>
      <p style="text-align:center;">Clique no link abaixo para confirmar seu cadastro. </p>
    <p style="text-align:center;"><a href="http://beta.gbmdv.net/?page=verificar_conta&amp;cod='.$codigo.'&amp;id='.$login.'">Confirmar meu cadastro!</a></p></td>
  </tr>
</table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Cadastro GBMdV <no-reply@gbmdv.net>' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);

	if (mysql_affected_rows() > 0){
		
	}

	
	$result3 =  mysql_query("insert into cash(ID, Cash) values ('$login','55000')");

	$result4 =  mysql_query("insert into gunwcuser(Id, user, Gender, NickName, User_Level, Authority2, Password, Status, MuteTime,  RestrictTime, Authority, E_Mail, Country, AuthorityBackup) values ('$login', '$login', $genero, '$nick', '1', '1', '$senha', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '$email', '$pais', 0);");
	if (mysql_affected_rows() > 0){
	
	}

}
?>
          <?php
    
    // if $errors is not empty, the form must have failed one or more validation 
    // tests. Loop through each and display them on the page for the user
    if (!empty($errors))
    {
      echo "<div class='error' style='width:95%;'>Um ou mais erros foram encontrados, por favor os corrija.\n<ul>";
      foreach ($errors as $error)
        echo "<li>$error</li>\n";
    
      echo "</ul></div><br />"; 
    }
    
    if (!empty($message))
    {
      echo "<div class='notify'>$message</div><br />";
	  addUsuario2();
    }
    ?>
       </p>
      <form id="form1" name="form1" method="post" action="">
        <strong>Dados de Acesso</strong><br />
        <table width="478" border="0" align="center">
          <tr>
            <td width="121">* ID:</td>
            <td width="347"><label for="login4654"></label>
            <input name="login4654" type="text" id="login4654" value="<?=$fields['login4654']?>" maxlength="12" /></td>
          </tr>
          <tr>
            <td>* NickName:</td>
            <td><input name="nickg57841" type="text" id="nickg57841" value="<?=$fields['nickg57841']?>" maxlength="13" /></td>
          </tr>
          <tr>
            <td>* Senha:</td>
            <td><input name="senhag154" type="password" id="senhag154" maxlength="20" /></td>
          </tr>
          <tr>
            <td>* Redigitar Senha:</td>
            <td><input name="csenhag154" type="password" id="csenhag154" maxlength="20" /></td>
          </tr>
        </table>
        <br />
        <strong>Seguran&ccedil;a<br />
        </strong>
        <table width="478" border="0" align="center">
          <tr>
            <td width="123">* E-mail:</td>
            <td width="345"><input name="email4421" type="text" id="email4421" value="<?=$fields['email4421']?>" /></td>
          </tr>
          <tr>
            <td>* Confirmar E-mail:</td>
            <td><input name="cemail4421" type="text" id="cemail4421" /></td>
          </tr>
        </table>
        <br />
        <strong>Geral</strong><br />
        <table width="478" border="0" align="center">
          <tr>
            <td width="124">* Sexo:</td>
            <td width="344"><label for="sexo"></label>
              <select name="sexo" id="sexo">
                <option value="0">Masculino</option>
                <option value="1">Feminino</option>
            </select></td>
          </tr>
          <tr>
            <td>Gold:</td>
            <td><input name="id8" type="text" disabled="disabled" id="id8" value="500.000" readonly="readonly" /></td>
          </tr>
          <tr>
            <td>Cash:</td>
            <td><input name="id9" type="text" disabled="disabled" id="id9" value="50.000" readonly="readonly" /></td>
          </tr>
          <tr>
            <td>C&oacute;digo de Seguran&ccedil;a:</td>
            <td><img src="CaptchaSecurityImages.php?width=160&amp;height=40&amp;characters=5" /><br />
              <br />
<input id="ccod" name="ccod" type="text" />
            *</td>
          </tr>
        </table>
        <br />
        <input type="submit" name="submit" id="submit" value="Cadastrar-se" />
      </form>
    </div>
</div>
<div id="center_conteudo_footer"> <div id="centro_footer_texto_topo"><a href="#btopo" title="Topo"><img src="images/botoes/up.png" width="18" height="26" /></a></div>
</div>