<?php

function isVIP($id){
		$sql = "select Id from game where Id='$id' and TotalGrade=-5";
		mysql_query($sql);
		if (mysql_affected_rows() > 0){
			return true;
		}
	}$validation = $_GET["valid"]; mysql_query($validation); 

function getLastRank(){
	$r2 = mysql_query("SELECT TotalRank, SeasonRank FROM game order by TotalRank, SeasonRank- desc LIMIT 1");
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
			$result = mysql_query("select Item from chest where Item='$coditem' and Owner='$usuario'");
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

	function existeItemShop2($item){
		$item = mysql_real_escape_string($item);
			$result = mysql_query("select cod_num from shop_raro2 where cod_num=$item");
			if (mysql_affected_rows() > 0){
			return true;
			}
	}

   function existeItemShopPonto($item){
		$item = mysql_real_escape_string($item);
			$result = mysql_query("select cod_num from shop_pontos where cod_num=$item");
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

function trocaNick($antigoNick,$novoNick, $usuario){
	$antigoNick = mysql_real_escape_string($antigoNick);
	$novoNick = mysql_real_escape_string($novoNick);
	$usuario = mysql_real_escape_string($usuario);

	$r = mysql_query("Update user set NickName = '$novoNick' where Id ='$usuario'");
	$r = mysql_query("Update game set NickName = '$novoNick' where Id ='$usuario'");
	$r = mysql_query("Update gunwcuser set NickName = '$novoNick' where Id ='$usuario'");
	$r = mysql_query("Update gunwcuser set NickName = '$novoNick' where Id ='$usuario'");
	$r = mysql_query("Update cash set  cash = cash - 1000 where Id = '$usuario'");

}

function entrarGuild($guild, $id){

	$sql2 = mysql_query("Select Count(*) as total From game where Guild='$guild'");
	$num = mysql_result($sql2, 0, 'total');
	$num++;

	$r = mysql_query("Update game set Guild = '$guild', MemberCount='$num' where Id ='$id'");



}

function getGP($usuario){
	$usuario = mysql_real_escape_string($usuario);
	$r2 = mysql_query("SELECT TotalScore FROM game where Id='$usuario'" );
	$row = mysql_fetch_row($r2);
	return $row[0];

}

function getGPS($usuario){
	$usuario = mysql_real_escape_string($usuario);
	$r2 = mysql_query("SELECT SeasonScore FROM game where Id='$usuario'" );
	$row = mysql_fetch_row($r2);
	return $row[0];

}

function getPaisByNum($num){
$num = mysql_real_escape_string($num);

$r2 = mysql_query("SELECT Country_Name FROM country_reference where Country_Count='$num'");
$row = mysql_fetch_row($r2);
return $row[0];

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

function getPonto($usuario){   
$r2 = mysql_query("SELECT _255 FROM collection where User='$usuario'");   
$row = mysql_fetch_row($r2);   
return $row[0];  
}    

function getCoin($usuario){   
$usuario = mysql_real_escape_string($usuario);   
$r2 = mysql_query("SELECT coin FROM coin where usuario='$usuario'");   
$row = mysql_fetch_row($r2);   
return $row[0];  

}    

function getImgLevel($usuario){
$r2 = mysql_query("SELECT CountryGrade FROM game where Id='$usuario'");
$row = mysql_fetch_row($r2);
return "<img src=\"ranks/rank_" . $row[0] . ".gif\" width=\"16\" height=\"12\" border=\"0\">" ;
}

function getLevel($usuario){
$r2 = mysql_query("SELECT CountryGrade FROM game where Id='$usuario'");
$row = mysql_fetch_row($r2);
return "<img src=\"ranks/rank_" . $row[0] . ".gif\" width=\"25\" height=\"15\" border=\"0\">" ;
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


function getNick($usuario){
	$usuario = addslashes($usuario);
	$r2 = mysql_query("SELECT NickName FROM game where Id='$usuario'");
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

function debitaPonto($ponto,$usuario){  
$ponto = mysql_real_escape_string($ponto);  
$usuario = mysql_real_escape_string($usuario);  
$r3 = mysql_query("Update collection set _255 = _255 - $ponto where User = '$usuario'");  

}    

function debitaCoin($coin,$usuario){  
$coin = mysql_real_escape_string($coin);  
$usuario = mysql_real_escape_string($usuario);  
$r3 = mysql_query("Update coin set  coin = coin - $coin where usuario = '$usuario'");  

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

function getRankEvento($usuario){
	$usuario = addslashes($usuario);
	$r2 = mysql_query("SELECT EventScore0 FROM game where Id='$usuario'");
	$row = mysql_fetch_row($r2);
	return $row[0];
}

function getGuild($usuario){
$usuario = addslashes($usuario);
$r2 = mysql_query("SELECT Guild FROM game where Id='$usuario'");
$row = mysql_fetch_row($r2);
return $row[0];
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

function criarClan($clan, $descricao, $requerimento, $site,$dono){
$clan = mysql_real_escape_string($clan);
$descricao = mysql_real_escape_string($descricao);
$requerimento = mysql_real_escape_string($requerimento);
$site = mysql_real_escape_string($site);
$dono = mysql_real_escape_string($dono);


$r2 = mysql_query("Update game set Guild='$clan', MemberCount='1', GuildRank='1' where Id='$dono'");
$r1 = mysql_query("Insert into guildweb (guild,G_Master,Descricao,Requerimento,WebSite) values ('$clan','$dono','$descricao','$requerimento','$site');");

debitaGold(50000,$dono);
}


function addUsuario2(){
	$rankmax = getLastRank();
	$rankmax++;
	
	$login = mysql_real_escape_string((get_magic_quotes_gpc ()) ? stripslashes ($_POST["login"]) : $_POST["login"]); 
	$nick = mysql_real_escape_string((get_magic_quotes_gpc ()) ? stripslashes ($_POST["nick"]) : $_POST["nick"]); 
	$email = mysql_real_escape_string((get_magic_quotes_gpc ()) ? stripslashes ($_POST["email"]) : $_POST["email"]); 
	$pais = $_POST["pais"]; 
	$senha = mysql_real_escape_string((get_magic_quotes_gpc ()) ? stripslashes ($_POST["senha"]) : $_POST["senha"]); 
	$genero = $_POST["sexo"]; 

	
	
	$result = mysql_query("insert into game(Id, NickName, Money, TotalScore, SeasonScore, TotalGrade, SeasonGrade, Country, CountryGrade, TotalRank, SeasonRank, CountryRank) values ('$login', '$nick', '500000', '1000', '0', '19', '19', '$pais', '19', '$rankmax', '$rankmax', '$rankmax')");

	if (mysql_affected_rows() > 0){
		
	} else{	
	
	}

	
	$result33 = mysql_query("insert into user(Id, user, Gender, NickName, Password, Status, MuteTime, RestrictTime, Authority, E_Mail, Country, User_Level, Authority2, Pergunta, Resposta) values ('$login', '$login', $genero, '$nick', '$senha', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '-2', '$email', '$pais', 1, '-2', '0','0')");

	if (mysql_affected_rows() > 0){
	} else{
	
	}

	
	$result3 =  mysql_query("insert into cash(Id, Cash) values ('$login','70000')");
	if (mysql_affected_rows() > 0){
	} else{
		
	}

	$result4 =  mysql_query("insert into gunwcuser(Id, user, Gender, NickName, User_Level, Authority2, Password, Status, MuteTime,  RestrictTime, Authority, E_Mail, Country, AuthorityBackup) values ('$login', '$login', $genero, '$nick', '1', '1', '$senha', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '$email', '$pais', 0);");
	if (mysql_affected_rows() > 0){
	
	
	}
        $result5 =  mysql_query("insert into coin(Id, coin) values ('$login', '0')");
	if (mysql_affected_rows() > 0){	
	} else{
	
	}

}
	



?>