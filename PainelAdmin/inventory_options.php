<?php 
// verify.php já é incluído em header.php
include("header.php"); 
include("../mesh.php");

$user_id = mysql_real_escape_string($_GET['user_id'] ?? '');
$action = $_GET['action'] ?? '';
$success = '';
$error = '';

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action_post = $_POST['action'] ?? '';
    
    if ($action_post === 'add_item') {
        $user_id_post = mysql_real_escape_string($_POST['user_id'] ?? '');
        $item_id = mysql_real_escape_string($_POST['item_id'] ?? '');
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        if (empty($user_id_post) || empty($item_id)) {
            $error = 'Preencha todos os campos!';
        } else {
            // Calcular data de expiração (opcional, pode adicionar campo depois)
            $expire_date = null; // Pode ser adicionado depois se necessário
            $expire_sql = $expire_date ? "'$expire_date'" : 'NULL';
            
            for ($i = 0; $i < $quantity; $i++) {
                $insert = mysql_query("INSERT INTO chest (Owner, Item, Wearing, Acquisition, Volume, Expire, ExpireType) 
                                      VALUES ('$user_id_post', '$item_id', '0', 'G', 1, $expire_sql, 'W')");
                if (!$insert) {
                    $error = 'Erro ao adicionar item: ' . mysql_error();
                    break;
                }
            }
            if (empty($error)) {
                $success = "Item(s) adicionado(s) com sucesso! ($quantity item(s))";
            }
        }
    }
    
    if ($action_post === 'remove_item') {
        $chest_id = (int)($_POST['chest_id'] ?? 0);
        if ($chest_id) {
            $delete = mysql_query("DELETE FROM chest WHERE id = $chest_id");
            if ($delete) {
                $success = "Item removido com sucesso!";
            } else {
                $error = 'Erro ao remover item!';
            }
        }
    }
    
    if ($action_post === 'equip_item') {
        $chest_id = (int)($_POST['chest_id'] ?? 0);
        $wearing = (int)($_POST['wearing'] ?? 0);
        if ($chest_id) {
            $update = mysql_query("UPDATE chest SET Wearing = $wearing WHERE id = $chest_id");
            if ($update) {
                $success = "Item " . ($wearing ? "equipado" : "desequipado") . " com sucesso!";
            } else {
                $error = 'Erro ao alterar item!';
            }
        }
    }
}

// Buscar inventário do usuário
$inventory = [];
if ($user_id) {
    $result = mysql_query("SELECT c.*, m.menu_name, m.ItemType 
                          FROM chest c 
                          LEFT JOIN MENU m ON c.Item = m.Item1 
                          WHERE c.Owner = '$user_id' 
                          ORDER BY c.Wearing DESC, m.menu_name");
    while ($row = mysql_fetch_assoc($result)) {
        $inventory[] = $row;
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Opções de Inventário</h1>
    <p>Gerencie o inventário dos usuários.</p>
    
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
    
    <!-- Buscar Usuário -->
    <div class="admin-section" style="max-width: 600px; margin-bottom: 2rem;">
        <h2>Buscar Usuário</h2>
        <form method="get" style="padding: 1.5rem;">
            <dl>
                <dt><label for="user_id">ID do Usuário:</label></dt>
                <dd>
                    <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" 
                           placeholder="Digite o ID do usuário" 
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            <p style="margin-top: 1rem;">
                <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                             color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                             border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> Buscar Inventário
                </button>
            </p>
        </form>
    </div>
    
    <?php if ($user_id): ?>
        <!-- Adicionar Item -->
        <div class="admin-section" style="max-width: 600px; margin-bottom: 2rem;">
            <h2>Adicionar Item</h2>
            <form method="post" style="padding: 1.5rem;">
                <input type="hidden" name="action" value="add_item">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                
                <dl>
                    <dt><label for="item_id">ID do Item:</label></dt>
                    <dd>
                        <input type="text" id="item_id" name="item_id" required 
                               placeholder="Digite o código do item" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="quantity">Quantidade:</label></dt>
                    <dd>
                        <input type="number" id="quantity" name="quantity" min="1" max="100" value="1" required 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <p style="margin-top: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                                 color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                                 border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-plus"></i> Adicionar Item
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Lista de Itens -->
        <div class="admin-section">
            <h2>Inventário de <?php echo htmlspecialchars($user_id); ?></h2>
            <p>Total de itens: <strong><?php echo count($inventory); ?></strong></p>
            
            <table width='100%' cellspacing="1" class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Equipado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($inventory) > 0) {
                        foreach ($inventory as $item) {
                            $equipped = $item['Wearing'] ? 'Sim' : 'Não';
                            $equipped_class = $item['Wearing'] ? 'style="color: green; font-weight: bold;"' : '';
                            
                            echo '<tr class="row2">';
                            echo '<td>' . htmlspecialchars($item['id'] ?? 'N/A') . '</td>';
                            echo '<td>' . htmlspecialchars($item['Item']) . '</td>';
                            echo '<td>' . htmlspecialchars($item['menu_name'] ?? 'Item ' . $item['Item']) . '</td>';
                            echo '<td>' . htmlspecialchars($item['ItemType'] ?? 'N/A') . '</td>';
                            echo '<td ' . $equipped_class . '>' . $equipped . '</td>';
                            echo '<td>';
                            
                            // Botão Equipar/Desequipar
                            echo '<form method="post" style="display: inline;">';
                            echo '<input type="hidden" name="action" value="equip_item">';
                            echo '<input type="hidden" name="chest_id" value="' . ($item['id'] ?? '') . '">';
                            echo '<input type="hidden" name="wearing" value="' . ($item['Wearing'] ? '0' : '1') . '">';
                            echo '<button type="submit" style="background: ' . ($item['Wearing'] ? '#ff9800' : '#28a745') . '; color: white; padding: 3px 10px; border: none; cursor: pointer; border-radius: 4px; margin-right: 5px;">';
                            echo $item['Wearing'] ? 'Desequipar' : 'Equipar';
                            echo '</button>';
                            echo '</form>';
                            
                            // Botão Remover
                            echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja remover este item?\');">';
                            echo '<input type="hidden" name="action" value="remove_item">';
                            echo '<input type="hidden" name="chest_id" value="' . ($item['id'] ?? '') . '">';
                            echo '<button type="submit" style="background: #dc3545; color: white; padding: 3px 10px; border: none; cursor: pointer; border-radius: 4px;">Remover</button>';
                            echo '</form>';
                            
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6" style="text-align: center;">Nenhum item encontrado no inventário.</td></tr>';
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

