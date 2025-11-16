<?php
require_once 'config.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_info = getUserInfo($_SESSION['user_id']);

$page_title = 'Meu Perfil';
include 'includes/header.php';
?>

<main class="main-content">
    <div class="container">
        <h1 class="page-title">Meu Perfil</h1>
        
        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-header">
                    <h2><?php echo htmlspecialchars($user_info['Nickname'] ?? $user_info['NickName'] ?? 'N/A'); ?></h2>
                    <p class="profile-id">ID: <?php echo htmlspecialchars($_SESSION['user_id']); ?></p>
                </div>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-label">Pontos Totais</div>
                        <div class="stat-value"><?php echo number_format($user_info['TotalScore'] ?? 0); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Gold</div>
                        <div class="stat-value"><?php echo number_format($user_info['Money'] ?? 0); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Ranking</div>
                        <div class="stat-value">#<?php echo $user_info['TotalRank'] ?? 0; ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Email</div>
                        <div class="stat-value"><?php echo htmlspecialchars($user_info['E_Mail'] ?? 'N/A'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

