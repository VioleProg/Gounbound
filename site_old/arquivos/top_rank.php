<?php

# Requere a página onde está a função #
require_once("blockpage.php");
# Chama funcao #
checapagina( basename(__FILE__) );
# Sql #
$sql = "SELECT NickName, TotalRank, TotalScore, TotalGrade, CountryGrade ,NoRankUpdate from game order by TotalRank LIMIT 0,5";
$r = mysql_query($sql, $link);
$i = $inicial;
print "<table border=\"0\" width=\"0\">";

while ($row = mysql_fetch_array($r))

	{
$i++;
  if ($row['CountryGrade'] == 20){
    }
  
  elseif($row['NoRankUpdate'] == 1) {
  
		} else {
			echo "<td width=\"10\" align=\"rigth\"><img src=\"ranks/" . $i . ".gif\" width=\"10\" height=\"9\" border=\"0\"></td>
			</td>";
			echo "<td align=\"left\">" . "<img src=\"ranks/level_" . $row['CountryGrade'] . ".jpg\" width=\"12\" height=\"12\" border=\"0\">" . "</td>\n";
			if ($row['TotalGrade'] == -5) {
				echo "<td align=\"left\" ><span style=\"font color:#333333\"><b><span>" . $row['NickName'] . "</span>\n";
				echo "<td align=\"left\">" . "<img src=\"ranks/level_" . $row['TotalGrade'] . ".png\" width=\"12\" height=\"12\" border=\"0\">" . "</td>\n";
			} else {
				echo "<td align=\"left\" ><span style=\"font color:#333333\"><b><span>" . $row['NickName'] . "</span>\n";
			}
			
				echo "</span></td>\n";
				echo "</tr>\n";
		}
      	}
	
?>
</table>