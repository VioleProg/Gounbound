<?php 
include("header.php"); 
include("../mesh.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = mysql_real_escape_string($_POST['item_id'] ?? '');
    $item_name = mysql_real_escape_string($_POST['item_name'] ?? '');
    $price = (int)($_POST['price'] ?? 0);
    $price_type = mysql_real_escape_string($_POST['price_type'] ?? 'cash');
    
    if (empty($item_id) || empty($item_name) || $price <= 0) {
        $error = 'Preencha todos os campos corretamente!';
    } else {
        // Aqui você pode criar uma tabela de loja virtual ou usar outra lógica
        // Por enquanto, vamos apenas mostrar uma mensagem de sucesso
        $success = "Avatar adicionado à loja virtual com sucesso! (Esta funcionalidade requer configuração adicional da tabela de loja)";
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Adicionar Avatar à Loja Virtual</h1>
    
    <?php if ($success): ?>
        <div style="background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 5px;">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 5px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <form method="post" style="max-width: 500px;">
        <fieldset>
            <legend>Adicionar Avatar</legend>
            
            <dl>
                <dt><label for="item_id">ID do Item:</label></dt>
                <dd><input type="text" id="item_id" name="item_id" required style="width: 100%; padding: 5px;"></dd>
            </dl>
            
            <dl>
                <dt><label for="item_name">Nome do Item:</label></dt>
                <dd><input type="text" id="item_name" name="item_name" required style="width: 100%; padding: 5px;"></dd>
            </dl>
            
            <dl>
                <dt><label for="price">Preço:</label></dt>
                <dd><input type="number" id="price" name="price" min="1" required style="width: 100%; padding: 5px;"></dd>
            </dl>
            
            <dl>
                <dt><label for="price_type">Tipo de Moeda:</label></dt>
                <dd>
                    <select id="price_type" name="price_type" style="width: 100%; padding: 5px;">
                        <option value="cash">Cash</option>
                        <option value="gold">Gold</option>
                    </select>
                </dd>
            </dl>
            
            <p class="quick">
                <input type="submit" value="Adicionar à Loja" class="button1">
                <a href="admin_panel.php" class="button1">Voltar</a>
            </p>
        </fieldset>
    </form>
</div>

<?php include("footer.php"); ?>

