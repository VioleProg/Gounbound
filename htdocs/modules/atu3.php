<?PHP
function updateranksemanal() {
   global $db;
     $updrank = $db->Execute("SELECT Id, SeasonScore FROM game ORDER BY 'SeasonScore' DESC");
     $rank = 0;
     foreach ($updrank->GetArray() as $r => $rankinfo) {
          $rank++;
          $db->Execute("UPDATE game SET SeasonRank=? WHERE Id = ?", array($rank,$rankinfo['Id']));
     }
}

function updatesemanal() {
   global $db;
		    $db->Execute("UPDATE game SET SeasonGrade='19' WHERE SeasonScore >= 0 and SeasonScore <= 1050 and SeasonGrade !=19 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='18' WHERE TotalRank >= 1696 and TotalRank <= 1815 and SeasonGrade !=18 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='17' WHERE TotalRank >= 1583 and TotalRank <= 1695 and SeasonGrade !=17 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='16' WHERE TotalRank >= 1463 and TotalRank <= 1582 and SeasonGrade !=16 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='15' WHERE TotalRank >= 1357 and TotalRank <= 1462 and SeasonGrade !=15 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='14' WHERE TotalRank >= 1231 and TotalRank <= 1356 and SeasonGrade !=14 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='13' WHERE TotalRank >= 1121 and TotalRank <= 1230 and SeasonGrade !=13 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='12' WHERE TotalRank >= 1011 and TotalRank <= 1120 and SeasonGrade !=12 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='11' WHERE TotalRank >= 900 and TotalRank <= 1010 and SeasonGrade !=11 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='10' WHERE TotalRank >= 791 and TotalRank <= 899 and SeasonGrade !=10 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='9' WHERE TotalRank >= 681 and TotalRank <= 790 and SeasonGrade !=9 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='8' WHERE TotalRank >= 561 and TotalRank <= 680 and SeasonGrade !=8 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='7' WHERE TotalRank >= 451 and TotalRank <= 560 and SeasonGrade !=7 and  NoRankUpdate = 0");
             
		    $db->Execute("UPDATE game SET SeasonGrade='6' WHERE TotalRank >= 382 and TotalRank <= 450 and SeasonGrade !=6 and  NoRankUpdate = 0");   
					
	            $db->Execute("UPDATE game SET SeasonGrade='5' WHERE TotalRank >= 331 and TotalRank <= 381 and SeasonGrade !=5 and  NoRankUpdate = 0");                 
             
                    $db->Execute("UPDATE game SET SeasonGrade='4' WHERE TotalRank >= 280 and TotalRank <= 330 and SeasonGrade !=4 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='3' WHERE TotalRank >= 229 and TotalRank <= 279 and SeasonGrade !=3 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='2' WHERE TotalRank >= 178 and TotalRank <= 228 and SeasonGrade !=2 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='1' WHERE TotalRank >= 127 and TotalRank <= 177 and SeasonGrade !=1 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='0' WHERE TotalRank >= 76 and TotalRank <= 126 and SeasonGrade !=0 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='-1' WHERE TotalRank >= 23 and TotalRank <=75 and SeasonGrade !=-1 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='-2' WHERE TotalRank >= 6 and TotalRank <= 22 and SeasonGrade !=-2 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='-3' WHERE TotalRank >= 2 and TotalRank <= 5 and SeasonGrade !=-3 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET SeasonGrade='-4' WHERE TotalRank = 1 and TotalRank <= 1 and SeasonGrade  !=-4 and  NoRankUpdate = 0"); 
}

updateranksemanal();
updatesemanal();

echo 'Atualização de Ranking Semanal <br> Redirecionando em 2 segundos';
header('Refresh: 1; url=ranking.jsp');
?>