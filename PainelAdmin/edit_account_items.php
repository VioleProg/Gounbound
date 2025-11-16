<?php 
include("header.php");

$success = '';
$error = '';
$user_id = mysql_real_escape_string($_GET['user_id'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id_post = mysql_real_escape_string($_POST['user_id'] ?? '');
    $gold = (int)($_POST['gold'] ?? 0);
    $cash = (int)($_POST['cash'] ?? 0);
    $gp = (int)($_POST['gp'] ?? 0);
    $grade = (int)($_POST['grade'] ?? -4);
    
    if (empty($user_id_post)) {
        $error = 'ID do usuário é obrigatório!';
    } else {
        // Verificar se usuário existe
        $check = mysql_query("SELECT Id FROM game WHERE Id='$user_id_post'");
        if (mysql_num_rows($check) == 0) {
            $error = 'Usuário não encontrado!';
        } else {
            $updates = [];
            
            // Atualizar Gold
            if ($gold > 0) {
                mysql_query("UPDATE game SET Money = $gold WHERE Id = '$user_id_post'");
                $updates[] = "Gold: $gold";
            }
            
            // Atualizar Cash
            if ($cash >= 0) {
                $check_cash = mysql_query("SELECT Cash FROM cash WHERE ID='$user_id_post'");
                if (mysql_num_rows($check_cash) > 0) {
                    mysql_query("UPDATE cash SET Cash = $cash WHERE ID='$user_id_post'");
                } else {
                    mysql_query("INSERT INTO cash (ID, Cash) VALUES ('$user_id_post', $cash)");
                }
                $updates[] = "Cash: $cash";
            }
            
            // Atualizar GP
            if ($gp > 0) {
                mysql_query("UPDATE game SET TotalScore = $gp WHERE Id = '$user_id_post'");
                $updates[] = "GP: $gp";
            }
            
            // Atualizar Grade
            if ($grade >= -4) {
                mysql_query("UPDATE game SET TotalGrade = $grade, SeasonGrade = $grade, CountryGrade = $grade WHERE Id = '$user_id_post'");
                $updates[] = "Grade: $grade";
            }
            
            $success = "Itens da conta atualizados: " . implode(", ", $updates);
            $user_id = $user_id_post;
        }
    }
}

// Buscar dados do usuário se fornecido
$user_data = null;
if (!empty($user_id)) {
    $result = mysql_query("SELECT g.*, c.Cash FROM game g 
                           LEFT JOIN cash c ON g.Id = c.ID 
                           WHERE g.Id = '$user_id'");
    $user_data = mysql_fetch_assoc($result);
}
?>

<a name="maincontent"></a>

<h1>Editar Itens da Conta</h1>
    <p>Edite os recursos e valores iniciais de uma conta.</p>
    
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
            <h2>Editar Recursos</h2>
            <form method="post" style="padding: 1.5rem;">
                <dl>
                    <dt><label for="user_id">ID do Usuário:</label></dt>
                    <dd>
                        <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" required 
                               placeholder="Digite o ID do usuário"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                        <a href="user.php" style="display: inline-block; margin-top: 0.5rem; font-size: 0.85rem; color: var(--admin-primary);">
                            <i class="fas fa-search"></i> Pesquisar usuário
                        </a>
                    </dd>
                </dl>
                
                <?php if ($user_data): ?>
                    <dl>
                        <dt><label for="gold">Gold Atual:</label></dt>
                        <dd>
                            <input type="number" id="gold" name="gold" value="<?php echo $user_data['Money']; ?>" min="0" 
                                   style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                            <small style="color: var(--admin-text-light);">Atual: <?php echo number_format($user_data['Money']); ?></small>
                        </dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="cash">Cash Atual:</label></dt>
                        <dd>
                            <input type="number" id="cash" name="cash" value="<?php echo $user_data['Cash'] ?? 0; ?>" min="0" 
                                   style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                            <small style="color: var(--admin-text-light);">Atual: <?php echo number_format($user_data['Cash'] ?? 0); ?></small>
                        </dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="gp">GP Atual:</label></dt>
                        <dd>
                            <input type="number" id="gp" name="gp" value="<?php echo $user_data['TotalScore']; ?>" min="0" 
                                   style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                            <small style="color: var(--admin-text-light);">Atual: <?php echo number_format($user_data['TotalScore']); ?></small>
                        </dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="grade">Grade Atual:</label></dt>
                        <dd>
                            <input type="number" id="grade" name="grade" value="<?php echo $user_data['TotalGrade']; ?>" min="-4" max="20" 
                                   style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                            <small style="color: var(--admin-text-light);">Atual: <?php echo $user_data['TotalGrade']; ?></small>
                        </dd>
                    </dl>
                <?php else: ?>
                    <div class="info-message">
                        <i class="fas fa-info-circle"></i> Digite o ID do usuário e clique em "Carregar Dados" ou use o botão de pesquisa.
                    </div>
                <?php endif; ?>
                
                <p style="margin-top: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                                 color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                                 border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-save"></i> Salvar Alterações
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Informações do Usuário -->
        <?php if ($user_data): ?>
            <div class="admin-section">
                <h2>Informações da Conta</h2>
                <div style="padding: 1.5rem;">
                    <dl>
                        <dt>ID:</dt>
                        <dd><strong><?php echo htmlspecialchars($user_data['Id']); ?></strong></dd>
                    </dl>
                    <dl>
                        <dt>Nickname:</dt>
                        <dd><?php echo htmlspecialchars($user_data['Nickname']); ?></dd>
                    </dl>
                    <dl>
                        <dt>Gold:</dt>
                        <dd><?php echo number_format($user_data['Money']); ?></dd>
                    </dl>
                    <dl>
                        <dt>Cash:</dt>
                        <dd><?php echo number_format($user_data['Cash'] ?? 0); ?></dd>
                    </dl>
                    <dl>
                        <dt>GP Total:</dt>
                        <dd><?php echo number_format($user_data['TotalScore']); ?></dd>
                    </dl>
                    <dl>
                        <dt>Grade:</dt>
                        <dd><?php echo $user_data['TotalGrade']; ?></dd>
                    </dl>
                    <p style="margin-top: 1rem;">
                        <!-- Funcionalidade desativada -->
                        <span class="button1" style="opacity: 0.5; cursor: not-allowed; background: #6c757d;">
                            <i class="fas fa-ban"></i> Editar Conta Completa (Desativado)
                        </span>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

