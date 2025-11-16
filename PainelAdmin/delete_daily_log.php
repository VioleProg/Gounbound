<?php 
include("header.php"); 
include("../mesh.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_log'])) {
    $days = (int)($_POST['days'] ?? 30);
    
    // Deletar logs antigos (mais de X dias)
    $delete = mysql_query("DELETE FROM playlog WHERE StartTime < DATE_SUB(NOW(), INTERVAL $days DAY)");
    
    if ($delete) {
        $affected = mysql_affected_rows();
        $success = "Logs deletados com sucesso! ($affected registro(s) removido(s))";
    } else {
        $error = 'Erro ao deletar logs!';
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Eliminar Log Diário</h1>
    
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
    
    <div style="max-width: 600px; padding: 20px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 5px;">
        <p><strong>Atenção:</strong> Esta operação irá deletar logs de jogadas antigos.</p>
        <p>Esta ação não pode ser desfeita!</p>
        
        <form method="post" onsubmit="return confirm('Tem CERTEZA que deseja deletar os logs antigos?');">
            <dl>
                <dt><label for="days">Deletar logs mais antigos que (dias):</label></dt>
                <dd>
                    <input type="number" id="days" name="days" value="30" min="1" required style="width: 100px; padding: 5px;">
                </dd>
            </dl>
            
            <p class="quick">
                <input type="submit" name="delete_log" value="Deletar Logs" class="button1" style="background: #dc3545; color: white; padding: 15px 30px; font-size: 16px;">
            </p>
        </form>
    </div>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

