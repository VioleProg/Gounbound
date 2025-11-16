<?PHP
$data = 'banidos';
    SmartyPaginate::connect($data);
    SmartyPaginate::setLimit($config['toprank_pp'],$data);
	SmartyPaginate::setPrevText("<<",$data);
	SmartyPaginate::setNextText(">>",$data);
	SmartyPaginate::setLastText('LAST', $data);
	SmartyPaginate::setFirstText('FIRST', $data);
	SmartyPaginate::setPageLimit($config['rank_page_limit'], $data);
	SmartyPaginate::setUrl("index.php?op=banidos", $data);
	//SmartyPaginate::setUrl("banidos.html", $data);

    function get_db_results($data,$where='',$order='') {
     global $db, $config;
		$where = $where == '' ? 'banlog.Id = game.Id' : "banlog.Id = banlog.Id and game.Id like '%$where%'";
        $result = $db->Execute("SELECT SQL_CALC_FOUND_ROWS *, banlog.Id, game.Id FROM banlog , game where $where order by banlog.StartTime DESC LIMIT ?,?",
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
	
	//print_r(get_db_results($data));
	
	$where = '';
	if (isset($_POST['name'])) {
		if (clean_variable($_POST['name'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['name'];
		}
	} 
	$rs = get_db_results($data,$where);
	echo "";
 echo "<table border='0' width='400'>
	<tr>
    <td align='center' class='top2'><b>&nbsp;</b></td>
    <td align='center' class='top2'><b>Login</b></td>
    <td align='center' class='top2'><b>Duração</b></td>
    <td align='center' class='top2'><b>Motivo</b></td>
	<td align='center' class='top2'><b>Por</b></td>
	</tr>";
	if (is_array($rs)) {
		foreach ($rs as $db => $r) {
		echo'<tr>
	   <td align="center" class="top2"><a href="rankgrade.html">'.getminirank($r['TotalGrade']).'</a> </td>
	   <td align="center" class="top2"> '.$r['Id'].'</td>
	   <td align="center" class="top2">'.number_format($r['Duration']).'</td>
	   <td align="center" class="top2">'.$r['Reason'].'</td>
	   	   <td align="center" class="top2"><b>'.$r['Judge'].'</b></td>
	   </tr>';
	   
	   
		
		}
	}
		echo '</table>';

	?>