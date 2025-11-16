<?PHP
function notice($text,$header='',$type='') {
if ($type == 'alert') {
return "
<table> <tr><td valign=top rowspan=2> <img src=template/".$GLOBALS['config']['template']."/images/under_cons.gif><td valign=top><h4>$header</h4></td></tr><tr><td valign=top><h5>$text</h5></td> </tr></table>";
} else {
$key= rand(0,5);
$key = str_pad($key+1, 2, 0, STR_PAD_LEFT);
return "<table cellpadding=\"0\" cellspacing=\"0\" > 
  <tbody><tr><td rowspan=\"2\" valign=\"top\"><img src=template/".$GLOBALS['config']['template']."/images/".$key.".gif></td><td height=\"10\" valign=\"top\"><span class=vblue>$header</span></td></tr><tr><td valign=\"top\">$text</td> </tr></tbody></table>";
}
}


function writelog($logentry, $lgname) {
global $config;
$user = @isset($GLOBALS['user_auth']->username) ? @$GLOBALS['user_auth']->username : '' ;
$admin = @!isset($_SERVER['PHP_AUTH_USER']) ? @$GLOBALS['admin_auth']->username : @$_SERVER['PHP_AUTH_USER'];
$logentry = $_SERVER['REMOTE_ADDR']. " ". @$_SERVER['PHP_AUTH_USER']." $logentry";
$lgname = $config['adm_logs'].'/'.$lgname.'_'.date("d_m_y").'.txt';
      $logfile = @fopen ($lgname, "a+");
      if (!$logfile)
        {
          echo (" ERROR: Failed to open $lgname");
        }
      else
        {
          fwrite ($logfile, "[".date ("D M d Y h:iA")."] [$logentry]\r\n");
          fclose ($logfile);
        }

//$GLOBALS['db']->Execute("INSERT INTO ".$config['db_prefix']."logs (type,ip,description,adminlogin,userlogin,date) VALUES (?,?,?,?,?,?)",
//array($lgname,$_SERVER['REMOTE_ADDR'],$logentry,$admin,$user,$GLOBALS['db']->DBTimeStamp(time())));
  
}

function admin_checklogin($user,$hash) {
$hash = clean_variable(md5_decrypt($hash));
$user = clean_variable($user);
$result = $GLOBALS['db']->Execute("SELECT Id FROM user where upper(Id) = upper(?) and Password = upper(?) and  Authority = 100",array($user,$hash));
	return $result->RecordCount() > 0 ? true : false;
}

function clean_variable($var=NULL,$r=NULL) {
$newvar = @preg_replace('/[^a-zA-Z0-9\_]/', '', $var);
if (!preg_match('/^[a-zA-Z0-9\_\s]*$/i',stripslashes($var))) {
	if ($r != NULL) {  return true; } else { return $newvar; }
	writelog("$var", 'VARIABLE_ERROR'); 
 } 
	if ($r == NULL) {  return $newvar; }

}

function user_checklogin($user,$hash) {
$hash = clean_variable(md5_decrypt($hash));
$user = clean_variable($user);
$result = $GLOBALS['db']->Execute("SELECT Id FROM user where upper(Id) = upper(?) and Password = upper(?) ",array($user,$hash));
	return $result->RecordCount() > 0 ? true : false;
}

function get_rnd_iv($iv_len)
{
   $iv = '';
   while ($iv_len-- > 0) {
       $iv .= chr(mt_rand() & 0xff);
   }
   return $iv;
}
function md5_encrypt($plain_text, $password='thecodeiswithu', $iv_len = 16)
{
   $plain_text .= "\x13";
   $n = strlen($plain_text);
   if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
   $i = 0;
   $enc_text = get_rnd_iv($iv_len);
   $iv = substr($password ^ $enc_text, 0, 512);
   while ($i < $n) {
       $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
       $enc_text .= $block;
       $iv = substr($block . $iv, 0, 512) ^ $password;
       $i += 16;
   }
   return base64_encode($enc_text);
}

function md5_decrypt($enc_text, $password='thecodeiswithu', $iv_len = 16)
{
   $enc_text = base64_decode($enc_text);
   $n = strlen($enc_text);
   $i = $iv_len;
   $plain_text = '';
   $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
   while ($i < $n) {
       $block = substr($enc_text, $i, 16);
       $plain_text .= $block ^ pack('H*', md5($iv));
       $iv = substr($block . $iv, 0, 512) ^ $password;
       $i += 16;
   }
   return preg_replace('/\\x13\\x00*$/', '', $plain_text);
}

function mailer($rcpto, $subject, $content, $account=NULL) {

global $config;
if ($account != NULL) {
$mail = $GLOBALS['db']->Execute("Select E_Mail from user where ID = ?",array($account));
$row = $mail->getArray();
$rcpto=$row[0]['E_Mail'];
}
$mailTo = $rcpto;
$msgSubject = $config['server_name'] . " :: ". $subject;
 $msgBody = "Este e um e-mail automatico de Registro do $config[server_name].\n\n" .
 $content ."\n\nObrigado por jogar o $config[server_name]\n\n";
$xHeaders = "From: $config[admin_mail]\nX-Mailer: PHP/" . phpversion();
//mail($mailTo, $msgSubject, $msgBody, $xHeaders);
require("_inc/smtp.php");

	
	$from="admin@gbevolution.com.br"; 
	$to="$mailTo";                        

	$smtp=new smtp_class;

	$smtp->host_name="$config[mail_host]";       
	$smtp->localhost="localhost";      
	$smtp->direct_delivery=0;           
	$smtp->timeout=10;                 
	$smtp->data_timeout=0;              
	$smtp->debug=0;                    
	$smtp->html_debug=0;              
	$smtp->pop3_auth_host="";        
	$smtp->user="$config[mail_user]";                   
	$smtp->realm="";                   
	$smtp->password="$config[mail_pass]";               
	$smtp->workstation="";        
	$smtp->authentication_mechanism=""; 

	
	if($smtp->SendMessage(
		$from,
		array(
			$to
		),
		array(
			"From: $from",
			"To: $to",
			"Subject: $msgSubject",
			"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")
		),
		"Olá, $to!\n\n$msgBody\n\nGunbound GBEvolution - http://www.gbevolution.com.br\n")) {
		writelog("Success Sending Mail... $to ","Mail");
		return true;
	 } else {
		writelog("Error Sending Mail... $to ","Mail");
		return false;
	}
}
function valid_account($value) {
	$result = $GLOBALS['db']->Execute("SELECT user FROM `user` where upper(user) = upper(?)", array($value));
	return $result->RecordCount() > 0 ? true : false;
 }

function valid_email($value) {	
	$result = $GLOBALS['db']->Execute("SELECT E_Mail FROM `user` where upper(E_Mail) = upper(?)", array($value));
	return $result->RecordCount() > 0 ? true : false;
}

function valid_NickName($value) {
	$result = $GLOBALS['db']->Execute("SELECT user FROM `user` where upper(NickName) = upper(?)", array($value));
	return $result->RecordCount() > 0 ? true : false;
 }

function getgrade($grade) {
return "<img src=\"ranks/rank_".$grade.".gif\" width=\"25\" height=\"15\" border=\"0\">";
}

function getminirank($minirank) {
return "<img src=\"ranks/level_".$minirank.".jpg\" width=\"12\" height=\"12\" border=\"0\">";
}

function vip_valid($value) {	
	$result = $GLOBALS['db']->Execute("SELECT NickName FROM `user` where upper(NickName) = upper(?) and  vip = 1", array($value));
	return $result->RecordCount() > 0 ? true : false;
}

function voto_valid($value) {	
	$result = $GLOBALS['db']->Execute("SELECT NickName FROM `user` where upper(NickName) = upper(?) and  voto = 1", array($value));
	return $result->RecordCount() > 0 ? true : false;
}

function getminicountry($minicountry) {
return "<img src=\"ranks/ban_".$country.".jpg\" width=\"12\" height=\"12\" border=\"0\">";
}

function getcountry($c) {

     $country = array(1 => 'Afghanistan',2 => 'Albania',3 => 'Algeria',4 => 'Andorra',5 => 'Angola',6 => 'Anguilla',7 => 'Antarctica',8 => 'Antigua and Barbuda',9 => 'Argentina',10 => 'Armenia',11 => 'Aruba',12 => 'Australia',13 => 'Austria',14 => 'Azerbaijan',15 => 'Bahamas',16 => 'Bahrain',17 => 'Bangladesh',18 => 'Barbados',19 => 'Belgium',20 => 'Belize',21 => 'Belarus',22 => 'Benin',23 => 'Bermuda',24 => 'Bhutan',25 => 'Bolivia',26 => 'Bosnia and Herzegovina',27 => 'Botswana',28 => 'Brasil',29 => 'Brunei',30 => 'Bulgaria',31 => 'Burkina Faso',32 => 'Burundi',33 => 'Cambodia',34 => 'Cameroon',35 => 'Canada',36 => 'Cape Verde',37 => 'Cayman Islands',38 => 'Central African Republic',39 => 'Chile',40 => "People's Rep. of China",41 => 'Christmas Island',42 => 'Colombia',43 => 'Comoros',44 => 'Congo',45 => 'Democratic Republic of the Congo',46 => 'Cook Islands',47 => 'Costa Rica',48 => "Cote D'Ivoire",49 => 'Croatia',50 => 'Cuba',51 => 'Cyprus',52 => 'Czech Republic',53 => 'Denmark',54 => 'Djibouti',55 => 'Dominica',56 => 'Dominican Republic',57 => 'Ecuador',58 => 'Egypt',59 => 'El Salvador',60 => 'Equatorial Guinea',61 => 'Eritrea',62 => 'Estonia',63 => 'Ethiopia',64 => 'Falkland Islands',65 => 'Fiji',66 => 'Finland',67 => 'France',68 => 'French Guiana',69 => 'French Polynesia',70 => 'Gabon',71 => 'Gambia',72 => 'Germany',73 => 'Georgia',74 => 'S. Georgia and the S. Sandwich Is.',75 => 'Ghana',76 => 'Greece',77 => 'Greenland',78 => 'Grenada',79 => 'Guadeloupe',80 => 'Guam',81 => 'Guatemala',82 => 'Guinea',83 => 'Guinea-Bissau',84 => 'Guyana',85 => 'Haiti',86 => 'Honduras',87 => 'Hong Kong',88 => 'Hungary',89 => 'Iceland',90 => 'India',91 => 'Indonesia',92 => 'Iran',93 => 'Iraq',94 => 'Ireland',95 => 'Israel',96 => 'Italy',97 => 'Jamaica',98 => 'Japan',99 => 'Jordan',100 => 'Kazakhstan',101 => 'Kenya',102 => 'Kiribati',103 => 'Kitts and Nevis',104 => 'North Korea',105 => 'South Korea',106 => 'Kyrgyzstan',107 => 'Kuwait',108 => 'Laos',109 => 'Latvia',110 => 'Lebanon',111 => 'Lesotho',112 => 'Liberia',113 => 'Libya',114 => 'Liechtenstein',115 => 'Lithuania',116 => 'Luxembourg',117 => 'Macau',118 => 'Macedonia',119 => 'Madagascar',120 => 'Malaysia',121 => 'Maldives',122 => 'Mali',123 => 'Marshall Islands',124 => 'Malta',125 => 'Northern Mariana Islands',126 => 'Malawi',127 => 'Martinique',128 => 'Mauritania',129 => 'Mauritius',130 => 'Mayotte',131 => 'Mexico',132 => 'Micronesia',133 => 'Moldova',134 => 'Mongolia',135 => 'Montserrat',136 => 'Morocco',137 => 'Mozambique',138 => 'Myanmar',139 => 'Namibia',140 => 'Nauru',141 => 'Nepal',142 => 'Netherlands',143 => 'Netherlands Antilles',144 => 'New Caledonia',145 => 'New Zealand',146 => 'Nicaragua',147 => 'Niger',148 => 'Nigeria',149 => 'Niue',150 => 'Norway',151 => 'Oman',152 => 'Pakistan',153 => 'Palau',154 => 'Panama',155 => 'Papua New Guinea',156 => 'Paraguay',157 => 'Peru',158 => 'Philippines',159 => 'Pitcairn Island',160 => 'Poland',161 => 'Portugal',162 => 'Puerto Rico',163 => 'Qatar',164 => 'Reunion',165 => 'Romania',166 => 'Russia',167 => 'Rwanda',168 => 'Saint Lucia',169 => 'Saint Vincent and the Grenadines',170 => 'Samoa-American',171 => 'Samoa-Western',172 => 'San Marino',173 => 'Sao Tome and Principe',174 => 'Saudi Arabia',175 => 'Senegal',176 => 'Seychelles',177 => 'Sierra Leone',178 => 'Singapore',179 => 'Slovakia',180 => 'Slovenia',181 => 'Solomon Islands',182 => 'Somalia',183 => 'South Africa',184 => 'Spain',185 => 'Sri Lanka',186 => 'Sudan',187 => 'Suriname',188 => 'Swaziland',189 => 'Sweden',190 => 'Switzerland',191 => 'Syria',192 => 'Taiwan',193 => 'Tajikistan',194 => 'Tanzania',195 => 'Thailand',196 => 'Togo',197 => 'Tonga',198 => 'Trinidad and Tobago',199 => 'Tunisia',200 => 'Turkey',201 => 'Turkmenistan',202 => 'Tuvalu',203 => 'Uganda',204 => 'Ukraine',205 => 'United Arab Emirates',206 => 'United Kingdom',207 => 'USA',208 => 'Uruguay',209 => 'Uzbekistan',210 => 'Vanuatu',211 => 'Vatican City',212 => 'Venezuela',213 => 'Virgin Islands',214 => 'Vietnam',215 => 'Western Sahara',216 => 'Yemen',217 => 'Yugoslavia',218 => 'Zambia',219 => 'Zimbabwe',220 => 'APO',221 => 'FPO',222 => 'Other',223 => 'Bouvet Island',224 => 'British Indian Ocean Territory',225 => 'Chad',226 => 'Cocos(Keeling) Islands',227 => 'East Timor',228 => 'Faroe Islands',229 => 'French Southern Territories',230 => 'Gibraltar',231 => 'Heard and McDonald Islands',232 => 'Monaco',233 => 'Norfolk Island',234 => 'Saint Helena',235 => 'Saint Pierre and Miquelon',236 => 'Svalbard and Jan Mayen Islands',237 => 'Tokelau',238 => 'Turks and Caicos Islands',239 => 'United States Minor Outlying Islands',240 => 'Wallis and Futuna',
	241 => 'British Virgin Islands');
    if ($c == 'get') {
		return $country; 
	} else {
		return isset($country[$c]) ? $country[$c] : "unknown" ;
	} 
}

function getban($c) {

     $ban = array(-1 => '= Permanente');
    if ($c == 'get') {
		return $ban; 
	} else {
		return isset($ban[$c]) ? $ban[$c] : " " ;
	} 
}

function getmeuavatar($c) {

     $meuavatar = array('Glasses'  => 'Oculos','Flag'  => 'Bandeira','Helm'  => 'Cabeça','Body'  => 'Corpo','Ex'  => 'Ex Item');
    if ($c == 'get') {
		return $meuavatar; 
	} else {
		return isset($meuavatar[$c]) ? $meuavatar[$c] : " " ;
	} 
}

function getaranking($c) {

     $aranking = array('204801'  => 'Power User ->','Flag'  => 'Bandeira','Helm'  => 'Cabeça','Body'  => 'Corpo','Ex'  => 'Ex Item');
    if ($c == 'get') {
		return $aranking; 
	} else {
		return isset($aranking[$c]) ? $aranking[$c] : " " ;
	} 
}



function getauth($auth) {
$authority = array('-100' => 'banned', 1 => 'normal', 99 => 'gm', 100 => 'admin');
if ($auth == 'get') {
	return $authority;
} else {
return isset($authority[$auth])  ? $authority[$auth] : "unknown" ;
}
}
?>