<?php 
include("header.php");

$success = '';
$error = '';

// Verificar Authority do usuário atual
$current_user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? '';
$current_user_info = mysql_fetch_assoc(mysql_query("SELECT Authority FROM gunwcuser WHERE Id='".mysql_real_escape_string($current_user_id)."'"));
$current_authority = (int)($current_user_info['Authority'] ?? 0);
$is_gm = ($current_authority == 99);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
    $gold = (int)($_POST['gold'] ?? 0);
    $cash = (int)($_POST['cash'] ?? 0);
    
    if (empty($user_id)) {
        $error = 'ID do usuário é obrigatório!';
    } else if ($gold <= 0 && $cash <= 0) {
        $error = 'Informe pelo menos Gold ou Cash para adicionar!';
    } else {
        // Se for GM (Authority = 99), só pode adicionar na própria conta
        if ($is_gm && $user_id !== $current_user_id) {
            $error = 'Você só pode adicionar recursos na sua própria conta!';
        } else {
            // Verificar se usuário existe
            $check = mysql_query("SELECT Id FROM game WHERE Id='$user_id'");
            if (mysql_num_rows($check) == 0) {
                $error = 'Usuário não encontrado!';
            } else {
            $updates = [];
            
            // Adicionar Gold
            if ($gold > 0) {
                $update_gold = mysql_query("UPDATE game SET Money = Money + $gold WHERE Id = '$user_id'");
                if ($update_gold) {
                    $updates[] = "$gold Gold";
                }
            }
            
            // Adicionar Cash
            if ($cash > 0) {
                $check_cash = mysql_query("SELECT Cash FROM cash WHERE ID='$user_id'");
                if (mysql_num_rows($check_cash) > 0) {
                    $update_cash = mysql_query("UPDATE cash SET Cash = Cash + $cash WHERE ID='$user_id'");
                } else {
                    $update_cash = mysql_query("INSERT INTO cash (ID, Cash) VALUES ('$user_id', $cash)");
                }
                if ($update_cash) {
                    $updates[] = "$cash Cash";
                }
            }
            
            if (count($updates) > 0) {
                $success = "Adicionado com sucesso: " . implode(" e ", $updates) . " para <strong>$user_id</strong>";
            } else {
                $error = 'Erro ao adicionar recursos!';
            }
        }
        }
    }
}
?>

<a name="maincontent"></a>

<h1>Adicionar Gold e Cash</h1>
<p>Adicione Gold e/ou Cash para um usuário específico.</p>
<?php if ($is_gm): ?>
    <div class="error-message" style="background: #fff3cd; color: #856404; border-color: #ffc107;">
        <i class="fas fa-info-circle"></i> <strong>Modo GM:</strong> Você só pode adicionar recursos na sua própria conta.
    </div>
<?php endif; ?>
    
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
    
    <div class="admin-section" style="max-width: 600px;">
        <h2>Adicionar Recursos</h2>
        <form method="post" style="padding: 1.5rem;">
            <dl>
                <dt><label for="user_id">ID do Usuário:</label></dt>
                <dd>
                    <input type="text" id="user_id" name="user_id" value="<?php echo $is_gm ? htmlspecialchars($current_user_id) : ''; ?>" required 
                           placeholder="Digite o ID do usuário" <?php echo $is_gm ? 'readonly' : ''; ?>
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; <?php echo $is_gm ? 'background: #f1f5f9;' : ''; ?>">
                    <?php if ($is_gm): ?>
                        <small style="color: var(--admin-text-light); display: block; margin-top: 0.5rem;">
                            <i class="fas fa-lock"></i> Modo GM: Você só pode adicionar na sua própria conta.
                        </small>
                    <?php endif; ?>
                </dd>
            </dl>
            
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
            
            <p style="margin-top: 1rem;">
                <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                             color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                             border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-coins"></i> Adicionar Recursos
                </button>
            </p>
        </form>
    </div>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

