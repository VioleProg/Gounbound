<?php 
include("header.php"); 
include("../mesh.php");
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Usuários Online</h1>
    
    <table width='100%' cellspacing="1">
        <caption>Usuários Atualmente Online</caption>
        <thead>
            <tr>
                <th>ID do Usuário</th>
                <th>IP do Servidor</th>
                <th>Porta do Servidor</th>
                <th>Hora de Login</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = @mysql_query("SELECT * FROM currentuser ORDER BY LoggingTime DESC");
            if ($result && mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_assoc($result)) {
                    echo '<tr class="row2">';
                    echo '<td><a href="account.php?search=' . htmlspecialchars($row['Id']) . '">' . htmlspecialchars($row['Id']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row['ServerIp'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['ServerPort'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['LoggingTime'] ?? 'N/A') . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4" style="text-align: center;">Nenhum usuário online no momento.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

