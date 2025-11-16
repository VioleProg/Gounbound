<?php 
include("header.php"); 
include("../mesh.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_gp'])) {
    // Resetar GP diário (SeasonScore)
    $update = mysql_query("UPDATE game SET SeasonScore = 0");
    
    if ($update) {
        $affected = mysql_affected_rows();
        $success = "GP diário resetado com sucesso! ($affected jogador(es) afetado(s))";
    } else {
        $error = 'Erro ao resetar GP diário!';
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Reiniciar GP's Diário</h1>
    
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
        <p><strong>Atenção:</strong> Esta operação irá resetar o GP diário (SeasonScore) de TODOS os jogadores para 0.</p>
        <p>Esta ação não pode ser desfeita!</p>
        
        <form method="post" onsubmit="return confirm('Tem CERTEZA que deseja resetar o GP diário de TODOS os jogadores?');">
            <p class="quick">
                <input type="submit" name="reset_gp" value="Resetar GP Diário" class="button1" style="background: #ffc107; color: #000; padding: 15px 30px; font-size: 16px;">
            </p>
        </form>
    </div>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

