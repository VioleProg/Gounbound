<?php 
// verify.php já é incluído em header.php
include("header.php"); 
include("../mesh.php");

$action = $_GET['action'] ?? '';
$guild_name = mysql_real_escape_string($_GET['guild'] ?? '');
$success = '';
$error = '';

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action_post = $_POST['action'] ?? '';
    
    if ($action_post === 'create_guild') {
        $guild_name_post = mysql_real_escape_string($_POST['guild_name'] ?? '');
        $leader_id = mysql_real_escape_string($_POST['leader_id'] ?? '');
        
        if (empty($guild_name_post) || empty($leader_id)) {
            $error = 'Preencha todos os campos!';
        } else {
            // Verificar se a guilda já existe
            $check = mysql_query("SELECT Guild FROM game WHERE Guild = '$guild_name_post' LIMIT 1");
            if (mysql_num_rows($check) > 0) {
                $error = 'Esta guilda já existe!';
            } else {
                // Criar guilda (atualizar o líder)
                $update = mysql_query("UPDATE game SET Guild = '$guild_name_post', GuildRank = 1 WHERE Id = '$leader_id'");
                if ($update) {
                    $success = "Guilda criada com sucesso!";
                } else {
                    $error = 'Erro ao criar guilda!';
                }
            }
        }
    }
    
    if ($action_post === 'delete_guild') {
        $guild_name_post = mysql_real_escape_string($_POST['guild_name'] ?? '');
        if ($guild_name_post) {
            $update = mysql_query("UPDATE game SET Guild = '', GuildRank = 0 WHERE Guild = '$guild_name_post'");
            if ($update) {
                $affected = mysql_affected_rows();
                $success = "Guilda deletada com sucesso! ($affected membro(s) removido(s))";
            } else {
                $error = 'Erro ao deletar guilda!';
            }
        }
    }
    
    if ($action_post === 'change_rank') {
        $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
        $new_rank = (int)($_POST['new_rank'] ?? 0);
        if ($user_id) {
            $update = mysql_query("UPDATE game SET GuildRank = $new_rank WHERE Id = '$user_id'");
            if ($update) {
                $success = "Rank da guilda alterado com sucesso!";
            } else {
                $error = 'Erro ao alterar rank!';
            }
        }
    }
}

// Buscar guildas
$guilds = [];
$guild_result = mysql_query("SELECT Guild, COUNT(*) as member_count, MAX(GuildRank) as max_rank 
                            FROM game 
                            WHERE Guild != '' AND Guild IS NOT NULL 
                            GROUP BY Guild 
                            ORDER BY member_count DESC");
while ($row = mysql_fetch_assoc($guild_result)) {
    $guilds[] = $row;
}

// Buscar membros de uma guilda específica
$guild_members = [];
if ($guild_name) {
    $members_result = mysql_query("SELECT g.Id, g.Nickname, g.GuildRank, g.TotalScore, gw.NickName as AccountNick 
                                  FROM game g 
                                  LEFT JOIN gunwcuser gw ON g.Id = gw.Id 
                                  WHERE g.Guild = '$guild_name' 
                                  ORDER BY g.GuildRank DESC, g.TotalScore DESC");
    while ($row = mysql_fetch_assoc($members_result)) {
        $guild_members[] = $row;
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Gerenciamento de Guildas</h1>
    <p>Gerencie as guildas do servidor.</p>
    
    <?php if ($success): ?>
        <div class="success-message">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <!-- Criar Guilda -->
    <div class="admin-section" style="max-width: 600px; margin-bottom: 2rem;">
        <h2>Criar Guilda</h2>
        <form method="post" style="padding: 1.5rem;">
            <input type="hidden" name="action" value="create_guild">
            
            <dl>
                <dt><label for="guild_name">Nome da Guilda:</label></dt>
                <dd>
                    <input type="text" id="guild_name" name="guild_name" required 
                           placeholder="Digite o nome da guilda" 
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="leader_id">ID do Líder:</label></dt>
                <dd>
                    <input type="text" id="leader_id" name="leader_id" required 
                           placeholder="Digite o ID do líder" 
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <p style="margin-top: 1rem;">
                <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                             color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                             border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-plus"></i> Criar Guilda
                </button>
            </p>
        </form>
    </div>
    
    <!-- Lista de Guildas -->
    <div class="admin-section">
        <h2>Lista de Guildas</h2>
        <p>Total de guildas: <strong><?php echo count($guilds); ?></strong></p>
        
        <table width='100%' cellspacing="1" class="admin-table">
            <thead>
                <tr>
                    <th>Nome da Guilda</th>
                    <th>Membros</th>
                    <th>Rank Máximo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($guilds) > 0) {
                    foreach ($guilds as $guild) {
                        echo '<tr class="row2">';
                        echo '<td><a href="?guild=' . urlencode($guild['Guild']) . '">' . htmlspecialchars($guild['Guild']) . '</a></td>';
                        echo '<td>' . htmlspecialchars($guild['member_count']) . '</td>';
                        echo '<td>' . htmlspecialchars($guild['max_rank']) . '</td>';
                        echo '<td>';
                        echo '<a href="?guild=' . urlencode($guild['Guild']) . '" class="button1" style="background: #007bff; color: white; padding: 3px 10px; text-decoration: none; border-radius: 4px; margin-right: 5px;">Ver Membros</a>';
                        echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja deletar esta guilda?\');">';
                        echo '<input type="hidden" name="action" value="delete_guild">';
                        echo '<input type="hidden" name="guild_name" value="' . htmlspecialchars($guild['Guild']) . '">';
                        echo '<button type="submit" style="background: #dc3545; color: white; padding: 3px 10px; border: none; cursor: pointer; border-radius: 4px;">Deletar</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4" style="text-align: center;">Nenhuma guilda encontrada.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <!-- Membros da Guilda -->
    <?php if ($guild_name && count($guild_members) > 0): ?>
        <div class="admin-section" style="margin-top: 2rem;">
            <h2>Membros da Guilda: <?php echo htmlspecialchars($guild_name); ?></h2>
            
            <table width='100%' cellspacing="1" class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nickname (Game)</th>
                        <th>Nickname (Conta)</th>
                        <th>Rank na Guilda</th>
                        <th>GP Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($guild_members as $member) {
                        echo '<tr class="row2">';
                        echo '<td><a href="account.php?search=' . htmlspecialchars($member['Id']) . '">' . htmlspecialchars($member['Id']) . '</a></td>';
                        echo '<td>' . htmlspecialchars($member['Nickname'] ?? 'N/A') . '</td>';
                        echo '<td>' . htmlspecialchars($member['AccountNick'] ?? 'N/A') . '</td>';
                        echo '<td>' . htmlspecialchars($member['GuildRank']) . '</td>';
                        echo '<td>' . number_format($member['TotalScore'] ?? 0) . '</td>';
                        echo '<td>';
                        echo '<form method="post" style="display: inline;">';
                        echo '<input type="hidden" name="action" value="change_rank">';
                        echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($member['Id']) . '">';
                        echo '<input type="number" name="new_rank" value="' . htmlspecialchars($member['GuildRank']) . '" min="0" max="10" style="width: 60px; padding: 3px;">';
                        echo '<button type="submit" style="background: #28a745; color: white; padding: 3px 10px; border: none; cursor: pointer; border-radius: 4px; margin-left: 5px;">Alterar</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

