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
   <tr>
    <td align="center" valign="top">
    
    <form method=POST action=add_gcoin.jsp>
<table border=0 align=center>
  <tr>
    <td align=left class=LoginLogined colspan="2"><strong>Adicionando créditos na conta de um membro
</strong></td>
  </tr>
<tr>
  <td width=144 align=left class=register>Login:</td>
  <td width=271 align=left><input class=login name=login type=text size=25> 
    * </td>
</tr>
	<tr>
  <td align=left class=register>Quantia de créditos:</td>
  <td align=left><input class=login name=gcoin type=text size=25 maxlength=50> 
    * </td>
  <tr>
    <td align=left class=register>&nbsp;</td>
    <td align=center>
	<input align=center class=buttons type=submit name=submit value="Adicionar" />
        <input align=center class=buttons type=reset name=submit2 value="Resetar" /></td>
  </tr>
</table>
<br>
</form>

<?PHP
if (isset($_POST['submit'])) {
$db->Execute("update credito set Credito = Credito + ? where ID = ?", array($_POST['gcoin'],$_POST['login']));
            
writelog("User: ".$_POST['login'] ." Moedas-G: ".$_POST['gcoin'], 'MOEDAS-G_ADD'); 
echo 'As Moedas-G foram adicionadas com sucesso na conta: <b>'.$_POST['login'].'</b>!<br><strong>Sistema criado por WebMaster_IMDS</strong>';
}
} else {
		echo '<script language="JavaScript">

alert("Você não tem permissão para acessar esta pagina!");

</SCRIPT>
';
		header('Refresh: 2; url=index.jsp');
	
	} ?>


</td>
  </tr>
</table></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>