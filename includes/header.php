<?php
// Detectar caminho base automaticamente
$base_path = '';
if (strpos(__DIR__, '/admin') !== false || strpos(__DIR__, '\\admin') !== false) {
    $base_path = '../';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Gunbol</title>
    <link rel="stylesheet" href="<?php echo $base_path; ?>Assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="page-wrapper">
        <header class="main-header">
            <div class="container">
                <div class="header-content">
                    <nav class="main-nav">
                        <ul class="nav-menu">
                            <li><a href="<?php echo $base_path; ?>index.php" class="nav-link"><i class="fas fa-home"></i> <span>Início</span></a></li>
                            <li><a href="<?php echo $base_path; ?>ranking.php" class="nav-link"><i class="fas fa-trophy"></i> <span>Ranking</span></a></li>
                            <?php if (isLoggedIn()): ?>
                                <li><a href="<?php echo $base_path; ?>dashboard.php" class="nav-link"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a></li>
                                <li><a href="<?php echo $base_path; ?>profile.php" class="nav-link"><i class="fas fa-user"></i> <span>Perfil</span></a></li>
                                <?php if (isAdmin()): ?>
                                    <li><a href="<?php echo $base_path; ?>admin/index.php" class="nav-link admin-link"><i class="fas fa-shield-alt"></i> <span>Admin</span></a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo $base_path; ?>logout.php" class="nav-link logout-link"><i class="fas fa-sign-out-alt"></i> <span>Sair</span></a></li>
                            <?php else: ?>
                                <li><a href="<?php echo $base_path; ?>login.php" class="nav-link"><i class="fas fa-sign-in-alt"></i> <span>Login</span></a></li>
                                <li><a href="<?php echo $base_path; ?>register.php" class="nav-link btn-register"><i class="fas fa-user-plus"></i> <span>Registrar</span></a></li>
                            <?php endif; ?>
                        </ul>
                        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                            <i class="fas fa-bars"></i>
                        </button>
                    </nav>
                    <div class="logo">
                        <a href="<?php echo $base_path; ?>index.php">
                            <img src="<?php echo $base_path; ?>Assets/logo.png" alt="Gunbol Logo" onerror="this.style.display='none'">
                        </a>
                    </div>
                </div>
            </div>
        </header>

