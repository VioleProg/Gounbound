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
<table border="0" cellpadding="0" cellspacing="0" width="586">

  <tr>
    <td align="center" valign="top">
    
    <form method=POST action=add_avataruser.jsp>
<table border=0 align=center>
  <tr>
    <td align=center class=LoginLogined colspan="2"><strong>Adicionando avatar 
	na conta de um membro</strong></td>
  </tr>
<tr>
  <td width=144 align=left class=register>Login:</td>
  <td width=271 align=left><input class=login name=login type=text size=25> 
    * </td>
</tr>
	<tr>
  <td align=left class=register>Código do Avatar:</td>
  <td align=left><input class=login name=item type=text size=25 maxlength=50> 
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
$result = $db->Execute("SELECT No FROM `chest` order by `No` desc LIMIT 1"); 
$rank = $result->GetArray(); 
$rankmax = $rank[0]['No']; 
$rankmax++; 
				
$result = $db->Execute("insert into `chest`(No, Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, ?, '1', 'C', NULL, 1, 0, 0, ?, 'I')",
array($rankmax,$_POST['Item'],$_POST['Owner']));
							
							
if (isset($_POST['submit'])) {
$result = $db->Execute("insert into `chest`(Item, Wearing, Acquisition, Expire, Volume, PlaceOrder, Recovered, Owner, ExpireType) values (?, '1', 'C', NULL, 1, 0, 0, ?, 'I')",
array($_POST['item'],$_POST['login']));
            
writelog("Avatar: ".$_POST['nome'] ." Código: ".$_POST['codigo'], 'AVATAR_ADD_LIST'); 
echo 'O avatar foi adicionado com sucesso na conta: <b>'.$_POST['login'].'</b>!<br><strong>Sistema criado por WebMaster_IMDS</strong>';
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