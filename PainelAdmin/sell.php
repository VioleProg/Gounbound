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
echo "<h2><font color='#adadad'>Avatares Vendidos/Deletados</font></h2>";
echo "<a href='?Id=$id_param&page=$prev'>Página Anterior</a> || <a href='?Id=$id_param&page=$next'>Próxima Página</a> || <a href='sell.php'>Índice do Log de Vendas</a>";
echo "<br /><form method=get>Pesquisar por ID de LOGIN: <input name=Id value='$id_param'><input type=submit value='Pesquisar'></form>";

$getSell = mysql_query("SELECT * FROM `receiptconsume` $search ORDER BY `Time`  DESC LIMIT $page_offset,50");
echo "<tr>";
echo "
                    <th>ID:</th>
                    <th>Hora:</th>
                    <th>Avatar:</th>
                    <th>Reembolso:</th>
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