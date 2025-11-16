<?php 
include("header.php"); 
include("../mesh.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_ranking'])) {
    // Atualizar rankings baseado em TotalScore
    $update_total = mysql_query("UPDATE game g1 
                                  SET TotalRank = (
                                      SELECT COUNT(*) + 1 
                                      FROM game g2 
                                      WHERE g2.TotalScore > g1.TotalScore
                                  )");
    
    // Atualizar rankings da temporada
    $update_season = mysql_query("UPDATE game g1 
                                  SET SeasonRank = (
                                      SELECT COUNT(*) + 1 
                                      FROM game g2 
                                      WHERE g2.SeasonScore > g1.SeasonScore
                                  )");
    
    if ($update_total && $update_season) {
        $success = "Rankings atualizados com sucesso!";
    } else {
        $error = 'Erro ao atualizar rankings!';
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Atualizar Ranking</h1>
    
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
    
    <div style="max-width: 600px; padding: 20px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 5px;">
        <p><strong>Atenção:</strong> Esta operação irá recalcular todos os rankings baseado nas pontuações atuais dos jogadores.</p>
        <p>Isso pode levar alguns minutos dependendo da quantidade de jogadores.</p>
        
        <form method="post" onsubmit="return confirm('Tem certeza que deseja atualizar todos os rankings?');">
            <p class="quick">
                <input type="submit" name="update_ranking" value="Atualizar Rankings" class="button1" style="background: #007bff; color: white; padding: 15px 30px; font-size: 16px;">
            </p>
        </form>
    </div>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

