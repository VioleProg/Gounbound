<?php 
include("header.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gold = (int)($_POST['gold'] ?? 0);
    $cash = (int)($_POST['cash'] ?? 0);
    $confirm = $_POST['confirm'] ?? '';
    
    if ($gold <= 0 && $cash <= 0) {
        $error = 'Informe pelo menos Gold ou Cash para adicionar!';
    } else if ($confirm !== 'CONFIRMAR') {
        $error = 'Por segurança, digite "CONFIRMAR" para adicionar recursos a TODAS as contas!';
    } else {
        $updated = 0;
        
        // Adicionar Gold para todas as contas
        if ($gold > 0) {
            $result_gold = mysql_query("UPDATE game SET Money = Money + $gold");
            if ($result_gold) {
                $updated += mysql_affected_rows();
            }
        }
        
        // Adicionar Cash para todas as contas
        if ($cash > 0) {
            // Primeiro, garantir que todas as contas tenham registro em cash
            $result_cash_check = mysql_query("SELECT DISTINCT Id FROM game WHERE Id NOT IN (SELECT ID FROM cash)");
            while ($row = mysql_fetch_assoc($result_cash_check)) {
                mysql_query("INSERT INTO cash (ID, Cash) VALUES ('{$row['Id']}', 0)");
            }
            
            // Agora adicionar cash para todos
            $result_cash = mysql_query("UPDATE cash SET Cash = Cash + $cash");
            if ($result_cash) {
                $updated += mysql_affected_rows();
            }
        }
        
        $resources = [];
        if ($gold > 0) $resources[] = "$gold Gold";
        if ($cash > 0) $resources[] = "$cash Cash";
        
        $success = "Adicionado com sucesso: " . implode(" e ", $resources) . " para <strong>$updated contas</strong>!";
    }
}

// Contar total de contas
$total_accounts = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) as total FROM game"))['total'] ?? 0;
?>

<a name="maincontent"></a>

<h1>Adicionar Gold/Cash para Todas as Contas</h1>
    <p style="color: var(--admin-error); font-weight: 600;">
        <i class="fas fa-exclamation-triangle"></i> ATENÇÃO: Esta ação afetará TODAS as <?php echo number_format($total_accounts); ?> contas do sistema!
    </p>
    
    <?php if ($success): ?>
        <div class="success-message">
            <i class="fas fa-check-circle"></i> <?php echo $success; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <div class="admin-section" style="max-width: 600px; border: 2px solid var(--admin-error);">
        <h2 style="background: var(--admin-error) !important;">Adicionar Recursos em Massa</h2>
        <form method="post" style="padding: 1.5rem;">
            <div class="warning-message" style="margin-bottom: 1.5rem;">
                <i class="fas fa-exclamation-triangle"></i> 
                Esta operação irá adicionar recursos para <strong>TODAS</strong> as contas do sistema. 
                Use com cuidado!
            </div>
            
            <dl>
                <dt><label for="gold">Quantidade de Gold:</label></dt>
                <dd>
                    <input type="number" id="gold" name="gold" value="0" min="0" 
                           placeholder="0"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="cash">Quantidade de Cash:</label></dt>
                <dd>
                    <input type="number" id="cash" name="cash" value="0" min="0" 
                           placeholder="0"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="confirm">Confirmação:</label></dt>
                <dd>
                    <input type="text" id="confirm" name="confirm" required 
                           placeholder="Digite CONFIRMAR para prosseguir"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-error); border-radius: 8px; font-weight: 600;">
                    <small style="color: var(--admin-error); display: block; margin-top: 0.5rem;">
                        Digite <strong>CONFIRMAR</strong> para confirmar esta ação perigosa.
                    </small>
                </dd>
            </dl>
            
            <p style="margin-top: 1rem;">
                <button type="submit" style="background: var(--admin-error) !important; 
                                             color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                             border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-exclamation-triangle"></i> Adicionar para Todas as Contas
                </button>
            </p>
        </form>
    </div>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

