<?php 
include("header.php");

$multi = isset($_GET['multi']) ? (int)$_GET['multi'] : 1;
$success = '';
$error = '';

// Verificar Authority do usuário atual
$current_user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? '';
$current_user_info = mysql_fetch_assoc(mysql_query("SELECT Authority FROM gunwcuser WHERE Id='".mysql_real_escape_string($current_user_id)."'"));
$current_authority = (int)($current_user_info['Authority'] ?? 0);
$is_gm = ($current_authority == 99);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
    $avatar_id = mysql_real_escape_string($_POST['avatar_id'] ?? '');
    $quantity = (int)($_POST['quantity'] ?? 1);
    $expire_days = !empty($_POST['expire_days']) ? (int)$_POST['expire_days'] : null;
    
    if (empty($user_id) || empty($avatar_id)) {
        $error = 'Preencha todos os campos obrigatórios!';
    } elseif ($quantity <= 0) {
        $error = 'A quantidade deve ser maior que zero!';
    } else {
        // Se for GM (Authority = 99), só pode adicionar na própria conta
        if ($is_gm && $user_id !== $current_user_id) {
            $error = 'Você só pode adicionar avatares na sua própria conta!';
        } else {
            // Verificar se usuário existe
            $user_check = mysql_query("SELECT Id FROM game WHERE Id='$user_id'");
            if (mysql_num_rows($user_check) == 0) {
                $error = 'Usuário não encontrado!';
            } else {
            // Calcular data de expiração
            $expire_date = null;
            if ($expire_days && $expire_days > 0) {
                $expire_date = date('Y-m-d H:i:s', strtotime("+$expire_days days"));
            }
            
            // Inserir avatar(s) no chest com todos os campos necessários
            // Se quantidade > 1, criar múltiplos registros, cada um com Volume = 1
            for ($i = 0; $i < $quantity; $i++) {
                $expire_sql = $expire_date ? "'$expire_date'" : 'NULL';
                $insert = mysql_query("INSERT INTO chest (Owner, Item, Wearing, Acquisition, Volume, Expire, ExpireType) 
                                      VALUES ('$user_id', '$avatar_id', '0', 'G', 1, $expire_sql, 'W')");
                if (!$insert) {
                    $error = 'Erro ao enviar avatar: ' . mysql_error();
                    break;
                }
            }
            if (empty($error)) {
                $expire_text = $expire_date ? " (expira em " . date('d/m/Y', strtotime($expire_date)) . ")" : " (permanente)";
                $success = "Avatar(s) enviado(s) com sucesso! ($quantity item(s))$expire_text";
            }
        }
        }
    }
}
?>

<a name="maincontent"></a>

<h1>Enviar Avatar<?php echo $multi > 1 ? ' x4' : ''; ?></h1>
<p>Envie avatares para usuários. Todos os itens serão inseridos com Acquisition='G' e ExpireType='W'.</p>
<?php if ($is_gm): ?>
    <div class="error-message" style="background: #fff3cd; color: #856404; border-color: #ffc107;">
        <i class="fas fa-info-circle"></i> <strong>Modo GM:</strong> Você só pode adicionar avatares na sua própria conta.
    </div>
<?php endif; ?>

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

<div class="admin-section" style="max-width: 600px; margin-top: 2rem;">
    <h2>Dados do Avatar</h2>
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
            <dt><label for="avatar_id">ID do Avatar:</label></dt>
            <dd>
                <input type="text" id="avatar_id" name="avatar_id" required 
                       placeholder="Ex: 200001"
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                <small>Digite o código do item do avatar</small>
            </dd>
        </dl>
        
        <dl>
            <dt><label for="quantity">Quantidade:</label></dt>
            <dd>
                <input type="number" id="quantity" name="quantity" value="1" min="1" required
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                <small>Quantidade de itens a serem enviados</small>
            </dd>
        </dl>
        
        <dl>
            <dt><label for="expire_days">Dias até Expirar (opcional):</label></dt>
            <dd>
                <input type="number" id="expire_days" name="expire_days" min="1"
                       placeholder="Ex: 30 (30 dias) - deixe em branco para permanente"
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                <small>Deixe em branco para item permanente</small>
            </dd>
        </dl>
        
        <p class="quick" style="margin-top: 1rem;">
            <button type="submit" class="button1">
                <i class="fas fa-paper-plane"></i> Enviar Avatar
            </button>
            <a href="admin_panel.php" class="button1">Voltar</a>
        </p>
    </form>
</div>

<?php include("footer.php"); ?>
