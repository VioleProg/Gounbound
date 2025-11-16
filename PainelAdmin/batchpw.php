<?php
// verify.php já é incluído em header.php
include('header.php');
require_once("../mesh.php");
?>

<a name='maincontent'></a>

<?php
echo "<table width='530px'>";
echo "<h2><font color='#adadad'>Batch Password</font></h2>";
echo "<font color='#939390'>Find multiple accounts with the same password.";
echo "<br /><form method=post>Search Account(s) by Password: <input name=search><input type=submit name=submit value=Search></form>";
echo "</table>";

echo "<table width='79%'>";
if (isset($_POST['submit'])) {
    $search = mysql_real_escape_string($_POST['search'] ?? '');
    
    if (empty($search)) {
        die("<td><font color='red'>Please enter a password to search</font></td></table>");
    }
    
    // Buscar em gunwcuser (tabela principal)
    $sqlpw = mysql_query("SELECT * FROM gunwcuser WHERE Password='$search'");
    $count = mysql_num_rows($sqlpw);
    
    if ($count == 0) {
        die("<td><font color='red'>No accounts can be found with that password</font></td></table>");
    } else {
        echo "<table width='79%'>";
        echo "<tr><th>Id</th><th>Username</th><th>Nickname</th><th>Password</th></tr>";
        while ($batchpw = mysql_fetch_assoc($sqlpw)) {
            echo "<tr>";
            echo "<td><a href='account.php?search=" . htmlspecialchars($batchpw['Id']) . "'>" . htmlspecialchars($batchpw['Id']) . "</a></td>";
            echo "<td>" . htmlspecialchars($batchpw['user'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($batchpw['NickName'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($batchpw['Password']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}
echo "</table>";
?>
</div>

<?PHP include "footer.php"; ?>