<?php
// verify.php já é incluído em header.php
include('header.php');
require_once("../mesh.php");
include("../includes/rank_functions.php");
?>

<div id="main">
<a name='maincontent'></a>
<?php
echo "<h1>Log de Jogadas</h1>";
echo "<table width='70%'><tr><td>";
$userspace = array(0,1,2,3,4,5,6,7);

$append = "";
if(isset($_GET["id"]) && !empty($_GET["id"])){
    $user_id_search = mysql_real_escape_string($_GET["id"]);
    $append = "WHERE `S0_ID`='$user_id_search'
     OR `S1_ID`='$user_id_search'
      OR `S2_ID`='$user_id_search'
       OR `S3_ID`='$user_id_search'
        OR `S4_ID`='$user_id_search'
         OR `S5_ID`='$user_id_search'
          OR `S6_ID`='$user_id_search'
           OR `S7_ID`='$user_id_search'";
}

$page = isset($_GET["page"]) ? (int)$_GET["page"] : 0;
$page_offset = $page * 50;
$next = $page + 1;
$prev = max(0, $page - 1);
$user_id_param = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : '';

echo "<a href='?id=$user_id_param&page=$prev'>Página Anterior</a> || <a href='?id=$user_id_param&page=$next'>Próxima Página</a> || <a href='gamelog.php'>Índice do Log de Jogadas</a><br />
<hr>";
echo "<font color='red'><b>Nota Rápida:</b></font>: Todos os tempos destacados em <font color='red'>VERMELHO</font> são QUICKGAMES que duraram menos de 30 segundos. Por favor, verifique-os.<br><br>";
echo "<form method=get>Pesquisar por ID de LOGIN: <input name=id value='$user_id_param'><input type=submit value='Pesquisar'></form>";
echo "</td></tr></table>";

$sql = mysql_query("SELECT * FROM `playlog` $append ORDER BY `StartTime` DESC LIMIT $page_offset,50");
echo "<table width='100%' bgcolor='#666666' border=0 cellspacing=1px><tr><td>";
$tablenum = 0;
$count = array(0 => 0, 1 => 0);

while($sqlly = mysql_fetch_array($sql)){
    $tablenum++;
    $gametype = array(25266 => "Solo", 1335986 => "Pontuação", 549554 => "Tag", 811698 => "Jóia", 0 => "Desconhecido");
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
    
    //Time A
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
                $grade_rank = $sqlly2["TotalGrade"] ?? -4;
                $rank_img = "../Assets/rank/" . getRankImageName($grade_rank);
                echo "<img src='$rank_img' style='width: 20px; height: 20px; vertical-align: middle;'> <a href='account.php?search={$sqlly["S{$x}_ID"]}'><font color='{$color}'><b>" . htmlspecialchars($sqlly["S{$x}_ID"]) . "</a></b></font><br>(<font color='blue'>{$sqlly["S{$x}_ScoreDelta"]}GP</font>/<b><font color='orange'>{$sqlly["S{$x}_MoneyDelta"]}GOLD</b></font>)";
                if($sqlly["S{$x}_DeadCause"] == 19){ echo " <b><font color=red><i>SUICÍDIO</i></font></b>";}
                $count[$team]++;
            }
        }
    }
    
    echo "</td>
    <td width=100%>";
    
    //Time B
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
                $grade_rank = $sqlly2["TotalGrade"] ?? -4;
                $rank_img = "../Assets/rank/" . getRankImageName($grade_rank);
                echo "<img src='$rank_img' style='width: 20px; height: 20px; vertical-align: middle;'> <a href='account.php?search={$sqlly["S{$x}_ID"]}'><font color='{$color}'><b>" . htmlspecialchars($sqlly["S{$x}_ID"]) . "</a></b></font><br>(<font color='blue'>{$sqlly["S{$x}_ScoreDelta"]}GP</font>/<b><font color='orange'>{$sqlly["S{$x}_MoneyDelta"]}GOLD</b></font>)";
                if($sqlly["S{$x}_DeadCause"] == 19){ echo " <b><font color=red><i>SUICÍDIO</i></font></b>";}
                $count[$team]++;
            }
        }
    }
    
    $count[0] = 0; 
    $count[1] = 0;
    echo "</td></tr></table>";
}

echo"</td></tr></table>

</td></tr></table>";

echo "<p style='margin-top: 20px;'><a href='admin_panel.php' class='button1'>Voltar ao Painel</a></p>";
?>
</div>

<?php include("footer.php"); ?>
