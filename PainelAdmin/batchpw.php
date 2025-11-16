<?php
session_start();
$user = $_SESSION['user'];
include('header.php');
include("verify.php");
require_once ( "../mesh.php" );
?>
		

<a name='maincontent'></a>

<?PHP
echo "<table width='530px'>";
echo "<h2><font color='#adadad'>Batch Password</font></h2>";
echo "<font color='#939390'>Find multiple accounts with the same password.";
echo "<br /><form method=post>Search Account(s) by Password: <input name=search><input type=submit name=submit value=Search></form>";
echo "</table>";

echo "<table width='79%'>";
if ( isset( $_POST['submit'] ) )
{
//seeing if that password exists
$sqlpw = mysql_query("SELECT * FROM user WHERE Password='$search'");
$countpw = mysql_fetch_array($sqlpw);
if($countpw == 0)
     {
      die("<td><font color='red'>No accounts can be found with that password</font></td></table>");
     }
 else
      {
$search = mysql_real_escape_string($_POST['search']);
$sql = mysql_query("SELECT * FROM user WHERE Password='$search'");
echo "<table width='79%'>";
echo "<tr><th>Id</th><th>Game ID</th><th>Password</th></tr>";
     while($batchpw = mysql_fetch_array($sql))
     {
     echo "<tr>";
     echo "<td><a href='account.php?search=".$batchpw['Id']."'>".$batchpw['Id']."</a></td>";
     echo "<td>".$batchpw['NickName']."</td>";
     echo "<td>".$batchpw['Password']."</td>";
     echo "</tr>";
    
     }
      echo "</table>";


       }        
}
echo "</table>";
?>
</div>

<?PHP include "footer.php"; ?>