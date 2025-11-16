<?PHP
include("verify.php");
$sql = mysql_query("SELECT * FROM country_reference");
while($sqlly = mysql_fetch_assoc($sql))
{
echo " ".$sqlly['Country_Name']." - ".$sqlly['Country_Number']."<br> ";
}
?>