<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_ranking.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>
				

<head>
<link href="css/gunbound.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_content.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.opcoesrank {
	color: #993300;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
-->
</style>
</head>

<table border="0" cellpadding="0" cellspacing="0" width="586" align="top">

  <tr>
    <td background="template/syslink/images/modules_r2_c1.gif">
      <table width="574" border="0" align="top" class="ranksch">
        <tr>
          <td width="568"><table width="97%" border="0">
            <tr>
              <td width="47%" align="center"><span class="opcoesrank"><a href="ranking.sys"><span class="opcoesrank">RANKING <strong>TOTAL</strong></span></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; <a href="cranking.sys"><span class="opcoesrank"> RANKING<strong> DE PAISES </strong></span></a></span></td>
              <td width="53%" align="right"><?PHP
							  if (isset($_POST) && valid_account($_POST['Id']) == true) 			
$where = '';
	if (isset($_POST['name'])) {
		if (clean_variable($_POST['name'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['name'];
		}
	} 
	echo "<form method='post' action='rankings-search.sys'> 
  <input type=text name='name' class='textfield' size='25' maxlenght='10' >
  <input name='Submit' type='Submit' value='GO' class='textfield'></form>";
?></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <map name="support" id="support">
        <area shape="rect" coords="135,2,204,58" href="seguranca.sys" />
        <area shape="rect" coords="68,2,134,58" href="suporte.sys" />
      </map>
      <?PHP
$data = $_GET['url'] == '' ? 'granking' : $_GET['url'];
   SmartyPaginate::connect($data);
    SmartyPaginate::setLimit($config['rank_pp'],$data);
	SmartyPaginate::setPrevText("<<",$data);
	SmartyPaginate::setNextText(">>",$data);
	SmartyPaginate::setLastText('Proxima', $data);
	SmartyPaginate::setFirstText('Anterior', $data);
	SmartyPaginate::setPageLimit($config['rank_page_limit'], $data);
	SmartyPaginate::setUrl("index.php?op=granking", $data);
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
	
	
if (!isset($_GET['url'])) {
 

   
	//print_r(get_db_results($data));
	
	$where = '';
	if (isset($_POST['guild'])) {
		if (clean_variable($_POST['guild'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['guild'];
		}
	} 
	 
	echo '';

} else {
	
	if (clean_variable($_GET['url'],1)==true) {
	  echo notice('N&atilde;o encontrado','Error!!!');
	  header('Refresh: 2; url=granking.sys');
	} else {
		$rs = get_db_results($data,$_GET['url']);
		
		
		
		
		$result = $db->Execute('Select *, game.NickName as Nick, user.NickName from game, user where game.Id=user.Id and game.CountryGrade = ? order by game.TotalRank ',array($_GET['url']));
		if ($result->RecordCount() > 0) {
					 echo "<table cellspacing='0' cellpadding='0' align='center' class='ranklist'>
		
	<tr valign='top'>
              <img src='images/trranking.jpg' width='573' height='28' />
				</tr>";
			foreach ($result->GetArray() as $rs => $r) {
			
					echo'<tr class="list02">
	      <td class="rank" align="right"><strong>'.$r['TotalRank'].'</strong></td>
	  <td class="num" align="left">'.getgrade($r['CountryGrade']).'</td>
	  <td nowrap="nowrap" class="num" style="text-align:left;" width="21">&nbsp;</td>
	  <td nowrap="nowrap" class="num" style="text-align:left;" width="83">'.$r['NickName'].'</td>
	   	  <td class="num" width="53">'.($r['Status'] != 1 ? '<img src="images/online.gif">' : '<img src="images/offline.gif">').'</td>
	   	  <td class="num" width="118">'.number_format($r['TotalScore']).' GP</td>
		  <td class="flag" align="center"> </td>
		 <td class="num" style="text-align:center;"><font color="#333333">'.
	    ($r['Guild'] != '' ? ' '.$r['Guild'].' ['.$r['GuildRank'].'/'.$r['MemberCount'].'] ' : '   ').'</font> </td>
	   <td class="ranksame" align="center"> <a href="cranking-'.$r['Country'].'.jsp"><img src="ranks/pais/24/'.getcountry($r['Country']).'.png" width="20" height="20" alt="'.getcountry($r['Country']).'" title="'.$r['NickName'].' &eacute; o '.$r['CountryRank'].'&ordm; do ranking no país '.getcountry($r['Country']).'"></a></td>
	   </tr>';
			
			}
				echo '</table>';
			
			
		} else {
		echo notice('Nivel n&atilde;o existente','Error!!!');
		header('Refresh: 2; url=granking.sys');
		}
	
	
	}



}
	?></td>
    <td><img src="images/spacer.gif" width="1" height="262" border="0" alt="" /></td>
  </tr>
</table>
</center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>