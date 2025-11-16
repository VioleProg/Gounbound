<?php
/******************************************************
            [ Pega os dados da Tabela GAME ]
 ******************************************************/

$img = mysql_query("SELECT * FROM game WHERE NickName='$id'");
while ($inf = mysql_fetch_array($img)) {
$money = $inf['Money'];
$ranktotal = $inf['TotalRank'];
$clan = $inf['Guild'];
$score = $inf['TotalScore'];
$grade = $inf['TotalGrade'];
$country = $inf['Country'];
$clan_r = $inf['GuildRank'];
$clan_mc = $inf['MemberCount'];
}

//Pega os dados da Tabela CASH
$img2 = mysql_query("SELECT * FROM cash WHERE NickName='$id'");
while ($inf1 = mysql_fetch_array($img2)) {
$cash1  = $inf1['Cash'];
}

//Pega os dados da Tabela CREDITOS
$img3 = mysql_query("SELECT * FROM credito WHERE NickName='$id'");
while ($inf = mysql_fetch_array($img3)) {
$credito  = $inf['Credito'];
}

//Pega os dados da Tabela USER
$img4 = mysql_query("SELECT * FROM user WHERE NickName='$id'");
while ($inf = mysql_fetch_array($img4)) {
$status  = $inf['Status'];
}
?>