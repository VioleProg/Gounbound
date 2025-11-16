<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_ranking.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>
				
<head>
<link href="template/www.johan.com.br/images/portal.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_content.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_main.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body onLoad="MM_preloadImages('template/www.johan.com.br/images/optionr_r1_c2.jpg','template/www.johan.com.br/images/optionr_r1_c04.jpg','template/www.johan.com.br/images/optionr_r1_c06.jpg')">
 <?PHP if ($config['admin_login'] == 'ok') {
					?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  </tr>
</table>
<table width="706" border="0">
  <tr>
    <td width="584" align="center"><p><img src="template/www.johan.com.br/images/pranking.jpg" width="581" height="15" /><br />
            <br />
            <br />
    </p>
        <div>
          <table width="467" border="0" class="ranksch">
            <tr>
              <td width="112" height="35" align="right" valign="middle" class="ad"><strong>Busca r&aacute;pida: </strong></td>
              <td width="345"><?PHP
							  if (isset($_POST) && valid_account($_POST['Id']) == true) 			
$where = '';
	if (isset($_POST['name'])) {
		if (clean_variable($_POST['name'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['name'];
		}
	} 
	echo "<form method='post' action='ranking-search.html'> 
  <input type=text name='name' class='textfield' size='35' maxlenght='10' >
  <input name='Submit' type='Submit' value='Buscar' class='textfield'></form>";
?></td>
            </tr>
          </table>
        </div>
      <p></p>
      <table border="0" cellpadding="0" cellspacing="0" width="581">
        <!-- fwtable fwsrc="rankingcont.png" fwbase="optionr.jpg" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
        <tr>
          <td><img src="images/spacer.gif" width="55" height="1" border="0" alt="" /></td>
          <td><img src="images/spacer.gif" width="135" height="1" border="0" alt="" /></td>
          <td><img src="images/spacer.gif" width="11" height="1" border="0" alt="" /></td>
          <td><img src="images/spacer.gif" width="136" height="1" border="0" alt="" /></td>
          <td><img src="images/spacer.gif" width="16" height="1" border="0" alt="" /></td>
          <td><img src="images/spacer.gif" width="144" height="1" border="0" alt="" /></td>
          <td><img src="images/spacer.gif" width="84" height="1" border="0" alt="" /></td>
          <td><img src="images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
        </tr>
        <tr>
          <td><img src="template/www.johan.com.br/images/optionr_r1_c1.jpg" alt="" name="optionr_r1_c1" width="55" height="37" border="0" id="optionr_r1_c1" /></td>
          <td><a href="ranking.html"></a><a href="ranking.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Player Ranking','','template/www.johan.com.br/images/optionr_r1_c2.jpg',1)"><img src="template/www.johan.com.br/images/optionr_r1_c02.jpg" alt="Player Ranking" name="Player Ranking" border="0" id="Player Ranking" /></a></td>
          <td><img src="template/www.johan.com.br/images/optionr_r1_c3.jpg" alt="" name="optionr_r1_c3" width="11" height="37" border="0" id="optionr_r1_c3" /></td>
          <td><a href="sranking.html"></a><a href="rsemanal.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('RSemanal','','template/www.johan.com.br/images/optionr_r1_c04.jpg',1)"><img src="template/www.johan.com.br/images/optionr_r1_c4.jpg" alt="Ranking Semanal" name="RSemanal" border="0" id="RSemanal" /></a></td>
          <td><img src="template/www.johan.com.br/images/optionr_r1_c5.jpg" alt="" name="optionr_r1_c5" width="16" height="37" border="0" id="optionr_r1_c5" /></td>
          <td><a href="cranking.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('CRanking','','template/www.johan.com.br/images/optionr_r1_c06.jpg',1)"><img src="template/www.johan.com.br/images/optionr_r1_c6.jpg" alt="Ranking entre Paises" name="CRanking" border="0" id="CRanking" /></a><a href="cranking.html"></a></td>
          <td><img src="template/www.johan.com.br/images/optionr_r1_c7.jpg" alt="" name="optionr_r1_c7" width="84" height="37" border="0" id="optionr_r1_c7" /></td>
          <td><img src="images/spacer.gif" width="1" height="37" border="0" alt="" /></td>
        </tr>
      </table>
      <table width="575" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#F9F9F9">
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF"> <?PHP
$data = $_GET['url'] == '' ? 'aranking' : $_GET['url'];
   SmartyPaginate::connect($data);
    SmartyPaginate::setLimit($config['rank_pp'],$data);
	SmartyPaginate::setPrevText("<<",$data);
	SmartyPaginate::setNextText(">>",$data);
	SmartyPaginate::setLastText('Proxima', $data);
	SmartyPaginate::setFirstText('Anterior', $data);
	SmartyPaginate::setPageLimit($config['rank_page_limit'], $data);
	SmartyPaginate::setUrl("index.php?op=aranking", $data);
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
	if (isset($_POST['aranking'])) {
		if (clean_variable($_POST['aranking'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['aranking'];
		}
	} 
	 
	echo ' ';

} else {
	
	if (clean_variable($_GET['url'],1)==true) {
	  echo notice('Id nao encontrado','Error!!!');
	  header('Refresh: 2; url=aranking.html');
	} else {
		$rs = get_db_results($data,$_GET['url']);
		
		
		
		
		$result = $db->Execute('Select *, game.NickName as Nick, playlog.S0_ID from game, playlog where game.Id=playlog.S0_ID and playlog.S0_ID = ? order by playlog.StartTime ',array($_GET['url']));
		if ($result->RecordCount() > 0) {
					 echo "<table cellspacing='0' cellpadding='0' align='center' class='ranklist'>
		
	<tr valign='top'>
              <th align='center'>Login  </th>
              <th>Sala</th>
			  <th>Titulo</th>
              <th>Inicio</th>
			  <th> </th>
              <th> Gp</th>
			   <th>  </th>
			     <th>Gold</th>
				</tr>";
			foreach ($result->GetArray() as $rs => $r) {
			
					echo'<tr class="list02">
	      <td class="rank" align="center"><strong>'.$r['S0_ID'].' </strong></td>
		  <td class="num" align="left">'.$r['GameRoomID'].'</td>
	   <td class="num" align="left">'.$r['GameRoomTitle'].'</td>
	  
	  <td nowrap="nowrap" class="num" style="text-align:center;">'.$r['StartTime'].'</td>
	<td nowrap="nowrap" class="num" style="text-align:center;"> </td>
	   	  <td class="num" style="text-align:center;">'.number_format($r['S0_ScoreDelta']).'</td>
		  <td nowrap="nowrap" class="num" style="text-align:center;"> </td>
		   <td class="num" style="text-align:center;">'.number_format($r['S0_MoneyDelta']).'</td>

	   
	   </tr>';
			
			}
				echo '</table>';
			
			
		} else {
		echo notice('Id não encontrado','Error!!!');
		header('Refresh: 2; url=aranking.html');
		}
	
	
	}



}
	?></td>
          </tr>
      </table></td>
    <td width="1"></td>
    <td><br />
        <br />
        <br />
        <br />
    </td>
    <td width="23">&nbsp;</td>
  </tr>
</table>
<?PHP } ?></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>