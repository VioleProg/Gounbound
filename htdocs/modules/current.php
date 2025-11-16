<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_ranking.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>
				<table height="100%" cellspacing="0" cellpadding="0" width="549" 
              border="0">
              <tr>

                <td valign="top" 
                background="template/<?=$config['template'];?>/images/index(main)_01.gif">
                  <table width="509" border="0" align="center" cellpadding="0" cellspacing="0">
                    
                    <tr>
                      <td colspan="4"><img height="33" 
                        src="template/<?=$config['template'];?>/images/rankings.gif" 
                        width="509"></td>
                    </tr>
                    <tr>
                      <td width="21"></td>
                      <td width="465" align="center" background="template/<?=$config['template'];?>/images/bgreg.jpg"  bgcolor="#FFFFFF">
                        <table cellspacing="0" cellpadding="0" width="434" border="0">
                          
                          <tr>

                            <td colspan="2" height="10"></td></tr>
                          <tr>
                            <td width="13" valign="top"></td>
                            <td width="460" align="center" valign="top">
                              <div align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="450">
                                  <tr>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="19" height="1" border="0" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="13" height="1" border="0" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="93" height="1" border="0" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="14" height="1" border="0" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="155" height="1" border="0" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="9" height="1" border="0" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="129" height="1" border="0" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="18" height="1" border="0" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
                                  </tr>
                                  <tr>
                                    <td rowspan="5"><img name="tabelaranking_r1_c1" src="template/<?=$config['template'];?>/images/tabela ranking_r1_c1.jpg" width="19" height="75" border="0" id="tabelaranking_r1_c1" alt="" /></td>
                                    <td colspan="6"><img name="tabelaranking_r1_c2" src="template/<?=$config['template'];?>/images/tabela ranking_r1_c2.jpg" width="413" height="6" border="0" id="tabelaranking_r1_c2" alt="" /></td>
                                    <td rowspan="5"><img name="tabelaranking_r1_c8" src="template/<?=$config['template'];?>/images/tabela ranking_r1_c8.jpg" width="18" height="75" border="0" id="tabelaranking_r1_c8" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="1" height="6" border="0" alt="" /></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6" background="template/<?=$config['template'];?>/images/tabela ranking_r2_c2.jpg"><?PHP
							  if (isset($_POST) && valid_account($_POST['Id']) == true) 			
$where = '';
	if (isset($_POST['name'])) {
		if (clean_variable($_POST['name'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['name'];
		}
	} 
	echo "<form method='post' action='ranking-search.jsp'> 
  <input type=text name='name' class='textfield' size='50' maxlenght='10' >
  <input name='Submit' type='image' src='template/www.johan.com.br/images/bt_ok.gif'></form>";
?></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="1" height="21" border="0" alt="" /></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><img name="tabelaranking_r3_c2" src="template/<?=$config['template'];?>/images/tabela ranking_r3_c2.jpg" width="413" height="5" border="0" id="tabelaranking_r3_c2" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="1" height="5" border="0" alt="" /></td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2"><img name="tabelaranking_r4_c2" src="template/<?=$config['template'];?>/images/tabela ranking_r4_c2.jpg" width="13" height="43" border="0" id="tabelaranking_r4_c2" alt="" /></td>
                                    <td><a href="rank-player.jsp"><img name="tabelaranking_r4_c3" src="template/<?=$config['template'];?>/images/tabela ranking_r4_c3.jpg" width="93" height="32" border="0" id="tabelaranking_r4_c3" alt="" /></a></td>
                                    <td><img name="tabelaranking_r4_c4" src="template/<?=$config['template'];?>/images/tabela ranking_r4_c4.jpg" width="14" height="32" border="0" id="tabelaranking_r4_c4" alt="" /></td>
                                    <td><a href="semanal.jsp"><img name="tabelaranking_r4_c5" src="template/<?=$config['template'];?>/images/tabela ranking_r4_c5.jpg" width="155" height="32" border="0" id="tabelaranking_r4_c5" alt="" /></a></td>
                                    <td><img name="tabelaranking_r4_c6" src="template/<?=$config['template'];?>/images/tabela ranking_r4_c6.jpg" width="9" height="32" border="0" id="tabelaranking_r4_c6" alt="" /></td>
                                    <td><a href="rankpais.jsp"><img name="tabelaranking_r4_c7" src="template/<?=$config['template'];?>/images/tabela ranking_r4_c7.jpg" width="129" height="32" border="0" id="tabelaranking_r4_c7" alt="" /></a></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
                                  </tr>
                                  <tr>
                                    <td colspan="5"><img name="tabelaranking_r5_c3" src="template/<?=$config['template'];?>/images/tabela ranking_r5_c3.jpg" width="400" height="11" border="0" id="tabelaranking_r5_c3" alt="" /></td>
                                    <td><img src="template/<?=$config['template'];?>/images/spacer.gif" width="1" height="11" border="0" alt="" /></td>
                                  </tr>
                                </table>
                                <br />
                                <br />
                                <div align="center">
                                  <?PHP
$data = 'current';
    SmartyPaginate::connect($data);
    SmartyPaginate::setLimit($config['rank_pp'],$data);
	SmartyPaginate::setPrevText("<<",$data);
	SmartyPaginate::setNextText(">>",$data);
	SmartyPaginate::setLastText('LAST', $data);
	SmartyPaginate::setFirstText('FIRST', $data);
	SmartyPaginate::setPageLimit($config['rank_page_limit'], $data);
	SmartyPaginate::setUrl("index.php?op=current", $data);
	//SmartyPaginate::setUrl("current.jsp", $data);

     
	     function get_db_results($data,$where='',$order='') {
		 global $db, $config;
		$where = $where == '' ? 'currentuser .Id = game.Id' : "currentuser .Id = currentuser .Id and game.Id like '%$where%'";
        $result = $db->Execute("SELECT SQL_CALC_FOUND_ROWS *, currentuser .Id, game.Id FROM currentuser , game where $where order by currentuser.LoggingTime DESC LIMIT ?,?",
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
    <td align='center' class='top2'><b>NickName</b></td>
	<td align='center' class='top2'><b>Servidor</b></td>
    <td align='center' class='top2'><b>Data</b></td>
	</tr>";
	if (is_array($rs)) {
		foreach ($rs as $db => $r) {
		echo'<tr>
	   <td align="center" class="top2"><a href="rankgrade.jsp">'.getminirank($r['TotalGrade']).'</a> </td>
	   <td align="center" class="top2"> '.$r['NickName'].'</td>
	   <td align="center" class="top2"> '.ucfirst($r['ServerPort'] != 8360 ? 'Avatar OFF' : 'Avatar OFF').'</td>
	   <td align="center" class="top2">'.$r['LoggingTime'].'</td>
	   </tr>';
	   
	   
		
		}
	}
		echo '</table>';

	?>
                                </div>
                            </div></td>
                        </tr></table></td>
                      <td width="1" bgcolor="#d8d8d8"></td>
                      <td width="23"></td></tr>
                    <tr>
                  <td colspan="4"><img height="27" 
                        src="template/<?=$config['template'];?>/images/rankings2.gif" 
                        width="509"></td>
                    </tr></table></td></tr></table></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>