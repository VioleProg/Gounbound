<?php
include "_inc/barra/inc/includes.php";

/******************************************************
            [ Dados para mostrar na barra ]
 ******************************************************/

$nick      =  substr(trim($id), 0);
$gold      = 'GOLD: '.substr(trim($money), 0);
$rank      = 'RANK: '.substr(trim($ranktotal), 0);
$guild     = 'GUILD: '.substr(trim($clan), 0);
$gr        =  substr(trim($clan_r), 0);
$mc        =  substr(trim($clan_mc), 0);
$pais      = 'PAЭS: '.substr(trim(getcountry($country)), 0);
$gp        = 'GP: '.substr(trim($score), 0);
$cash      = 'CASH: '.substr(trim($cash1), 0);
$gcoin     = 'Moedas-G: '.substr(trim($credito), 0);
$status2   = ($status != 1 ? 'ONLINE' : 'OFFLINE');
$status3   = 'Status: ';
$website   = 'http://gbrasil.hopto.org/sig/'.$nick;


/*******************************************************************************
[Se o player nуo estiver em uma guild, aparece a mensagem: Sem Guild na imagem ]
 *******************************************************************************/
if ($guild == '') { $guild = 'Guild: Sem Guild';}

/****************************************************************
[ Configuraчуo e localizaчуo das informaчѕes que serуo escritas ]
 ****************************************************************/

ImageTTFText($gd, 7, 0, 34, 18, $branco, $fnt2, $nick); //Escreve o nick do player
ImageTTFText($gd, 7, 0, 5, 30, $branco, $fnt2, $rank); //Mostra o Ranking do player
ImageTTFText($gd, 7, 0, 5, 40, $branco, $fnt2, $gp); //Mostra o GP do player
ImageTTFText($gd, 7, 0, 5, 50, $branco, $fnt2, $guild.' ['.$gr.'/'.$mc.']'); //Mostra a guild do player
ImageTTFText($gd, 7, 0, 3, 62, $branco, $fnt2, $website); //Mostra o Website

ImageTTFText($gd, 8, 0, 134, 24, $cor_status, $fnt2, $status2); //Mostra o Cash do player


/*
ImageTTFText($gd, 7, 0, 114, 40, $branco, $fnt2, $gcoin); //Mostra o Cash do player
ImageTTFText($gd, 7, 0, 230, 16, $branco, $fnt2, $gold); //Mostra o gold do player
ImageTTFText($gd, 7, 0, 114, 50, $branco, $fnt2, $cash); //Mostra o Cash do player
ImageTTFText($gd, 7, 0, 400, 8, $branco, $fnt2, $pais); //Mostra o Pсis do player
ImageTTFText($gd, 7, 0, 9900, 2400, $branco, $fnt2, $status3); //Mostra o Cash do player
ImageTTFText($gd, 8, 0, 134, 24, $cor_status, $fnt2, $status2); //Mostra o Cash do player
*/

header('Content-Type: image/jpeg');
imagejpeg($gd);
imagedestroy ($gd);

?>