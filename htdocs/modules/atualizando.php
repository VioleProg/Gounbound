<?PHP
if (@$config['user_login'] == 'ok') {
		
	$error = 0;
	switch (@$_GET['url']) {
	default:
	header('location: index.jsp');
	break;
	
case 'nickname':

			if (isset($_POST['nickname'])) {
				if (clean_variable($_POST['nickname'],1) == true) {
				echo "O Nick tem car&aacute;teres invalidas nele, por favor usa um outro Nick ";
				} else {		
					if (valid_NickName($_POST['nickname']) === true) {
					echo "O Nick que voc&ecirc; escolheu j&aacute; est&aacute; sendo usado por outra pessoa.";
					} else {
						if ($game['Money'] < $config['NickX_Pay']) {
						echo "Voc&ecirc; n&atilde;o tem bastante gold para fazer a troca";
						} else {
							$db->Execute("Update user set NickName = ? where Id = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update game set NickName = ? where Id = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update gunwcuser set NickName = ? where Id = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update forumlivre set NickName = ? where Author = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update forumlivre2 set NickName = ? where Author = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update forumss set NickName = ? where Author = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update forumss2 set NickName = ? where Author = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update forumde set NickName = ? where Author = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update forumde2 set NickName = ? where Author = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update fevento set NickName = ? where Author = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update fevento2 set NickName = ? where Author = ?", array($_POST['nickname'],$user_auth->username));
					        $db->Execute("Update gbe_comentarios set NickName = ? where Author = ?", array($_POST['nickname'],$user_auth->username));
					        $db->Execute("Update gbe_noticias set NickName = ? where Author = ?", array($_POST['nickname'],$user_auth->username));
							echo "<br>Update User Database... ";
							if ($db->Affected_Rows()== 1) {
								 echo "done";								 
							}
							$db->Execute("Update user set NickName = ? where Id = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update game set NickName = ? where Id = ?", array($_POST['nickname'],$user_auth->username));
							$db->Execute("Update gunwcuser set NickName = ? where Id = ?", array($_POST['nickname'],$user_auth->username));
							echo "<br>Update Game Database... ";
							if ($db->Affected_Rows()== 1) {
								 echo "done";
							}
							$db->Execute("Update game set  Money = Money - ? where Id = ?", array($config['NickX_Pay'],$user_auth->username));
							echo "<br>Update Gold Database... ";
							if ($db->Affected_Rows()== 1) {
							}
							writelog("OLD: ".$user['NickName'] ." New: ".$_POST['nickname'], 'NICK_CHANGE'); 
							echo 'Seu nick foi atualizado';
							$game['Money'] -= $config['NickX_Pay'];
						}
					}
				
				}
			}
		
case 'senha':
			if (isset($_POST['senha'])) {
				if (clean_variable($_POST['senha'],1) == true) {
				echo "Sua senha apresenta caracteres especiais, use outra senha por favor";
				} else {		
					if ($user['Resposta'] != $_POST['resposta']) {
					echo "Sua resposta secreta nao confere.";
	
					
					} else {
							$db->Execute("Update user set Password = ? where Id = ?", array($_POST['senha'],$user_auth->username));
							$db->Execute("Update gunwcuser set Password = ? where Id = ?", array($_POST['senha'],$user_auth->username));

							echo "<br><b>Parabens,</b> sua senha foi alterada com sucesso!!! <br><br>";
							if ($db->Affected_Rows()== 1) {							 
							}
                            writelog("Antiga: ".$user['Password'] ." Nova: ".$_POST['senha'], 'PASS_CHANGE'); 
							echo 'Sua senha foi atualizada';

					
					}
			}
				
				
			}
case 'codigo':
}} ?>