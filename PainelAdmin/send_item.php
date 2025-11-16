<?php 
include("header.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
    $item_id = mysql_real_escape_string($_POST['item_id'] ?? '');
    $item_type = mysql_real_escape_string($_POST['item_type'] ?? 'avatar');
    $quantity = (int)($_POST['quantity'] ?? 1);
    $expire_days = !empty($_POST['expire_days']) ? (int)$_POST['expire_days'] : null;
    
    if (empty($user_id) || empty($item_id)) {
        $error = 'Preencha todos os campos obrigatórios!';
    } elseif ($quantity <= 0) {
        $error = 'A quantidade deve ser maior que zero!';
    } else {
        // Verificar se usuário existe
        $user_check = mysql_query("SELECT Id FROM game WHERE Id='$user_id'");
        if (mysql_num_rows($user_check) == 0) {
            $error = 'Usuário não encontrado!';
        } else {
            // Calcular data de expiração
            $expire_date = null;
            if ($expire_days && $expire_days > 0) {
                $expire_date = date('Y-m-d H:i:s', strtotime("+$expire_days days"));
            }
            
            // Inserir item(s) no chest com todos os campos necessários
            // Se quantidade > 1, criar múltiplos registros, cada um com Volume = 1
            for ($i = 0; $i < $quantity; $i++) {
                $expire_sql = $expire_date ? "'$expire_date'" : 'NULL';
                $insert = mysql_query("INSERT INTO chest (Owner, Item, Wearing, Acquisition, Volume, Expire, ExpireType) 
                                      VALUES ('$user_id', '$item_id', '0', 'G', 1, $expire_sql, 'W')");
                if (!$insert) {
                    $error = 'Erro ao enviar item: ' . mysql_error();
                    break;
                }
            }
            if (empty($error)) {
                $expire_text = $expire_date ? " (expira em " . date('d/m/Y', strtotime($expire_date)) . ")" : " (permanente)";
                $success = "Item(s) enviado(s) com sucesso! ($quantity item(s))$expire_text";
            }
        }
    }
}

// Buscar lista de itens do MENU para referência
$items_result = mysql_query("SELECT DISTINCT Item1, menu_name FROM MENU WHERE Item1 IS NOT NULL AND menu_name IS NOT NULL ORDER BY menu_name LIMIT 100");
$items_list = [];
if ($items_result) {
    while ($row = mysql_fetch_assoc($items_result)) {
        $items_list[] = $row;
    }
}
?>

<a name="maincontent"></a>

<h1>Enviar Item</h1>
<p>Envie itens para usuários. Todos os itens serão inseridos com Acquisition='G' e ExpireType='W'.</p>

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

<div class="admin-section" style="max-width: 600px; margin-top: 2rem;">
    <h2>Enviar Item ao Usuário</h2>
    
    <form method="post" style="padding: 1.5rem;">
        <dl>
            <dt><label for="user_id">ID do Usuário:</label></dt>
            <dd>
                <input type="text" id="user_id" name="user_id" required 
                       placeholder="Digite o ID do usuário" 
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
            </dd>
        </dl>
        
        <dl>
            <dt><label for="item_type">Tipo de Item:</label></dt>
            <dd>
                <select id="item_type" name="item_type" 
                        style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    <option value="avatar">Avatar</option>
                    <option value="item">Item</option>
                    <option value="consumable">Consumível</option>
                </select>
            </dd>
        </dl>
        
        <dl>
            <dt><label for="item_id">ID do Item:</label></dt>
            <dd>
                <input type="text" id="item_id" name="item_id" required 
                       placeholder="Digite o código do item" 
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                <small style="color: var(--admin-text-light); margin-top: 0.5rem; display: block;">
                    Digite o código numérico do item (ex: 1001, 2005, etc.)
                </small>
            </dd>
        </dl>
        
        <dl>
            <dt><label for="quantity">Quantidade:</label></dt>
            <dd>
                <input type="number" id="quantity" name="quantity" min="1" max="100" value="1" required 
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                <small>Quantidade de itens a serem enviados</small>
            </dd>
        </dl>
        
        <dl>
            <dt><label for="expire_days">Dias até Expirar (opcional):</label></dt>
            <dd>
                <input type="number" id="expire_days" name="expire_days" min="1"
                       placeholder="Ex: 30 (30 dias) - deixe em branco para permanente"
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                <small>Deixe em branco para item permanente</small>
            </dd>
        </dl>
        
        <p style="margin-top: 1.5rem;">
            <button type="submit" class="button1">
                <i class="fas fa-paper-plane"></i> Enviar Item
            </button>
            <a href="admin_panel.php" class="button1">Voltar</a>
        </p>
    </form>
</div>

<?php if (count($items_list) > 0): ?>
<div class="admin-section" style="max-width: 600px; margin-top: 2rem;">
    <h2>Referência de Itens (Primeiros 100)</h2>
    <div style="max-height: 400px; overflow-y: auto; padding: 1rem;">
        <table class="admin-table" style="font-size: 0.85rem;">
            <thead>
                <tr>
                    <th>ID do Item</th>
                    <th>Nome</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items_list as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['Item1']); ?></td>
                        <td><?php echo htmlspecialchars($item['menu_name']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php include("footer.php"); ?>
