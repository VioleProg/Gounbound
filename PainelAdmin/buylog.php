<?php
// verify.php já é incluído em header.php
include('header.php');
require_once("../mesh.php");
?>

<a name='maincontent'></a>
<?php
$search = "";
if(isset($_GET["Id"]) && !empty($_GET["Id"])){
    $search = "WHERE `Id`='".mysql_real_escape_string($_GET["Id"])."'"; 
}
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 0;
$page_offset = $page * 50;
$next = $page + 1;
$prev = max(0, $page - 1);
$id_param = isset($_GET["Id"]) ? htmlspecialchars($_GET["Id"]) : '';

echo "<table width='79%'>";
echo "<h2><font color='#adadad'>Avatares Comprados</font></h2>";
echo "<a href='?Id=$id_param&page=$prev'>Página Anterior</a> || <a href='?Id=$id_param&page=$next'>Próxima Página</a>  || <a href='buylog.php'>Índice do Log de Compras</a>";
echo "<br /><form method=get>Pesquisar por ID de LOGIN: <input name=Id value='$id_param'><input type=submit value='Pesquisar'></form>";
$getBought = mysql_query("SELECT * FROM `receiptbuy` $search ORDER BY `Time`  DESC LIMIT $page_offset,50");
echo "<tr>";
echo "
                    <th>ID:</th>
                    <th>Hora:</th>
                    <th>Avatar:</th>
                    <th>Gold:</th>
                    <th>Cash:</th>
                    <th>Duração:</th>
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
             echo "<td>Mês</td>";
             if($rowBought['ExpireType'] == 'W')
             echo "<td>Semana</td>";
             if($rowBought['ExpireType'] == 'I')
             echo "<td>Ilimitado</td>";
             echo "</tr>";
             }
             echo "</table>";
?>
</div>

<?PHP include "footer.php" ?>