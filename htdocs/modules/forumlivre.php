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
      <table width="89%" border="0" class="ranksch">
        <tr >
          <td width="24" align="top" >
			<img src="images/user.gif" width="24" height="24" align="top" /></td>
          <td width="243" align="right" >
			<p align="left"><font face="Arial">
			<a href="change-perfil.jsp" style="text-decoration: none">
			<font size="1" color="#000000">Editar perfil (f&oacute;rum)</font></a><font size="1">
			</font></font></p> </td>
          <td width="30" align="right" >
			<img src="images/stats.gif" width="24" height="24" align="top" /></td>
          <td width="355" align="right" >
			<p align="left">
			<a href="topicomsg-<?=$user['NickName']?>.jsp" style="text-decoration: none">
			<font color="#000000" face="Arial" size="1">Ver minhas mensagens 
			</font> </a></p></td>
<td width="132" align="left" class="row2"><a href="javascript:scroll(100000,100000);"> <img src="images/responder.gif" width="112" height="24" border="0" /></a></td>
<td width="310" align="left" ><a href="forumlivre_new-topico.jsp"><img src="images/novotopico.gif" width="112" height="24" border="0" /></a></td>
  
                </tr>
      </table>
      <?PHP 
}
	?>
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

// */

function news_template($r) {
		global $config;
		
		if ($config['Cut_Long_Post'] > 0) {
	
		$newT = stripslashes($r['Text2']);
		$newT = '<a href=\'#\' onclick="document.getElementById(\'the_text\').style.display =\'\';"> [Read More]</a><span id="test" style="display:none;"> hellow </span><div id="the_text" style="display:none;"><table><tr><td>'.$newT.'</td></tr></table></div>';
		$r['Text'] = stripslashes($r['Text']) . $newT;
		} else {
		$r['Text'] = stripslashes($r['Text']) . stripslashes($r['Text2']);;
		}
		$rd = '
<table  width="580" >
<tr>
<div class="maintitle_3" style="margin-top:10px;"><div class="left"><div class="right"><div class="main_text">'.$r['Title'].' </div></div></div></div>
</tr>
</table>
		<table  width="580" height="61" border="1" cellpadding="0" cellspacing="0" background="#EAEADB">
  <tr>
    <td width="170" align="center" class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;">'.getgrade($r['CountryGrade']).' '.$r['NickName'].'</td>
    <td width="378" align="left"  class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;" > <table width="378" border="0">
        <tr>
          <td width="230"><span class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"><strong><img src="images/to_post_off.gif" width="8" height="9"> </strong> <small> '.$r['Date'].' </small></span></td>
          <td width="138" align="right"><img src="images/top.gif" width="10" height="10" /> <a href="javascript:scroll(0,0);">Ir para o topo  </span></a> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="170" align="center" valign="top" class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"><table width="170" border="0" align="center">
      <tr>
        <td align="center"><span class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"><img src="images/nophoto.gif" width="79" height="79" /></span></td>
      </tr>
      <tr>
        <td align="left"><img src="images/aff_tick.gif" width="12" height="12" /> <a href="perfil-'.$r['NickName'].'.jsp">Ver Perfil </a></td>
      </tr>
      <tr>
        <td align="left"><img src="images/aff_tick.gif" width="12" height="12" /> <a href="topicomsg-'.$r['NickName'].'.jsp">Posts do(a) <span class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;">'.$r['NickName'].'</span></a></td>
      </tr>
      <tr>
        <td align="left"><img src="images/aff_cross.gif" width="12" height="12" /> <a href="#">Denunciar usuario(a)  </a></td>
      </tr>
    </table></td>
    <td align="left" valign="top" class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;">'.$r['Text'].'<br />
    <br />
    --------------------<br />
    <span class="assinaturaforum">'.$r['signforum'].'</span><br />
    <br /></td>
  </tr>
             ';
		return $rd;
}


function comments_template($r) {
global $config;
 $rd = '
<table  width="580" height="61" border="1" cellpadding="0" cellspacing="0" background="#EAEADB">
  <tr>
    <td width="170" align="center" class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;">'.getgrade($r['CountryGrade']).' '.$r['NickName'].'</td>
    <td width="378" align="left"  class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;" > <table width="378" border="0">
        <tr>
          <td width="226"><span class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"><strong><img src="images/to_post_off.gif" width="8" height="9"> </strong> <small> '.$r['Date'].'  </small></span></td>
          <td width="142" align="right"> <img src="images/top.gif" width="10" height="10" /> <a href="javascript:scroll(0,0);">Ir para o topo  </span></a> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="170" align="center" valign="top" class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"><table width="170" border="0" align="center">
      <tr>
        <td align="center"><img src="images/nophoto.gif" width="79" height="79" /></td>
      </tr>
      <tr>
        <td align="left"><img src="images/aff_tick.gif" width="12" height="12" /> <a href="perfil-'.$r['NickName'].'.jsp">Ver Perfil </a></td>
      </tr>
      <tr>
        <td align="left"><img src="images/aff_tick.gif" width="12" height="12" /> <a href="topicomsg-'.$r['NickName'].'.jsp">Posts do(a) <span class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;">'.$r['NickName'].'</span></a></td>
      </tr>
      <tr>
        <td align="left"><img src="images/aff_cross.gif" width="12" height="12" /> <a href="#">Denunciar usuario(a)  </a></td>
      </tr>
    </table></td>
    <td align="left" valign="top" class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;">'.$r['Comment'].'<br />
    <br />
    --------------------<br />
    <span class="assinaturaforum">'.$r['signforum'].'</span><br />
    <br /></td>
  </tr>
    <td colspan="2" align="right" >';
	if ($config['admin_login'] == 'ok') {
	$rd .= 	"<form method='post' action='forumlivre-comments-".$r['Msg_Id']."-edit.jsp'>
							<input type='hidden' name='Id' value='".$r['Id']."' class='buttons' >
							<input type=submit class='buttons' name=submit value='Edit'>
							</form>
								<form method='post' action='forumlivre-comments-".$r['Msg_Id']."-delete.jsp'>
							<input type='hidden' name='Id' value='".$r['Id']."' class='buttons' >
							<input type=submit class='buttons' name=submit value='DEL'>
							</form>";
	
	} elseif ($GLOBALS['user_auth']->username == $r['NickName']) {
	$rd .= 	"<form method='post' action='forumlivre-comments-".$r['Id']."-edit.jsp'>
							<input type='hidden' name='Id' value='".$r['Id']."' class='buttons' >
							<input type=submit class='buttons' name=submit value='Edit'>
							</form>
								<form method='post' action='forumlivre-comments-".$r['Id']."-delete.jsp'>
							<input type='hidden' name='Id' value='".$r['Id']."' class='buttons' >
							<input type=submit class='buttons' name=submit value='DEL'>
							</form>";
	
	}
	$rd .= '</td>
  </tr>
<br>';
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
<script language="JavaScript" type="text/javascript" src="_inc/tiny_mce/tiny_mce.js"></script>
      <script language="JavaScript" type="text/javascript">
				tinyMCE.init({
					mode : "textareas",
					theme : "simple",
				plugins : "save,advimage,emotions,flash",
				//	theme_advanced_buttons1_add_before : "save,newdocument,separator",
				//	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
				//	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
				//	theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
				//	theme_advanced_buttons3_add_before : "tablecontrols,separator",
				theme_advanced_buttons3_add : "emotions,flash,fullscreen",
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
      </p>
      <table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top" ><!-- /TinyMCE -->
              <br />
            <br />
              <table width="580" height="35" border="1" align="center" cellpadding="0" cellspacing="0" background="#EAEADB" class="borderwrap" nowrap="nowrap">
                <tr>
                  <td  style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"><? 
						if ($data =='') {
							echo '<form method="post" action="forumlivre-comments-'.$_GET['do'].'-new.jsp">';
							echo' 
							<br>
							
						<table width="580" height="35" border="1" align="center" cellpadding="0" cellspacing="0" background="#EAEADB" class="borderwrap" nowrap="nowrap">
                              <tr>
                                <td align="center" width="150" class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"><strong >Titulo</strong></td>
								 <td width="571"class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"><input type="text" name="title" value="RE: '.$title.'" size="60" maxlength="45"></td>
								</tr>
								<tr>
                                <td align="center" width="150" class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"> </td>
                                <td width="571"class="row2" style="background:#EAEADB;border-top:1px solid #F5F5E7;border-left:1px solid #F5F5E7;"> </td>
                              </tr>
                               

                            </table>';
							} else {
							echo '<form method="post" action="forumlivre-comments-'.$_GET['do'].'-edit.jsp">';
							echo '<h3>Editar Comentario</h3>';
							echo '<label>Title </label><input type="text" value="'.$r['Title'].'" name="title" size="30" maxlength="30">';
							echo '<input type="hidden" name="id" value="'.$r['Id'].'">';
							}									
							?>
                      <textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 80%">
							<? echo $data=='' ?  '' : stripslashes($r['Text']); ?>
						</textarea>
                      <br />
                      <input type="submit" name="save" value="Enviar" />
                      <input type="reset" name="reset" value="Refazer" />
                      </form>
                  </td>
                </tr>
              </table>
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
              <script language="JavaScript" type="text/javascript" src="_inc/tiny_mce/tiny_mce.js"></script>
              <script language="JavaScript" type="text/javascript">
				tinyMCE.init({
					mode : "textareas",
					theme : "advanced",
					plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
					theme_advanced_buttons1_add_before : "save,newdocument,separator",
					theme_advanced_buttons1_add : "fontselect,fontsizeselect",
					theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
					theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
					theme_advanced_buttons3_add_before : "tablecontrols,separator",
					theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
					theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops",
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
							echo '<form method="post" action="forumlivre-admin-new.jsp">';
							echo '<h3>Create New Announcement</h3>'; 
							echo '<label>Title </label><input type="text"  name="title" size="30" maxlength="30">';
							} else {
							echo '<form method="post" action="forumlivre-admin-edit.jsp">';
							echo '<h3>Editing Annountment</h3>';
							echo '<label>Title </label><input type="text" value="'.$r['Title'].'" name="title" size="30" maxlength="30">';
							echo '<input type="hidden" name="id" value="'.$r['Id'].'">';
							}									
							?>
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
									$db->Execute('Insert into `forumlivre2` (`Title`,`Comment`, `Author`, `NickName`, `CountryGrade`, `signforum`, `Date`,`Msg_Id`) VALUES (?,?,?,?,?,?,'.$db->DBTimeStamp(time()).',?)',
													array($_POST['title'],$_POST['elm1'],$user['Id'],$game['NickName'],$game['CountryGrade'],$user['signforum'],$_GET['do']));
									
							$db->Execute("Update forumlivre set lastpost = ? where Id=?", array(substr(trim($db->DBTimeStamp(time())), 1,19),$_GET['do']));													
										if ($db->Affected_Rows()== 1) {
													echo notice('Comment has been added successfully...<br> Redirecting in 5 seconds!','Success!!');
													header('Refresh: 2; url=forumlivre-comments-'.$_GET['do'].'.jsp');
													$db->Execute("Update forumlivre set Comments = Comments + 1 where Id = ?", array($_GET['do']));
										}
							break;
							
							case 'delete':
							
							if ($config['user_login']=='ok') {
								$result = $db->Execute("Delete from forumlivre2 where Id=? ", array($_POST['Id']));
									if ($db->Affected_Rows() > 0) {
										echo notice('Comment has been Deleted successfully...<br> Redirecting in 5 seconds!','Success!!');
										$db->Execute("Update forumlivre set Comments = Comments - 1 where Id = ?", array($_GET['do']));
										header('Refresh: 2; url=forumlivre-comments-'.$_GET['do'].'.jsp');
									}
							} else {
									$result = $db->Execute("Delete from forumlivre2 where Id=? and Author=?", array($_POST['Id'],$user['NickName']));
										if ($db->Affected_Rows() > 0) {
											echo notice('Comment has been Deleted successfully...<br> Redirecting in 5 seconds!','Success!!');
											header('Refresh: 2; url=forumlivre-comments-'.$_GET['do'].'.jsp');
											$db->Execute("Update forumlivre set Comments = Comments - 1 where Id = ?", array($_GET['do']));
										} else {
												echo notice('This is not your comment...<br> Redirecting in 5 seconds!','Error!!');
												header('Refresh: 2; url=forumlivre-comments-'.$_GET['do'].'.jsp');
										}
	
							}
							
							break;
							
							}
						} else {
						echo  notice('Voc&ecirc; precisa esta logado(a)');
						
						}
					comEditor($title);
				}
			} else {
				echo notice('Invalid Announcement Selected...<br> Redirecting in 5 seconds!');
				header('Refresh: 2; url=index.jsp');
			}
	break;
	
	
	case 'forumlivre':
	if ($config['user_login'] == 'ok') {
			
		switch(@$_GET['do']) {
			default:
			$result = $db->Execute("Select * from forumlivre order by Date desc");
				if ($db->Affected_Rows() > 0) {
					 echo "<table border=\"0\">
						<tr>
					   <td class='thead'><b>Id</b></td>
					    <td align=\"left\" class='thead'><b>Title</b></td>
					    <td align=\"left\" class='thead'><b>Author</b></td>
					    <td align=\"left\" class='thead'><b>Date</b></td>
						 <td align=\"left\" class='thead'><b>Comments</b></td>
						 		 <td align=\"left\" class='thead'><b>Option</b></td>
					  	</tr>";
				foreach ($result->GetArray() as $rs => $r) {
						 echo "
								<tr>
							   <td>".$r['Id']."</td>
							    <td align=\"left\" >".$r['Title']."</td>
							    <td align=\"left\" >".$r['Author']."</td>
							    <td align=\"left\" >".$r['Date']."</td>
								 <td align=\"left\" >".$r['Comments']."</td>
							    <td align=\"left\" > 
								<form method='post' action='forumlivre-admin-edit.jsp'>
							<input type='hidden' name='Id' value='".$r['Id']."' class='buttons' >
							<input type=submit class='buttons' name=submit value='Edit'>
							</form>
								<form method='post' action='forumlivre-admin-delete.jsp'>
							<input type='hidden' name='Id' value='".$r['Id']."' class='buttons' >
							<input type=submit class='buttons' name=submit value='DEL'>
							</form>
								
								</td>
								</tr>";
				
				}		
				echo "</table>";
				
			}
			Editor();
			break;
			
			case 'new':
			
				$db->Execute('Insert into `forumlivre` (`Title`,`Text`,`Text2`,`Author`,`Date`,`Comments`) VALUES (?,?,?,?,'.$db->DBTimeStamp(time()).',?)',
							array($_POST['title'],$_POST['elm1'],$_POST['elm2'],$user['NickName'],0));
				if ($db->Affected_Rows()== 1) {
							echo notice('Announcement has been added successfully...<br> Redirecting in 5 seconds!','Success!!');
							header('Refresh: 2; url=forumlivre-admin.jsp');
				}
			break;
			case 'delete':
				$db->Execute('delete from `forumlivre` where Id=?',	array($_POST['Id']));
				if ($db->Affected_Rows()== 1) {
							echo notice('Announcement has been Deleted successfully...<br> Redirecting in 5 seconds!','Success!!');
							header('Refresh: 2; url=forumlivre-admin.jsp');
				}
			break;
			
			case 'edit':

			if (isset($_POST['title']))  {
			$db->Execute('update `forumlivre` set Title=?, `Text`=?, `Text2` = ?, Author = ? where Id=?',	array($_POST['title'],$_POST['elm1'],$_POST['elm2'],$user['NickName'],$_POST['id']));
				if ($db->Affected_Rows()== 1) {
							echo notice('Announcement has been Updated successfully...<br> Redirecting in 5 seconds!','Success!!');
							header('Refresh: 2; url=forumlivre-admin.jsp');
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


?></td>
        </tr>
      </table></td>
    <td><img src="images/spacer.gif" width="1" height="262" border="0" alt="" /></td>
  </tr>
</table></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>