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
                    <div class="logo">
                        <a href="<?php echo $base_path; ?>index.php">
                            <img src="<?php echo $base_path; ?>Assets/logo.png" alt="Gunbol Logo" onerror="this.style.display='none'">
                        </a>
                    </div>
                    <nav class="main-nav">
                        <ul>
                            <li><a href="<?php echo $base_path; ?>index.php">Início</a></li>
                            <li><a href="<?php echo $base_path; ?>ranking.php">Ranking</a></li>
                            <?php if (isLoggedIn()): ?>
                                <li><a href="<?php echo $base_path; ?>dashboard.php">Dashboard</a></li>
                                <li><a href="<?php echo $base_path; ?>profile.php">Perfil</a></li>
                                <?php if (isAdmin()): ?>
                                    <li><a href="<?php echo $base_path; ?>admin/index.php">Admin</a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo $base_path; ?>logout.php">Sair</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo $base_path; ?>login.php">Login</a></li>
                                <li><a href="<?php echo $base_path; ?>register.php" class="btn-register">Registrar</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

