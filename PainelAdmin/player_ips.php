<?php 
include("header.php"); 
include("../mesh.php");

$search = mysql_real_escape_string($_GET['search'] ?? '');
$where = "1=1";
if ($search) {
    $where .= " AND (Id LIKE '%$search%' OR IP LIKE '%$search%' OR NickName LIKE '%$search%')";
}

$result = mysql_query("SELECT Id, NickName, user, IP FROM gunwcuser WHERE $where ORDER BY Id LIMIT 100");
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>IP de Jogadores</h1>
    
    <form method="get" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Buscar por ID, IP ou Nickname..." 
               value="<?php echo htmlspecialchars($search); ?>" style="width: 400px; padding: 5px;">
        <input type="submit" value="Buscar" class="button1">
        <?php if ($search): ?>
            <a href="player_ips.php" class="button1">Limpar</a>
        <?php endif; ?>
    </form>
    
    <table width='100%' cellspacing="1">
        <caption>IPs dos Jogadores</caption>
        <thead>
            <tr>
                <th>ID do Usuário</th>
                <th>Nickname</th>
                <th>Username</th>
                <th>Endereço IP</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_assoc($result)) {
                    echo '<tr class="row2">';
                    echo '<td><a href="account.php?search=' . htmlspecialchars($row['Id']) . '">' . htmlspecialchars($row['Id']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row['NickName'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['user'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['IP'] ?? 'N/A') . '</td>';
                    echo '<td><a href="ban_ip.php?ip=' . urlencode($row['IP'] ?? '') . '" class="button1" style="background: #dc3545; color: white;">Banir IP</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5" style="text-align: center;">Nenhum resultado encontrado.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

