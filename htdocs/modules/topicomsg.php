
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
			<div id="content_full_content"><center>
				<table border="0" cellpadding="0" cellspacing="0" width="100%">

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
          <td width="567" align="right" ><a href="forumlivre_new-topico.jsp"><img src="template/gbetools/images/novotopico.gif" width="112" height="24" border="0" /></a></td>
        </tr>
      </table>
      <?PHP 
}
		

	?>
      <table border="0" cellpadding="0" cellspacing="0" width="39%">
        <!-- fwtable fwsrc="topbtforum.png" fwbase="topbtforum.jpg" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
                <tr>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="21"><img src="template/gbetools/images/topbtforum_r1_c1.jpg" alt="" name="topbtforum_r1_c1"  width="21" height="37" border="0" id="topbtforum_r1_c1" /></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="26"><a href="forum.jsp"  onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forumlivre','','template/gbetools/images/topbtforum_r1_c2.jpg',1)"><img src="template/gbetools/images/topbtforum_r1_c2.jpg" alt="F&oacute;rum Livre" name="forumlivre" border="0" id="forumlivre" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="26"><a href="forum1.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forumscreenshot','','template/gbetools/images/topbtforum_r1_c04.jpg',1)"><img src="template/gbetools/images/topbtforum_r1_c4.jpg" alt="F&oacute;rum ScreenShot" name="forumscreenshot" border="0" id="forumscreenshot" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="26"><a href="forum2.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forumdenuncias','','template/gbetools/images/topbtforum_r1_c06.jpg',1)"><img src="template/gbetools/images/topbtforum_r1_c6.jpg" alt="F&oacute;rum denuncias" name="forumdenuncias" border="0" id="forumdenuncias" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="26"><a href="forum3.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forumeventos','','template/gbetools/images/topbtforum_r1_c08.jpg',1)"><img src="template/gbetools/images/topbtforum_r1_c8.jpg" alt="F&oacute;rum denuncias" name="forumeventos" border="0" id="forumeventos" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="26"><a href="forum4.jsp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forumnoticias','','template/gbetools/images/topbtforum_r1_c10.jpg',1)"><img src="template/gbetools/images/topbtforum_r1_c9.jpg" alt="F&oacute;rum denuncias" name="forumnoticias" border="0" id="forumnoticias" /></a></td>
          <td background="template/gbetools/images/topbtforum_r1_c3.jpg" width="69%"><img src="template/gbetools/images/topbtforum_r1_c7.jpg" alt="" name="topbtforum_r1_c7" width="21" height="37" border="0" id="topbtforum_r1_c7" /></td>
         </tr>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#f5f5e6;border:2px solid #ddddb4;">
        <tr>
          <td width="49"><!--img src="css/images/forum/box_tab_left.gif" alt="" name="topbtforum_r1_c1"  width="6" height="30" border="0" id="topbtforum_r1_c1" /--></td>
          <!--td background="css/images/forum/box_tab.gif" width="133"-->
          <td width="130"><b>
			<font color="#67673e">Titulo</font></b></td>
          <td width="171"><font color="#67673E"><b>Respondido em</b></font></td>
          <td width="75"><b>
			<font color="#67673e">Autor</font></b></td>
          <td width="168"><b>
			<font color="#67673e">Postado em:</font></b></td>
          <td>&nbsp;</td>
          <td width="8%"></td>
        </tr>		

</table>
<?PHP
$data = $_GET['url'] == '' ? 'topicmsg' : $_GET['url'];
   SmartyPaginate::connect($data);
    SmartyPaginate::setLimit($config['rank_pp'],$data);
	SmartyPaginate::setPrevText("<<",$data);
	SmartyPaginate::setNextText(">>",$data);
	SmartyPaginate::setLastText('Proxima', $data);
	SmartyPaginate::setFirstText('Anterior', $data);
	SmartyPaginate::setPageLimit($config['rank_page_limit'], $data);
	SmartyPaginate::setUrl("index.php?op=topicmsg", $data);
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
	if (isset($_POST['topicmsg'])) {
		if (clean_variable($_POST['topicmsg'],1) == true) {
		echo notice('Variable Error Found... Try Again :p','Error');
		} else {
		$where = $_POST['topicmsg'];
		}
	} 
	 
	echo ' ';

} else {
	
	if (clean_variable($_GET['url'],1)==true) {
	  echo notice('Você não possui posts','Error!!!');
	  header('Refresh: 2; url=forum.sys');
	} else {
		$rs = get_db_results($data,$_GET['url']);
		
		
		
	$result = $db->Execute('Select *, forumlivre2.NickName as Nick, forumlivre2.Id from forumlivre2 where forumlivre2.Id=forumlivre2.Id and forumlivre2.NickName = ? order by Id',array($_GET['url']));

		if ($result->RecordCount() > 0) {
					 echo '<table border="0" cellpadding="0" cellspacing="0" width="100%" border="0" id="table1" style="background:#f5f5e6;border:1px solid #ddddb4;border-top:1px solid #ddddb4;">
';
			foreach ($result->GetArray() as $rs => $r) {
			
					echo'<tr>
<font color="#67673e">
<td width="45" align="right"><span class="row2"><img src="images/newtopics.gif" width="22" height="21" /></span></td>
<td width="153" align="left">&nbsp;&nbsp;&nbsp;<a href="forumlivre-comments-'.$r['Id'].'.sys#comments">'.$r['Title'].'</a></td>
<td width="215" align="left">'.$r['Date'].'</td>
<td width="87" align="left">'.$r['Author'].'</td>';
if ($config['admin_login'] == 'ok') {
echo '<td width="196" align="left">&nbsp;<font color="#67673e">'.$r['IP'].'</font></td>'; 
} else {
echo '<td width="196" align="left">&nbsp;<font color="#67673e">&nbsp;</font></td>'; 
}
echo '
<td width="344" align="left">&nbsp;</td>
<td align="left">&nbsp;</td>
</font>
</tr>';
			
			}
		echo '</table><br>';
		echo '<table cellspacing="0" cellpadding="0" width="455" align="center">
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
              </table>	';
		} else {
		echo notice('Você não possui posts','Error!!!');
		header('Refresh: 2; url=forum.sys');
		}
	
	
	}



}
	?></table></td>
        </tr>
      </table><br>
	<table border="0" width="32%" id="oqueeh" border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#f5f5e6;border:2px solid #ddddb4;">
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