
<head>
<link href="css/gunbound.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_content.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a {
	color: #0099CC;
	text-decoration: none;
}

a:hover {
	color: #00CCFF;
}

a img {
  border: none;/*remove border for linked images*/
}

.linkforumred a:link
{ 
	color: #FF0000; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size: 10px;
	font-weight: bold;
}

.linkforumred a:visited
{ 
	color: #FF0000; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}

.linkforumred a:active
{ 
	color: #FF0000; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

.linkforumred a:hover
{ 
	color: #FF0000; 
	text-decoration: underline; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

/* AZUL */

.linkforumblue a:link
{ 
	color: #0033CC; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size: 10px;
	font-weight: bold;
}

.linkforumblue a:visited
{ 
	color: #0033CC; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}

.linkforumblue a:active
{ 
	color: #0033CC; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

.linkforumblue a:hover
{ 
	color: #0033CC; 
	text-decoration: underline; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

/* normal */

.linkforumnormal a:link
{ 
	color: #333333; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size: 10px;

}

.linkforumnormal a:visited
{ 
	color: #333333; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;

}

.linkforumnormal a:active
{ 
	color: #333333; 
	text-decoration: none; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

.linkforumnormal a:hover
{ 
	color: #333333; 
	text-decoration: underline; 
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>

</head>
<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_forum.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center><table border="0" cellpadding="0" cellspacing="0" width="100%">

  <tr>
    <td align="center" background="template/gbetools/images/modules_r2_c1.gif"><p><?PHP 
if (@$config['user_login'] == 'ok') {
		

	?>
    </p>
      <table width="100%" border="0" class="ranksch">
        <tr >
          <td width="24" align="top" >
			<img src="images/user.gif" width="24" height="24" align="top" /></td>
          <td width="243" align="right" >
			<p align="left"><font face="Arial">
			<a href="change-perfil.jsp" style="text-decoration: none">
			<font size="2" color="#000000">Editar perfil (f&oacute;rum)</font></a><font size="2">
			</font></font></p> </td>
          <td width="30" align="right" >
			<img src="images/stats.gif" width="24" height="24" align="top" /></td>
          <td width="355" align="right" >
			<p align="left">
			<a href="topicomsg-<?=$user['NickName']?>.jsp" style="text-decoration: none">
			<font color="#000000" face="Arial" size="2">Ver minhas mensagens 
			</font> </a></p></td>
			<?PHP 
if (@$config['admin_login'] == 'ok') {
		

	?>          <td width="567" align="right" ><a href="gbe_noticias_new-topico.jsp"><img src="images/novotopico.gif" width="112" height="24" border="0" /></a></td>      <?PHP 
} elseif (@$config['user_login'] == 'ok') { echo '<td width="707" align="right" ></td>';
}
	?>
        </tr>
      </table>
      <?PHP 
}
		

	?>
      <table border="0" cellpadding="0" cellspacing="0" width="39%">
        <!-- fwtable fwsrc="topbtforum.png" fwbase="topbtforum.jpg" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
        <tr>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="21"><img src="template/gbetools/images/topbtforum_r1_c1.jpg" alt="" name="topbtforum_r1_c1"  width="21" height="37" border="0" id="topbtforum_r1_c1" /></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="26"><a href="forum.jsp"  onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forumlivre','','template/gbetools/images/topbtforum_r1_c2.jpg',1)"><img src="template/gbetools/images/topbtforum_r1_c02.jpg" alt="F&oacute;rum Livre" name="forumlivre" border="0" id="forumlivre" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="26"><a href="forum1.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forumscreenshot','','template/gbetools/images/topbtforum_r1_c4.jpg',1)"><img src="template/gbetools/images/topbtforum_r1_c4.jpg" alt="F&oacute;rum ScreenShot" name="forumscreenshot" border="0" id="forumscreenshot" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="26"><a href="forum2.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forumdenuncias','','template/gbetools/images/topbtforum_r1_c06.jpg',1)"><img src="template/gbetools/images/topbtforum_r1_c6.jpg" alt="F&oacute;rum denuncias" name="forumdenuncias" border="0" id="forumdenuncias" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="26"><a href="forum3.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forumeventos','','template/gbetools/images/topbtforum_r1_c08.jpg',1)"><img src="template/gbetools/images/topbtforum_r1_c8.jpg" alt="F&oacute;rum denuncias" name="forumeventos" border="0" id="forumeventos" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="26"><a href="forum4.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forumnoticias','','template/gbetools/images/topbtforum_r1_c10.jpg',1)"><img src="template/gbetools/images/topbtforum_r1_c10.jpg" alt="F&oacute;rum denuncias" name="forumnoticias" border="0" id="forumnoticias" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="69%"><img src="template/gbetools/images/topbtforum_r1_c7.jpg" alt="" name="topbtforum_r1_c7" width="21" height="37" border="0" id="topbtforum_r1_c7" /></td>
         </tr>
      <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#f5f5e6;border:2px solid #ddddb4;">
        <tr>
          <td width="49"><!--img src="css/images/forum/box_tab_left.gif" alt="" name="topbtforum_r1_c1"  width="6" height="30" border="0" id="topbtforum_r1_c1" /--></td>
          <!--td background="css/images/forum/box_tab.gif" width="133"-->
          <td width="110"><b>
			<font color="#67673e">Titulo</font></b></td>
          <td width="119"><b>
			<font color="#67673e">Respostas</font></b></td>
          <td width="98"><b>
			<font color="#67673e">Autor</font></b></td>
          <td width="118"><b>
			<font color="#67673e">Postado em:</font></b></td>
          <td><b>
			<font color="#67673e">Última resposta em:</font></b></td>
          <td width="1%"></td>
        </tr>		

</table>



<?PHP
$data = 'forum-player';
    SmartyPaginate::connect($data);
    SmartyPaginate::setLimit($config['forum_pp'],$data);
	SmartyPaginate::setPrevText("<<",$data);
	SmartyPaginate::setNextText(">>",$data);
	SmartyPaginate::setLastText('Proxima', $data);
	SmartyPaginate::setFirstText('Anterior', $data);
	SmartyPaginate::setPageLimit($config['forum_page_limit'], $data);
	SmartyPaginate::setUrl("index.php?op=forum3", $data);
	//SmartyPaginate::setUrl("rank-player.asp", $data);

		  function get_db_results($data,$where='',$order='') {
     global $db, $config;
		$where = $where == '' ? 'gbe_noticias.NickName = gbe_noticias.NickName' : "gbe_noticias.Id = gbe_noticias.Id and gbe_noticias.Id like '%$where%'";
        $result = $db->Execute("SELECT SQL_CALC_FOUND_ROWS *, gbe_noticias.Id, gbe_noticias.Id FROM gbe_noticias where $where order by gbe_noticias.Date DESC LIMIT ?,?",
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
	 echo '<table border="0" cellpadding="0" cellspacing="0" width="100%" border="0" id="table1" style="background:#f5f5e6;border:1px solid #ddddb4;border-top:1px solid #ddddb4;">
';
	if (is_array($rs)) {
			foreach ($rs as $db => $r) {
		echo'
<tr>
<font color="#67673e">
<td width="45" align="right"><span class="row2"><img src="images/newtopics.gif" width="22" height="21" /></span></td>
<td width="207" align="left" class="'.$r['class'].'">&nbsp;&nbsp;&nbsp;<a href="gbe_noticias-comments-'.$r['Id'].'.jsp">'.$r['Title'].'</a></td>
<td width="145" align="left">&nbsp;'.$r['Comments'].'</td>
<td width="150" align="left">'.getminirank($r['CountryGrade']).' <a href="perfil-'.$r['NickName'].'.jsp">'.$r['NickName'].'</td>
<td width="196" align="left">'.$r['Date'].'</td>';
if ($r['lastpost'] == '0000-00-00 00:00:00') {
echo '<td width="344" align="left">Nenhuma Resposta</td>';
} else { 
echo '<td width="344" align="left">'.$r['lastpost'].'</td>';
}echo '<td align="left">&nbsp;</td>
</font>
</tr>
';
		
		}
	}
		echo '
</table><br>';
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
	

	
	echo '';

	?><br><table border="0" width="32%" id="oqueeh" border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#f5f5e6;border:2px solid #ddddb4;">
	<tr>
<td>

<p align="center">

<span style="background-color: #333333">&nbsp;&nbsp; &nbsp;</span>Todos&nbsp;&nbsp;&nbsp;
<span style="background-color: #FF0000">&nbsp;&nbsp; &nbsp;</span>Guild&nbsp;&nbsp;&nbsp;
<span style="background-color: #0033CC">&nbsp;&nbsp;&nbsp; </span>Fixo&nbsp;&nbsp;&nbsp;
<span style="background-color: #FF6600">&nbsp;&nbsp;&nbsp; </span>Anúncio

		</td>
	</tr>
</table></table></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>