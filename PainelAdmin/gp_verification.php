<?php 
include("header.php"); 
include("../mesh.php");

$search = mysql_real_escape_string($_GET['search'] ?? '');
$where = "1=1";
if ($search) {
    $where .= " AND (g.Id LIKE '%$search%' OR g.Nickname LIKE '%$search%')";
}

// Buscar jogadores com GP suspeito (muito alto ou negativo)
$result = mysql_query("SELECT g.Id, g.Nickname, g.TotalScore, g.SeasonScore, gw.NickName as AccountNick 
                       FROM game g 
                       LEFT JOIN gunwcuser gw ON g.Id = gw.Id 
                       WHERE $where AND (g.TotalScore < 0 OR g.TotalScore > 10000000 OR g.SeasonScore < 0 OR g.SeasonScore > 1000000)
                       ORDER BY g.TotalScore DESC 
                       LIMIT 100");
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Verificação de GPs Diários</h1>
    <p>Lista de jogadores com GPs suspeitos (negativos ou muito altos)</p>
    
    <form method="get" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Buscar por ID ou Nickname..." 
               value="<?php echo htmlspecialchars($search); ?>" style="width: 400px; padding: 5px;">
        <input type="submit" value="Buscar" class="button1">
        <?php if ($search): ?>
            <a href="gp_verification.php" class="button1">Limpar</a>
        <?php endif; ?>
    </form>
    
    <table width='100%' cellspacing="1">
        <caption>Jogadores com GPs Suspeitos</caption>
        <thead>
            <tr>
                <th>ID do Usuário</th>
                <th>Nickname (Game)</th>
                <th>Nickname (Conta)</th>
                <th>GP Total</th>
                <th>GP Diário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_assoc($result)) {
                    $gp_total = (int)($row['TotalScore'] ?? 0);
                    $gp_daily = (int)($row['SeasonScore'] ?? 0);
                    $suspicious = ($gp_total < 0 || $gp_total > 10000000 || $gp_daily < 0 || $gp_daily > 1000000);
                    
                    echo '<tr class="row2" style="' . ($suspicious ? 'background: #fff3cd;' : '') . '">';
                    echo '<td><a href="account.php?search=' . htmlspecialchars($row['Id']) . '">' . htmlspecialchars($row['Id']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row['Nickname'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['AccountNick'] ?? 'N/A') . '</td>';
                    echo '<td>' . number_format($gp_total) . '</td>';
                    echo '<td>' . number_format($gp_daily) . '</td>';
                    echo '<td><a href="account.php?search=' . htmlspecialchars($row['Id']) . '" class="button1">Ver Detalhes</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6" style="text-align: center;">Nenhum jogador com GP suspeito encontrado.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

