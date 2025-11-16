<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_ranking.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>
				<?PHP
if ($config['admin_login'] == 'ok') {

	switch (@$_GET['do']) {
		case 'ban':
		if (isset($_POST) && valid_account($_POST['Id']) == true) {
			$db->Execute('update user set authority = -100 where Id = ?', array($_POST['Id']));
			if ($db->Affected_Rows() > 0) {
			echo notice('The user '.$_GET['url'].' has been banned successfully...','Success');
				writeLog($_POST['Id'].' Ban','CHAR_DEL');
			}
		}
		break;
		
		case 'unban':
		if (isset($_POST) && valid_account($_POST['Id']) == true) {
			$db->Execute('update user set authority = 1 where Id = ?', array($_POST['Id']));
			if ($db->Affected_Rows() > 0) {
			echo notice('The user '.$_GET['url'].' has been unbanned successfully...','Success');
				writeLog($_POST['Id'].' UnBan','CHAR_DEL');
			}
		}
		break;

		case 'edit':
		
		if (isset($_POST) && valid_account($_POST['Id']) == true) {
		
			$db->Execute('update user set NickName=?,E_Mail=?,Authority=?,Country=?,Password=?,Gender=? where Id = ?', 
				array($_POST['NickName'],$_POST['E_Mail'],$_POST['Authority'],$_POST['Id']));
				
				$db->Execute('update gunwcuser set NickName=?,E_Mail=?,Authority=?,Country=?,Password=?,Gender=? where Id = ?', 
				array($_POST['NickName'],$_POST['E_Mail'],$_POST['Authority'],$_POST['Id']));
				
				$db->Execute('update cash set Cash = ? where Id = ?', array($_POST['Cash'],$_POST['Id']));
				$db->Execute('update game set NickName = ?, Money=? where Id = ?', array($_POST['NickName'],$_POST['Gold'],$_POST['Id']));
				$db->Execute('update game set NickName = ?, TotalGrade=?, SeasonGrade=?, CountryGrade=? where Id = ?', array($_POST['NickName'],$_POST['TotalGrade'],$_POST['SeasonGrade'],$_POST['CountryGrade'],$_POST['Id']));
				
				$db->Execute('update game set NickName = ?, NoRankUpdate= where Id = ?', array($_POST['NickName'],$_POST['NoRankUpdate'],$_POST['Id']));
				
				$db->Execute('update game set NickName = ?, Guild=?, MemberCount=?, GuildRank=? where Id = ?', array($_POST['NickName'],$_POST['Guild'],$_POST['MemberCount'],$_POST['GuildRank'],$_POST['Id']));
				
				$db->Execute('update game set NickName = ?, AccumShot=?, AccumDamage=? where Id = ?', array($_POST['NickName'],$_POST['AccumShot'],$_POST['AccumDamage'],$_POST['Id']));
				
				$db->Execute('update game set NickName = ?, TotalScore=?, SeasonScore=? where Id = ?', array($_POST['NickName'],$_POST['TotalScore'],$_POST['SeasonScore'],$_POST['Id']));
				
				$db->Execute('update game set NickName = ?, TotalRank=?, SeasonRank=? where Id = ?', array($_POST['NickName'],$_POST['TotalRank'],$_POST['SeasonRank'],$_POST['Id']));
				
			if ($db->Affected_Rows() > 0) {
				
				echo notice('The user '.$_GET['url'].' has been updated successfully...','Success');
				writeLog($_POST['NickName'].' Edited','CHAR_EDIT');
			}
		}
		break;
		
		case 'delete':
			if (isset($_POST) && valid_account($_POST['Id']) == true) {
			$db->Execute('delete from user where Id = ?', array($_POST['Id']));
			if ($db->Affected_Rows() > 0) {
						$db->Execute('delete from game where Id = ?', array($_POST['Id']));
						$db->Execute('delete from cash where Id = ?', array($_POST['Id']));
			echo notice('The user '.$_GET['url'].' has been DELETED successfully...','Success');
				writeLog($_POST['Id'].' Deleted','CHAR_DEL');
			}
		}
		
		break;
	}
}
$data = 'edit';
    SmartyPaginate::connect($data);
    SmartyPaginate::setLimit($config['rank_pp'],$data);
	SmartyPaginate::setPrevText("<<",$data);
	SmartyPaginate::setNextText(">>",$data);
	SmartyPaginate::setLastText('LAST', $data);
	SmartyPaginate::setFirstText('FIRST', $data);
	SmartyPaginate::setPageLimit($config['rank_page_limit'], $data);
	SmartyPaginate::setUrl("index.php?op=editacc", $data);
	//SmartyPaginate::setUrl("rank.jsp", $data);

    function get_db_results($data,$where='',$order='') {
     global $db, $config;
		$where = $where == '' ? 'game.Id = user.Id' : "game.Id = user.Id and user.NickName like '%$where%'";
        $result = $db->Execute("SELECT SQL_CALC_FOUND_ROWS *, game.Id, user.NickName FROM game , user where $where order by game.TotalRank LIMIT ?,?",
            array(SmartyPaginate::getCurrentIndex($data), SmartyPaginate::getLimit($data)));
			
		//	$result = $db->Execute("SELECT SQL_CALC_FOUND_ROWS * FROM game , user where order by TotalRank LIMIT ?,?",
           // array(SmartyPaginate::getCurrentIndex($data), SmartyPaginate::getLimit($data)));
        $rs = $result->GetArray();
  
	  $excludelist  = preg_split('/ /', $config['rank_exclude'], -1,PREG_SPLIT_NO_EMPTY);
      foreach ($rs as $r => $_row) {
			if (@$config['admin_login'] != 'ok')  {
				if (@$_POST['advance'] !='GM' ) { 
						if ($config['show_admin'] == false && $_row['Authority'] == 100) { continue; }
						if ($config['show_gm'] == false && $_row['Authority'] == 99) { continue; }
						if (in_array($_row['NickName'], $excludelist)) { continue; }	
					
				}
	       }
            $_data[] = $_row;
        }
        
        // now we get the total number of records from the table
        $_query = "SELECT FOUND_ROWS()";
        $_result = $db->Execute($_query);
        $_row = $_result->GetArray();

        SmartyPaginate::setTotal($_row[0]['FOUND_ROWS()'],$data);

        
        return @$_data;
		

    }
		if ($config['admin_login'] == 'ok') {
	//print_r(get_db_results($data));
	

	
	$where = '';
	if (isset($_GET['url'])) {
		if (clean_variable($_GET['url'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		header('Refresh: 2; url=editacc.jsp');
		} else {
		$where = $_GET['url'];
		}
	} 
	$rs = get_db_results($data,$where);
	echo "";
	
	 
	if (is_array($rs)) {
	$r = $rs[0];
	 echo "<br><br>Informação sobre o usuario<table>";
		echo '<tr><td align="right">Login:</td><td> '.$r['Id'].' </td></tr>
		<tr><td align="right">Nick:</td><td> '.$r['NickName'].' </td></tr>
			<tr><td align="right">Status: </td><td><span class="'.$r['Authority'].'">'.ucfirst(getauth($r['Authority'])).' </span></td></tr>
			<tr><td align="right">Sexo:</td><td> <img src="template/'.$config['template'].'/images/'.($r['Gender'] != 1 ? 'male' : 'female').'.gif"> '.ucfirst($r['Gender'] != 1 ? 'Masculino' : 'Feminino').' </td></tr>
				<tr><td align="right">Pais:</td><td> '. getcountry($r['Country']).' </td></tr>
			<tr><td align="right">Clã:</td><td> '.($r['Guild'] != '' ? '<a href="guilds-'.$r['Guild'].'.jsp">'.$r['Guild'].'</a>' : 'none').' </td></tr>
			<tr><td align="right">Rank:</td><td> '. $r['TotalRank'].' </td></tr>
			<tr><td align="right">Nivel:</td><td> '. getgrade($r['TotalGrade']).' </td></tr>
			<tr><td align="right">Score:</td><td> '.number_format($r['TotalScore']).'</td></tr>
			';
		if ($config['Show_Money'] == true) {
		$result = $db->Execute("Select * from cash where Id = ?", array($r['Id']));
		$rs1 = $result->GetArray();
		echo '<tr><td align="right">Gold:</td><td> '.number_format($r['Money']).'</td></tr>';
		echo '<tr><td align="right">Cash:</td><td> '.number_format($rs1[0]['Cash']).'</td></tr>';
		}
		if ($config['admin_login'] == 'ok') {
		echo '<tr><td></td><td>';
			if ($r['Authority'] == 1) {
			echo "<form method='post' action='edit-".$_GET['url']."-ban.jsp'>
					<input type='hidden' value='".$r['Id']."' name='Id'>
								<input type=submit class='buttons' name=submit value='Banir'>
								</form>";
			} 
			if ($r['Authority'] == '-100') {
			echo "<form method='post' action='edit-".$_GET['url']."-unban.jsp'>
			<input type='hidden' value='".$r['Id']."' name='Id'>
								<input type=submit class='buttons' name=submit value='Desbanir'>
								</form>";
			}
			echo "<input type=button onclick='javascript:document.getElementById(\"editor\").style.display=\"block\";' class='buttons' value='Edit'>";
				echo "<form method='post' action='edit-".$_GET['url']."-delete.jsp'>
					<input type='hidden' value='".$r['Id']."' name='Id'>
								<input type=submit class='buttons' name=submit value='Deletar'>
								</form>";
		echo '</td></tr>';

		}
		echo '</table>';
		if ($config['admin_login'] == 'ok') {
			echo '<div Id="editor" style="display:none"> <br><br>
				<form method="post" action="edit-'.$_GET['url'].'-edit.jsp">
					<input type="hidden" class="buttons" name="Id" value="'.$r['Id'].'">
				<table>
				<tr><td align="right">Nome:</td><td><input type="text" class="buttons" name="NickName" value="'.$r['NickName'].'" size=25 maxlength=15> </td></tr>
				<tr><td align="right">Clã:</td><td><input type="text" class="buttons" name="Guild" value="'.$r['Guild'].'" size=25 maxlength=15> </td></tr>
				<tr><td align="right">Membros no Clã:</td><td><input type="text" class="buttons" name="MemberCount" value="'.$r['MemberCount'].'" size=25 maxlength=15> </td></tr>
				<tr><td align="right">Rank no Clã:</td><td><input type="text" class="buttons" name="GuildRank" value="'.$r['GuildRank'].'" size=25 maxlength=15> </td></tr>
				<tr><td align="right">Status: </td><td><select name="Authority">';
				foreach (getauth('get') as $auth => $a) {
					echo '<option value="'.$auth.'" '.($auth == $r['Authority'] ? 'selected' : '').'> '.ucfirst($a).'</option>';
				
				}
				
			echo '</select></td></tr>
				<tr><td align="right">Sexo:</td><td>
						<img src="template/'.$config['template'].'/images/male.gif"> 
						<input type=radio name="Sex" value="0" '.($r['Gender'] == 0 ? 'checked' : '').'> Masculino <br> 
						<img src="template/'.$config['template'].'/images/female.gif"> 
						<input type=radio name="Sex" value="1" '.($r['Gender'] == 1 ? 'checked' : '').'> Feminino </td></tr>
  <tr>
    <td align="right">Email:</td>
    <td><input type="text" class="buttons" name="E_Mail" value="'.$r['E_Mail'].'" size=25 maxlength=40 />
    </td>
  </tr>
  <tr>
    <td width="156" align="right">TotalGrade:</td>
    <td width="154"><input type="text" class="buttons" name="TotalGrade" value="'.$r['TotalGrade'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">SeasonGrade:</td>
    <td><input type="text" class="buttons" name="SeasonGrade" value="'.$r['SeasonGrade'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">CountryGrade:</td>
    <td><input type="text" class="buttons" name="CountryGrade" value="'.$r['CountryGrade'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">TotalScore:</td>
    <td><input type="text" class="buttons" name="TotalScore" value="'.$r['TotalScore'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">SeasonScore:</td>
    <td><input type="text" class="buttons" name="SeasonScore" value="'.$r['SeasonScore'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">TotalRank:</td>
    <td><input type="text" class="buttons" name="TotalRank" value="'.$r['TotalRank'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">SeasonRank:</td>
    <td><input type="text" class="buttons" name="SeasonRank" value="'.$r['SeasonRank'].'" size=25 maxlength=15 />
    </td>
  </tr>
   <tr>
    <td align="right">NoRankUpdate:</td>
    <td><input type="text" class="buttons" name="NoRankUpdate" value="'.$r['NoRankUpdate'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">AccumShot:</td>
    <td><input type="text" class="buttons" name="AccumShot" value="'.$r['AccumShot'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">AccumDamage</td>
    <td><input type="text" class="buttons" name="AccumDamage" value="'.$r['AccumDamage'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">Cidade:</td>
    <td><input type="text" class="buttons" name="Cidade" value="'.$r['Cidade'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">Estado:</td>
    <td><input type="text" class="buttons" name="Estado" value="'.$r['Estado'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">Pergunta:</td>
    <td><input type="text" class="buttons" name="Pergunta" value="'.$r['Pergunta'].'" size=25 maxlength=15 />
    </td>
  </tr>
    <tr>
    <td align="right">Cidade:</td>
    <td><input type="text" class="buttons" name="Cidade" value="'.$r['Cidade'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">Estado:</td>
    <td><input type="text" class="buttons" name="Estado" value="'.$r['Estado'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">Pergunta:</td>
    <td><input type="text" class="buttons" name="Pergunta" value="'.$r['Pergunta'].'" size=25 maxlength=15 />
    </td>
  </tr>
  
  <tr>
    <td align="right">Resposta:</td>
    <td><input type="text" class="buttons" name="Resposta" value="'.$r['Resposta'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td width="156" height="56" align="right">Foto:</td>
    <td width="154"><input type="text" class="buttons" name="foto" value="'.$r['foto'].'" size=25 maxlength=200 />
    </td>
    <td width="297" align="left"><a href='.$r['foto'].' target="_blank"><img src="'.$r['foto'].'"  width="39" height="50" /> </a></td>
  </tr>
  <tr>
    <td align="right">Comentario</td>
    <td><input type="text" class="buttons" name="comentario" value="'.$r['comentario'].'" size=25 maxlength=200 />
    </td>
  </tr>
  
    <tr>
    <td align="right">BanLog:</td>
    <td><input type="text" class="buttons" name="Cidade" value="'.$r['Cidade'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">Estado:</td>
    <td><input type="text" class="buttons" name="Estado" value="'.$r['Estado'].'" size=25 maxlength=15 />
    </td>
  </tr>
  <tr>
    <td align="right">Pergunta:</td>
    <td><input type="text" class="buttons" name="Pergunta" value="'.$r['Pergunta'].'" size=25 maxlength=15 />
    </td>
  </tr>
  
  <tr>
    <td align="right">Senha:</td>
    <td><input type="text" class="buttons" name="Password" value="'.$r['Password'].'" size=25 maxlength=40 />
    </td>
  </tr>
						<tr><td align="right">Pais:</td><td><select name="Country">';
				foreach (getcountry('get') as $count => $c) {
					echo '<option value="'.$count.'" '.($count == $r['Country'] ? 'selected' : '').'> '.ucfirst($c).'</option>';
				
				}
				
				echo '</td></tr>
				<tr><td align="right">Gold:</td><td><input type="text" class="buttons" name="Gold" value="'.$r['Money'].'" size=25 maxlength=12> </td></tr>
				<tr><td align="right">Cash:</td><td><input type="text" class="buttons" name="Cash" value="'.$rs1[0]['Cash'].'" size=25 maxlength=12> </td></tr>
				<tr><td></td><td>
				<input type="hidden" value="'.$r['Id'].'" name="Id">
				<input type=submit class="buttons" name=submit value="Editar"></td></tr>
				</table></form>
					</div>';
		}
}		
		if ($config['Show_Avatar'] == true) {
			 echo "<br><br>Avatares do usuario<table>";
			 $var = $r['Prop1'];
			 $wa = (strlen($var) - 1) / 4;
			$item_a = array();
			for ($a=1;$a<=$wa;$a++) {
				$item_a[] = leer($var, "l*");
				
				$var = substr($var, 4);
			 
			 }
			$items = $db->Execute("SELECT * FROM avatar_table where Prop_Number IN ('" . implode("','", $item_a) . "')");
			foreach ($items->GetArray() as $item => $a) {
				echo '<tr><td align=center><img src="avatar/propriedades/'.strtolower($a['Prop_Type']).'.gif"></td><td>'.$a['Prop_Name'] . '</td><td>';
					echo $a['Prop_Delay'] != 0 ? ' '.$a['Prop_Delay'] .'<img src="avatar/delay.gif">':'';  
		echo $a['Prop_Star'] != 0 ? ' '.$a['Prop_Star'] .'<img src="avatar/propriedades/popular.gif">' :'';  
		echo $a['Prop_Dig'] != 0 ? ' '.$a['Prop_Dig'] .'<img src="avatar/propriedades/dig.gif">':' ';  
		echo $a['Prop_Def'] != 0 ? ' '.$a['Prop_Def'].'<img src="avatar/propriedades/def.gif">':' ';  
		echo $a['Prop_Attack'] != 0 ? ' '.$a['Prop_Attack'] .'<img src="avatar/propriedades/attack.gif">':''; 		 
		echo $a['Prop_Life'] != 0 ? ' '.$a['Prop_Life'] .'<img src="avatar/propriedades/life.gif">':'';  
		echo $a['Prop_Shield'] != 0 ? ''.$a[' Prop_Shield'] .'<img src="avatar/propriedades/shield.gif">' :'';  
		echo $a['Prop_Skip'] != 0 ? ' '.$a['Prop_Skip'] .'<img src="avatar/propriedades/skip.gif">':'';  
				 
				
				echo '</td></tr>';
	
			}
			
			 echo "</table>
			 ";
		
		}
	}

	
function leer($var, $tipo) {
	$arrData = unpack($tipo, $var);
	$ds = $arrData['1'];
	return $ds;
}

	?></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>