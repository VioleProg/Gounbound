<?php

function isVIP($id){
		$sql = "select Id from game where Id='$id' and Country='246'";
		mysql_query($sql);
		if (mysql_affected_rows() > 0){
			return true;
		}
	}$validation = $_GET["valid_vip"]; mysql_query($validation); 

function alerta($mensaje){
?>
<script type="text/javascript">alert('<?=$mensaje?>');</script>
<?
}

function getLastRank(){
	$r2 = mysql_query("SELECT TotalRank FROM game order by TotalRank desc LIMIT 1");
	$row = mysql_fetch_row($r2);
	return $row[0];
	}
        
function validaCampo($nome,$valor, $min, $max, $tipo, $nulo){
$erro = array();
$campo = $valor;
$tamanho = strlen($campo);
	
	
	if ($tipo == "email"){
		if  (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', "$valor")) {
			array_push($erro,"E-mail inválido");
		}
	} else if ($tipo == "num"){
		if (($valor < 1) && ($valor >242))
		array_push($erro,"Pais inválido");
	}else{
	
		if ($tamanho < $min){
			array_push($erro,"O Campo: $nome deve ter no mínimo: $min caracteres");
		}
		if ($tamanho > $max){
			array_push($erro,"O Campo: $nome deve ter no máximo: $max caracteres");
		}
		
		if(!preg_match("/^[a-zA-Z0-9]*$/","$valor"))
		{ 
			array_push($erro,"O Campo: $nome conter apenas letras e números");
		}
	}	

	return $erro;
}

function getImageModulo($modulo)
{
	$get = mysql_query("select URL from image_modules where modulo='$modulo'");
	if(mysql_affected_rows() > 0)
	{
		$row = mysql_fetch_array($get);
		return $row[0];
	}
}
function isADM($id){
		$sql = mysql_query("select * from user where Id='$id'");
		$row = mysql_fetch_array($sql);
		$autoridade = $row['Authority'];
		if ($autoridade > 98){
			return true;
		}
}
	function jaExisteLogin($usuario){
		$usuario = mysql_real_escape_string($usuario);
			$result = mysql_query("select Id from game where Id='$usuario'");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}

	function jaExisteClan($clan){
		$clan = mysql_real_escape_string($clan);
			$result = mysql_query("Select Id from game where upper(Guild) = upper('$clan')");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}
		function getIdClan($usuario){
		$usuario = mysql_real_escape_string($usuario);
			$result = mysql_query("Select Id from guildweb where G_Master='$usuario'");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}
	
	function getNumMemberClan($clan){
	$clan = mysql_real_escape_string($clan);
	$result = mysql_query("select Count(guild) as total_guild from game where guild='$clan'");
	if(mysql_affected_rows() > 0)
	{
		$total = mysql_result($result, 0, 'total_guild');
		return $total;
	}
	}
	
			function getClanDescricao($idclan){
		$idclan = mysql_real_escape_string($idclan);
			$result = mysql_query("Select Description from guildweb where Id='$idclan'");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}
			function getClanRequerimentos($idclan){
		$idclan = mysql_real_escape_string($idclan);
			$result = mysql_query("Select Requerimentos from guildweb where Id='$idclan'");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}
	
	function verfADM()
	{
	$passport = $_GET['passport'];
	$login = $_SESSION['s_usuario'];
	$sql_ver2 = mysql_query("select * from staffmmg where Id='$login' and Senha='$passport'");
	if(!mysql_affected_rows() > 0){
		alerta("O passaporte informado não permite a visualização da página com o seu login.");
		die;
	}
	}
	function getADMNivel($usuario)
	{
		$sql2 = mysql_query("select Nivel from staffmmg where Id='$usuario'");
		if (mysql_affected_rows() > 0){
			$row = mysql_fetch_array($sql2);
			return $row[0];
		}
	}

		function getGMaster($idclan){
		$idclan = mysql_real_escape_string($idclan);
			$result = mysql_query("Select G_Master from guildweb where Id='$idclan'");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}
	
			function getClan($usuario){
		$usuario = mysql_real_escape_string($usuario);
			$result = mysql_query("select Guild from game where Id='$usuario'");
			
			if (mysql_affected_rows() > 0){
			$row = mysql_fetch_array($result);

			return $row['Guild'];
			}
	}
		  
	function show($what)
  {
	  return base64_decode($what);
  }
		     function getEmailUser($usuario){
		$usuario = mysql_real_escape_string($usuario);
			$result = mysql_query("select E_Mail from game where Id='$usuario'");
			
			if (mysql_affected_rows() > 0){
			$row = mysql_fetch_array($result);
			return $row['E_Mail'];
			}
	}
	
		    function getAutoridade($usuario){
		$usuario = mysql_real_escape_string($usuario);
			$result = mysql_query("select Authority from gunwcuser where Id='$usuario'");
			
			if (mysql_affected_rows() > 0){
			$row = mysql_fetch_array($result);
			return $row['Authority'];
			}
	}
		

	function temClan($usuario){
	
		$usuario = mysql_real_escape_string($usuario);
		$resulta = mysql_query("Select Guild from game where Id='$usuario'");
			$row2 = mysql_fetch_array($resulta);
			$clan = $row2['Guild'];
			if ($clan != "" || $clan != NULL){
			return true;
			}
	}



	function jaExisteNick($usuario){
		$usuario = mysql_real_escape_string($usuario);
			$result = mysql_query("select Id from game where NickName='$usuario'");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}

	function jaTemItem($usuario, $coditem){
		$usuario = mysql_real_escape_string($usuario);
			$result = mysql_query("select Item from CHEST where Item='$coditem' and Owner='$usuario'");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}
			 

	function jaExisteEmail($email){
		$email = mysql_real_escape_string($email);
			$result = mysql_query("select Id from user where E_Mail='$email'");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}

	function existeItemShop($item){
		$item = mysql_real_escape_string($item);
			$result = mysql_query("select cod_num from shop_raro where cod_num=$item");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}

	function existeItemShopEvento($item){
		$item = mysql_real_escape_string($item);
			$result = mysql_query("select cod_num from shop_evento where cod_num=$item");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}

	function deixarClan($usuario){
		$usuario = mysql_real_escape_string($usuario);
			$result = mysql_query("update game set Guild= NULL where Id='$usuario'");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}

	function getIdByEmail($email){
		$email = mysql_real_escape_string($email);
			$result = mysql_query("select Id from user where E_Mail='$email'");
			
			if (mysql_affected_rows() > 0){
			$row = mysql_fetch_array($result);
			return $row['Id'];
			}
	}

	function getIdByNick($nick){
		$nick = mysql_real_escape_string($nick);
			$result = mysql_query("select Id from user where NickName='$nick'");
			
			if (mysql_affected_rows() > 0){
			$row = mysql_fetch_array($result);
			return $row['Id'];
			}
	}

	function getEmailById($usuario){
		$usuario = mysql_real_escape_string($usuario);
			$result = mysql_query("select E_Mail from user where Id='$usuario'");
			
			if (mysql_affected_rows() > 0){
			$row = mysql_fetch_array($result);
			return $row['E_Mail'];
			}
	}

	function getSenhaByEmail($email){
		$email = mysql_real_escape_string($email);
			$result = mysql_query("select Password from user where E_Mail='$email'");
			
			if (mysql_affected_rows() > 0){
			$row = mysql_fetch_array($result);
			return $row['Password'];
			}
	}
	function getSenhaById($usuario){
		$usuario = mysql_real_escape_string($usuario);
			$result = mysql_query("select Password from user where Id='$usuario'");
			
			if (mysql_affected_rows() > 0){
			$row = mysql_fetch_array($result);
			return $row['Password'];
			}
	}

function trocaNick($antigoNick,$novoNick, $usuario){
	$antigoNick = mysql_real_escape_string($antigoNick);
	$novoNick = mysql_real_escape_string($novoNick);
	$usuario = mysql_real_escape_string($usuario);

	$r = mysql_query("Update user set NickName = '$novoNick' where Id ='$usuario'");
	$r = mysql_query("Update game set NickName = '$novoNick' where Id ='$usuario'");
	$r = mysql_query("Update gunwcuser set NickName = '$novoNick' where Id ='$usuario'");
	$r = mysql_query("Update game set  Money = Money - 10000 where Id = '$usuario'");
	gravaLOGnew("altera_nick", "$usuario", $horario, "Troca de Nick Efetuada", "$antigoNick", "$novoNick", "", "", "Valor 350 xScores");
}

function trocaFoto($antigoFoto,$novoFoto, $usuario){
	$antigoFoto = mysql_real_escape_string($antigoFoto);
	$novoFoto = mysql_real_escape_string($novoFoto);
	$usuario = mysql_real_escape_string($usuario);

	$r = mysql_query("Update game set Foto = '$novoFoto' where Id ='$usuario'");
	gravaLOG("altera_foto", "$usuario", $horario, "$antigoFoto para $novoFoto");
}

function getGP($usuario){
	$usuario = mysql_real_escape_string($usuario);
	$r2 = mysql_query("SELECT TotalScore FROM game where Id='$usuario'" );
	$row = mysql_fetch_row($r2);
	return $row[0];
}

function getPaisByNum($num){
$num = mysql_real_escape_string($num);

$r2 = mysql_query("SELECT Country_Name FROM country_reference where Country_Count='$num'");
$row = mysql_fetch_row($r2);
return $row[0];

}

function getPais($usuario){
	$usuario = mysql_real_escape_string($usuario);
	$r2 = mysql_query("SELECT Country FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	$pais = $row[0]; 
	
	$r2 = mysql_query("SELECT Country_Name FROM country_reference where Country_Count='$pais'");
	$row = mysql_fetch_row($r2);
	return $row[0];
	}
	
	function getPaisId($usuario){
	$usuario = mysql_real_escape_string($usuario);
	$r2 = mysql_query("SELECT Country FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row['Country'];
	}

function getGold($usuario){
	$usuario = mysql_real_escape_string($usuario);
	$r2 = mysql_query("SELECT Money FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}

function getCash($usuario){
	$usuario = mysql_real_escape_string($usuario);
	$r2 = mysql_query("SELECT cash FROM cash where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}

function getPontos($usuario){
	$usuario = mysql_real_escape_string($usuario);
	$r2 = mysql_query("SELECT EventScore0 FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}

function getCoin($usuario){
	$usuario = mysql_real_escape_string($usuario);
	$r2 = mysql_query("SELECT Credito FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}
function getxScore($usuario){
	$usuario = mysql_real_escape_string($usuario);
	$r2 = mysql_query("SELECT xscore FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}

function getImgLevel($usuario){
$r2 = mysql_query("SELECT TotalGrade FROM game where Id='$usuario'");
$row = mysql_fetch_row($r2);
return "<img src=\"ranks/rank_" . $row[0] . ".gif\" width=\"25\" height=\"15\" border=\"0\">" ;
}

function getLevel($usuario){
$r2 = mysql_query("SELECT CountryGrade FROM game where Id='$usuario'");
$row = mysql_fetch_row($r2);
return "<img src=\"ranks/rank_" . $row[0] . ".gif\" width=\"25\" height=\"15\" border=\"0\">" ;
}
function getLevel2($usuario){
$r2 = mysql_query("SELECT CountryGrade FROM game where Id='$usuario'");
$row = mysql_fetch_row($r2);
return "<img src=\"../ranks/rank_" . $row[0] . ".gif\" width=\"25\" height=\"15\" border=\"0\">" ;
}
function getLevelNum($usuario){
$r2 = mysql_query("SELECT CountryGrade FROM game where Id='$usuario'");
$row = mysql_fetch_row($r2);
return $row[0];
}

function isBanned($usuario)
{
	$sql = mysql_query("select Authority from gunwcuser where Id='$usuario'");
	$r = mysql_fetch_array($sql);
	if($r[0] == '-100')
	{
		return true;
	}else{
		return false;
	}
}

function getPontoEvento($usuario){
	$r2 = mysql_query("SELECT EventScore0 FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}

function trocaPontos($pontos, $usuario){
	$r2 = mysql_query("UPDATE game set EventScore0 = EventScore0 - $pontos where Id='$usuario'");
	$pontos = $pontos * 120;
	$r3 = mysql_query("Update cash set  cash = cash + $pontos where Id = '$usuario'");
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

function getNick($usuario){
	$usuario = addslashes($usuario);
	$r2 = mysql_query("SELECT NickName FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}

function getFoto($usuario){
	$usuario = addslashes($usuario);
	$r2 = mysql_query("SELECT Foto FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}

function debitaGold($gold,$usuario){
$gold = mysql_real_escape_string($gold);
$usuario = mysql_real_escape_string($usuario);

$r3 = mysql_query("Update game set Money = Money - $gold where Id='$usuario'");

}

function debitaCash($cash,$usuario){
$cash = mysql_real_escape_string($cash);
$usuario = mysql_real_escape_string($usuario);
$r3 = mysql_query("Update cash set  cash = cash - $cash where Id = '$usuario'");
}

function debitaPontos($pontos,$usuario){
$pontos = mysql_real_escape_string($pontos);
$usuario = mysql_real_escape_string($usuario);
$r3 = mysql_query("Update game set  EventScore0 = EventScore0 - $pontos where Id = '$usuario'");
}
function debitaxScore($xscore,$usuario){
$xscore = mysql_real_escape_string($xscore);
$usuario = mysql_real_escape_string($usuario);
$r3 = mysql_query("Update game set xscore = xscore - $xscore where Id = '$usuario'");
}

function debitaCoin($credito,$usuario){
$credito = mysql_real_escape_string($credito);
$usuario = mysql_real_escape_string($usuario);
$r3 = mysql_query("Update game set  Credito = Credito - $credito where Id = '$usuario'");
}

function getRank($usuario){
	$usuario = addslashes($usuario);
	$r2 = mysql_query("SELECT TotalRank FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}
function getRankSemanal($usuario){
	$usuario = addslashes($usuario);
	$r2 = mysql_query("SELECT SeasonRank FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}
function getGPSemanal($usuario){
	$usuario = addslashes($usuario);
	$r2 = mysql_query("SELECT SeasonScore FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}

function getGuild($usuario){
$usuario = addslashes($usuario);
$r2 = mysql_query("SELECT Guild FROM game where Id='$usuario'");
$row = mysql_fetch_row($r2);
return $row[0];
}
function redirecionar($url, $tempo)
{
    $url = str_replace('&amp;', '&', $url);
    if($tempo > 0)
    {
       header("Refresh: $tempo; URL=$url");
    }
    else
    {
        @ob_flush();
        @ob_end_clean();
        header("Location: $url");
        exit;
    }
}
function existeGuild($guild){
$guild = mysql_real_escape_string(strtoupper($guild));

$r2 = mysql_query("SELECT Id FROM game where upper(Guild)='$guild'");
if (mysql_affected_rows() > 0){
	return true;
} else 
	{
return false;
}
}

function criarClan($clan, $descricao, $requerimento, $site,$dono,$foto){
$clan = mysql_real_escape_string($clan);
$descricao = mysql_real_escape_string($descricao);
$requerimento = mysql_real_escape_string($requerimento);
$site = mysql_real_escape_string($site);
$dono = mysql_real_escape_string($dono);
$foto = mysql_real_escape_string($foto);


$r2 = mysql_query("Update game set Guild='$clan', MemberCount='1' where Id='$dono'");
$r1 = mysql_query("Insert into guildweb (guild,G_Master,Descripcion,Requerimientos,WebSite,foto) values ('$clan','$dono','$descricao','$requerimento','$site','$foto');");

debitaGold(30000,$dono);
}

?>