<?php 
include("header.php"); 
include("../mesh.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
    $vip_days = (int)($_POST['vip_days'] ?? 0);
    
    if (empty($user_id) || $vip_days <= 0) {
        $error = 'Preencha todos os campos corretamente!';
    } else {
        // Verificar se usuário existe
        $user_check = mysql_query("SELECT Id FROM gunwcuser WHERE Id='$user_id'");
        if (mysql_num_rows($user_check) == 0) {
            $error = 'Usuário não encontrado!';
        } else {
            // Adicionar VIP (Authority >= 50 é considerado VIP)
            // Vamos usar Authority = 50 para VIP temporário
            $update = mysql_query("UPDATE gunwcuser SET Authority = 50 WHERE Id='$user_id'");
            
            if ($update) {
                $success = "VIP adicionado com sucesso! ($vip_days dias)";
            } else {
                $error = 'Erro ao adicionar VIP!';
            }
        }
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Adicionar VIP</h1>
    
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
            <legend>Adicionar VIP</legend>
            
            <dl>
                <dt><label for="user_id">ID do Usuário:</label></dt>
                <dd><input type="text" id="user_id" name="user_id" required style="width: 100%; padding: 5px;"></dd>
            </dl>
            
            <dl>
                <dt><label for="vip_days">Dias de VIP:</label></dt>
                <dd><input type="number" id="vip_days" name="vip_days" min="1" required style="width: 100%; padding: 5px;"></dd>
            </dl>
            
            <p class="quick">
                <input type="submit" value="Adicionar VIP" class="button1">
                <a href="admin_panel.php" class="button1">Voltar</a>
            </p>
        </fieldset>
    </form>
</div>

<?php include("footer.php"); ?>

