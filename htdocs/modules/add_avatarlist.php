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
    <td align="center" valign="top">
    
    <form method=POST action=add_avatarlist.jsp>
<table border=0 align=center width="100%">
  <tr>
    <td align=center class=LoginLogined colspan="2"><strong>Adicionando avatar na lista 
	de compras</strong></td>
  </tr>
<tr>
  <td width=144 align=left class=register>Código do Avatar:</td>
  <td width=183 align=left><input class=login name=codigo type=text size=25> 
    * </td>
</tr>
<tr>
  <td align=left class=register>Sexo do Avatar:</td>
  <td align=left><select id=Sexo name=sexo class=cselect style=background: #FEFFF0 no-repeat 5px 1px>
                        <option value=>Selecione</option>
                        <option value=masculino>Masculino</option>
                        <option value=feminino>Feminino</option>
                        <option value=unisex>Unisex</option></select> * </td>
	<tr>
  <td align=left class=register>Tipo de Avatar:</td>
  <td align=left><select id=Tipo name=tipo class=cselect style=background: #FEFFF0 no-repeat 5px 1px>
                        <option value=>Selecione</option>
                        <option value=cabeca>Cabeça</option>
                        <option value=corpo>Corpo</option>
                        <option value=oculos>Óculos</option>
                        <option value=bandeira>Bandeira</option>
                        <option value=ex>Ex</option>                  
                        </select> * </td>
	<tr>
  <td align=left class=register>Nome do Avatar:</td>
  <td align=left><input class=login name=nome type=text size=25 maxlength=50> 
    * </td>
	<tr>
  <td align=left class=register>Preço Moeda-G:</td>
  <td align=left><input class=login name=gcoin type=text size=25 maxlength=10> 
    * </td>
	<tr>
  <td align=left class=register>Preço Cash:</td>
  <td align=left><input class=login name=cash type=text size=25 maxlength=10> 
    * </td>
  </tr>
	<tr>
  <td align=left class=register>Limite de vendas:</td>
  <td align=left><input class=login name=qtd type=text size=25 maxlength=10><br>
&nbsp;</td>
  </tr>
	<tr>
  <td align=left class=register colspan="2"><hr>
	<p>&nbsp;</td>
  </tr>
	<tr>
  <td align=left class=register>Foto:</td>
  <td align=left><input class=login name=foto type=text size=25 maxlength=100> 
    * <br>
	ex: avatar/feminino/cabeca/observador_cabeca.gif<br>
&nbsp;</td>
  </tr>
	<tr>
  <td align=left class=register colspan="2"><hr>
	<p align="center"><b>Propriedades do avatar</b></td>
  </tr>
	<tr>
  <td align=center class=register colspan="2">
	<table border="0" width="322" id="table1" align="center">
		<tr>
			<td align="center" width="11"><img border="0" src="avatar/propriedades/delay.gif" width="13" height="13"></td>
			<td align="center" width="11"><img border="0" src="avatar/propriedades/popular.gif" width="14" height="13"></td>
			<td align="center" width="11"><img border="0" src="avatar/propriedades/attack.gif" width="13" height="13"></td>
			<td align="center" width="11"><img border="0" src="avatar/propriedades/def.gif" width="14" height="14"></td>
			<td align="center" width="11"><img border="0" src="avatar/propriedades/life.gif" width="13" height="13"></td>
			<td align="center" width="11"><img border="0" src="avatar/propriedades/shield.gif" width="14" height="13"></td>
			<td align="center" width="11"><img border="0" src="avatar/propriedades/skip.gif" width="13" height="13"></td>
			<td align="center" width="22"><img border="0" src="avatar/propriedades/dig.gif" width="14" height="14"></td>
		</tr>
		<tr>
			<td align="center" width="11">
			<input name=delay type=text size=2 maxlength=2 value="0"></td>
			<td align="center" width="11">
			<input name=popular type=text size=2 maxlength=2 value="0"></td>
			<td align="center" width="11">
			<input name=attack type=text size=2 maxlength=2 value="0"></td>
			<td align="center" width="11">
			<input name=def type=text size=2 maxlength=2 value="0"></td>
			<td align="center" width="11">
			<input name=life type=text size=2 maxlength=2 value="0"></td>
			<td align="center" width="11">
			<input name=shield type=text size=2 maxlength=2 value="0"></td>
			<td align="center" width="11">
			<input name=skip type=text size=2 maxlength=2 value="0"></td>
			<td align="center" width="22">
			<input name=dig type=text size=2 maxlength=2 value="0"></td>
		</tr>
	</table>
	</td>
  </tr>
	<tr>
  <td align=left class=register>&nbsp;</td>
  <td align=left>&nbsp;</td>
  </tr>
  <tr>
    <td align=left class=register>&nbsp;</td>
    <td align=center>
	<input align=center class=buttons type=submit name=submit value="Adicionar" />
        <input align=center class=buttons type=reset name=submit2 value="Resetar" /></td>
  </tr>
</table>

<br><br>
Para adicionar SET clique no botão abaixo<br><br>
<img border="0" src="images/add_set.jpg" width="121" height="23"><br>
</form>

<?PHP
if (isset($_POST['submit'])) {

$result = $db->Execute("insert into `shop_avatar`(codigo, sexo, tipo, nome, creditos, cash, qtd, foto, delay, popular, attack, def, life, shield, skip, dig) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
array($_POST['codigo'],$_POST['sexo'],$_POST['tipo'],$_POST['nome'],$_POST['gcoin'],$_POST['cash'],$_POST['qtd'],$_POST['foto'],$_POST['delay'],$_POST['popular'],$_POST['attack'],$_POST['def'],$_POST['life'],$_POST['shield'],$_POST['skip'],$_POST['dig']));
            
writelog("Avatar: ".$_POST['nome'] ." Código: ".$_POST['codigo'], 'AVATAR_ADD_LIST'); 
echo 'O avatar foi adicionado a lista com sucesso!<br><strong>Sistema criado por WebMaster_IMDS</strong>';
}
} else {
		echo '<script language="JavaScript">

alert("Você não tem permissão para acessar esta pagina!");

</SCRIPT>
';
		header('Refresh: 2; url=index.jsp');
	
	} ?>

</td>
    <td><img src="images/spacer.gif" width="1" height="262" border="0" alt="" /></td>
  </tr>
</table></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>