<head>
<link href="css/gunbound.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_content.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_main.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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
          <td width="567" align="right" >&nbsp;</td>
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
<?PHP

// /*

$db->Execute("CREATE TABLE IF NOT EXISTS `forumlivre` (
`Id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`Title` VARCHAR( 45 ) NOT NULL ,
`Text` TEXT NOT NULL ,
`Text2` TEXT NOT NULL ,
`Date` DATETIME NOT NULL ,
`Author` VARCHAR( 15 ) NOT NULL ,
`Comments` INT( 4 ) NOT NULL DEFAULT '0'
) ");

$db->Execute("CREATE TABLE IF NOT EXISTS `forumlivre2` (
`Id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`Msg_Id` INT NOT NULL ,
`IP` VARCHAR( 25 ) NOT NULL ,
`Author` VARCHAR( 15 ) NOT NULL ,
`Title` TEXT NOT NULL ,
`Comment` TEXT NOT NULL ,
`Date` DATETIME NOT NULL
) ");

$db->Execute("CREATE TABLE IF NOT EXISTS `game` (
  `NickName` varchar(16) NOT NULL ,
  `TotalGrade` smallint(6) NOT NULL ,
  `SeasonGrade` smallint(6) NOT NULL  ,
  `TotalRank` int(11) NOT NULL ,
  `SeasonRank` int(11) NOT NULL ,
  `CountryGrade` varchar(50) NOT NULL
  ) ");

// */

function news_template($r) {
		global $config;
		
		if ($config['Cut_Long_Post'] > 0) {
	
		$newT = stripslashes($r['Text2']);
		
		$newT = '<br><a href=\'#\' onclick="document.getElementById(\'the_text\').style.display =\'\';"> [Read More]</a><span id="test" style="display:none;"> hellow </span><div id="the_text" style="display:none;"><table><tr><td>'.$newT.'</td></tr></table></div>';
		
		$r['Text'] = stripslashes($r['Text']) . $newT;
		} else {
		
		$r['Text'] = stripslashes($r['Text']) . stripslashes($r['Text2']);;
		}
		$rd = '

		<table width="580" height="35" border="1" align="center" cellpadding="0" cellspacing="0" background="#EAEADB" class="borderwrap" nowrap="nowrap">
<tr>
  <td width="26" align="left" class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"><span class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"><img src="template/gbetools/images/newtopics.gif" width="22" height="21" /></span></td>
 <td width="15" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;" class="row2" align="left">&nbsp;</td>
 
    <td width="200" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;" class="row2" align="left"><a href="forumlivre-comments-'.$r['Id'].'.jsp#comments"> '.$r['Title'].'</a> </td>
		  <td width="60" align="center" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;" class="row2">&nbsp;<a href="forumlivre-comments-'.$r['Id'].'.jsp#comments">'.$r['Comments'].'</a></td>
          <td width="100" align="left" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;" class="row2">'.getminirank($r['CountryGrade']).' <a href="perfil-'.$r['NickName'].'.jsp">'.$r['NickName'].' </td>
		  <td width="150" align="center" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;" class="assinaturaforum">'.$r['Date'].'</td>
  </tr>
</table>';
		return $rd;
}


function comments_template($r) {
global $config;
 $rd = '<table width="494" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td ><img src="template/'.$config['template'].'/template/gbetools/images/comment_lin.gif" width="428" height="16"></td>
  </tr>
  
  <tr>
    <td width="66">&nbsp;</td>
    <td ><strong>'.$r['Title'].'</strong><br><strong><a href="info-'.$r['Author'].'.jsp">'.$r['Author'].'</a></strong> <small>@ '.$r['Date'].'</small></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td  style="background-color:#F4F4F4;">'.$r['Comment'].'</td>
  </tr>
  <tr>
    <td colspan="2" align="right">';
	if ($config['user_login'] == 'ok') {
	$rd .= 	"<form method='post' action='forumlivre_new-comments-".$r['Msg_Id']."-edit.jsp'>
							<input type='hidden' name='Id' value='".$r['Id']."' class='buttons' >
							<input type=submit class='buttons' name=submit value='Edit'>
							</form>
								<form method='post' action='forumlivre_new-comments-".$r['Msg_Id']."-delete.jsp'>
							<input type='hidden' name='Id' value='".$r['Id']."' class='buttons' >
							<input type=submit class='buttons' name=submit value='DEL'>
							</form>";
	
	} elseif ($GLOBALS['user_auth']->username == $r['Author']) {
	$rd .= 	"<form method='post' action='forumlivre_new-comments-".$r['Msg_Id']."-delete.jsp'>
							<input type='hidden' name='Id' value='".$r['Id']."' class='buttons' >
							<input type=submit class='buttons' name=submit value='Delete'>
							</form>";
	
	}
	$rd .= '</td>
  </tr>
</table><br>';
return $rd;
}
function comEditor($title,$data='') {
if ($data != '') {
global $db;
$result = $db->Execute("Select * from forumlivre2 where Id=?",array($data));
$rs = $result->GetArray();
$r = $rs[0];
}
			?>
  <script language="javascript" type="text/javascript" src="_inc/tiny_mce/tiny_mce.js"></script>
  <script language="javascript" type="text/javascript">
				tinyMCE.init({
					mode : "textareas",
					theme : "simple",
				//	plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
				//	theme_advanced_buttons1_add_before : "save,newdocument,separator",
				//	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
				//	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
				//	theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
				//	theme_advanced_buttons3_add_before : "tablecontrols,separator",
				//	theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
				//	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops",
				//	theme_advanced_toolbar_location : "top",
				//	theme_advanced_toolbar_align : "left",
				//	theme_advanced_path_location : "bottom",
				//	content_css : "example_full.css",
				    plugin_insertdate_dateFormat : "%Y-%m-%d",
				    plugin_insertdate_timeFormat : "%H:%M:%S",
				//	extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
					//external_link_list_url : "example_link_list.js",
				//	external_image_list_url : "example_image_list.js",
				//	flash_external_list_url : "example_flash_list.js",
				//	file_browser_callback : "fileBrowserCallBack",
					theme_advanced_resize_horizontal : false,
					theme_advanced_resizing : true
				});

				function fileBrowserCallBack(field_name, url, type, win) {
					// This is where you insert your custom filebrowser logic
					alert("Example of filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

					// Insert new URL, this would normaly be done in a popup
					win.document.forms[0].elements[field_name].value = "someurl.htm";
				}
			    </script>
      <!-- /TinyMCE -->
</div>
<table width=100%><tr><td width="66">&nbsp;</td><td>
						<? 
						if ($data =='') {
							echo '<form method="post" action="forumlivre_new-comments-'.$_GET['do'].'-new.jsp">';
							echo '<h3>Create New Comment</h3>'; 
							echo '<label>Title </label><input type="text"  name="title" value="RE: '.$title.'" size="40" maxlength="45">';
							} else {
							echo '<form method="post" action="forumlivre_new-comments-'.$_GET['do'].'-edit.jsp">';
							echo '<h3>Editing Comment</h3>';
							echo '<label>Title </label><input type="text" value="'.$r['Title'].'" name="title" size="30" maxlength="30">';
							echo '<input type="hidden" name="id" value="'.$r['Id'].'">';
							}									
							?>
						<textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 80%">
							<? echo $data=='' ?  '' : stripslashes($r['Text']); ?>
						</textarea>
						
						<br />
						<input type="submit" name="save" value="Submit" />
						<input type="reset" name="reset" value="Reset" />
				</form>
	</tr></table>
	<?PHP
}
function Editor($data='') {
if ($data != '') {
global $db;
$result = $db->Execute("Select * from forumlivre where Id=?",array($data));
$rs = $result->GetArray();
$r = $rs[0];
}
			?>
				<script language="javascript" type="text/javascript" src="_inc/tiny_mce/tiny_mce.js"></script>
				<script language="javascript" type="text/javascript">
				tinyMCE.init({
					mode : "textareas",
					theme : "simple",
					plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
					theme_advanced_buttons1_add_before : "save,newdocument,separator",
					theme_advanced_buttons1_add : "fontselect,fontsizeselect",
					theme_advanced_buttons3_add_before : "tablecontrols,separator",
					theme_advanced_buttons3_add : "emotions,flash",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_path_location : "bottom",
					content_css : "example_full.css",
				    plugin_insertdate_dateFormat : "%Y-%m-%d",
				    plugin_insertdate_timeFormat : "%H:%M:%S",
					extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
					external_link_list_url : "example_link_list.js",
					external_image_list_url : "example_image_list.js",
					flash_external_list_url : "example_flash_list.js",
					file_browser_callback : "fileBrowserCallBack",
					theme_advanced_resize_horizontal : false,
					theme_advanced_resizing : true
				});

				function fileBrowserCallBack(field_name, url, type, win) {
					// This is where you insert your custom filebrowser logic
					alert("Example of filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

					// Insert new URL, this would normaly be done in a popup
					win.document.forms[0].elements[field_name].value = "someurl.htm";
				}
			</script>
			<!-- /TinyMCE -->
		
						<? 
						if ($data =='') {
							echo '<form method="post" action="forumlivre_new-topico-new.jsp">';
							echo '<table width="662" border="0" align="center">
                              <tr>
                                <td align="center"><img src="template/gbetools/images/novotopico.jpg" width="662" height="60" /></td>
                              </tr>
                            </table>
                            <table width="659" border="0" align="center" bgcolor="#F7F7F7" class="list02">
                              <tr>
                                <td align="center" valign="middle"><strong class="newtopico">Titulo</strong></td>
                                <td width="571" bgcolor="#FFFFFF"><input type="text"  name="title" size="50" maxlength="50" class="textfield" /></td>
                              </tr>
                              <tr>
                                <td align="center" valign="middle"><strong class="newtopico">Op&ccedil;&otilde;es</strong></td>
                                <td bgcolor="#FFFFFF"> 
                                    <input name="class" type="radio" value="linkforumnormal" checked="checked" />Todos - 
                                    <input name="class" type="radio" value="linkforumred">Guild  
                                    <input name="class" type="radio" value="linkforumblue">Fixo 
                                    <input name="class" type="radio" value="linkforumorange">Anuncio 
                                </td>                              </tr>
                            </table>
							<br>';
							} else {
							echo '<form method="post" action="forumlivre_new-topico-edit.jsp">';
							echo '<h3>Editar topico</h3>';
							echo '<label>Title </label><input type="text" value="'.$r['Title'].'" name="title" size="30" maxlength="30">';
							echo '<input type="hidden" name="id" value="'.$r['Id'].'">';
							}									
							?>
						<textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 586">
							<? echo $data=='' ?  '&nbsp' : stripslashes($r['Text']); ?>
						</textarea><br>
						<br>
						 <?PHP if ($config['admin_login'] == 'ok') {
					?>
					Additional Content: ( if page cut is done this content will be hidden.. )<br>
						<textarea id="elm1" name="elm2" rows="15" cols="80" style="width: 586">
							<? echo $data=='GBrasil' ?  'GBrasil' : stripslashes($r['Text2']); ?>
						</textarea>
						<?PHP }
					?>
						
						<input type="submit" name="save" value="Enviar post" />
						<input type="reset" name="reset" value="Refazer" />
				</form>
				

	<?PHP
}



switch (@$_GET['url']) {
	default:

	$result = $db->Execute("Select * from forumlivre order by Date desc");
	if ($db->Affected_Rows() > 0) {
		foreach ($result->GetArray() as $rs => $r) {
			echo news_template($r);
		}
	}
	break;

	case 'comments':

	if (isset($_GET['do'])) {

				$result = $db->Execute("Select * from forumlivre where Id=? order by Date desc", array($_GET['do']));
				if ($db->Affected_Rows() > 0) {
					foreach ($result->GetArray() as $rs => $r) {
						echo news_template($r);
						$title = $r['Title'];
					}
					$result = $db->Execute("Select * from forumlivre2 where Msg_Id=? order by Date desc", array($_GET['do']));
					if ($db->Affected_Rows() > 0) {
					echo '<a name="comments">';
						foreach ($result->GetArray() as $rs => $r) {
							echo comments_template($r);
							
						}
					}
						if ($config['user_login'] == 'ok') {
							switch (@$_GET['key']) {
							case 'new':
									$db->Execute('Insert into `forumlivre2` (`Title`,`Comment`,`Author`,`Date`,`Msg_Id`) VALUES (?,?,?,'.$db->DBTimeStamp(time()).',?)',
													array($_POST['title'],$_POST['elm1'],$user['NickName'],$_GET['do']));
										if ($db->Affected_Rows()== 1) {
													echo notice('Comment has been added successfully...<br> Redirecting in 5 seconds!','Success!!');
													header('Refresh: 2; url=forumlivre_new-comments-'.$_GET['do'].'.jsp');
													$db->Execute("Update forumlivre set Comments = Comments + 1 where Id = ?", array($_GET['do']));
										}
							break;
							
							case 'delete':
							
							if ($config['user_login']=='ok') {
								$result = $db->Execute("Delete from forumlivre2 where Id=? ", array($_POST['Id']));
									if ($db->Affected_Rows() > 0) {
										echo notice('Comment has been Deleted successfully...<br> Redirecting in 5 seconds!','Success!!');
										$db->Execute("Update forumlivre set Comments = Comments - 1 where Id = ?", array($_GET['do']));
										header('Refresh: 2; url=forumlivre_new-comments-'.$_GET['do'].'.jsp');
									}
							} else {
									$result = $db->Execute("Delete from forumlivre2 where Id=? and Author=?", array($_POST['Id'],$user['NickName']));
										if ($db->Affected_Rows() > 0) {
											echo notice('Comment has been Deleted successfully...<br> Redirecting in 5 seconds!','Success!!');
											header('Refresh: 2; url=forumlivre_new-comments-'.$_GET['do'].'.jsp');
											$db->Execute("Update forumlivre set Comments = Comments - 1 where Id = ?", array($_GET['do']));
										} else {
												echo notice('This is not your comment...<br> Redirecting in 5 seconds!','Error!!');
												header('Refresh: 2; url=forumlivre_new-comments-'.$_GET['do'].'.jsp');
										}
	
							}
							
							break;
							
							}
						} else {
						echo  notice('You must be logined before you can post comments or edit your own comments','Please Login');
						
						}
					comEditor($title);
				}
			} else {
				echo notice('Invalid Announcement Selected...<br> Redirecting in 5 seconds!');
				header('Refresh: 2; url=index.jsp');
			}
	break;
	
	
	case 'topico':
	if ($config['user_login'] == 'ok') {
			
		switch(@$_GET['do']) {
			default:
			$result = $db->Execute("Select * from forumlivre order by Date desc");
				if ($db->Affected_Rows() > 0) {
				
			}
			Editor();
			break;
			
			case 'new':
			
				$db->Execute('Insert into `forumlivre` (`Title`,`Text`,`Text2`,`Author`,`NickName`,`CountryGrade`,`signforum`,`class`,`Date`,`Comments`) VALUES (?,?,?,?,?,?,?,?,'.$db->DBTimeStamp(time()).',?)',
							array($_POST['title'],$_POST['elm1'],$_POST['elm2'],$user['Id'],$game['NickName'],$game['CountryGrade'],$user['signforum'],$_POST['class'],0));
							
				if ($db->Affected_Rows()== 1) {
							echo notice('Topico postado com sucesso.<br>Aguarde!','Success!!');
							header('Refresh: 2; url=forum.jsp');
				}
			break;
			case 'delete':
				$db->Execute('delete from `forumlivre` where Id=?',	array($_POST['Id']));
				if ($db->Affected_Rows()== 1) {
							echo notice('Announcement has been Deleted successfully...<br> Redirecting in 5 seconds!','Success!!');
							header('Refresh: 2; url=forumlivre_new-topico.jsp');
				}
			break;
			
			case 'edit':

			if (isset($_POST['title']))  {
			$db->Execute('update `forumlivre` set Title=?, `Text`=?, `Text2` = ?, Author = ? where Id=?',	array($_POST['title'],$_POST['elm1'],$_POST['elm2'],$user['NickName'],$_POST['id']));
				if ($db->Affected_Rows()== 1) {
							echo notice('Announcement has been Updated successfully...<br> Redirecting in 5 seconds!','Success!!');
							header('Refresh: 2; url=forumlivre_new-topico.jsp');
				}
			
			} else  {
			Editor($_POST['Id']);
			}
			break;
		
		}
	


	} else {
		echo notice('Invalid Access', 'Por favor logue-se .<br> Redirecionando em 5 segundos!');
		header('Refresh: 2; url=entrar.jsp');
	
	}
	
	break;

}


?></table></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>