<?php 
include("header.php"); 
include("../mesh.php");

$search = mysql_real_escape_string($_GET['search'] ?? '');
$where = "1=1";
if ($search) {
    $where .= " AND (g.Id LIKE '%$search%' OR g.Nickname LIKE '%$search%')";
}

// Buscar jogadores com Gold suspeito (muito alto ou negativo)
$result = mysql_query("SELECT g.Id, g.Nickname, g.Money, gw.NickName as AccountNick 
                       FROM game g 
                       LEFT JOIN gunwcuser gw ON g.Id = gw.Id 
                       WHERE $where AND (g.Money < 0 OR g.Money > 100000000)
                       ORDER BY g.Money DESC 
                       LIMIT 100");
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Verificação de Gold</h1>
    <p>Lista de jogadores com Gold suspeito (negativo ou muito alto)</p>
    
    <form method="get" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Buscar por ID ou Nickname..." 
               value="<?php echo htmlspecialchars($search); ?>" style="width: 400px; padding: 5px;">
        <input type="submit" value="Buscar" class="button1">
        <?php if ($search): ?>
            <a href="gold_verification.php" class="button1">Limpar</a>
        <?php endif; ?>
    </form>
    
    <table width='100%' cellspacing="1">
        <caption>Jogadores com Gold Suspeito</caption>
        <thead>
            <tr>
                <th>ID do Usuário</th>
                <th>Nickname (Game)</th>
                <th>Nickname (Conta)</th>
                <th>Gold</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_assoc($result)) {
                    $gold = (int)($row['Money'] ?? 0);
                    $suspicious = ($gold < 0 || $gold > 100000000);
                    
                    echo '<tr class="row2" style="' . ($suspicious ? 'background: #fff3cd;' : '') . '">';
                    echo '<td><a href="account.php?search=' . htmlspecialchars($row['Id']) . '">' . htmlspecialchars($row['Id']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row['Nickname'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['AccountNick'] ?? 'N/A') . '</td>';
                    echo '<td>' . number_format($gold) . '</td>';
                    echo '<td><a href="account.php?search=' . htmlspecialchars($row['Id']) . '" class="button1">Ver Detalhes</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5" style="text-align: center;">Nenhum jogador com Gold suspeito encontrado.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

