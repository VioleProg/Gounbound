<?php 
include("header.php");

$action = $_GET['action'] ?? '';
$tweet_id = $_GET['tweet_id'] ?? '';
$user_id_block = $_GET['user_id'] ?? '';
$success = '';
$error = '';

// Verificar se a tabela tweets existe, caso contrário criar
$check_table = mysql_query("SHOW TABLES LIKE 'tweets'");
if (mysql_num_rows($check_table) == 0) {
    // Criar tabela tweets
    $create_tweets = "CREATE TABLE `tweets` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `user_id` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
        `nickname` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
        `message` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        INDEX `idx_user` (`user_id`),
        INDEX `idx_created` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    @mysql_query($create_tweets);
}

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action_post = $_POST['action'] ?? '';
    
    if ($action_post === 'delete') {
        $tweet_id = mysql_real_escape_string($_POST['tweet_id'] ?? '');
        if ($tweet_id) {
            $result = mysql_query("DELETE FROM tweets WHERE id = '$tweet_id'");
            if ($result) {
                $success = 'Mensagem deletada com sucesso!';
            } else {
                $error = 'Erro ao deletar mensagem: ' . mysql_error();
            }
        }
    }
    
    if ($action_post === 'block') {
        $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
        if ($user_id) {
            $result = mysql_query("UPDATE gunwcuser SET Status = '2' WHERE Id = '$user_id'");
            if ($result) {
                $success = 'Usuário bloqueado do chat com sucesso!';
            } else {
                $error = 'Erro ao bloquear usuário: ' . mysql_error();
            }
        }
    }
    
    if ($action_post === 'unblock') {
        $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
        if ($user_id) {
            $result = mysql_query("UPDATE gunwcuser SET Status = '1' WHERE Id = '$user_id'");
            if ($result) {
                $success = 'Usuário desbloqueado do chat com sucesso!';
            } else {
                $error = 'Erro ao desbloquear usuário: ' . mysql_error();
            }
        }
    }
}

// Paginação
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 50;
$offset = ($page - 1) * $per_page;

// Buscar tweets
$search = mysql_real_escape_string($_GET['search'] ?? '');
$where = "1=1";
if ($search) {
    $where .= " AND (t.nickname LIKE '%$search%' OR t.user_id LIKE '%$search%' OR t.message LIKE '%$search%')";
}

// Query simplificada sem CONVERT para evitar problemas de collation
$sql = "SELECT t.*, g.TotalScore, gw.imagem_perfil, gw.Status as user_status, gw.NickName as account_nickname
        FROM tweets t
        LEFT JOIN game g ON t.user_id = g.Id
        LEFT JOIN gunwcuser gw ON t.user_id = gw.Id
        WHERE $where
        ORDER BY t.created_at DESC
        LIMIT $offset, $per_page";

$result = @mysql_query($sql);

// Contar total
$count_sql = "SELECT COUNT(*) as total FROM tweets t WHERE $where";
$count_result = @mysql_query($count_sql);
$count_row = mysql_fetch_assoc($count_result);
$total_tweets = $count_row['total'] ?? 0;
$total_pages = ceil($total_tweets / $per_page);

// Buscar usuários bloqueados
$blocked_users = [];
$blocked_result = @mysql_query("SELECT Id, NickName, user FROM gunwcuser WHERE Status = '2'");
if ($blocked_result) {
    while ($row = mysql_fetch_assoc($blocked_result)) {
        $blocked_users[$row['Id']] = $row;
    }
}
?>

<a name="maincontent"></a>

<h1>Gerenciamento de Tweets</h1>
    <p>Gerencie as mensagens do chat e bloqueie usuários que violarem as regras.</p>
    
    <?php if ($success): ?>
        <div class="success-message" style="background: #d4edda; color: #155724; padding: 1rem; margin: 1rem 0; border: 1px solid #c3e6cb; border-radius: 8px; border-left: 4px solid #28a745;">
            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error-message" style="background: #f8d7da; color: #721c24; padding: 1rem; margin: 1rem 0; border: 1px solid #f5c6cb; border-radius: 8px; border-left: 4px solid #dc3545;">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <!-- Busca -->
    <div class="admin-section" style="margin-bottom: 2rem;">
        <h2>Buscar Mensagens</h2>
        <form method="get" action="" style="padding: 1.5rem;">
            <input type="text" name="search" placeholder="Buscar por nickname, user_id ou mensagem..." 
                   value="<?php echo htmlspecialchars($search); ?>" 
                   style="width: 70%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; display: inline-block;">
            <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                         color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                         border-radius: 8px; font-weight: 600; cursor: pointer; margin-left: 0.5rem;">
                <i class="fas fa-search"></i> Buscar
            </button>
            <?php if ($search): ?>
                <a href="tweets_manage.php" class="button1" style="margin-left: 0.5rem;">Limpar</a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- Estatísticas -->
    <div class="admin-section" style="margin-bottom: 2rem;">
        <h2>Estatísticas</h2>
        <div style="padding: 1.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div style="background: #e3f2fd; padding: 1rem; border-radius: 8px; border-left: 4px solid #2196F3;">
                <strong style="display: block; color: #1976D2; margin-bottom: 0.5rem;">Total de Mensagens</strong>
                <span style="font-size: 2rem; font-weight: bold; color: #0d47a1;"><?php echo number_format($total_tweets); ?></span>
            </div>
            <div style="background: #fff3e0; padding: 1rem; border-radius: 8px; border-left: 4px solid #ff9800;">
                <strong style="display: block; color: #f57c00; margin-bottom: 0.5rem;">Usuários Bloqueados</strong>
                <span style="font-size: 2rem; font-weight: bold; color: #e65100;"><?php echo count($blocked_users); ?></span>
            </div>
        </div>
    </div>
    
    <!-- Lista de Tweets -->
    <div class="admin-section">
        <h2>Tweets (Página <?php echo $page; ?> de <?php echo $total_pages; ?>)</h2>
        
        <table width='100%' cellspacing="1" class="admin-table" style="margin-top: 1rem;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Nickname</th>
                    <th>Mensagem</th>
                    <th>Data/Hora</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysql_num_rows($result) > 0) {
                    while ($tweet = mysql_fetch_assoc($result)) {
                        $is_blocked = isset($blocked_users[$tweet['user_id']]);
                        $user_status = $tweet['user_status'] ?? '1';
                        $status_text = ($user_status == '2') ? '<span style="color: red; font-weight: bold;">BLOQUEADO</span>' : '<span style="color: green; font-weight: bold;">Ativo</span>';
                        
                        echo '<tr class="row2">';
                        echo '<td>' . htmlspecialchars($tweet['id']) . '</td>';
                        echo '<td><a href="account.php?search=' . urlencode($tweet['user_id']) . '">' . htmlspecialchars($tweet['user_id']) . '</a></td>';
                        echo '<td>' . htmlspecialchars($tweet['nickname']) . '</td>';
                        echo '<td>' . htmlspecialchars($tweet['message']) . '</td>';
                        echo '<td>' . htmlspecialchars($tweet['created_at']) . '</td>';
                        echo '<td>' . $status_text . '</td>';
                        echo '<td style="white-space: nowrap;">';
                        
                        echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja deletar esta mensagem?\');">';
                        echo '<input type="hidden" name="action" value="delete">';
                        echo '<input type="hidden" name="tweet_id" value="' . htmlspecialchars($tweet['id']) . '">';
                        echo '<button type="submit" style="background: #dc3545; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 4px; margin-right: 5px;"><i class="fas fa-trash"></i> Deletar</button>';
                        echo '</form>';
                        
                        if (!$is_blocked) {
                            echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja bloquear este usuário do chat?\');">';
                            echo '<input type="hidden" name="action" value="block">';
                            echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($tweet['user_id']) . '">';
                            echo '<button type="submit" style="background: #ff9800; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 4px;"><i class="fas fa-ban"></i> Bloquear</button>';
                            echo '</form>';
                        } else {
                            echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja desbloquear este usuário?\');">';
                            echo '<input type="hidden" name="action" value="unblock">';
                            echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($tweet['user_id']) . '">';
                            echo '<button type="submit" style="background: #28a745; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 4px;"><i class="fas fa-check"></i> Desbloquear</button>';
                            echo '</form>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7" style="text-align: center; padding: 2rem;">';
                    if (!$result) {
                        echo '<div style="color: #dc3545;"><i class="fas fa-exclamation-triangle"></i> Erro ao buscar tweets: ' . mysql_error() . '</div>';
                    } else {
                        echo '<div style="color: #6c757d;"><i class="fas fa-info-circle"></i> Nenhum tweet encontrado.</div>';
                    }
                    echo '</td></tr>';
                }
                ?>
            </tbody>
        </table>
        
        <!-- Paginação -->
        <?php if ($total_pages > 1): ?>
            <div style="text-align: center; margin: 20px 0;">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo ($page - 1); ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="button1">« Anterior</a>
                <?php endif; ?>
                
                <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);
                for ($i = $start; $i <= $end; $i++):
                ?>
                    <a href="?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" 
                       class="button1" style="<?php echo $i == $page ? 'background: #007bff; color: white;' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo ($page + 1); ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="button1">Próxima »</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Lista de Usuários Bloqueados -->
    <?php if (count($blocked_users) > 0): ?>
        <div class="admin-section" style="margin-top: 2rem;">
            <h2>Usuários Bloqueados do Chat</h2>
            <table width='100%' cellspacing="1" class="admin-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Nickname</th>
                        <th>Username</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($blocked_users as $user_id => $user):
                        echo '<tr class="row2">';
                        echo '<td><a href="account.php?search=' . urlencode($user_id) . '">' . htmlspecialchars($user_id) . '</a></td>';
                        echo '<td>' . htmlspecialchars($user['NickName'] ?? 'N/A') . '</td>';
                        echo '<td>' . htmlspecialchars($user['user'] ?? 'N/A') . '</td>';
                        echo '<td>';
                        echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja desbloquear este usuário?\');">';
                        echo '<input type="hidden" name="action" value="unblock">';
                        echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($user_id) . '">';
                        echo '<button type="submit" style="background: #28a745; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 4px;"><i class="fas fa-check"></i> Desbloquear</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>
