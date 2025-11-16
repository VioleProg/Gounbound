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
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="586">
  <tr>
    <td align="center" valign="top">                            <?PHP
                              if ($config['admin_login'] == 'ok') {
							  if (isset($_POST) && valid_account($_POST['Id']) == true) 			
$where = '';
	if (isset($_POST['name'])) {
		if (clean_variable($_POST['name'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['name'];
		}
	} 
	
	echo "<form method='post' action='editacc-search.jsp'> 
  <input type=text name='name' class='buttons' size=30 maxlenght=10 />
  <input type=submit class='buttons' name=submit value='Buscar usuario'>
  </form><br> <br>";
 }
?><br />
<br />
<?PHP
								  		if ($config['admin_login'] == 'ok') {
$data = 'crankings';
    SmartyPaginate::connect($data);
    SmartyPaginate::setLimit($config['rank_pp'],$data);
	SmartyPaginate::setPrevText("<<",$data);
	SmartyPaginate::setNextText(">>",$data);
	SmartyPaginate::setLastText('Proxima', $data);
	SmartyPaginate::setFirstText('Anterior', $data);
	SmartyPaginate::setPageLimit($config['rank_page_limit'], $data);
	SmartyPaginate::setUrl("index.php?op=editacc", $data);
	//SmartyPaginate::setUrl("editacc.jsp", $data);

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
	 echo "<table border=\"0\" width=\"100%\">
	<tr>
    <td align='center' class='bgrthead'><b>Rank</b></td>
    <td align='center' class='bgrthead'><b>Nivel</b></td>
    <td align='center' class='bgrthead'><b>Nick</b></td>
    <td align='center' class='bgrthead'><b>Cl&atilde;</b></td>
	<td align='center' class='bgrthead'><b>Pais</b></td>
    <td align='center' class='bgrthead'><b>GP</b></td>
	</tr>";
	if (is_array($rs)) {
		foreach ($rs as $db => $r) {
		echo'<tr>
	   <td align="center" class="normal">'.$r['TotalRank'].'</td>
	   <td align="center" class="normal"> '.
	   getgrade($r['TotalGrade'])
	   .'</td>
	   <td align="center" class="normal"> <b><a href="edit-'.$r['NickName'].'.jsp"> <span class='.getauth($r['Authority']).'>'.$r['Id'].'</span></a></b></td>
	   	   <td align="center" class="normal">'.
	    ($r['Guild'] != '' ? '<a href="guilds-'.$r['Guild'].'.jsp">'.$r['Guild'].'</a>' : '--').' '  .$r[ 'GuildRank'].'/'.$r[ 'MemberCount'].'</td>
		<td align="center">'.
	   getcountry($r['Country'])
	   .'</td>
	   <td align="center" width="17%">'.number_format($r['TotalScore']).'</td>
	   </tr>';
		
		}
	}
	echo '</table>';
		echo '
  '. paginate_middle($data).'';
	
 $l = '<ul>';
	foreach (getauth('get') as $a => $a1) {
		$l .= "<li class=$a1> ".ucfirst($a1)."</li>";
	}
}
	?>


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