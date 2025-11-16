<?php 
include("header.php");

$success = '';
$error = '';

// Criar tabela de loja de eventos se não existir
$check_table = mysql_query("SHOW TABLES LIKE 'event_store'");
if (mysql_num_rows($check_table) == 0) {
    $create_table = "CREATE TABLE `event_store` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `item_id` int(11) NOT NULL,
        `item_name` varchar(255) NOT NULL,
        `event_points` int(11) NOT NULL,
        `item_type` varchar(50) DEFAULT NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `item_id` (`item_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    @mysql_query($create_table);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $item_id = (int)($_POST['item_id'] ?? 0);
        $item_name = mysql_real_escape_string($_POST['item_name'] ?? '');
        $event_points = (int)($_POST['event_points'] ?? 0);
        $item_type = mysql_real_escape_string($_POST['item_type'] ?? '');
        
        if (empty($item_id) || empty($item_name) || $event_points <= 0) {
            $error = 'Preencha todos os campos obrigatórios!';
        } else {
            // Verificar se já existe
            $check = mysql_query("SELECT id FROM event_store WHERE item_id = $item_id");
            if (mysql_num_rows($check) > 0) {
                $error = 'Este item já está na loja de eventos!';
            } else {
                $insert = mysql_query("INSERT INTO event_store (item_id, item_name, event_points, item_type) 
                                       VALUES ($item_id, '$item_name', $event_points, '$item_type')");
                
                if ($insert) {
                    $success = "Item adicionado à loja de eventos com sucesso!";
                } else {
                    $error = 'Erro ao adicionar item: ' . mysql_error();
                }
            }
        }
    }
    
    if ($action === 'remove') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $delete = mysql_query("DELETE FROM event_store WHERE id = $id");
            if ($delete) {
                $success = "Item removido da loja de eventos com sucesso!";
            } else {
                $error = 'Erro ao remover item: ' . mysql_error();
            }
        }
    }
}

// Buscar itens da loja de eventos
$event_items = [];
$result = @mysql_query("SELECT * FROM event_store ORDER BY event_points ASC");
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        $event_items[] = $row;
    }
}

$item_types = ['Head', 'Body', 'Glass', 'Flag', 'Set'];
?>

<a name="maincontent"></a>

<h1>Gerenciar Loja de Eventos</h1>
    <p>Adicione ou remova avatares/itens da loja de eventos (resgatáveis com pontos de evento).</p>
    
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
            <h2>Adicionar Item à Loja de Eventos</h2>
            <form method="post" style="padding: 1.5rem;">
                <input type="hidden" name="action" value="add">
                
                <dl>
                    <dt><label for="item_id">ID do Item/Avatar:</label></dt>
                    <dd>
                        <input type="number" id="item_id" name="item_id" required min="1" 
                               placeholder="ID numérico do item"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="item_name">Nome do Item:</label></dt>
                    <dd>
                        <input type="text" id="item_name" name="item_name" required maxlength="255" 
                               placeholder="Nome do item"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="event_points">Pontos de Evento Necessários:</label></dt>
                    <dd>
                        <input type="number" id="event_points" name="event_points" required min="1" 
                               placeholder="Quantidade de pontos de evento"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="item_type">Tipo (opcional):</label></dt>
                    <dd>
                        <select id="item_type" name="item_type" style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                            <option value="">Selecione o tipo</option>
                            <?php foreach ($item_types as $type): ?>
                                <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </dd>
                </dl>
                
                <p style="margin-top: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                                 color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                                 border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-gift"></i> Adicionar à Loja de Eventos
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Lista de Itens -->
        <div class="admin-section">
            <h2>Itens na Loja de Eventos</h2>
            <div style="padding: 1.5rem; max-height: 600px; overflow-y: auto;">
                <?php if (count($event_items) > 0): ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Pontos</th>
                                <th>Tipo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($event_items as $item): ?>
                                <tr>
                                    <td><?php echo $item['item_id']; ?></td>
                                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                    <td><strong style="color: var(--admin-secondary);"><?php echo number_format($item['event_points']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($item['item_type'] ?? 'N/A'); ?></td>
                                    <td>
                                        <form method="post" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja remover este item?');">
                                            <input type="hidden" name="action" value="remove">
                                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                            <button type="submit" style="background: var(--admin-error); color: white; padding: 0.25rem 0.5rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.8rem;">
                                                <i class="fas fa-trash"></i> Remover
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; color: var(--admin-text-light); padding: 2rem;">
                        <i class="fas fa-info-circle"></i> Nenhum item na loja de eventos.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

