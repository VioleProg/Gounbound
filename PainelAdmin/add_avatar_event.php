<?php 
include("header.php"); 
include("../mesh.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = mysql_real_escape_string($_POST['item_id'] ?? '');
    $item_name = mysql_real_escape_string($_POST['item_name'] ?? '');
    $event_name = mysql_real_escape_string($_POST['event_name'] ?? '');
    
    if (empty($item_id) || empty($item_name) || empty($event_name)) {
        $error = 'Preencha todos os campos!';
    } else {
        $success = "Avatar adicionado à loja de eventos com sucesso! (Esta funcionalidade requer configuração adicional da tabela de eventos)";
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Adicionar Avatar à Loja de Eventos</h1>
    
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
            <legend>Adicionar Avatar de Evento</legend>
            
            <dl>
                <dt><label for="event_name">Nome do Evento:</label></dt>
                <dd><input type="text" id="event_name" name="event_name" required style="width: 100%; padding: 5px;"></dd>
            </dl>
            
            <dl>
                <dt><label for="item_id">ID do Item:</label></dt>
                <dd><input type="text" id="item_id" name="item_id" required style="width: 100%; padding: 5px;"></dd>
            </dl>
            
            <dl>
                <dt><label for="item_name">Nome do Item:</label></dt>
                <dd><input type="text" id="item_name" name="item_name" required style="width: 100%; padding: 5px;"></dd>
            </dl>
            
            <p class="quick">
                <input type="submit" value="Adicionar à Loja de Eventos" class="button1">
                <a href="admin_panel.php" class="button1">Voltar</a>
            </p>
        </fieldset>
    </form>
</div>

<?php include("footer.php"); ?>

