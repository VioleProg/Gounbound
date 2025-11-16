<?php
require_once 'config.php';
require_once 'includes/functions.php';

// Se já estiver logado, redirecionar
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $nick = trim($_POST['nick'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $email_confirm = trim($_POST['email_confirm'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $gender = $_POST['gender'] ?? '0';
    
    // Validações
    if (empty($login)) {
        $errors[] = 'Login é obrigatório';
    } elseif (!validateUsername($login)) {
        $errors[] = 'Login deve ter entre 6 e 12 caracteres alfanuméricos';
    }
    
    if (empty($nick)) {
        $errors[] = 'Nick é obrigatório';
    } elseif (!validateUsername($nick)) {
        $errors[] = 'Nick deve ter entre 6 e 12 caracteres alfanuméricos';
    }
    
    if (empty($email)) {
        $errors[] = 'Email é obrigatório';
    } elseif (!validateEmail($email)) {
        $errors[] = 'Email inválido';
    }
    
    if ($email !== $email_confirm) {
        $errors[] = 'Os emails não coincidem';
    }
    
    if (empty($password)) {
        $errors[] = 'Senha é obrigatória';
    } elseif (strlen($password) < 6 || strlen($password) > 12) {
        $errors[] = 'Senha deve ter entre 6 e 12 caracteres';
    }
    
    if ($password !== $password_confirm) {
        $errors[] = 'As senhas não coincidem';
    }
    
    if (empty($errors)) {
        $result = register($login, $nick, $email, $password, $gender);
        if ($result['success']) {
            // Fazer login automático após registro
            if (login($login, $password)) {
                header('Location: dashboard.php');
                exit;
            } else {
                // Se o registro foi bem-sucedido mas o login falhou, mostrar mensagem
                $errors[] = 'Conta criada, mas não foi possível fazer login automaticamente. Tente fazer login manualmente.';
            }
        } else {
            $errors[] = $result['message'];
        }
    }
}

$page_title = 'Registro';
include 'includes/header.php';
?>

<main class="main-content auth-page">
    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Criar Conta</h1>
                    <p>Junte-se ao Gunbol hoje</p>
                </div>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <ul>
                            <?php foreach ($errors as $err): ?>
                                <li><?php echo htmlspecialchars($err); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="" class="auth-form">
                    <div class="form-group">
                        <label for="login">Login *</label>
                        <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($login ?? ''); ?>" required maxlength="12" pattern="[a-zA-Z0-9]{6,12}" title="6-12 caracteres alfanuméricos">
                        <small>6-12 caracteres, apenas letras e números</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="nick">Nickname *</label>
                        <input type="text" id="nick" name="nick" value="<?php echo htmlspecialchars($nick ?? ''); ?>" required maxlength="12" pattern="[a-zA-Z0-9]{6,12}" title="6-12 caracteres alfanuméricos">
                        <small>6-12 caracteres, apenas letras e números</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email_confirm">Confirmar Email *</label>
                        <input type="email" id="email_confirm" name="email_confirm" value="<?php echo htmlspecialchars($email_confirm ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Senha *</label>
                        <input type="password" id="password" name="password" required minlength="6" maxlength="12">
                        <small>6-12 caracteres</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirm">Confirmar Senha *</label>
                        <input type="password" id="password_confirm" name="password_confirm" required minlength="6" maxlength="12">
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gênero *</label>
                        <select id="gender" name="gender" required>
                            <option value="0" <?php echo (isset($gender) && $gender == '0') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="1" <?php echo (isset($gender) && $gender == '1') ? 'selected' : ''; ?>>Feminino</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Criar Conta</button>
                </form>
                
                <div class="auth-footer">
                    <p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

