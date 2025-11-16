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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Por favor, preencha todos os campos';
    } else {
        if (login($username, $password)) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Usuário ou senha incorretos';
        }
    }
}

$page_title = 'Login';
include 'includes/header.php';
?>

<main class="main-content auth-page">
    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Login</h1>
                    <p>Entre na sua conta</p>
                </div>
                
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="" class="auth-form">
                    <div class="form-group">
                        <label for="username">Usuário</label>
                        <input type="text" id="username" name="username" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                </form>
                
                <div class="auth-footer">
                    <p>Não tem uma conta? <a href="register.php">Registre-se aqui</a></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

