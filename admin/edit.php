<?php
require_once '../config.php';
require_once '../includes/functions.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../login.php');
    exit;
}

$user_id = $_GET['id'] ?? '';
$error = '';
$success = '';

if (empty($user_id)) {
    header('Location: index.php');
    exit;
}

$user_info = getUserInfo($user_id);

if (!$user_info) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? '1';
    $authority = (int)($_POST['authority'] ?? 1);
    
    if (updateUserStatus($user_id, $status) && updateUserAuthority($user_id, $authority)) {
        $success = 'Usuário atualizado com sucesso!';
        $user_info = getUserInfo($user_id); // Atualizar dados
    } else {
        $error = 'Erro ao atualizar usuário';
    }
}

$page_title = 'Editar Usuário';
include '../includes/header.php';
?>

<main class="main-content admin-page">
    <div class="container">
        <div class="admin-header">
            <h1 class="page-title">Editar Usuário</h1>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <div class="admin-form-container">
            <form method="POST" class="admin-form">
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" value="<?php echo htmlspecialchars($user_info['Id']); ?>" disabled>
                </div>
                
                <div class="form-group">
                    <label>Nickname</label>
                    <input type="text" value="<?php echo htmlspecialchars($user_info['Nickname'] ?? $user_info['NickName'] ?? 'N/A'); ?>" disabled>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="<?php echo htmlspecialchars($user_info['E_Mail'] ?? ''); ?>" disabled>
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="1" <?php echo (($user_info['Status'] ?? '1') == '1') ? 'selected' : ''; ?>>Ativo</option>
                        <option value="0" <?php echo (($user_info['Status'] ?? '1') == '0') ? 'selected' : ''; ?>>Inativo</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="authority">Autoridade</label>
                    <input type="number" id="authority" name="authority" value="<?php echo $user_info['Authority'] ?? 1; ?>" min="1" max="100" required>
                    <small>1 = Usuário normal, 98+ = Administrador</small>
                </div>
                
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

