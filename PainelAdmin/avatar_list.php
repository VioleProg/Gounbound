<?php 
include("header.php"); 
include("../mesh.php");

// Buscar avatares do MENU
$result = mysql_query("SELECT Item1, menu_name, ItemType FROM MENU WHERE ItemType IN ('Head', 'Body', 'Glass') ORDER BY menu_name LIMIT 200");
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Lista de Avatares</h1>
    
    <table width='100%' cellspacing="1">
        <caption>Lista de Avatares Disponíveis</caption>
        <thead>
            <tr>
                <th>ID do Item</th>
                <th>Nome</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_assoc($result)) {
                    echo '<tr class="row2">';
                    echo '<td>' . htmlspecialchars($row['Item1'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['menu_name'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['ItemType'] ?? 'N/A') . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3" style="text-align: center;">Nenhum avatar encontrado.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

