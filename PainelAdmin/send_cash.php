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
    $cash_amount = (int)($_POST['cash_amount'] ?? 0);
    
    if (empty($user_id) || $cash_amount <= 0) {
        $error = 'Preencha todos os campos corretamente!';
    } else {
        // Se for GM (Authority = 99), só pode adicionar na própria conta
        if ($is_gm && $user_id !== $current_user_id) {
            $error = 'Você só pode adicionar cash na sua própria conta!';
        } else {
            // Verificar se usuário existe
            $user_check = mysql_query("SELECT Id FROM game WHERE Id='$user_id'");
            if (mysql_num_rows($user_check) == 0) {
                $error = 'Usuário não encontrado!';
            } else {
            // Verificar se já existe registro de cash
            $cash_check = mysql_query("SELECT Cash FROM cash WHERE ID='$user_id'");
            if (mysql_num_rows($cash_check) > 0) {
                // Atualizar cash existente
                $update = mysql_query("UPDATE cash SET Cash = Cash + $cash_amount WHERE ID='$user_id'");
            } else {
                // Criar novo registro
                $update = mysql_query("INSERT INTO cash (ID, Cash) VALUES ('$user_id', $cash_amount)");
            }
            
            if ($update) {
                $success = "Cash enviado com sucesso! ($cash_amount Cash)";
            } else {
                $error = 'Erro ao enviar cash!';
            }
        }
        }
    }
}
?>

<a name="maincontent"></a>

<h1>Enviar Cash</h1>
<p>Envie cash para usuários.</p>
<?php if ($is_gm): ?>
    <div class="error-message" style="background: #fff3cd; color: #856404; border-color: #ffc107;">
        <i class="fas fa-info-circle"></i> <strong>Modo GM:</strong> Você só pode adicionar cash na sua própria conta.
    </div>
<?php endif; ?>
    
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
    
    <div class="admin-section" style="max-width: 600px; margin-top: 2rem;">
        <h2>Dados do Cash</h2>
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
                <dt><label for="cash_amount">Quantidade de Cash:</label></dt>
                <dd>
                    <input type="number" id="cash_amount" name="cash_amount" min="1" required
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <p class="quick" style="margin-top: 1rem;">
                <button type="submit" class="button1">
                    <i class="fas fa-paper-plane"></i> Enviar Cash
                </button>
                <a href="admin_panel.php" class="button1">Voltar</a>
            </p>
        </form>
    </div>

<?php include("footer.php"); ?>

