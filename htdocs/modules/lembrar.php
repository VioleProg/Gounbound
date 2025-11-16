<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_ranking.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
<div id="content_full_content"><center>
			
<form method=POST action=lembrar.jsp>
<table border=0 align=center width="438">
  <tr>
    <td align=center class=LoginLogined colspan="2"><strong>Preencha os dados 
	abaixo corretamente para lembrar sua senha!</strong></td>
  </tr>
<tr>
  <td width=144 align=left class=register>&nbsp;</td>
  <td width=284 align=left>&nbsp;</td>
</tr>
<tr>
  <td width=144 align=left class=register>Login:</td>
  <td width=284 align=left><input class=login name=login type=text size=25></td>
</tr>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>
  	</tr>
	<tr>
  <td align=left class=register>Pergunta Secreta:</td>
  <td align=left><select id="pergunta" name="pergunta" class="cselect" style="border-style: solid; border-color: #E8E8E8; font-family: Arial; font-size: 10pt;  color: #2E2E2E; width: 155px; height: 25px; background-color:#FEFFF0;">
                        <option value="">Selecione</option>
                        <option value="0">Nome da m&atilde;e</option>
                        <option value="1">Animal de estima&ccedil;&atilde;o</option>
                        <option value="2">Qualidade</option>
                        <option value="3">N&atilde;o suporto</option>
                        <option value="4">Desejo</option>
	</td>
  	<tr>
  <td align=left class=register>Resposta Secreta:</td>
  <td align=left><input class=login name=resposta type=text size=25></td>
  <tr>
    <td align=left class=register>&nbsp;</td>
    <td align=center>
	<input align=center class=buttons type=submit name=submit value="Lembrar" />
        <input align=center class=buttons type=reset name=submit2 value="Resetar" /></td>
  </tr>
</table>
<br>
</form>

<?PHP
if (isset($_POST['submit'])) {

$func = mysql_query("SELECT Password FROM `user` WHERE Id=$_POST['login'] and Pergunta=$_POST['pergunta'] and Resposta=$_POST['resposta']");
$y = mysql_num_rows($func);
while($r = mysql_fetch_array($y)) {

 echo'Sua senha é: <b>'.$result.'</b>!<br><strong>Sistema criado por WebMaster_IMDS</strong>';
 }
writelog("User: ".$_POST['login'], 'LEMBRAR_SENHA'); 

}
?>


</center></div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>