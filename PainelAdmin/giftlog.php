<?php
session_start();
$user = $_SESSION['user'];
include('header.php');
include("verify.php");
require_once ( "../mesh.php" );
?>
		

<a name='maincontent'></a>
<?PHP 
if(mysql_real_escape_string($_GET["Id"])){
$search = "WHERE `Id`='".mysql_real_escape_string($_GET["Id"])."' OR `Receiver`='".mysql_real_escape_string($_GET["Id"])."'"; }
$page = mysql_real_escape_string($_GET["page"]) * 50;
$pagination = mysql_real_escape_string($_GET["page"]);
$next = $pagination + 1;
$prev = $pagination - 1;
echo "<table width='79%'>";
echo "<h2><font color='#adadad'>Gifted Avatars</font></h2>";
echo "<a href='?Id={$_GET["Id"]}&page=$prev'>Previous Page</a> || <a href='?Id={$_GET["Id"]}&page=$next'>Next Page</a> || <a href='giftlog.php'>Gift Log Index</a>";
echo "<br /><form method=get>Search by Sender Login ID or Receiver Login ID: <input name=Id><input type=submit></form>";
                

                  $getSell = mysql_query("SELECT * FROM `receiptgift` $search ORDER BY `Time`  DESC LIMIT $page,50");
                   
                    echo "<tr>";
                    echo "
                    <th>Sender</th>
                    <th>Avatar</th>
                    <th>Receiver (LoginID):</th>
                    <th>Receiver (GameID)</th>
                    <th>Time:</th>
                    <th>Confirm Time:</th>
                    <th>Duration: </th>
                    </tr>";

             while($rowSell = mysql_fetch_array( $getSell ))
             {
             $getname = mysql_query("SELECT * FROM menu WHERE Item1='".$rowSell['MenuId']."'") or die(mysql_error());
             $getnamey = mysql_fetch_assoc($getname);
             echo "<tr>";
             echo "<td>".$rowSell['Id']."</td>";
             echo "<td>".$getnamey['Menu_Name']."</td>";
             echo "<td>".$rowSell['Receiver']."</td>";
             echo "<td>".$rowSell['ReceiverNick']."</td>";
             echo "<td>".$rowSell['Time']."</td>";
            echo "<td>".$rowSell['ConfirmTime']."</td>";
            if($rowSell['ExpireType'] == 'M')
             echo "<td>Month</td>";
             if($rowSell['ExpireType'] == 'W')
             echo "<td>Week</td>";
             if($rowSell['ExpireType'] == 'I')
             echo "<td>Unlimited</td>";
             echo "</tr>";
             }
             echo "</table>";
?>

<?PHP include "footer.php" ?>