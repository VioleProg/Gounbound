<?PHP
session_start(); 
header("Cache-control: private");
ob_start();
error_reporting(E_ALL ^E_NOTICE ^E_WARNING);

require('_inc/config.php');
// MYSQL Database Interface
include("_inc/ADODB/adodb-errorhandler.inc.php"); 
require_once '_inc/ADODB/adodb.inc.php';
require_once('_inc/PageGeneration.class.php');
require_once('_inc/Securelogin.class.php');
require_once('_inc/Paginate.class.php');
require_once('_inc/Validate.class.php');
require_once('_inc/functions.php');
$pagegen = new page_gen();
$pagegen->round_to = 7;
$pagegen->start();
define('ADODB_ERROR_LOG_TYPE', 3);
define('ADODB_ERROR_LOG_DEST', 'logs/adodb_errors.log');

$db = ADONewConnection('mysql','date');
$db->createdatabase = true ;
$db->debug = false ;
$result = $db->Connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
$ADODB_FETCH_MODE =  ADODB_FETCH_ASSOC;
if(!$result)
{
    $error_object = ADODB_Pear_Error();
    echo '<b>' . $error_object->message . '</b>';
}

/// AUTHENTICATION SCHEMAS
$admin_auth = new securelogin;
$admin_auth->handler['checklogin'] = 'admin_checklogin';
$admin_auth->handler['encode'] = 'md5_encrypt';
$admin_auth->post_index = array(
	'user' => 'user' ,
	'pass' => 'pass' ,
);
$admin_auth->use_cookie = false;
$admin_auth->use_session = true;

$user_auth = new securelogin;
$user_auth->handler['checklogin'] = 'user_checklogin';
$user_auth->handler['encode'] = 'md5_encrypt';
$user_auth->post_index = array(
	'user' => 'user' ,
	'pass' => 'pass' ,
);
$user_auth->use_cookie = false;
$user_auth->use_session = true;




# DETECT USER AND ADMIN 
if (isset($_GET['logout'])) { 
	$user_auth->clearlogin();
	$admin_auth->clearlogin();
	$config['user_login'] = ''; 
	$config['admin_login'] = ''; 
	setcookie("user_login", FALSE, time()+3600, "/", "", 0);
	setcookie("admin_login", FALSE, time()+3600, "/", "", 0);
	header('location: index.php');
} else {

if ($admin_auth->haslogin(true)) { 
	$config['admin_login'] = 'ok'; 
	setcookie("admin_login", 'ok', time()+3600, "/", "", 0);
	
} else { 
	$config['admin_login'] = '';  
}
if ($user_auth->haslogin(true)) { 
	$GLOBALS['user_auth']->savelogin();
	writelog($GLOBALS['user_auth']->username, "Login_user"); 
	$config['user_login'] = 'ok'; 
	setcookie("user_login", 'ok', time()+3600, "/", "", 0);
	$result = $db->Execute("Select * from game where Id = ?", array($user_auth->username));
	$game = $result->GetArray();
	$game = $game[0];
	$rs = $db->Execute("SELECT * FROM `user` WHERE Id = ?", array($user_auth->username));
	$user = $rs->GetArray();
	$user = $user[0];
	$rs = $db->Execute("SELECT * FROM `cash` WHERE id = ?", array($user_auth->username));
	$cash = $rs->GetArray();
	$cash = $cash[0];
	$rs = $db->Execute("SELECT * FROM `credito` WHERE id = ?", array($user_auth->username));
	$credito = $rs->GetArray();
	$credito = $credito[0];
	 } else {
	 	$config['user_login'] = ''; 
	 }



}

//LANUAGE SELECTION!

if (isset($_SESSION['language'])) {
		$config['language'] = $_SESSION['language'];
} 
if (isset($_GET['language'])) {
		$config['language'] = $_GET['language'];
		$_SESSION['language'] = $_GET['language'];
}
require('languages/'.$config['language'].'.lang.php');

?>