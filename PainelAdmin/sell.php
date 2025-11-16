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
echo "<h2><font color='#adadad'>Sold/Deleted Avatars</font></h2>";
echo "<a href='?Id={$_GET["Id"]}&page=$prev'>Previous Page</a> || <a href='?Id={$_GET["Id"]}&page=$next'>Next Page</a> || <a href='sell.php'>Sell Log Index</a>";
echo "<br /><form method=get>Search by LOGIN ID: <input name=Id><input type=submit></form>";
                  

                  $getSell = mysql_query("SELECT * FROM `receiptconsume` $search ORDER BY `Time`  DESC LIMIT $page,50");
                    echo "<tr>";
                    echo "
                    <th>Id:</th>
                    <th>Time:</th>
                    <th>Avatar:</th>
                    <th>Refund:</th>
                    </tr>";

             while($rowSell = mysql_fetch_array( $getSell ))
             {
             $getname = mysql_query("SELECT * FROM menu WHERE Item1='".$rowSell['Item']."'") or die(mysql_error());
             $getnamey = mysql_fetch_assoc($getname);
             echo "<tr>";
             echo "<td>".$rowSell['Id']."</td>";
             echo "<td>".$rowSell['Time']."</td>";
             echo "<td>".$getnamey['Menu_Name']."</td>";
             echo "<td>".$rowSell['Refund']."</td>";
             echo "</tr>";
             }
             echo "</table>";
?>
</div>

<?PHP include "footer.php" ?>