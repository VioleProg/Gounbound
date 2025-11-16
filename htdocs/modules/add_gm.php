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
    <td><table width="286">
      <tr>
        <td width="19" align="right"><img src="images/info.gif" width="16" height="16" /></td>
        <td width="37" align="left" class="ondeestou"><a href="home.jsp">Home</a></td>
        <td width="6" align="right" class="ondeestou"><img src="images/settop.gif" width="6" height="6" /></td>
        <td width="32" align="right" class="ondeestou"><a href="admin.jsp">Admin</a></td>
        <td width="6" align="right" class="ondeestou"><img src="images/settop.gif" width="6" height="6" /></td>
        <td width="154" align="left" class="ondeestou"><strong>Adicionar ADM/GM</strong></td>
      </tr>
    </table></td>
    <td><img src="images/spacer.gif" width="1" height="34" border="0" alt="" /></td>
  </tr>
  <tr>
    <td align="center" valign="top" background="template/jsplink/images/modules_r2_c1.gif">
<form method=POST action=add_gm.jsp>
  <p>
    <?PHP if ($config['admin_login'] == 'ok') {
					?>
</p>
  <table border=0 align=center>
  <tr>
    <td align=left class=LoginLogined colspan="2">
	<p align="center"><strong>Tornando um membro da Staff</strong></td>
  </tr>
<tr>
  <td width=144 align=left class=register>Login:</td>
  <td width=271 align=left><input class=login name=login type=text size=25> 
    * </td>
</tr>
	<tr>
  <td align=left class=register>Tipo de conta:</td>
  <td align=left>
	<input type="radio" value="100" name="tipo" style="font-weight: 700" checked><b>ADM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</b><input type="radio" value="99" name="tipo" style="font-weight: 700"><b>GM</b> 
    * </td>
  <tr>
  <td width="144" align="left" class="register">Level País:</td>
  <td width="271" align="left"><input name="countrygrade" type="text" class="login" value="20" size="25"> 
    * </td>
</tr>
<tr>
  <td width="144" align="left" class="register">Level Total:</td>
  <td width="271" align="left"><input name="totalgrade" type="text" class="login" value="20" size="25"> 
    * </td>
</tr>
<tr>
  <td width="144" align="left" class="register">Level Semanal:</td>
  <td width="271" align="left"><input name="seasongrade" type="text" class="login" value="20" size="25"> 
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
  <p>
    <?php } ?>
    <br>
    </p>
  </form>

<?PHP
if (isset($_POST['submit'])) {
$db->Execute('update game set CountryGrade = ? where Id = ?', array($_POST['countrygrade'],$_POST['login']));
$db->Execute('update game set CountryGrade = ? where Id = ?', array($_POST['countrygrade'],$_POST['login']));
$db->Execute('update game set TotalGrade = ? where Id = ?', array($_POST['totalgrade'],$_POST['login']));
$db->Execute('update game set TotalScore = ? where Id = ?', array('0',$_POST['login']));
$db->Execute('update game set Guild = ? where Id = ?', array('STAFF',$_POST['login']));
$db->Execute('update game set SeasonGrade = ? where Id = ?', array($_POST['seasongrade'],$_POST['login']));
$db->Execute('update game set NoRankUpdate = ? where Id = ?', array($_POST['norankupdate'],$_POST['login']));
$db->Execute('update gunwcuser set Authority = ? where Id = ?', array($_POST['tipo'],$_POST['login']));
$db->Execute('update gunwcuser set Authority2 = ? where Id = ?', array($_POST['tipo'],$_POST['login']));
$db->Execute('update user set Authority = ? where Id = ?', array($_POST['tipo'],$_POST['login']));
$db->Execute('update user set Authority2 = ? where Id = ?', array($_POST['tipo'],$_POST['login']));

            
writelog("Usuário: ".$_POST['login'] ." Tipo de restrição: ".$_POST['tipo'], 'GM_ADD'); 
echo 'O usuário: <b>'.$_POST['login'].'</b> se entrou na staff com sucesso!<br><strong>Sistema criado por WebMaster_IMDS<br></strong>';
}
?>


</td>
    <td><img src="images/spacer.gif" width="1" height="262" border="0" alt="" /></td>
  </tr>
</table>