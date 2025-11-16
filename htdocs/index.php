<?PHP 
require('_inc/header.php'); 
if (isset($_GET['write'])) {
	$argv = explode('-',$_GET['write']);
	settype($argv,'array'); 
	$_GET['op'] = @$argv[0];
	$_GET['url'] = @$argv[1];
	$_GET['do'] = @$argv[2];
	$_GET['key'] = @$argv[3];
}
include('template/'.$config['template'].'/header.php');
$op = !isset($_GET['op']) ? $config['default_mod'] : $_GET['op'] ;

   if (is_file("modules/".$op.".php")) {
   		include("modules/".$op.".php");
	
   } else {	
		echo ('<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_404.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><br><br><center><font color="#333333" size="1" face="Arial">
<img border="0" src="template/gbetools/images/erro_404.jpg" width="235" height="104"><br>
Você será redirecionado em 2 segundos...</font></center><br><br>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>');
header('Refresh: 2; url=home.jsp');
 
   }


include('template/'.$config['template'].'/footer.php');
@$db->Close();
ob_end_flush();
?>