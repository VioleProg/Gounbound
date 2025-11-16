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

	$error = 0;
	switch (@$_GET['url']) {
	default:
	header('location: home.jsp');
		
	break;
case 'convidar':
			if (isset($_POST['invited'])) {
			$invited = clean_variable($_POST['invited']);
			$result = $GLOBALS['db']->Execute("SELECT Id, Guild FROM game where upper(Id) = upper(?) and (Guild is NULL or Guild = '')",array($invited));
		
			if ($result->RecordCount() > 0) {
				echo notice('Give the Code to the Player you want to invite<br>The Player has also been sent a Email containing the Code.',"Creating Invitation Code for <strong>$invited</strong> <br />");
				$code = md5_encrypt($game['Guild'],$invited);
				echo '<fieldset><legend>Invitation Code</legend>
					<pre>Code: '.$code.'
					<br>Nome da Guild: '.$game['Guild'].'</pre>
					</fieldset>';
				$content = 'This is you Invitation Code: 
							'.$code.' 
							Guild Name : '.$game['Guild'].'
							To use:
							Go Login to your account and go to My Guilds 
							Put the invation code and the Guild Name. ';
				mailer('','Invite to Guild '.$game['Guild'], $content, $invited);
			} else {
				echo "<center><img src='images/aff_cross.gif'> <strong>$invited</strong> já está em uma guild<br><br><hr><br></center>";
			}
				
			}
		break;

case 'ativar':
	
		if (md5_decrypt($_POST['code'],$user['Id']) == $_POST['Guild'] && ($game['Guild']=='' || $game['Guild'] == NULL)) {
		 $result= $db->Execute("Update game set Guild = ? where Id =?", array(md5_decrypt($_POST['code'],$user['NickName']), $user_auth->username));
		 echo notice('Success', "You have joined $_POST[Guild] Guild... Congratulations!!! <br>Redirecting in 5 seconds");
		 if ($db->Affected_Rows()== 1) {
		 writelog("Guild: ".$game['Guild'], 'ENTROU_GUILD'); 
		 header('Refresh: 2; url=cla-guild.jsp');
		}
		} else {
		echo notice('', 'Invalid Invitation Code for this Guild');
		}
		break;
	
case 'sair':
		if ($game['Guild'] != '' || $game['Guild'] != NULL) {
		// Esses só executam quando você é o Master da Guild!        
		 $result= $db->Execute("Delete from guildweb where G_Master=?", array($game['Id']));
		 $result= $db->Execute("Update game set Guild       = '' where Id=?", array($user_auth->username));
		 $result= $db->Execute("Update game set MemberCount = '0' where Id=?", array($user_auth->username));
		 $result= $db->Execute("Update game set GuildRank   = '0' where Id=?", array($user_auth->username));
         echo "<center><img src='images/aff_tick.gif'> <strong>Você</strong> saiu da guild<br><br> Redirecionando em 5 segundos<br><br><hr><br></center>";
		 writelog("Guild: ".$game['Guild']."  ID: ".$game['Id'], 'SAIU_GUILD'); 
		 header('Refresh: 2; url=cla-guild.jsp');
		break;
        }
case 'foto':
if (isset($_POST['foto'])) {
echo "<center><img src='images/skip_delay.gif'> Iniciando alteração de <strong>Imagem</strong></center><br><br>";
				if (clean_variable($_POST['foto'],1) == false) {
				echo "<center><img src='images/aff_cross.gif'> <strong>Erro:</strong> Este serviço está temporariamente indisponivel.<br><br><hr><br></center>";
				} else {		
						if ($game['Money'] < $config['NickX_Pay']) {
						echo "<center><img src='images/aff_cross.gif'> <strong>Erro:</strong> Você não tem gold para alterar a imagem da sua guild.<br><br><hr><br></center>";
						} else {
							$db->Execute("Update guildweb set foto = ? where G_Master=?", array($_POST['foto'],$user_auth->username));
							echo "<b>Atualizando a nova foto da guild ...</b><br><img src='images/aff_tick.gif'> Atualizada com sucesso!<br><br>";
							if ($db->Affected_Rows()== 1) {
								 echo "";								 
							}
							
							$db->Execute("Update game set  Money = Money - ? where Id=?", array($config['NickX_Pay'],$user_auth->username));
							echo "<b>Retirando ".$config['NickX_Pay']." de gold de sua conta.</b><br><img src='images/aff_tick.gif'> Retirado com sucesso! <br><br>";
							if ($db->Affected_Rows()== 1) {
								 echo "";
							}
							writelog("OLD: ".$user['foto'] ." New: ".$_POST['foto'], 'FOTO_CHANGE'); 
							echo "<br><br><center><b>O procedimento de alteração de imagem foi finalizado com sucesso!</b><br><br>Redirecionando em 5 segundos...</center><hr><br>";
							$game['Money'] -= $config['NickX_Pay'];
							header('Refresh: 5; url=cla-guild.jsp');
						}
					}
				
				}
		break;
case 'criar':
		if (isset($_POST['code'])) {
				$db->Execute("CREATE TABLE IF NOT EXISTS `guildweb` (
							`guild` VARCHAR( 30 ) NOT NULL ,
							`G_Master` VARCHAR( 30 ) NOT NULL ,
							`Descricao` VARCHAR( 60 ) NOT NULL,
							`Requerimento` VARCHAR( 60 ) NOT NULL,
							`WebSite` VARCHAR( 40 ) NOT NULL,
							`foto` VARCHAR( 100 ) NOT NULL
							)");
			$code = $_POST['code'];
				if ($game['Guild'] != '' || $game['Guild'] != NULL) {
				echo "<center><img src='images/aff_cross.gif'> <strong>Você</strong> já está em uma guild<br><br> Redirecionando em 5 segundos<br><br><hr><br></center>";
				header('Refresh: 5; url=cla-guild.jsp');
				} else {
				
				echo "<center><img src='images/skip_delay.gif'> Iniciando criação de <strong>Guild</strong></center><br><br>";
				$result= $db->Execute("Select * from game where upper(Guild) = upper(?)", array($code));
				echo '<b>Checando nome da guild ...</b><br>';
			
				if ($db->Affected_Rows()== 0) {
					echo "<img src='images/aff_tick.gif'> O nome da guild: <strong>$code</strong> pode ser utilizado!<br><br>";
					if ($user['Authority'] >= 99) {
					$result= $db->Execute("Update game set Guild = ? where Id=?", array($code,$user_auth->username));
					} else {					
					$result= $db->Execute("Update game set Guild = ? , Money = Money - ? where Id=?", array($code,$config['guild_money_create'],$user_auth->username));
					}
					if ($db->Affected_Rows()== 1) {
						echo '<b>Inserindo as informações da Guild no banco de dados...</b><br>';
						echo "<img src='images/aff_tick.gif'> Inserido com Sucesso! <br><br>";
						
						
						$result= $db->Execute("Insert into guildweb (guild,G_Master,Descricao,Requerimento,WebSite,foto) values (?,?,?,?,?,?)", array($code,$user_auth->username,$_POST['Descricao'],$_POST['Requerimento'],$_POST['WebSite'],$_POST['foto']));
						
						if ($db->Affected_Rows()== 1) {
						echo '<b>Conferindo Banco de dados...</b><br>';
						echo "<img src='images/aff_tick.gif'> Conferido com Sucesso!<br><br><center><b>A guild $code foi criada com sucesso!</b></center><br><hr><br>";
						writelog("Guild: $code", 'CRIOU_GUILD');
						header('Refresh: 2; url=cla-guild.jsp');						
						}
					}
				}else {echo "<center><img src='images/aff_cross.gif'> O nome da guild: <strong>$code</strong> já existe!<br />Crie uma guild com outro nome.<br><br><hr><br></center>";}
				}
			}
		
		
		break;	
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