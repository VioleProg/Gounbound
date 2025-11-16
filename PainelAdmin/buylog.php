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
$search = "WHERE `Id`='".mysql_real_escape_string($_GET["Id"])."'"; }
$page = mysql_real_escape_string($_GET["page"]) * 50;
$pagination = mysql_real_escape_string($_GET["page"]);
$next = $pagination + 1;
$prev = $pagination - 1;
echo "<table width='79%'>";
echo "<h2><font color='#adadad'>Purchased Avatars</font></h2>";
echo "<a href='?Id={$_GET["Id"]}&page=$prev'>Previous Page</a> || <a href='?Id={$_GET["Id"]}&page=$next'>Next Page</a>  || <a href='buylog.php'>Buy Log Index</a>";
echo "<br /><form method=get>Search by LOGIN ID: <input name=Id><input type=submit></form>";
                    $getBought = mysql_query("SELECT * FROM `receiptbuy` $search ORDER BY `Time`  DESC LIMIT $page,50");
                    echo "<tr>";
                    echo "
                    <th>Id:</th>
                    <th>Time:</th>
                    <th>Avatar:</th>
                    <th>Gold:</th>
                    <th>Cash:</th>
                    <th>Duration:</th>
                    </tr>";

             while($rowBought = mysql_fetch_array( $getBought ))
             {
             $getname = mysql_query("SELECT * FROM menu WHERE Item1='".$rowBought['MenuId']."'") or die(mysql_error());
             $getnamey = mysql_fetch_assoc($getname);
             echo "<tr>";
             echo "<td>".$rowBought['Id']."</td>";
             echo "<td>".$rowBought['Time']."</td>";
             echo "<td>".$getnamey['Menu_Name']."</td>";
             echo "<td>".$rowBought['GoldChecked']."</td>";
             echo "<td>".$rowBought['CashChecked']."</td>";
             if($rowBought['ExpireType'] == 'M')
             echo "<td>Month</td>";
             if($rowBought['ExpireType'] == 'W')
             echo "<td>Week</td>";
             if($rowBought['ExpireType'] == 'I')
             echo "<td>Unlimited</td>";
             echo "</tr>";
             }
             echo "</table>";
?>
</div>

<?PHP include "footer.php" ?>