<?php 
include("header.php"); 
include("../mesh.php");

$success = '';
$error = '';

// Aceitar IP via GET também
$ip_from_get = isset($_GET['ip']) ? mysql_real_escape_string($_GET['ip']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip_address = mysql_real_escape_string($_POST['ip_address'] ?? $ip_from_get);
    $reason = mysql_real_escape_string($_POST['reason'] ?? '');
    
    if (empty($ip_address)) {
        $error = 'Digite um endereço IP!';
    } else {
        // Aqui você pode criar uma tabela de IPs banidos ou usar outra lógica
        // Por enquanto, vamos banir todos os usuários com esse IP
        $update = mysql_query("UPDATE gunwcuser SET Status = '0', Authority = '-100' WHERE IP = '$ip_address'");
        
        if ($update) {
            $affected = mysql_affected_rows();
            $success = "IP banido com sucesso! ($affected usuário(s) afetado(s))";
        } else {
            $error = 'Erro ao banir IP!';
        }
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Banir IP Total</h1>
    
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
            <legend>Banir IP</legend>
            
            <dl>
                <dt><label for="ip_address">Endereço IP:</label></dt>
                <dd><input type="text" id="ip_address" name="ip_address" value="<?php echo htmlspecialchars($ip_from_get); ?>" required style="width: 100%; padding: 5px;" placeholder="Ex: 192.168.1.1"></dd>
            </dl>
            
            <dl>
                <dt><label for="reason">Motivo:</label></dt>
                <dd><textarea id="reason" name="reason" style="width: 100%; padding: 5px; height: 80px;"></textarea></dd>
            </dl>
            
            <p class="quick">
                <input type="submit" value="Banir IP" class="button1" style="background: #dc3545; color: white;">
                <a href="admin_panel.php" class="button1">Voltar</a>
            </p>
        </fieldset>
    </form>
</div>

<?php include("footer.php"); ?>

