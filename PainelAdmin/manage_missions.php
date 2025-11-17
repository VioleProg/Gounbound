<?php 
include("header.php");

$success = '';
$error = '';

// Verificar se as tabelas existem, se não, criar
$check_missions = mysql_query("SHOW TABLES LIKE 'missions'");
if (mysql_num_rows($check_missions) == 0) {
    // Criar tabela missions
    $create_missions = "CREATE TABLE IF NOT EXISTS `missions` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `description` TEXT NOT NULL,
        `mission_type` VARCHAR(50) NOT NULL,
        `target_value` INT NOT NULL,
        `event_points_reward` INT NOT NULL DEFAULT 0,
        `event_score_index` TINYINT NOT NULL DEFAULT 0,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `start_date` DATETIME NULL,
        `end_date` DATETIME NULL,
        `repeatable` TINYINT(1) NOT NULL DEFAULT 0,
        `repeat_interval` VARCHAR(20) NULL,
        `icon` VARCHAR(100) NULL,
        `color` VARCHAR(20) NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX `idx_active` (`is_active`),
        INDEX `idx_type` (`mission_type`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    @mysql_query($create_missions);
    
    // Criar tabela mission_progress
    $create_progress = "CREATE TABLE IF NOT EXISTS `mission_progress` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` VARCHAR(16) NOT NULL,
        `mission_id` INT NOT NULL,
        `current_value` INT NOT NULL DEFAULT 0,
        `is_completed` TINYINT(1) NOT NULL DEFAULT 0,
        `completed_at` DATETIME NULL,
        `last_reset` DATETIME NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY `unique_user_mission` (`user_id`, `mission_id`),
        INDEX `idx_user` (`user_id`),
        INDEX `idx_mission` (`mission_id`),
        INDEX `idx_completed` (`is_completed`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    @mysql_query($create_progress);
    
    // Inserir missões padrão se a tabela estava vazia
    $check_count = mysql_query("SELECT COUNT(*) as total FROM missions");
    $count_row = mysql_fetch_assoc($check_count);
    if ($count_row['total'] == 0) {
        $insert_defaults = "INSERT INTO `missions` (`title`, `description`, `mission_type`, `target_value`, `event_points_reward`, `event_score_index`, `is_active`, `repeatable`, `repeat_interval`, `icon`, `color`) VALUES
            ('Login Diário', 'Faça login 7 dias seguidos para completar a missão!', 'daily_login', 7, 100, 0, 1, 1, 'daily', 'fa-calendar-check', '#4CAF50'),
            ('Jogador Ativo', 'Jogue 10 partidas para ganhar pontos de evento!', 'play_games', 10, 500, 0, 1, 0, NULL, 'fa-gamepad', '#2196F3'),
            ('Vencedor', 'Ganhe 5 partidas e mostre sua habilidade!', 'win_games', 5, 750, 1, 1, 0, NULL, 'fa-trophy', '#FF9800'),
            ('Comunidade Ativa', 'Envie 10 mensagens no chat para ganhar pontos!', 'send_tweets', 10, 300, 2, 1, 0, NULL, 'fa-comments', '#9C27B0'),
            ('Alcance o Topo', 'Alcance o rank 100 ou melhor para ganhar pontos!', 'reach_rank', 100, 1000, 3, 1, 0, NULL, 'fa-star', '#F44336'),
            ('Gastador Iniciante', 'Gaste 15.000 cash para ganhar pontos!', 'spend_cash', 15000, 200, 0, 1, 0, NULL, 'fa-coins', '#FFC107'),
            ('Gastador Intermediário', 'Gaste 25.000 cash para ganhar pontos!', 'spend_cash', 25000, 400, 0, 1, 0, NULL, 'fa-coins', '#FF9800'),
            ('Gastador Avançado', 'Gaste 45.000 cash para ganhar pontos!', 'spend_cash', 45000, 600, 1, 1, 0, NULL, 'fa-coins', '#FF5722'),
            ('Gastador Expert', 'Gaste 65.000 cash para ganhar pontos!', 'spend_cash', 65000, 800, 1, 1, 0, NULL, 'fa-coins', '#E91E63'),
            ('Gastador Master', 'Gaste 100.000 cash para ganhar pontos!', 'spend_cash', 100000, 1200, 2, 1, 0, NULL, 'fa-coins', '#9C27B0'),
            ('Gastador Lendário', 'Gaste 150.000 cash para ganhar pontos!', 'spend_cash', 150000, 2000, 3, 1, 0, NULL, 'fa-coins', '#673AB7'),
            ('Top 1 GP', 'Alcance o primeiro lugar no ranking de GP!', 'top_1_gp', 1, 5000, 0, 1, 0, NULL, 'fa-crown', '#FFD700'),
            ('Top 3 GP', 'Fique entre os 3 primeiros no ranking de GP!', 'top_3_gp', 3, 3000, 1, 1, 0, NULL, 'fa-medal', '#C0C0C0')";
        @mysql_query($insert_defaults);
    }
}

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $title = mysql_real_escape_string($_POST['title'] ?? '');
        $description = mysql_real_escape_string($_POST['description'] ?? '');
        $mission_type = mysql_real_escape_string($_POST['mission_type'] ?? '');
        $target_value = (int)($_POST['target_value'] ?? 1);
        $event_points_reward = (int)($_POST['event_points_reward'] ?? 0);
        $event_score_index = (int)($_POST['event_score_index'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $repeatable = isset($_POST['repeatable']) ? 1 : 0;
        $repeat_interval = mysql_real_escape_string($_POST['repeat_interval'] ?? '');
        $icon = mysql_real_escape_string($_POST['icon'] ?? 'fa-star');
        $color = mysql_real_escape_string($_POST['color'] ?? '#6366f1');
        
        if (empty($title) || empty($description) || empty($mission_type)) {
            $error = 'Título, descrição e tipo são obrigatórios!';
        } else {
            $insert = mysql_query("INSERT INTO missions (title, description, mission_type, target_value, event_points_reward, event_score_index, is_active, repeatable, repeat_interval, icon, color) 
                                   VALUES ('$title', '$description', '$mission_type', $target_value, $event_points_reward, $event_score_index, $is_active, $repeatable, '$repeat_interval', '$icon', '$color')");
            
            if ($insert) {
                $success = "Missão criada com sucesso!";
            } else {
                $error = 'Erro ao criar missão: ' . mysql_error();
            }
        }
    } elseif ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $title = mysql_real_escape_string($_POST['title'] ?? '');
        $description = mysql_real_escape_string($_POST['description'] ?? '');
        $target_value = (int)($_POST['target_value'] ?? 1);
        $event_points_reward = (int)($_POST['event_points_reward'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        if ($id > 0 && !empty($title)) {
            $update = mysql_query("UPDATE missions SET title='$title', description='$description', target_value=$target_value, event_points_reward=$event_points_reward, is_active=$is_active WHERE id=$id");
            
            if ($update) {
                $success = "Missão atualizada com sucesso!";
            } else {
                $error = 'Erro ao atualizar missão: ' . mysql_error();
            }
        }
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $delete = mysql_query("DELETE FROM missions WHERE id=$id");
            if ($delete) {
                $success = "Missão deletada com sucesso!";
            } else {
                $error = 'Erro ao deletar missão: ' . mysql_error();
            }
        }
    }
}

// Listar missões
$missions = [];
$result = @mysql_query("SELECT * FROM missions ORDER BY id ASC");
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        $missions[] = $row;
    }
}
?>

<a name="maincontent"></a>

<h1>Gerenciar Missões</h1>
    <p>Crie e gerencie missões/eventos para os jogadores ganharem pontos.</p>
    
    <?php if ($success): ?>
        <div class="success-message">
            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
        <!-- Formulário -->
        <div class="admin-section">
            <h2>Criar Nova Missão</h2>
            <form method="post" style="padding: 1.5rem;">
                <input type="hidden" name="action" value="add">
                
                <dl>
                    <dt><label for="title">Título: *</label></dt>
                    <dd>
                        <input type="text" id="title" name="title" required maxlength="255" 
                               placeholder="Título da missão"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="description">Descrição: *</label></dt>
                    <dd>
                        <textarea id="description" name="description" required rows="3" 
                                  placeholder="Descrição da missão"
                                  style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;"></textarea>
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="mission_type">Tipo de Missão: *</label></dt>
                    <dd>
                        <select id="mission_type" name="mission_type" required
                                style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                            <option value="">Selecione...</option>
                            <option value="daily_login" <?php echo ($edit_mission['mission_type'] ?? '') == 'daily_login' ? 'selected' : ''; ?>>Login Diário</option>
                            <option value="play_games" <?php echo ($edit_mission['mission_type'] ?? '') == 'play_games' ? 'selected' : ''; ?>>Jogar Partidas</option>
                            <option value="win_games" <?php echo ($edit_mission['mission_type'] ?? '') == 'win_games' ? 'selected' : ''; ?>>Ganhar Partidas</option>
                            <option value="send_tweets" <?php echo ($edit_mission['mission_type'] ?? '') == 'send_tweets' ? 'selected' : ''; ?>>Enviar Tweets</option>
                            <option value="reach_rank" <?php echo ($edit_mission['mission_type'] ?? '') == 'reach_rank' ? 'selected' : ''; ?>>Alcançar Rank</option>
                            <option value="spend_cash" <?php echo ($edit_mission['mission_type'] ?? '') == 'spend_cash' ? 'selected' : ''; ?>>Gastar Cash</option>
                            <option value="top_1_gp" <?php echo ($edit_mission['mission_type'] ?? '') == 'top_1_gp' ? 'selected' : ''; ?>>Top 1 GP</option>
                            <option value="top_3_gp" <?php echo ($edit_mission['mission_type'] ?? '') == 'top_3_gp' ? 'selected' : ''; ?>>Top 3 GP</option>
                        </select>
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="target_value">Valor Alvo: *</label></dt>
                    <dd>
                        <input type="number" id="target_value" name="target_value" required min="1" value="1"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="event_points_reward">Pontos de Recompensa: *</label></dt>
                    <dd>
                        <input type="number" id="event_points_reward" name="event_points_reward" required min="0" value="100"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="event_score_index">Índice do Evento (0-3): *</label></dt>
                    <dd>
                        <input type="number" id="event_score_index" name="event_score_index" required min="0" max="3" value="0"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="icon">Ícone Font Awesome:</label></dt>
                    <dd>
                        <input type="text" id="icon" name="icon" value="fa-star" placeholder="fa-star"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="color">Cor (hex):</label></dt>
                    <dd>
                        <input type="color" id="color" name="color" value="#6366f1"
                               style="width: 100%; padding: 0.5rem; border: 2px solid var(--admin-border); border-radius: 8px; height: 50px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt>
                        <label>
                            <input type="checkbox" name="repeatable" value="1"> Missão Repetível
                        </label>
                    </dt>
                    <dd>
                        <select name="repeat_interval" style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                            <option value="">Não repetir</option>
                            <option value="daily">Diária</option>
                            <option value="weekly">Semanal</option>
                            <option value="monthly">Mensal</option>
                        </select>
                    </dd>
                </dl>
                
                <dl>
                    <dt>
                        <label>
                            <input type="checkbox" name="is_active" value="1" checked> Ativa
                        </label>
                    </dt>
                </dl>
                
                <p style="margin-top: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                                 color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                                 border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-plus"></i> Criar Missão
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Lista de Missões -->
        <div class="admin-section">
            <h2>Missões Existentes</h2>
            <div style="padding: 1.5rem; max-height: 600px; overflow-y: auto;">
                <?php if (count($missions) > 0): ?>
                    <?php foreach ($missions as $mission): ?>
                        <div style="padding: 1rem; margin-bottom: 1rem; background: var(--admin-bg); border-radius: 8px; border-left: 4px solid <?php echo htmlspecialchars($mission['color'] ?? '#6366f1'); ?>;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                <h3 style="margin: 0; font-size: 1rem; color: var(--admin-primary); flex: 1;">
                                    <i class="fas <?php echo htmlspecialchars($mission['icon'] ?? 'fa-star'); ?>"></i>
                                    <?php echo htmlspecialchars($mission['title']); ?>
                                </h3>
                                <div style="display: flex; gap: 0.5rem; margin-left: 1rem;">
                                    <a href="?edit=<?php echo $mission['id']; ?>" 
                                       style="padding: 0.4rem 0.8rem; background: var(--admin-primary); color: #fff; 
                                              border-radius: 6px; text-decoration: none; font-size: 0.85rem;">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form method="post" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja deletar esta missão?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $mission['id']; ?>">
                                        <button type="submit" style="padding: 0.4rem 0.8rem; background: #dc3545; color: #fff; 
                                                                      border: none; border-radius: 6px; font-size: 0.85rem; cursor: pointer;">
                                            <i class="fas fa-trash"></i> Deletar
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p style="margin: 0; font-size: 0.85rem; color: var(--admin-text-light);">
                                <?php echo htmlspecialchars($mission['description']); ?>
                            </p>
                            <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; color: var(--admin-text);">
                                <strong>Tipo:</strong> <?php echo htmlspecialchars($mission['mission_type']); ?> | 
                                <strong>Alvo:</strong> <?php echo $mission['target_value']; ?> | 
                                <strong>Recompensa:</strong> <?php echo $mission['event_points_reward']; ?> pts (Evento <?php echo $mission['event_score_index']; ?>) |
                                <strong>Status:</strong> <?php echo $mission['is_active'] ? '<span style="color: #28a745;">Ativa</span>' : '<span style="color: #dc3545;">Inativa</span>'; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: var(--admin-text-light); padding: 2rem;">
                        <i class="fas fa-info-circle"></i> Nenhuma missão criada ainda.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

