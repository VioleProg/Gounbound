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
<form method=POST action=add_vip.jsp>
<table border=0 align=center>
  <tr>
    <td align=left class=LoginLogined colspan="2">
	<p align="center"><strong>Tornando um membro vip</strong></td>
  </tr>
<tr>
  <td width=144 align=left class=register>Login:</td>
  <td width=271 align=left><input class=login name=login type=text size=25> 
    * </td>
</tr>
	<tr>
  <td align=left class=register>Quantia de Cash:</td>
  <td align=left><input class=login name=cash type=text size=25 maxlength=50> 
    * </td>
  <tr>
  <td width="144" align="left" class="register">Level País:</td>
  <td width="271" align="left"><input name="countrygrade" type="text" class="login" value="21" size="25"> 
    * </td>
</tr>
<tr>
  <td width="144" align="left" class="register">Level Total:</td>
  <td width="271" align="left"><input name="totalgrade" type="text" class="login" value="21" size="25"> 
    * </td>
</tr>
<tr>
  <td width="144" align="left" class="register">Level Semanal:</td>
  <td width="271" align="left"><input name="seasongrade" type="text" class="login" value="21" size="25"> 
    * </td>
</tr>
<tr>
  <td width="144" align="left" class="register">Não mudar o level:</td>
  <td width="271" align="left"><input name="norankupdate" type="text" class="login" value="1" size="25"> 
    * </td>
</tr>
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
$db->Execute('update game set CountryGrade = ? where ID = ?', array($_POST['countrygrade'],$_POST['login']));
$db->Execute('update game set TotalGrade = ? where ID = ?', array($_POST['totalgrade'],$_POST['login']));
$db->Execute('update game set SeasonGrade = ? where ID = ?', array($_POST['seasongrade'],$_POST['login']));
$db->Execute('update game set NoRankUpdate = ? where ID = ?', array($_POST['norankupdate'],$_POST['login']));
$db->Execute('update cash set Cash = Cash + ? where ID = ?', array($_POST['cash'],$_POST['login']));
            
writelog("Usuário: ".$_POST['login'] ." Cash: ".$_POST['cash'], 'VIP_ADD'); 
echo 'O usuário: <b>'.$_POST['login'].'</b> se tornou VipUser com sucesso!<br><strong>Sistema criado por WebMaster_IMDS<br></strong>';
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