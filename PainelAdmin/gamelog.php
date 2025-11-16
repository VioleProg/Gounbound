<?php
session_start();
$user = $_SESSION['user'];
include('header.php');
include("verify.php");
require_once ( "../mesh.php" );
?>
		

<a name='maincontent'></a>
<?php
echo "<table width='70%'><tr><td>";
$userspace = array(0,1,2,3,4,5,6,7);

if(mysql_real_escape_string($_GET["id"])){
$append = "WHERE `S0_ID`='".mysql_real_escape_string($_GET["id"])."'
 OR `S1_ID`='".mysql_real_escape_string($_GET["id"])."'
  OR `S2_ID`='".mysql_real_escape_string($_GET["id"])."'
   OR `S3_ID`='".mysql_real_escape_string($_GET["id"])."'
    OR `S4_ID`='".mysql_real_escape_string($_GET["id"])."'
     OR `S5_ID`='".mysql_real_escape_string($_GET["id"])."'
      OR `S6_ID`='".mysql_real_escape_string($_GET["id"])."'
       OR `S7_ID`='".mysql_real_escape_string($_GET["id"])."'";

}

$page = mysql_real_escape_string($_GET["page"]) * 50;
$pagination = mysql_real_escape_string($_GET["page"]);
$next = $pagination + 1;
$prev = $pagination - 1;

echo "<a href='?id={$_GET["id"]}&page=$prev'>Previous Page</a> || <a href='?id={$_GET["id"]}&page=$next'>Next Page</a> || <a href='gamelog.php'>Game Log Index</a><br />
<font color='red'><b>Quick Note:</b></font>: All times highlighted in <font color='red'>RED</font> are QUICKGAMES that lasted under 30 seconds. Please look into them."; 

echo "<form method=get>Search by LOGIN ID: <input name=id><input type=submit></form>";


$sql = mysql_query("SELECT * FROM `playlog` $append ORDER BY `StartTime` DESC LIMIT $page,50");
echo "<table width='100%' bgcolor='#666666' border=0 cellspacing=1px><tr><td>";
while($sqlly = mysql_fetch_array($sql)){
$tablenum++;
$gametype = array(25266 => "Solo", 1335986 => "Score", 549554 => "Tag", 811698 => "Jewel", 0 => "Unknown");
$duration = strtotime($sqlly["EndTime"]) - strtotime($sqlly["StartTime"]);
 
$winningteam = $sqlly["WinTeamOrPlayer"];


if($tablenum & 1){
$tbgco = "#CCCCCC";
} else {
$tbgco = "#EEEEEE";
}
if($duration<30){ $dcolor = "red"; $fcolor="white"; } else { $dcolor=$tbgco; $fcolor="black"; }




echo "<tr bgcolor='$tbgco'><td>{$sqlly["GameRoomID"]}</td><td>{$sqlly["StartTime"]}</td><td bgcolor='$dcolor'><font color='$fcolor'><b>" . date("i:s", $duration) . "</b></font></td><td>{$sqlly["GameRoomTitle"]}</td></tr>
<tr><td bgcolor='#888888'>&nbsp;</td><td bgcolor='$tbgco' colspan=3>
<table cellspacing=1px><tr bgcolor='$tbgco'><td width=50%>";
//Team A
foreach($userspace as $x){
$team = 0;
if($sqlly["S{$x}_TeamID"] == $team){
if($sqlly["S{$x}_TeamID"] == $winningteam){ $color = "green"; } else { $color = "red"; }
if($sqlly["S{$x}_ID"]) {
if($count[$team]){
echo "<hr noshade>";
}
$sql2 = mysql_query("SELECT * FROM `game` WHERE `Id`='".$sqlly["S{$x}_ID"]."'");
$sqlly2 = mysql_fetch_array($sql2);
echo "<img src='/images/rank/s/{$sqlly2["TotalGrade"]}.png'> <a href='account.php?search={$sqlly2["Id"]}'><font color='{$color}'><b>{$sqlly["S{$x}_ID"]}</a></b></font><br>(<font color='blue'>{$sqlly["S{$x}_ScoreDelta"]}GP</font>/<b><font color='orange'>{$sqlly["S{$x}_MoneyDelta"]}GOLD</b></font>)";
if($sqlly["S{$x}_DeadCause"] == 19){ echo " <b><font color=red><i>SUICIDE</i></font></b>";}
$count[$team]++;
}
} else {
//Display nothing at all. LEAVE BLANK.
}

}
echo "</td>
<td width=100%>";
//Team B
foreach($userspace as $x){
$team = 1;
if($sqlly["S{$x}_TeamID"] == $team){
if($sqlly["S{$x}_TeamID"] == $winningteam){ $color = "green"; } else { $color = "red"; }
if($sqlly["S{$x}_ID"]) {
if($count[$team]){
echo "<hr noshade>";
}
$sql2 = mysql_query("SELECT * FROM `game` WHERE `Id`='".$sqlly["S{$x}_ID"]."'");
$sqlly2 = mysql_fetch_array($sql2);
echo "<img src='/images/rank/s/{$sqlly2["TotalGrade"]}.png'> <a href='account.php?search={$sqlly2["Id"]}'><font color='{$color}'><b>{$sqlly["S{$x}_ID"]}</a></b></font><br>(<font color='blue'>{$sqlly["S{$x}_ScoreDelta"]}GP</font>/<b><font color='orange'>{$sqlly["S{$x}_MoneyDelta"]}GOLD</b></font>)";
if($sqlly["S{$x}_DeadCause"] == 19){ echo " <b><font color=red><i>SUICIDE</i></font></b>";}
$count[$team]++;
}
} else {
//Display nothing at all. LEAVE BLANK.
}

}
$count[0] = 0; $count[1] = 0;
echo "</td></tr></table>";

}


echo"</td></tr></table>

</td></tr></table>";
?>
			</div>

<?PHP include "footer.php" ?>


