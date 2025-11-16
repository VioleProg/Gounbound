<?PHP

function updaterank() {
   global $db;
     $updrank = $db->Execute("SELECT Id, TotalScore FROM game ORDER BY 'TotalScore' DESC");
     $rank = 0;
     foreach ($updrank->GetArray() as $r => $rankinfo) {
          $rank++;
          $db->Execute("UPDATE game SET TotalRank=? WHERE Id = ?", array($rank,$rankinfo['Id']));
     }
}

function updategrade() {
   global $db;

                    $db->Execute("UPDATE game SET TotalGrade='19' WHERE SeasonScore >= 0 and SeasonScore <= 1050 and TotalGrade != 19 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='18' WHERE TotalRank >= 1696 and TotalRank <= 1815  and TotalGrade !=18 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='17' WHERE TotalRank >= 1583 and TotalRank <= 1695 and TotalGrade !=17 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='16' WHERE TotalRank >= 1463 and TotalRank <= 1582 and TotalGrade !=16 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='15' WHERE TotalRank >= 1357 and TotalRank <= 1462 and TotalGrade !=15 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='14' WHERE TotalRank >= 1231 and TotalRank <= 1356 and TotalGrade !=14 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='13' WHERE TotalRank >= 1121 and TotalRank <= 1230 and TotalGrade !=13 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='12' WHERE TotalRank >= 1011 and TotalRank <= 1120 and TotalGrade !=12 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='11' WHERE TotalRank >= 900 and TotalRank <= 1010 and TotalGrade !=11 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='10' WHERE TotalRank >= 791 and TotalRank <= 899 and TotalGrade !=10 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='9' WHERE TotalRank >= 681 and TotalRank <= 790 and TotalGrade !=9 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='8' WHERE TotalRank >= 561 and TotalRank <= 680 and TotalGrade !=8 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='7' WHERE TotalRank >= 451 and TotalRank <= 560 and TotalGrade !=7 and  NoRankUpdate = 0");
             
		    $db->Execute("UPDATE game SET TotalGrade='6' WHERE TotalRank >= 382 and TotalRank <= 450 and TotalGrade !=6 and  NoRankUpdate = 0");                    
                     
                    $db->Execute("UPDATE game SET TotalGrade='5' WHERE TotalRank >= 331 and TotalRank <= 381 and TotalGrade !=5 and  NoRankUpdate = 0");         
               
                    $db->Execute("UPDATE game SET TotalGrade='4' WHERE TotalRank >= 280 and TotalRank <= 330 and TotalGrade != 4 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='3' WHERE TotalRank >= 229 and TotalRank <= 279 and TotalGrade !=3 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='2' WHERE TotalRank >= 178 and TotalRank <= 228 and TotalGrade !=2 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='1' WHERE TotalRank >= 127 and TotalRank <= 177 and TotalGrade !=1 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='0' WHERE TotalRank >= 76 and TotalRank <= 126 and TotalGrade !=0 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='-1' WHERE TotalRank >= 23 and TotalRank <= 75 and TotalGrade !=-1 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='-2' WHERE TotalRank >= 6 and TotalRank <= 22 and TotalGrade !=-2 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='-3' WHERE Totalrank >= 2 and TotalRank <= 5 and TotalGrade !=-3 and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET TotalGrade='-4' WHERE TotalRank >= 1 and TotalRank <= 1 and TotalGrade !=-4 and  NoRankUpdate = 0");

            
}

updaterank();
updategrade();
echo 'Manutencao Realizada <br> Redirecionando em 2 segundos';
header('Refresh: 1; url=atusemanal.jsp');
?> 