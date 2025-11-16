<?
$config['db_host'] = 'localhost';
$config['db_user'] = 'root';
$config['db_pass'] = '';
$config['db_name'] = 'gunbound';

	if (!($link=@mysql_connect($config['db_host'],$config['db_user'],$config['db_pass']))){
	exit();
	}

	if (!@mysql_select_db($config['db_name'],$link)){
	exit();
	}
$query=mysql_query("select count(Id) as TOTAL from currentuser where ServerPort='8360'");
$row=mysql_fetch_array($query);
$total_online1 = $row['TOTAL'];

$query=mysql_query("select count(Id) as TOTAL from currentuser where ServerPort='8444'");
$row=mysql_fetch_array($query);
$total_online2 = $row['TOTAL'];

$query=mysql_query("select count(Id) as TOTAL from currentuser where ServerPort='8361'");
$row=mysql_fetch_array($query);
$total_online3 = $row['TOTAL'];

$query=mysql_query("select count(Id) as TOTAL from currentuser where ServerPort='8362'");
$row=mysql_fetch_array($query);
$total_online4 = $row['TOTAL'];

$query=mysql_query("select count(Id) as TOTAL from currentuser");
$row=mysql_fetch_array($query);
$total_online = $row['TOTAL'];
?>
<?
echo $total_online1.';'.$total_online2.';'.$total_online3.';'.$total_online4;
?>