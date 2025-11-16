<?php 
include("header.php");

$success = '';
$error = '';

// Verificar se tabela tokens existe e criar se necessário
$check_table = mysql_query("SHOW TABLES LIKE 'tokens'");
if (mysql_num_rows($check_table) == 0) {
    $create_tokens_table = "
    CREATE TABLE `tokens` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `token_code` VARCHAR(32) NOT NULL UNIQUE,
        `type` ENUM('cash', 'gold', 'avatar', 'item') NOT NULL,
        `item_id` INT NULL,
        `quantity` INT NOT NULL DEFAULT 1,
        `expire_days` INT NULL COMMENT 'Dias até o item expirar (apenas para avatar/item)',
        `uses_left` INT NOT NULL DEFAULT 1,
        `expires_at` DATETIME NULL COMMENT 'Data de expiração do token',
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `created_by` VARCHAR(16) NOT NULL,
        `description` TEXT NULL,
        INDEX `idx_token_code` (`token_code`),
        INDEX `idx_type` (`type`),
        INDEX `idx_expires_at` (`expires_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";
    @mysql_query($create_tokens_table);
} else {
    // Verificar estrutura atual da tabela
    $columns_result = mysql_query("SHOW COLUMNS FROM tokens");
    $existing_columns_info = [];
    if ($columns_result) {
        while ($col = mysql_fetch_assoc($columns_result)) {
            $existing_columns_info[$col['Field']] = $col;
        }
    }
    
    // Verificar e adicionar colunas se não existirem
    $columns_to_check = [
        'token_code' => "VARCHAR(32) NOT NULL UNIQUE",
        'token' => "VARCHAR(200) NULL", // Coluna alternativa 'token' (pode ser NULL)
        'quantity' => "INT NOT NULL DEFAULT 1",
        'value' => "INT NOT NULL DEFAULT 1", // Coluna alternativa 'value' (pode existir junto com quantity)
        'expire_days' => "INT NULL",
        'uses_left' => "INT NOT NULL DEFAULT 1",
        'expires_at' => "DATETIME NULL",
        'created_at' => "DATETIME DEFAULT CURRENT_TIMESTAMP",
        'created_by' => "VARCHAR(16) NOT NULL",
        'description' => "TEXT NULL"
    ];
    
    foreach ($columns_to_check as $col_name => $col_def) {
        if (!isset($existing_columns_info[$col_name])) {
            $after = '';
            if ($col_name == 'token_code' || $col_name == 'token') {
                $after = 'AFTER `id`';
            } elseif ($col_name == 'quantity' || $col_name == 'value') {
                $after = 'AFTER `item_id`';
            }
            @mysql_query("ALTER TABLE tokens ADD COLUMN `$col_name` $col_def $after");
        }
    }
}

// Verificar se tabela token_logs existe e criar se necessário
$check_log_table = mysql_query("SHOW TABLES LIKE 'token_logs'");
if (mysql_num_rows($check_log_table) == 0) {
    $create_token_logs_table = "
    CREATE TABLE `token_logs` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `token_id` INT NOT NULL,
        `token_code` VARCHAR(32) NOT NULL,
        `redeemed_by` VARCHAR(16) NOT NULL,
        `redeemed_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `item_inserted` TINYINT(1) DEFAULT 0,
        `chest_id` INT NULL COMMENT 'ID do item inserido no chest',
        INDEX `idx_token_id` (`token_id`),
        INDEX `idx_redeemed_by` (`redeemed_by`),
        INDEX `idx_redeemed_at` (`redeemed_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";
    @mysql_query($create_token_logs_table);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = mysql_real_escape_string($_POST['type'] ?? '');
    $item_id = !empty($_POST['item_id']) ? (int)$_POST['item_id'] : null;
    $quantity = (int)($_POST['quantity'] ?? 1);
    $expire_days = !empty($_POST['expire_days']) ? (int)$_POST['expire_days'] : null;
    $uses_left = (int)($_POST['uses_left'] ?? 1);
    $expires_at = !empty($_POST['expires_at']) ? mysql_real_escape_string($_POST['expires_at']) : null;
    $description = mysql_real_escape_string($_POST['description'] ?? '');
    $admin_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? 'Admin';
    
    if (empty($type)) {
        $error = 'Selecione o tipo de token!';
    } elseif (($type === 'avatar' || $type === 'item') && empty($item_id)) {
        $error = 'Para avatar/item, é necessário informar o ID do item!';
    } elseif ($quantity <= 0) {
        $error = 'A quantidade deve ser maior que zero!';
    } elseif ($uses_left <= 0) {
        $error = 'O número de usos deve ser maior que zero!';
    } else {
        // Gerar token único
        // Verificar qual coluna existe para fazer a verificação de duplicata
        $columns_result_check = mysql_query("SHOW COLUMNS FROM tokens");
        $has_token_code = false;
        $has_token = false;
        if ($columns_result_check) {
            while ($col = mysql_fetch_assoc($columns_result_check)) {
                if ($col['Field'] == 'token_code') $has_token_code = true;
                if ($col['Field'] == 'token') $has_token = true;
            }
        }
        
        do {
            $token_code = strtoupper(bin2hex(random_bytes(8))); // 16 caracteres hex
            if ($has_token_code) {
                $check = mysql_query("SELECT id FROM tokens WHERE token_code = '$token_code'");
            } elseif ($has_token) {
                $check = mysql_query("SELECT id FROM tokens WHERE token = '$token_code'");
            } else {
                $check = mysql_query("SELECT id FROM tokens WHERE token_code = '$token_code' OR token = '$token_code'");
            }
        } while (mysql_num_rows($check) > 0);
        
        // Verificar quais colunas existem na tabela
        $columns_result = mysql_query("SHOW COLUMNS FROM tokens");
        $existing_columns = [];
        if ($columns_result) {
            while ($col = mysql_fetch_assoc($columns_result)) {
                $existing_columns[] = $col['Field'];
            }
        }
        
        // Construir query dinamicamente baseado nas colunas existentes
        $insert_fields = [];
        $insert_values = [];
        
        // Verificar se existe coluna 'token' (sem _code) - pode ser obrigatória
        if (in_array('token', $existing_columns)) {
            $insert_fields[] = 'token';
            $insert_values[] = "'$token_code'";
        }
        
        // Verificar se existe coluna 'token_code'
        if (in_array('token_code', $existing_columns)) {
            $insert_fields[] = 'token_code';
            $insert_values[] = "'$token_code'";
        }
        
        if (in_array('type', $existing_columns)) {
            $insert_fields[] = 'type';
            $insert_values[] = "'$type'";
        }
        if (in_array('item_id', $existing_columns)) {
            $insert_fields[] = 'item_id';
            $insert_values[] = $item_id ? $item_id : 'NULL';
        }
        // Incluir 'quantity' se existir
        if (in_array('quantity', $existing_columns)) {
            $insert_fields[] = 'quantity';
            $insert_values[] = $quantity;
        }
        
        // Incluir 'value' se existir (pode existir junto com quantity ou sozinha)
        if (in_array('value', $existing_columns)) {
            $insert_fields[] = 'value';
            $insert_values[] = $quantity;
        }
        if (in_array('expire_days', $existing_columns)) {
            $insert_fields[] = 'expire_days';
            $insert_values[] = $expire_days ? $expire_days : 'NULL';
        }
        if (in_array('uses_left', $existing_columns)) {
            $insert_fields[] = 'uses_left';
            $insert_values[] = $uses_left;
        }
        if (in_array('expires_at', $existing_columns)) {
            $insert_fields[] = 'expires_at';
            $insert_values[] = $expires_at ? "'$expires_at'" : 'NULL';
        }
        if (in_array('created_by', $existing_columns)) {
            $insert_fields[] = 'created_by';
            $insert_values[] = "'$admin_id'";
        }
        if (in_array('description', $existing_columns)) {
            $insert_fields[] = 'description';
            $insert_values[] = $description ? "'$description'" : 'NULL';
        }
        
        $fields_str = implode(', ', $insert_fields);
        $values_str = implode(', ', $insert_values);
        
        $insert = mysql_query("INSERT INTO tokens ($fields_str) VALUES ($values_str)");
        
        if ($insert) {
            $success = "Token criado com sucesso! Código: <strong style='font-family: monospace; background: #f1f5f9; padding: 0.5rem; border-radius: 6px;'>$token_code</strong>";
        } else {
            $error = 'Erro ao criar token: ' . mysql_error();
        }
    }
}

// Buscar tokens criados
$tokens = [];
$result = @mysql_query("SELECT t.*, 
                        (SELECT COUNT(*) FROM token_logs WHERE token_id = t.id) as times_used,
                        (SELECT redeemed_by FROM token_logs WHERE token_id = t.id ORDER BY redeemed_at DESC LIMIT 1) as last_redeemed_by
                        FROM tokens t ORDER BY created_at DESC LIMIT 50");
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        $tokens[] = $row;
    }
}
?>

<a name="maincontent"></a>

<h1>Criar Token de Resgate</h1>
<p>Crie tokens que podem ser resgatados por usuários. Tokens de avatar/item serão inseridos na tabela CHEST.</p>

<?php if ($success): ?>
    <div class="success-message">
        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
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
        <h2>Criar Novo Token</h2>
        <form method="post" style="padding: 1.5rem;">
            <dl>
                <dt><label for="type">Tipo de Token:</label></dt>
                <dd>
                    <select id="type" name="type" required style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                        <option value="">Selecione o tipo</option>
                        <option value="cash">Cash</option>
                        <option value="gold">Gold</option>
                        <option value="avatar">Avatar (insere em CHEST)</option>
                        <option value="item">Item (insere em CHEST)</option>
                    </select>
                </dd>
            </dl>
            
            <dl id="item_id_field" style="display: none;">
                <dt><label for="item_id">ID do Item:</label></dt>
                <dd>
                    <input type="number" id="item_id" name="item_id" 
                           placeholder="Ex: 200001"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    <small>ID do item que será inserido no CHEST</small>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="quantity">Quantidade:</label></dt>
                <dd>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" required
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    <small>Para avatar/item: quantidade de itens. Para cash/gold: valor.</small>
                </dd>
            </dl>
            
            <dl id="expire_days_field" style="display: none;">
                <dt><label for="expire_days">Dias até Expirar o Item:</label></dt>
                <dd>
                    <input type="number" id="expire_days" name="expire_days" min="1"
                           placeholder="Ex: 30 (30 dias)"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    <small>Deixe em branco para item permanente</small>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="uses_left">Usos Restantes:</label></dt>
                <dd>
                    <input type="number" id="uses_left" name="uses_left" value="1" min="1" required
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    <small>Quantas vezes este token pode ser usado</small>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="expires_at">Token Expira em:</label></dt>
                <dd>
                    <input type="datetime-local" id="expires_at" name="expires_at"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    <small>Deixe em branco para token sem expiração</small>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="description">Descrição (opcional):</label></dt>
                <dd>
                    <textarea id="description" name="description" rows="3"
                              style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;"></textarea>
                </dd>
            </dl>
            
            <p style="margin-top: 1rem;">
                <button type="submit" class="button1">
                    <i class="fas fa-plus-circle"></i> Criar Token
                </button>
            </p>
        </form>
    </div>
    
    <!-- Lista de Tokens -->
    <div class="admin-section">
        <h2>Tokens Criados</h2>
        <div style="padding: 1.5rem; max-height: 600px; overflow-y: auto;">
            <?php if (count($tokens) > 0): ?>
                <table class="admin-table" style="width: 100%; font-size: 0.85rem;">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Usos</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tokens as $token): ?>
                            <tr>
                                <td><code style="font-size: 0.75rem;"><?php echo htmlspecialchars($token['token_code']); ?></code></td>
                                <td><?php echo htmlspecialchars($token['type']); ?></td>
                                <td><?php echo ($token['times_used'] ?? 0) . '/' . $token['uses_left']; ?></td>
                                <td>
                                    <?php 
                                    $now = date('Y-m-d H:i:s');
                                    if ($token['expires_at'] && $token['expires_at'] < $now) {
                                        echo '<span style="color: #dc3545;">Expirado</span>';
                                    } elseif (($token['times_used'] ?? 0) >= $token['uses_left']) {
                                        echo '<span style="color: #6c757d;">Esgotado</span>';
                                    } else {
                                        echo '<span style="color: #28a745;">Ativo</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: var(--admin-text-light); padding: 2rem;">
                    <i class="fas fa-info-circle"></i> Nenhum token criado ainda.
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.getElementById('type').addEventListener('change', function() {
    var itemField = document.getElementById('item_id_field');
    var expireField = document.getElementById('expire_days_field');
    var itemInput = document.getElementById('item_id');
    
    if (this.value === 'avatar' || this.value === 'item') {
        itemField.style.display = 'block';
        expireField.style.display = 'block';
        itemInput.required = true;
    } else {
        itemField.style.display = 'none';
        expireField.style.display = 'none';
        itemInput.required = false;
    }
});
</script>

<?php include("footer.php"); ?>
