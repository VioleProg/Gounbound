<?
$config['db_host'] = 'localhost';
$config['db_user'] = 'root';
$config['db_pass'] = '';
$config['db_name'] = 'gbwc';

	if (!($link=@mysql_connect($config['db_host'],$config['db_user'],$config['db_pass']))){
	exit();
	}

	if (!@mysql_select_db($config['db_name'],$link)){
	exit();
	}
$query=mysql_query("select count(Id) as TOTAL from currentuser");
$row=mysql_fetch_array($query);
$total_online = $row['TOTAL'];
?>
<?
echo $total_online;
?>
