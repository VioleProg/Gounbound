<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_ban.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>
			
      <table width="97%" border="0">
        <tr>
          <td width="53%" align="right"><?PHP
							  if (isset($_POST) && valid_account($_POST['Id']) == true) 			
$where = '';
	if (isset($_POST['ID'])) {
		if (clean_variable($_POST['ID'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['ID'];
		}
	} 
	echo "<form method='post' action='ban-search.jsp'> 
  <input type=text name='ID' class='textfield' size='25' maxlenght='10' >
  <input name='Submit' type='Submit' value='GO' class='textfield'></form>";
?></td>
        </tr>
      </table>
      <?PHP
$data = 'banidos';
    SmartyPaginate::connect($data);
    SmartyPaginate::setLimit($config['rank_pp'],$data);
	SmartyPaginate::setPrevText("<<",$data);
	SmartyPaginate::setNextText(">>",$data);
	SmartyPaginate::setLastText('LAST', $data);
	SmartyPaginate::setFirstText('FIRST', $data);
	SmartyPaginate::setPageLimit($config['rank_page_limit'], $data);
	SmartyPaginate::setUrl("index.php?op=ban", $data);
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
 echo "<table align='center' class='ranklist' width='560'>
		
	<tr valign='top'>
              <td class='style2'><strong>#N.</strong></td>
              <td class='style2'><strong>#GAME ID</strong></td>
              <td class='style2'> <strong>#DATA</strong></td>
              <td class='style2'><strong>#MOTIVO</strong></td>
              <td class='style2'><strong>#DURAÇÃO</strong></td>
				</tr>
	";
	if (is_array($rs)) {
		foreach ($rs as $db => $r) {
		echo'<tr>
	   <td align="center">'.getgrade($r['TotalGrade']).'</td>
	   <td align="left"> '.$r['NickName'].'</td>
	     <td align="left"><em> '.$r['StartTime'].'</em></td>
	   <td align="left"> '.$r['Reason'].'</td>
	     <td align="right">'.number_format($r['Duration']).'</td>
	   </tr>';
		
		}
	}
		echo '</table>';
		echo '
	
	<table cellspacing="0" cellpadding="0" width="455" align="center">
                  <tr><td class="rank_pgnavi_t"></td></tr>
          		  <tr>
          			<td class="rank_pgnavi_m" align="center">
          				<table  align="center">
          					<tr valign="top">
                              <td align="center"> '. paginate_middle($data).'</td>
                          </tr>
                      </table>
       				</td>
   				  </tr>

          				<tr><td class="rank_pgnavi_b"></td></tr>
              </table>
	
	';

	?>


</center></div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>