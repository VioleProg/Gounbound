<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_ranking.png" />			</h2>
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
.style1 {font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #666666;
}
.style16 {color: #406040;
	font-weight: bold;
}
-->
</style>
</head>
<?PHP if ($config['admin_login'] == 'ok') {
					?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="586">
 
    <td align="center" valign="top">
    
    <form method=POST action=add_credvip.jsp>
<table border=0 align=center width="459">
  <tr>
    <td align=center class=LoginLogined colspan="2"><strong>Adicionando pacotes&nbsp; 
	na CredVip<br>
	</strong>Insira os dados principais do pacote</td>
  </tr>
<tr>
  <td width=123 align=left class=register>Nome do pacote:</td>
  <td width=326 align=left><input class=login name=nome type=text size=25> 
    * </td>
</tr>
<tr>
  <td align=left class=register>Sexo do pacote:</td>
  <td align=left><select id=Sexo name=sexo class=cselect style=background: #FEFFF0 no-repeat 5px 1px>
                        <option value=>Selecione</option>
                        <option value=masculino>Masculino</option>
                        <option value=feminino>Feminino</option></select> * </td>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>
	<tr>
  <td align=left class=register>Preço Moeda-G:</td>
  <td align=left><input class=login name=gcoin type=text size=25 maxlength=10> 
    Só pode ser comprado com Moedas-G* </td>
	</tr>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>
	<tr>
  <td align=left class=register>Quantia de cash que vem no pacote:</td>
  <td align=left><input class=login name=cash type=text size=25 maxlength=10> 
    * </td>
  </tr>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>
  </tr>
	<tr>
  <td align=left class=register colspan="2"><hr></td>
  </tr>
	<tr>
  <td align=left class=register colspan="2">
	<p align="center"><b>Avatares do pacote<br>
	</b>Insira os avatares que serão incluídos no pacote</td>
  </tr>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>
  </tr>
	<tr>
  <td align=left class=register>Cabeça:</td>
  <td align=left><input class=login name=avt type=text size=25 maxlength=100>Código
	do avatar
	<input class=login name=cabeca type=text size=25 maxlength=100>Nome do avatar</td>
  </tr>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>  </tr>
	<tr>
  <td align=left class=register>Corpo:</td>
  <td align=left><input class=login name=avt1 type=text size=25 maxlength=100>Código
	do avatar
	<input class=login name=corpo type=text size=25 maxlength=100>Nome do avatar</td>  </tr>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>  </tr>
	<tr>
  <td align=left class=register>Bandeira:</td>
  <td align=left><input class=login name=avt2 type=text size=25 maxlength=100>Código
	do avatar
	<input class=login name=bandeira type=text size=25 maxlength=100>Nome do avatar</td>  </tr>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>
  </tr>
	<tr>
  <td align=left class=register>Óculos:</td>
  <td align=left><input class=login name=avt3 type=text size=25 maxlength=100>Código
	do avatar
	<input class=login name=oculos type=text size=25 maxlength=100>Nome do 
	avatar</td>
  </tr>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>  </tr>
	<tr>
  <td align=left class=register>Ex:</td>
  <td align=left><input class=login name=avt4 type=text size=25 maxlength=100>Código
	do avatar
	<input class=login name=ex type=text size=25 maxlength=100>Nome do avatar</td>  </tr>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>  </tr>
	<tr>
  <td align=left class=register>Ex2:</td>
  <td align=left><input class=login name=avt5 type=text size=25 maxlength=100>Código
	do avatar
	<input class=login name=ex2 type=text size=25 maxlength=100>Nome do avatar</td>  </tr>
	<tr>
  <td align=left class=register colspan="2"><hr>
	<p align="center"><b>Duração do pacote<br>
	</b>Insira um numero de dias de duração do pacote</td>
  </tr>
	<tr>
  <td align=left class=register>Dias:</td>
  <td align=left>
	<input class=login name=duracao type=text size=25 maxlength=100 value="0"></td>
  </tr>
  <tr>
    <td align=left class=register>&nbsp;</td>
    <td align=center>
	<input align=center class=buttons type=submit name=submit value="Adicionar" />
        <input align=center class=buttons type=reset name=submit2 value="Resetar" /></td>
  </tr>
</table>

</form>

<?PHP
if (isset($_POST['submit'])) {

$result = $db->Execute("insert into `shop_credvip`(nome, sexo, creditos, cash, avt, avt1, avt2, avt3, avt4, avt5, duracao, cabeca, corpo, bandeira, oculos, ex, ex2) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
array($_POST['nome'],$_POST['sexo'],$_POST['gcoin'],$_POST['cash'],$_POST['avt'],$_POST['avt1'],$_POST['avt2'],$_POST['avt3'],$_POST['avt4'],$_POST['avt5'],$_POST['duracao'],$_POST['cabeca'],$_POST['corpo'],$_POST['bandeira'],$_POST['oculos'],$_POST['ex'],$_POST['ex2']));
            
writelog("Pacote: ".$_POST['nome'] ." Preço: ".$_POST['gcoin'], 'ADD_PACOTE_CREDVIP'); 
echo 'O pacote foi adicionado com sucesso!<br><strong>Sistema criado por WebMaster_IMDS</strong>';
}
} else {
		echo '<script language="JavaScript">

alert("Você não tem permissão para acessar esta pagina!");

</SCRIPT>
';
		header('Refresh: 2; url=index.jsp');
	
	} ?>

</td>
    <td width="1"><img src="images/spacer.gif" width="1" height="262" border="0" alt="" /></td>
  </tr>
</table></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>