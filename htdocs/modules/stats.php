<script language="javascript">
function resetDamage() {
  if (confirm("Você realmente deseja redefinir sua média de danos? ") ) {
      document.location.href="damage.jsp";
   }
}

function MudarNickName(form) {
  var form_change = "<form method=post action=atualizando-nickname.jsp><table >";
  form_change += '<tr>';
  form_change += '<td class="formlist_l"><span class="gray04">Novo NickName</span></td>';
  form_change += '<td class="p9 ln15" style="padding:9px 0 9px 23px"><input type="text" name="nickname" class="box01" >&nbsp;';
  form_change += '<input type="image" src="images/btn_change.gif" value="Trocar" alt="Submit"/></a>';
  form_change += '<span id="idUsableMsg" name="idUsableMsg"></span>';
  form_change += '</td>';
  form_change += '</tr>';
  form_change += '<tr>';
  form_change += '<td></td><td> 10,000 de Gold é necessário para alterar um nickname.<br />';
  form_change += 'Esta quantia será retirada de sua conta a cada vez que o seu nickname for alterado. ';
  form_change += 'Seu nickname pode ser alterado quando você quiser.</td></tr></table></form><hr>';

  document.getElementById("span_change").innerHTML= form_change;
  document.registerForm.memberid.focus();
}

function MudarSenha(form) {
  var form_change = "<form method=post action=atualizando-senha.jsp><table >";
  form_change += '<tr>';
  form_change += '<td class="formlist_l"><span class="gray04">Nova Senha</span></td>';
  form_change += '<td class="p9 ln15" style="padding:9px 0 9px 23px"><input type="text" name="senha" class="box01" >&nbsp;';
  form_change += '<input type="image" src="images/btn_change.gif" value="Trocar" alt="Submit"/></a>';
  form_change += '<span id="idUsableMsg" name="idUsableMsg"></span>';
  form_change += '</td>';
  form_change += '</tr>';
  form_change += '<tr><td class="formlist_l"><span class="gray04">Pergunta Secreta</span></td>';
  form_change += "<td class=p9 ln15 style='padding:9px 0 9px 23px'><b>Pergunta:</b> <? if ($user['Pergunta'] == 0) { echo 'Nome da mãe'; } elseif ($user['Pergunta'] == 1) { echo 'Animal de estimação'; } elseif ($user['Pergunta'] == 2) { echo 'Qualidade'; } elseif ($user['Pergunta'] == 3) { echo 'Não Suporto'; } elseif ($user['Pergunta'] == 4) { echo 'Desejo'; } ?><br> <input type=text name=resposta class=box01 >&nbsp;";
  form_change += '<br> Digite a resposta da pergunta secreta que você inseriu quando se cadastrou para confirmar a troca de senha.</td></tr><tr>';  
  form_change += '<td></td><td> 10,000 de Gold é necessário para alterar uma senha.<br />';
  form_change += 'Esta quantia será retirada de sua conta a cada vez que o sua senha for alterada. ';
  form_change += 'Sua senha pode ser alterado quando você quiser.</td></tr></table></form><hr>';

  document.getElementById("span_change").innerHTML= form_change;
  document.registerForm.memberid.focus();
}
</script>
<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_myacc.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>
<div class="right">
				<!-- my gunbound / table width 573px -->
				<br>
&nbsp;<table cellspacing="0" cellpadding="0" align="center" class="formlist">
				<col width="121"><col width="452">
								<tr>
				<td class="formlist_l" height="30">
				<img src="images/stit_mygunbound.gif" width="87" height="20" alt="" align="left"/></td>
				<td class="gray05">&nbsp;</td>
                </tr>
										<tr><td colspan="2" height="1" bgcolor="#ADADAD"></td></tr>

		<tr>
				<td class="formlist_l" height="30">Meu Game ID</td>
				<td class="gray05"><b><?=$user['Id']?></b></td>
                </tr>
                				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30">Meu NickName</td>
				<td class="gray05"><b><?=getminirank($game['CountryGrade']); ?>&nbsp;<?=$user['NickName']?></b>&nbsp;&nbsp;
                  <a href="javascript:void(MudarNickName(this.form));">
				<img src="images/btn_change.gif" align="middle" alt="change" /></a>

                  </td>
                </tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
                  <tr>
				<td class="formlist_l" height="30">Senha</td>
				<td class="gray05"><b>
				
<input type="password" name="Password" value="<?=$user['Password']?>" size="20" disabled="disabled" style="background: #FEFFF0 no-repeat 5px 1px"/>
</b>&nbsp;&nbsp;
                  <a href="javascript:void(MudarSenha(this.form));">
				<img src="images/btn_change.gif" align="middle" alt="change" /></a>

                  </td>
                </tr>
                <tr><td colspan="2"><span id="span_change" name="span_change" ></span></td></tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="31">Classe</td>
				<td><?=getauth($user['Authority']); ?></td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
								<tr>
				<td class="formlist_l" height="30">Guild</td>
				<td class="gray05"><?= ($game['Guild'] != '' ? ' '.$game['Guild'].' - <a href="cla-guild.jsp">Ir para página do Clan</a><b> ' : ' Você não está em nenhuma guild<br /><a href="cla-guild.jsp">Entre ou Crie uma Guild</a> ') ?></td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30">Sexo</td>
				<td class="gray05"><?=' '.ucfirst($user['Gender'] != 1 ? 'Masculino' : 'Feminino').' '?>&nbsp;<img src="template/<?=$config['template']?>/images/<?=($user['Gender'] != 1 ? 'masculino' : 'feminino')?>.gif"></td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30">Nacionalidade</td>
				<td class="gray05"><img align="top" src="ranks/pais/16/<?=getcountry($user['Country']);?>.png" width="16" height="16" alt="<?=getcountry($use['Country']);?>" title="<?=$user['NickName'];?> &eacute; o n&ordm; <?=$game['CountryRank'];?> no país <?=getcountry($user['Country']);?>"> - <?=getcountry($user['Country']);?>                   </td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30">Gold</td>
				<td class="gray05"><?=number_format($game['Money']);?></td>
				</tr>			
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30">Cash</td>
				<td class="gray05"> <?=number_format($cash['Cash']);?></td>
				</tr>			
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30">Moedas-G</td>
				<td class="gray05"> <?=number_format($credito['Credito']);?></td>
				</tr>			
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30">Pontos de evento</td>
				<td class="gray05"><?=number_format($game['EventScore0']);?></td>
				</tr>			
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30">Último Acesso</td>
				<td class="gray05"><?=$game['LastUpdateTime']?></td>
				</tr>			
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>			
				</table>

				<!-- my ranking -->
				<div class="subtitle">&nbsp;</div>
				<table cellspacing="0" cellpadding="0" align="center" class="formlist" width="573">
				<col width="280"><col>

				<tr>
				<td class="formlist_l" height="30" width="190"><img src="images/stit_myranking.gif" width="87" height="20" alt="" /></td>
				<td class="gray05" width="373">&nbsp;</td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#ADADAD"></td></tr>

				<tr>
				<td class="formlist_l" height="30" width="190">Ranking na Guild</td>
				<td class="gray05" width="373"><?=($game['Guild'] != '' ? 'Você está em <b>'.$game['GuildRank'].'º</b> entre <b>'.$game['MemberCount'].'</b> membro(s) na guild <b>'.$game['Guild'].'</b>' : '<b>Atenção:</b> Você deve <a href="cla-guild.jsp">criar ou entrar em uma guild</a> para ver este ranking ') ?></td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30" width="190">Ranking no País</td>

				<td class="gray05" width="373">Você está em <b><?=$game['CountryRank'];?>°</b> no país <b><?=getcountry($user['Country']);?></b></td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30" width="190">Ranking Total</td>
				<td class="gray05" width="373">Você está em <b><?=$game['TotalRank'];?>°</b>(Você adquiriu <b><?=$game['TotalScore'];?> GP's</b> Totalmente)</td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30" width="190">Ranking Semanal</td>
				<td class="gray05" width="373">Você está em <b><?=$game['SeasonRank'];?>°</b> (Você adquiriu <b><?=$game['SeasonScore'];?> GP's</b> esta semana)</td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr><td colspan="2" height="1" bgcolor="#ADADAD"></td></tr>

				</table>

				<!-- Win -->
				<?
							$win_lose = $db->Execute('Select * from playlog where S0_ID = ? or S1_ID = ? or S2_ID = ? or S3_ID = ? or S4_ID = ? or S5_ID = ? or S6_ID = ? or S7_ID = ?',
									array($user_auth->username,$user_auth->username,$user_auth->username,$user_auth->username,$user_auth->username,$user_auth->username,$user_auth->username,$user_auth->username));
							if ($db->Affected_Rows() > 0) {
								$win = 0;
								$lose = 0;
								$played = 0;
								foreach($win_lose->GetArray() as $wl => $w) {
									$played++;
									if ($w['WinTeamOrPlayer'] == 0 && $w['S0_ID'] == $user_auth->username) {
										$win++;
									}
									if ($w['WinTeamOrPlayer'] == 1 && $w['S1_ID'] == $user_auth->username) {
										$win++;
									}
									if ($w['WinTeamOrPlayer'] == 2 && $w['S2_ID'] == $user_auth->username) {
										$win++;
									}
										if ($w['WinTeamOrPlayer'] == 3 && $w['S3_ID'] == $user_auth->username) {
										$win++;
									}
									if ($w['WinTeamOrPlayer'] == 4 && $w['S4_ID'] == $user_auth->username) {
										$win++;
									}
										if ($w['WinTeamOrPlayer'] == 5 && $w['S5_ID'] == $user_auth->username) {
										$win++;
									}
									if ($w['WinTeamOrPlayer'] == 6 && $w['S6_ID'] == $user_auth->username) {
										$win++;
									}
										if ($w['WinTeamOrPlayer'] == 7 && $w['S7_ID'] == $user_auth->username) {
										$win++;
									}
								
								
								}
					
								$lose = $played-$win;
							}
							
							?>
				<div class="subtitle">&nbsp;</div>
				<table cellspacing="0" cellpadding="0" align="center" class="formlist" width="573">
				<col width="120"><col>
				<tr>
				<td class="formlist_l" height="30" width="129"><img src="images/stit_win.gif" width="87" height="20" alt="" /></td>

				<td class="gray05" width="434">&nbsp;</td>
				</tr>
								<tr><td colspan="2" height="1" bgcolor="#ADADAD"></td></tr>

				<tr>
				<td class="formlist_l" height="30" width="129">Total</td>

				<td class="gray05" width="434">Você participou de <b><? echo  $played; ?></b> partidas</td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30" width="129">% de vitórias</td>
				<td class="gray05" width="434">Seu índice de vitórias é: <b><? echo round(($win / $played) * 100,2); ?>%</b></td>

				</tr>
				<tr><td colspan="2" height="1" bgcolor="#E3E3E3"></td></tr>
				<tr>
				<td class="formlist_l" height="30" width="129">Vitórias &amp; 
				Derrotas</td>
				<td class="gray05" width="434">Você tem um total de <b><?=$win;?></b> vitórias &amp; <b><?=$lose;?></b> derrotas</td>
				</tr>
				<tr><td colspan="2" height="1" bgcolor="#ADADAD"></td></tr>
				</table>

				<!-- damage -->
				<div class="subtitle">&nbsp;</div>
				<table cellspacing="0" cellpadding="0" align="center" class="formlist"  width="573">
				<col width="120"><col>
				<tr>
				<td class="formlist_l" height="30"><img src="images/stit_damage.gif" width="87" height="20" alt="" /></td>
				<td class="gray05">
&nbsp;</td>

				</tr>				<tr><td colspan="2" height="1" bgcolor="#ADADAD"></td></tr>

				<tr>
				<td class="formlist_l" height="30">Média</td>
				<td class="gray05">
<?php
$damage = $game['AccumDamage'] % $game['AccumShot'];
if ($damage >= 1) {
echo "<?=$damage?>";
}
if ($damage == 0) {
echo "0";
}?>
&nbsp;&nbsp;<a href="javascript:void(resetDamage());"><img src="images/btn_reset02.gif" width="50" height="20" align="absmiddle" alt="reset" /></a></td>

				</tr>
				<tr><td colspan="2" height="1" bgcolor="#ADADAD"></td></tr>
				</table>
			</div></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>