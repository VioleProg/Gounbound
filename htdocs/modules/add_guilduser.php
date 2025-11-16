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
    <td><table width="313">
      <tr>
        <td width="19" align="right"><img src="images/info.gif" width="16" height="16" /></td>
        <td width="37" align="left" class="ondeestou"><a href="home.jsp">Home</a></td>
        <td width="6" align="right" class="ondeestou"><img src="images/settop.gif" width="6" height="6" /></td>
        <td width="32" align="right" class="ondeestou"><a href="admin.jsp">Admin</a></td>
        <td width="6" align="right" class="ondeestou"><img src="images/settop.gif" width="6" height="6" /></td>
        <td width="180" align="left" class="ondeestou"><strong>Adicionar membro 
		na guild</strong></td>
      </tr>
    </table></td>
    <td><img src="images/spacer.gif" width="1" height="34" border="0" alt="" /></td>
  </tr>
  <tr>
    <td align="center" valign="top" background="template/jsplink/images/modules_r2_c1.gif">
    
<form method=POST action=add_guilduser.jsp>
  <p>
    <?PHP if ($config['admin_login'] == 'ok') {
					?>
  </p>
  <table border=0 align=center>
  <tr>
    <td align=center class=LoginLogined colspan="2"><strong>Adicionando cash 
	na conta de um membro</strong></td>
  </tr>
<tr>
  <td width=144 align=left class=register>Login:</td>
  <td width=271 align=left><input class=login name=login type=text size=25> 
    * </td>
</tr>
	<tr>
  <td align=left class=register>Guild:</td>
  <td align=left><input class=login name=guild type=text size=25 maxlength=50> 
    * </td>
  <tr>
    <td align=left class=register>&nbsp;</td>
    <td align=center>
	<input align=center class=buttons type=submit name=submit value="Adicionar" />
        <input align=center class=buttons type=reset name=submit2 value="Resetar" /></td>
  </tr>
</table>
<?php } ?>
<br>
</form>

<?PHP
if (isset($_POST['submit'])) {
$db->Execute("update game set Guild = ? where Id = ?", array($_POST['guild'],$_POST['login']));

            
writelog("User: ".$_POST['login'] ." Guild: ".$_POST['cash'], 'GUILD_USER_ADD'); 
echo 'O <b>'.$_POST['login'].'</b> foi adicionado com sucesso na guild: '.$_POST['guild'].'!<br><strong>Sistema criado por WebMaster_IMDS</strong>';

function updateguilds() {
	global $config, $db;

	$result = $db->Execute("SELECT DISTINCT Guild, count( Id ) as counts, sum(TotalScore) as TotalScore
						FROM game
						WHERE Guild IS NULL
						OR Guild != ''
						GROUP BY Guild order by TotalScore desc");
	if ($db->Affected_Rows() > 0) {
	
		foreach ($result->GetArray() as $rs => $r) {
		
			$db->Execute('Update game set MemberCount = ? where Guild = ?', array($r['counts'], $r['Guild']));
			$result2 = $db->Execute("Select Id, Guild from game where Guild=? order by TotalScore desc",array($r['Guild']));
			if ($db->Affected_Rows() > 0) {
				$grank=0;
				foreach ($result2->GetArray() as $rs2 => $r) {
				$grank++;
					$db->Execute('Update game set GuildRank = ? where Guild = ? and Id=?', array($grank, $r['Guild'],$r['Id']));
					
				}
			}
		}
	
	}

}
updateguilds();
}
?>

</td>
    <td><img src="images/spacer.gif" width="1" height="262" border="0" alt="" /></td>
  </tr>
</table>
