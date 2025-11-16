<?php 
include("header.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $item_id = (int)($_POST['item_id'] ?? 0);
        $item_name = mysql_real_escape_string($_POST['item_name'] ?? '');
        $item_type = mysql_real_escape_string($_POST['item_type'] ?? '');
        $price_gold = (int)($_POST['price_gold'] ?? 0);
        $price_cash = (int)($_POST['price_cash'] ?? 0);
        
        if (empty($item_id) || empty($item_name)) {
            $error = 'ID e nome do item são obrigatórios!';
        } else {
            // Verificar se já existe no MENU
            $check = mysql_query("SELECT Item1 FROM menu WHERE Item1 = $item_id");
            if (mysql_num_rows($check) > 0) {
                $error = 'Este item já está na loja!';
            } else {
                // Adicionar ao MENU (loja)
                $insert = mysql_query("INSERT INTO menu (menu_name, Item1, PriceByGoldForW, PriceByCashForW) 
                                       VALUES ('$item_name', $item_id, $price_gold, $price_cash)");
                
                if ($insert) {
                    $success = "Item adicionado à loja com sucesso!";
                } else {
                    $error = 'Erro ao adicionar item: ' . mysql_error();
                }
            }
        }
    }
    
    if ($action === 'remove') {
        $item_id = (int)($_POST['item_id'] ?? 0);
        if ($item_id) {
            $delete = mysql_query("DELETE FROM menu WHERE Item1 = $item_id");
            if ($delete) {
                $success = "Item removido da loja com sucesso!";
            } else {
                $error = 'Erro ao remover item: ' . mysql_error();
            }
        }
    }
}

// Buscar itens da loja
$store_items = [];
$result = @mysql_query("SELECT * FROM menu ORDER BY menu_name ASC LIMIT 100");
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        $store_items[] = $row;
    }
}

// Buscar tipos de itens disponíveis
$item_types = ['Head', 'Body', 'Glass', 'Flag', 'Set'];
?>

<a name="maincontent"></a>

<h1>Gerenciar Loja</h1>
    <p>Adicione ou remova avatares e itens da loja (Set completo, Cabeça, Corpo, Óculos, Bandeira, etc).</p>
    
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
            <h2>Adicionar Item à Loja</h2>
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
                               placeholder="Nome que aparecerá na loja"
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
                
                <dl>
                    <dt><label for="price_gold">Preço em Gold:</label></dt>
                    <dd>
                        <input type="number" id="price_gold" name="price_gold" value="0" min="0" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="price_cash">Preço em Cash:</label></dt>
                    <dd>
                        <input type="number" id="price_cash" name="price_cash" value="0" min="0" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <p style="margin-top: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                                 color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                                 border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-plus-circle"></i> Adicionar à Loja
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Lista de Itens -->
        <div class="admin-section">
            <h2>Itens na Loja</h2>
            <div style="padding: 1.5rem; max-height: 600px; overflow-y: auto;">
                <?php if (count($store_items) > 0): ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Gold</th>
                                <th>Cash</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($store_items as $item): ?>
                                <tr>
                                    <td><?php echo $item['Item1']; ?></td>
                                    <td><?php echo htmlspecialchars($item['menu_name']); ?></td>
                                    <td><?php echo number_format($item['PriceByGoldForW']); ?></td>
                                    <td><?php echo number_format($item['PriceByCashForW']); ?></td>
                                    <td>
                                        <form method="post" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja remover este item da loja?');">
                                            <input type="hidden" name="action" value="remove">
                                            <input type="hidden" name="item_id" value="<?php echo $item['Item1']; ?>">
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
                        <i class="fas fa-info-circle"></i> Nenhum item na loja.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

