<?php 
include("header.php");

$success = '';
$error = '';

// Criar tabela se não existir
$check_table = mysql_query("SHOW TABLES LIKE 'mute_log'");
if (mysql_num_rows($check_table) == 0) {
    $create_table = "CREATE TABLE `mute_log` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
      `admin_id` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
      `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
      `mute_time` datetime NOT NULL,
      `unmute_time` datetime DEFAULT NULL,
      `duration_minutes` int(11) DEFAULT NULL,
      `is_permanent` tinyint(1) DEFAULT 0,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `mute_time` (`mute_time`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    @mysql_query($create_table);
}

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'mute') {
        $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
        $duration = (int)($_POST['duration'] ?? 60);
        $reason = mysql_real_escape_string($_POST['reason'] ?? '');
        $is_permanent = isset($_POST['is_permanent']) ? 1 : 0;
        $admin_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? 'Admin';
        
        if (empty($user_id)) {
            $error = 'ID do usuário é obrigatório!';
        } else {
            // Verificar se usuário existe
            $check_user = mysql_query("SELECT Id FROM gunwcuser WHERE Id = '$user_id'");
            if (mysql_num_rows($check_user) == 0) {
                $error = 'Usuário não encontrado!';
            } else {
                $mute_time = date('Y-m-d H:i:s');
                $unmute_time = $is_permanent ? null : date('Y-m-d H:i:s', strtotime("+$duration minutes"));
                
                // Inserir no log
                $insert = mysql_query("INSERT INTO mute_log (user_id, admin_id, reason, mute_time, unmute_time, duration_minutes, is_permanent) 
                                       VALUES ('$user_id', '$admin_id', '$reason', '$mute_time', " . ($unmute_time ? "'$unmute_time'" : "NULL") . ", $duration, $is_permanent)");
                
                // Atualizar Status do usuário (Status = '2' = bloqueado/mutado)
                $update = mysql_query("UPDATE gunwcuser SET Status = '2' WHERE Id = '$user_id'");
                
                if ($insert && $update) {
                    $success = "Usuário mutado com sucesso!";
                } else {
                    $error = 'Erro ao mutar usuário: ' . mysql_error();
                }
            }
        }
    }
    
    if ($action === 'unmute') {
        $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
        $admin_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? 'Admin';
        
        if (empty($user_id)) {
            $error = 'ID do usuário é obrigatório!';
        } else {
            // Atualizar log
            $update_log = mysql_query("UPDATE mute_log SET unmute_time = NOW() WHERE user_id = '$user_id' AND (unmute_time IS NULL OR unmute_time > NOW())");
            
            // Desmutar usuário
            $update = mysql_query("UPDATE gunwcuser SET Status = '1' WHERE Id = '$user_id'");
            
            if ($update) {
                $success = "Usuário desmutado com sucesso!";
            } else {
                $error = 'Erro ao desmutar usuário: ' . mysql_error();
            }
        }
    }
}

// Paginação
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 50;
$offset = ($page - 1) * $per_page;

// Buscar logs de mute
$search = mysql_real_escape_string($_GET['search'] ?? '');
$where = "1=1";
if ($search) {
    $where .= " AND (m.user_id LIKE '%$search%' OR m.admin_id LIKE '%$search%' OR m.reason LIKE '%$search%')";
}

$sql = "SELECT m.*, gw.NickName as user_nickname, gw.user as username, 
               admin.NickName as admin_nickname
        FROM mute_log m
        LEFT JOIN gunwcuser gw ON m.user_id = gw.Id
        LEFT JOIN gunwcuser admin ON m.admin_id = admin.Id
        WHERE $where
        ORDER BY m.mute_time DESC
        LIMIT $offset, $per_page";

$result = @mysql_query($sql);

// Contar total
$count_sql = "SELECT COUNT(*) as total FROM mute_log m WHERE $where";
$count_result = @mysql_query($count_sql);
$count_row = mysql_fetch_assoc($count_result);
$total = $count_row['total'] ?? 0;
$total_pages = ceil($total / $per_page);

// Buscar usuários mutados atualmente
$muted_users = [];
$muted_result = @mysql_query("SELECT Id, NickName, user FROM gunwcuser WHERE Status = '2'");
if ($muted_result) {
    while ($row = mysql_fetch_assoc($muted_result)) {
        $muted_users[$row['Id']] = $row;
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Log de Mutes</h1>
    <p>Gerencie os mutes do chat de tweets.</p>
    
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
    
    <!-- Formulário de Mute -->
    <div class="admin-section" style="max-width: 600px; margin-bottom: 2rem;">
        <h2>Mutar Usuário</h2>
        <form method="post" style="padding: 1.5rem;">
            <input type="hidden" name="action" value="mute">
            
            <dl>
                <dt><label for="user_id">ID do Usuário:</label></dt>
                <dd>
                    <input type="text" id="user_id" name="user_id" required 
                           placeholder="Digite o ID do usuário" 
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="duration">Duração (minutos):</label></dt>
                <dd>
                    <input type="number" id="duration" name="duration" min="1" value="60" required 
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="is_permanent">Mute Permanente:</label></dt>
                <dd>
                    <input type="checkbox" id="is_permanent" name="is_permanent" value="1">
                    <label for="is_permanent">Marque para mute permanente</label>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="reason">Motivo:</label></dt>
                <dd>
                    <textarea id="reason" name="reason" rows="3" 
                              style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;" 
                              placeholder="Digite o motivo do mute..."></textarea>
                </dd>
            </dl>
            
            <p style="margin-top: 1rem;">
                <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                             color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                             border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-ban"></i> Mutar Usuário
                </button>
            </p>
        </form>
    </div>
    
    <!-- Busca -->
    <div class="admin-section" style="margin-bottom: 2rem;">
        <h2>Buscar Logs de Mute</h2>
        <form method="get" action="" style="padding: 1.5rem;">
            <input type="text" name="search" placeholder="Buscar por user_id, admin_id ou motivo..." 
                   value="<?php echo htmlspecialchars($search); ?>" 
                   style="width: 70%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; display: inline-block;">
            <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                         color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                         border-radius: 8px; font-weight: 600; cursor: pointer; margin-left: 0.5rem;">
                <i class="fas fa-search"></i> Buscar
            </button>
            <?php if ($search): ?>
                <a href="mute_log.php" class="button1" style="margin-left: 0.5rem;">Limpar</a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- Estatísticas -->
    <div class="admin-section" style="margin-bottom: 2rem;">
        <h2>Estatísticas</h2>
        <div style="padding: 1.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div style="background: #e3f2fd; padding: 1rem; border-radius: 8px; border-left: 4px solid #2196F3;">
                <strong style="display: block; color: #1976D2; margin-bottom: 0.5rem;">Total de Mutes</strong>
                <span style="font-size: 2rem; font-weight: bold; color: #0d47a1;"><?php echo number_format($total); ?></span>
            </div>
            <div style="background: #fff3e0; padding: 1rem; border-radius: 8px; border-left: 4px solid #ff9800;">
                <strong style="display: block; color: #f57c00; margin-bottom: 0.5rem;">Usuários Mutados</strong>
                <span style="font-size: 2rem; font-weight: bold; color: #e65100;"><?php echo count($muted_users); ?></span>
            </div>
        </div>
    </div>
    
    <!-- Lista de Mutes -->
    <div class="admin-section">
        <h2>Log de Mutes (Página <?php echo $page; ?> de <?php echo $total_pages; ?>)</h2>
        
        <table width='100%' cellspacing="1" class="admin-table" style="margin-top: 1rem;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Admin</th>
                    <th>Motivo</th>
                    <th>Data do Mute</th>
                    <th>Duração</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysql_num_rows($result) > 0) {
                    while ($mute = mysql_fetch_assoc($result)) {
                        $is_muted = isset($muted_users[$mute['user_id']]);
                        $status_text = $is_muted ? '<span style="color: red; font-weight: bold;">MUTADO</span>' : '<span style="color: green; font-weight: bold;">Desmutado</span>';
                        $duration_text = $mute['is_permanent'] ? 'Permanente' : ($mute['duration_minutes'] . ' min');
                        
                        echo '<tr class="row2">';
                        echo '<td>' . htmlspecialchars($mute['id']) . '</td>';
                        echo '<td><a href="account.php?search=' . urlencode($mute['user_id']) . '">' . htmlspecialchars($mute['user_id']) . '</a><br><small>' . htmlspecialchars($mute['user_nickname'] ?? 'N/A') . '</small></td>';
                        echo '<td>' . htmlspecialchars($mute['admin_nickname'] ?? $mute['admin_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($mute['reason'] ?? 'Sem motivo') . '</td>';
                        echo '<td>' . htmlspecialchars($mute['mute_time']) . '</td>';
                        echo '<td>' . $duration_text . '</td>';
                        echo '<td>' . $status_text . '</td>';
                        echo '<td style="white-space: nowrap;">';
                        
                        if ($is_muted) {
                            echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja desmutar este usuário?\');">';
                            echo '<input type="hidden" name="action" value="unmute">';
                            echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($mute['user_id']) . '">';
                            echo '<button type="submit" style="background: #28a745; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 4px;"><i class="fas fa-check"></i> Desmutar</button>';
                            echo '</form>';
                        }
                        
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="8" style="text-align: center; padding: 2rem;">';
                    if (!$result) {
                        echo '<div style="color: #dc3545;"><i class="fas fa-exclamation-triangle"></i> Erro ao buscar logs: ' . mysql_error() . '</div>';
                    } else {
                        echo '<div style="color: #6c757d;"><i class="fas fa-info-circle"></i> Nenhum mute encontrado.</div>';
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
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>
