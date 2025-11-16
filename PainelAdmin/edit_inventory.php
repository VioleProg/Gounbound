<?php 
include("header.php");

$user_id_search = mysql_real_escape_string($_GET['user_id'] ?? '');
$success = '';
$error = '';
$inventory_items = [];
$menu_items = [];

// Buscar itens do MENU para seleção
$menu_result = @mysql_query("SELECT Item1, menu_name, ItemType FROM MENU ORDER BY menu_name LIMIT 500");
if ($menu_result) {
    while ($row = mysql_fetch_assoc($menu_result)) {
        $menu_items[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
    
    if (empty($user_id)) {
        $error = 'ID do Usuário é obrigatório!';
    } else {
        // Verificar se usuário existe
        $user_check = mysql_query("SELECT Id FROM game WHERE Id='$user_id'");
        if (mysql_num_rows($user_check) == 0) {
            $error = 'Usuário não encontrado!';
        } else {
            if ($action === 'add_item') {
                $item_id = mysql_real_escape_string($_POST['item_id'] ?? '');
                $quantity = (int)($_POST['quantity'] ?? 1);
                $expire_days = !empty($_POST['expire_days']) ? (int)$_POST['expire_days'] : null;
                
                if (empty($item_id) || $quantity <= 0) {
                    $error = 'Preencha o ID do Item e a Quantidade.';
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
                            $error = 'Erro ao adicionar item: ' . mysql_error();
                            break;
                        }
                    }
                    if (empty($error)) {
                        $expire_text = $expire_date ? " (expira em " . date('d/m/Y', strtotime($expire_date)) . ")" : " (permanente)";
                        $success = "Item(s) adicionado(s) com sucesso ao inventário de '$user_id'! ($quantity item(s))$expire_text";
                    }
                }
            } elseif ($action === 'remove_item') {
                $chest_id = mysql_real_escape_string($_POST['chest_id'] ?? '');
                if (empty($chest_id)) {
                    $error = 'ID do item no inventário é obrigatório.';
                } else {
                    $delete = mysql_query("DELETE FROM chest WHERE No = '$chest_id' AND Owner = '$user_id'");
                    if ($delete) {
                        $success = "Item removido com sucesso do inventário de '$user_id'!";
                    } else {
                        $error = 'Erro ao remover item ou item não encontrado no inventário do usuário.';
                    }
                }
            } elseif ($action === 'toggle_equip') {
                $chest_id = mysql_real_escape_string($_POST['chest_id'] ?? '');
                $current_wearing = mysql_real_escape_string($_POST['current_wearing'] ?? '0');
                $new_wearing = $current_wearing == '1' ? '0' : '1';
                
                if (empty($chest_id)) {
                    $error = 'ID do item no inventário é obrigatório.';
                } else {
                    $update = mysql_query("UPDATE chest SET Wearing = '$new_wearing' WHERE No = '$chest_id' AND Owner = '$user_id'");
                    if ($update) {
                        $success = "Status de equipamento do item atualizado com sucesso!";
                    } else {
                        $error = 'Erro ao atualizar status de equipamento do item.';
                    }
                }
            }
        }
    }
    // Redirecionar para evitar reenvio do formulário
    header("Location: edit_inventory.php?user_id=" . urlencode($user_id) . "&success=" . urlencode($success) . "&error=" . urlencode($error));
    exit;
}

// Se um user_id foi fornecido via GET, buscar inventário
if (!empty($user_id_search)) {
    $sql = "SELECT c.No, c.Item, c.Wearing, m.menu_name, m.ItemType
            FROM chest c
            LEFT JOIN MENU m ON c.Item = m.Item1
            WHERE c.Owner = '$user_id_search'
            ORDER BY c.Wearing DESC, m.menu_name ASC";
    $result = @mysql_query($sql);
    if ($result) {
        while ($row = mysql_fetch_assoc($result)) {
            $inventory_items[] = $row;
        }
    }
}

// Exibir mensagens de sucesso/erro de redirecionamento
if (isset($_GET['success'])) {
    $success = htmlspecialchars($_GET['success']);
}
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
}
?>

<a name="maincontent"></a>

<h1>Editar Inventário</h1>
    <p>Gerencie os itens no inventário dos usuários.</p>
    
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
    
    <!-- Formulário de Busca de Usuário -->
    <div class="admin-section" style="max-width: 600px; margin-bottom: 2rem;">
        <h2>Buscar Inventário por Usuário</h2>
        <form method="get" action="" style="padding: 1.5rem;">
            <dl>
                <dt><label for="search_user_id">ID do Usuário:</label></dt>
                <dd>
                    <input type="text" id="search_user_id" name="user_id" value="<?php echo htmlspecialchars($user_id_search); ?>" required 
                           placeholder="Digite o ID do usuário"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            <p class="quick" style="margin-top: 1rem;">
                <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                             color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                             border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> Buscar Inventário
                </button>
            </p>
        </form>
    </div>
    
    <?php if (!empty($user_id_search)): ?>
        <!-- Adicionar Item ao Inventário -->
        <div class="admin-section" style="max-width: 600px; margin-bottom: 2rem;">
            <h2>Adicionar Item a <?php echo htmlspecialchars($user_id_search); ?></h2>
            <form method="post" action="" style="padding: 1.5rem;">
                <input type="hidden" name="action" value="add_item">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id_search); ?>">
                <dl>
                    <dt><label for="add_item_id">ID do Item:</label></dt>
                    <dd>
                        <select id="add_item_id" name="item_id" style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;" required>
                            <option value="">Selecione um item</option>
                            <?php foreach ($menu_items as $item): ?>
                                <option value="<?php echo htmlspecialchars($item['Item1']); ?>">
                                    <?php echo htmlspecialchars($item['menu_name'] . " (ID: " . $item['Item1'] . " - Tipo: " . ($item['ItemType'] ?? 'N/A') . ")"); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt><label for="add_quantity">Quantidade:</label></dt>
                    <dd>
                        <input type="number" id="add_quantity" name="quantity" value="1" min="1" required 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                        <small>Quantidade de itens a serem adicionados</small>
                    </dd>
                </dl>
                <dl>
                    <dt><label for="add_expire_days">Dias até Expirar (opcional):</label></dt>
                    <dd>
                        <input type="number" id="add_expire_days" name="expire_days" min="1"
                               placeholder="Ex: 30 (30 dias) - deixe em branco para permanente"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                        <small>Deixe em branco para item permanente</small>
                    </dd>
                </dl>
                <p class="quick" style="margin-top: 1rem;">
                    <button type="submit" style="background: var(--admin-success); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-plus-circle"></i> Adicionar Item
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Inventário do Usuário -->
        <div class="admin-section">
            <h2>Inventário de <?php echo htmlspecialchars($user_id_search); ?></h2>
            <table class="admin-table" style="margin-top: 1rem;">
                <thead>
                    <tr>
                        <th>Seq</th>
                        <th>ID do Item</th>
                        <th>Nome do Item</th>
                        <th>Tipo</th>
                        <th>Equipado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($inventory_items) > 0) {
                        foreach ($inventory_items as $item) {
                            $wearing_status = $item['Wearing'] == '1' ? '<span style="color: var(--admin-success); font-weight: 600;">Sim</span>' : '<span style="color: var(--admin-text-light);">Não</span>';
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($item['No']) . '</td>';
                            echo '<td>' . htmlspecialchars($item['Item']) . '</td>';
                            echo '<td>' . htmlspecialchars($item['menu_name'] ?? 'Desconhecido') . '</td>';
                            echo '<td>' . htmlspecialchars($item['ItemType'] ?? 'N/A') . '</td>';
                            echo '<td>' . $wearing_status . '</td>';
                            echo '<td style="white-space: nowrap;">';
                            echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja ' . ($item['Wearing'] == '1' ? 'desequipar' : 'equipar') . ' este item?\');">';
                            echo '<input type="hidden" name="action" value="toggle_equip">';
                            echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($user_id_search) . '">';
                            echo '<input type="hidden" name="chest_id" value="' . htmlspecialchars($item['No']) . '">';
                            echo '<input type="hidden" name="current_wearing" value="' . htmlspecialchars($item['Wearing']) . '">';
                            echo '<button type="submit" style="background: var(--admin-info); color: white; padding: 0.25rem 0.5rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.8rem; margin-right: 0.25rem;">' . ($item['Wearing'] == '1' ? 'Desequipar' : 'Equipar') . '</button>';
                            echo '</form>';
                            echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja remover este item do inventário?\');">';
                            echo '<input type="hidden" name="action" value="remove_item">';
                            echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($user_id_search) . '">';
                            echo '<input type="hidden" name="chest_id" value="' . htmlspecialchars($item['No']) . '">';
                            echo '<button type="submit" style="background: var(--admin-error); color: white; padding: 0.25rem 0.5rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.8rem;"><i class="fas fa-trash"></i> Remover</button>';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6" style="text-align: center; padding: 2rem;">Nenhum item encontrado no inventário deste usuário.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

