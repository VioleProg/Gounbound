<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_guild.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>
 <?PHP
if (@$config['user_login'] == 'ok') {

$idg = $game['Guild'];
$gfoto = mysql_query("SELECT * FROM guildweb WHERE guild='$idg'");
while ($gweb = mysql_fetch_array($gfoto)) {
$fotog  = $gweb['foto'];
$gwebsite  = $gweb['WebSite'];
$gmaster  = $gweb['G_Master'];

}

		
	$error = 0;
	switch (@$_GET['url']) {
	default:
	header('location: home.jsp');
		
	break;
	
	case 'guild':
			if ($game['Guild'] == NULL || $game['Guild'] == '') {
			echo ('<table cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" height="10"><strong>Criando uma Guild</strong></td>
  </tr>
  <tr>
    <td valign="top"> &bull; Voc&ecirc;   precisa ser <img height="12" src="ranks/level_12.jpg" width="12" border="0" /> (Machado de Prata) ou   maior.<br />
      &bull; Seu gold tem que ser no minino (30,000) para poder criar uma Guild.<br />
      &bull; Se voc&ecirc; usar caracteres especiais no nome da Guild, poderao nao aparecer corretamente no Jogo e ou no WebSite. </td>
  </tr>
</table>');
			$cerror = '';	
			$c_needed =  $config['guild_rank_create'] - $game['TotalGrade'];
			if ($c_needed >= 0 || $game['TotalGrade'] == 20 || $game['TotalGrade'] == 21) {
				$rn = '<img src="images/aff_tick.gif">';
			} else { 
				$rn = "<img src='images/aff_cross.gif'>Seu GOLD ou seu NIVEL nao sao o suficiente  $c_needed !";
				$cerror = 1;
			}
			$m_needed =  $game['Money'] - $config['guild_money_create'];
			if ($m_needed >= 0 || $game['TotalGrade'] == 20 || $game['TotalGrade'] == 21) {
				$mn = '<img src="images/aff_tick.gif">';
			} else { 
				$mn = "<img src='images/aff_cross.gif'> Gold insuficiente: <b>$m_needed</b>";
				$cerror = 1;
			}
			echo "<br>
				 Nivel: ".getminirank($game['TotalGrade'])." - ". $rn ." <br>
				 Gold: <b>".number_format($game['Money'])."</b> - " . $mn ."</i>";
				 
			if ($cerror != 1) { 
					echo "
	   
	   <br>
<form method='post' action='guild-criar.jsp'>
						  <p>
						    <small>Coloque o nome da sua Guild</small>:<br />
						    <input type=text name='code' class='login' size=25 maxlenght=10> 
					      </p>
						  <p>Coloque a descri&ccedil;&atilde;o da sua Guild:<br />
						      <textarea name='Descricao' cols='30' rows='10' class='login' maxlenght='10'></textarea>
					          <br />
				              <br />
			                Requerimento:<br />
			                <textarea name='Requerimento' cols='30' rows='10' class='login' maxlenght='10'></textarea>
			                <br />
			                <br />
			                WebSite:<br />
			                <input name='WebSite' type='text' class='login' id='WebSite' value='http://' size='25' maxlenght='10' />
			                <br />
			                <br />
			                Foto para a Guild:<br />
			               			                
			                <input type=text name='foto' value='http://' class='login' maxlenght=10 size=43>
<strong><br />
                                Aten&ccedil;&atilde;o</strong>: Coloque sempre o http antes do link.<br />
			                <br>
					        <br>
						    <input type=submit class='buttons' name=submit value='Criar novo Cl&atilde;'>
                            <input type='reset' class='buttons' name='submit2' value='Refazer' />
  </p>
</form>";
			
			}
			echo "";
			?>
            <table>
              <tr> </tr>
              <tr>
                <td colspan="2" height="10"><img height="3"
                              src="template/<?=$config['template'];?>/images/prevent_hacking_02.gif" 
                              width="434" /></td>
              </tr>
            </table>
            <table cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" height="10"><strong>Entrando em uma Guild</strong></td>
              </tr>
              <tr>
                <td valign="top"><p>&bull; Procure a Guild desejada na <a href="guilds.jsp">lista de Guilds</a>.<br />
                  &bull; Anote o nick do Guild Master e pegue o codigo de confirma&ccedil;&atilde;o. <br />
                  &bull; Voc&ecirc;   precisa ser <img src="ranks/level_14.jpg" width="12" height="12" /> (Machado de Metal)  ou   maior para entrar na Guild. <br />
                  &bull; Use o navegador 'Internet Explorer'.<br />
                  &bull; Coloque o Codigo e o Nome da Guild no formulario. </p></td>
              </tr>
            </table>
            <?PHP
				$jerror='';
				if ($j_needed >= 0) {
					$rn = 'Ok!';
				} else { 
					$rn = "Lacking $j_needed !";
					$jerror = 1;
				}		
							
				if ($jerror != 1) {
					echo "<br><br><strong>Coloque o codigo de confirma&ccedil;&atilde;o: </strong><br>";
					echo "<br><small>Codigo de Confirma&ccedil;&atilde;o:</small><br>
						<form method='post' action='guild-ativar.jsp'>
						<input type=text name='code' class='login' size=45 maxlenght=35> <br>
						<small>Nome da Guild:</small><br>
						<input type=text name='Guild' class='login' size=20 maxlenght=15><br>
						<br><input type=submit class='buttons' name=submit value='Entrar no Cl&atilde;'>
						</form>";
				}
				echo "";
					 
			} else {
			
				$g = $db->Execute("Select *, game.Id, user.NickName from game, user where game.Id = user.Id and game.Guild = ? order by game.GuildRank asc", array($game['Guild']));
				$guilds = $g->GetArray();
				$db->Execute("CREATE TABLE IF NOT EXISTS `GuildWeb` (
							`guild` VARCHAR( 30 ) NOT NULL ,
							`G_Master` VARCHAR( 30 ) NOT NULL
							)");
				$g_m = $db->Execute("Select * from GuildWeb where guild = ?", array($game['Guild']));
				$gm = $g_m->GetArray();
			
				if (!isset($gm[0]['G_Master'])) {
					$db->Execute("Insert into GuildWeb (G_Master ,guild) Values (?,?)" , array($guilds[0]['Id'],$game['Guild']));
					$g_m = $db->Execute("Select * from GuildWeb where guild = ?", array($game['Guild']));
					$gm = $g_m->GetArray();
				}
			echo "<table width=580 class=login> 
			<tr>
             <td width=315 align=center rowspan=3>".'<img src='.$fotog.'  width="250" />'."</span></td>
             <td width=99 align=center>&nbsp;</td>
             <td width=153 align=center>&nbsp;</td>
              </tr>

			<tr>
             <td width=99 align=center height=210 valign=top>
				<p align=left><strong>WebSite: </strong>&nbsp;</p><br>
				<p align=left><strong>Clã: </strong>&nbsp;</p><br>
				<p align=left><strong>Membros:</strong>&nbsp;</p><br>
				<p align=left><strong>Guild Master:</strong>&nbsp;</p><br>
				<p align=left><strong>Total Score:</strong>&nbsp;</p><br>
				<p align=left><strong>Avg. Rank:</strong>&nbsp;</p>

				<p>&nbsp;</td>
             <td width=153  height=210 valign=top>
				<p align=left>".$gwebsite."</span></p><br>
				<p align=left>".$game['Guild']."</span></p><br>
				<p align=left>".$game['MemberCount']."</span></p><br>
				<p align=left><a href=perfil-".$gmaster.".jsp><span class=".getauth($r['Authority']).">".$gmaster."</a></span></p><br>
				<p align=left>".$r['TotalScore']."</span></p>
				<p align=left>".round($r['TotalGrade'],2)."</span></p>

				<p>&nbsp;</td>
              </tr>

			<tr>
             <td width=99 align=center>&nbsp;</td>
             <td width=153 align=center></span></td>
              </tr>

</table>";
			
				echo "<center><table width=90%><tr><td class='thead'> # </td>
				<td class='thead'> Nivel </td> 
				<td class='thead'>Nick </td> 
				<td class='thead'>Rank </td>
				<td class='thead'>GP's </td>
				".($gm[0]['G_Master'] == $user_auth->username ? "<td class='thead'> Op&ccedil;&otilde;es </td>" : '')."</tr>";
				$ranks = 0;
				foreach ($guilds  as $guild => $gmem) {
				$ranks++;
					echo "<tr><td>".$game['GuildRank']. "</td>
					<td> ".	getgrade($gmem['TotalGrade']). "</td>
					<td>". $gmem['NickName'] ." ".($gm[0]['G_Master'] == $gmem['Id'] ? '[CM]' : '')."</td>
					<td algin='center'> ". $gmem['TotalRank'] ."</td>
					<td algin='center'> ". $gmem['TotalScore'] ."</td>
						".($gm[0]['G_Master'] == $user_auth->username ? "<td><form method='post' action='guild-kick.jsp'>
					<input type=hidden name='kick' value='".$gmem['Id']."' class='buttons'> 
						<input type=submit class='buttons' name=submit value='Expulsar!'>
						</form> </td>" : '')."</tr> ";

			
				}
				$db->Execute("Update game set MemberCount = ? where Guild=?",array($ranks,$game['Guild']));
				
				
				echo "</table>";
				echo "<br><form method='post' action='guild-convidar.jsp'>
				<input type=text name='invited' value='NickName' class='buttons' size=15 maxlenght=15> 
						<br><input type=submit class='buttons' name=submit value='Convidar amigo(a) para o cl&atilde; ".$game['Guild']." '>
						</form>";
				
				echo "<br><form method='post' action='guild-sair.jsp'>
						<br><input type=submit class='buttons' name=submit  value='Sair do Cl&atilde; ".$game['Guild']." '>
						</form>"; 
						
				echo ($gm[0]['G_Master'] == $user_auth->username ? "<br><hr>Preço para trocar a foto da guild: <b>".$config['NickX_Pay']." Gold </b><br>
				  Seu gold: <b>".$game['Money']." </b><br>" : '');
			if ($game['Money'] >= $config['NickX_Pay']) { 
				echo ($gm[0]['G_Master'] == $user_auth->username ? "
				<br>Por favor, coloque o link da foto!<br>
				  <form method='post' action='guild-foto.jsp'>
								<input type=text name='foto' class='login' maxlenght=10 size=20>
								<input type=submit class='buttons' name=submit value='Alterar Foto'>
								</form><hr>" : '');
			} else {
	
	$f = new FormValidator($elems);
	$err = $f->validate($_POST['nickname']);
	
	if ( $err === true ) {
		
		$valid = $f->getValidElems();
		
		foreach ( $valid as $k => $v ) {
			
			if ( $valid[$k][0][1] == true ) {
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
	}
				
			echo '<i> Você nao tem gold suficiente.</i>';
			}
			echo "";


			}
	}}

	
?>
</center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>