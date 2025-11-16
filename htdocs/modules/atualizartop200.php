<?PHP
if ($config['admin_login'] == 'ok') {

$db->Execute('UPDATE cash SET Cash=Cash+10000');

echo '<div id="content">
	<div id="content_full">
		<div id="content_full_top">
			<h2>
				<img src="template/gbetools/images/title_ranking.png" />			</h2>
		</div>

		<div id="content_full_wrapper">
			<div id="content_full_content"><center>
				<font color="#333333" size="1" face="Arial">
				<br>
Top 200 atualizado com sucesso...</font></center>
			</div>
		</div>
		<div class="clear"></div>
		<div id="content_full_bottom"></div>
	</div>
	<div class="clear"></div>
</div>';
header('Refresh: 1; url=stats.jsp');
} 
?>