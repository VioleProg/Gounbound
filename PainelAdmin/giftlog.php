<?php
// verify.php já é incluído em header.php
include('header.php');
require_once("../mesh.php");
?>

<a name='maincontent'></a>
<?php
$search = "";
if(isset($_GET["Id"]) && !empty($_GET["Id"])){
    $search = "WHERE `Id`='".mysql_real_escape_string($_GET["Id"])."' OR `Receiver`='".mysql_real_escape_string($_GET["Id"])."'"; 
}
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 0;
$page_offset = $page * 50;
$next = $page + 1;
$prev = max(0, $page - 1);
$id_param = isset($_GET["Id"]) ? htmlspecialchars($_GET["Id"]) : '';

echo "<table width='79%'>";
echo "<h2><font color='#adadad'>Avatares Presenteados</font></h2>";
echo "<a href='?Id=$id_param&page=$prev'>Página Anterior</a> || <a href='?Id=$id_param&page=$next'>Próxima Página</a> || <a href='giftlog.php'>Índice do Log de Presentes</a>";
echo "<br /><form method=get>Pesquisar por ID de Login do Remetente ou Destinatário: <input name=Id value='$id_param'><input type=submit value='Pesquisar'></form>";

$getSell = mysql_query("SELECT * FROM `receiptgift` $search ORDER BY `Time`  DESC LIMIT $page_offset,50");

echo "<tr>";
echo "
                    <th>Remetente</th>
                    <th>Avatar</th>
                    <th>Destinatário (ID de Login):</th>
                    <th>Destinatário (GameID)</th>
                    <th>Hora:</th>
                    <th>Hora de Confirmação:</th>
                    <th>Duração: </th>
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
             echo "<td>Mês</td>";
             if($rowSell['ExpireType'] == 'W')
             echo "<td>Semana</td>";
             if($rowSell['ExpireType'] == 'I')
             echo "<td>Ilimitado</td>";
             echo "</tr>";
             }
             echo "</table>";
?>

<?PHP include "footer.php" ?>