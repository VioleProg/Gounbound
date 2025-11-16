<?php
require_once 'config.php';
require_once 'includes/functions.php';

$page_title = 'Início';
include 'includes/header.php';
?>

<main class="main-content">
    <section class="hero-section">
        <div class="hero-slider">
            <div class="slide active">
                <img src="Assets/banner1.jpg" alt="Banner 1">
            </div>
            <div class="slide">
                <img src="Assets/webeventohallo1.png" alt="Evento Halloween 1">
            </div>
            <div class="slide">
                <img src="Assets/webeventohallo2.png" alt="Evento Halloween 2">
            </div>
        </div>
        <div class="hero-content">
            <div class="hero-logo">
                <img src="Assets/logo.png" alt="Gunbol Logo">
            </div>
            <?php if (!isLoggedIn()): ?>
                <div class="hero-buttons">
                    <a href="register.php" class="btn btn-primary btn-large">Começar Agora</a>
                    <a href="login.php" class="btn btn-secondary btn-large">Fazer Login</a>
                </div>
            <?php else: ?>
                <div class="hero-buttons">
                    <a href="dashboard.php" class="btn btn-primary btn-large">Dashboard</a>
                    <a href="ranking.php" class="btn btn-secondary btn-large">Ver Ranking</a>
                </div>
            <?php endif; ?>
        </div>
        <div class="slider-controls">
            <button class="slider-btn prev" onclick="changeSlide(-1)"><i class="fas fa-chevron-left"></i></button>
            <button class="slider-btn next" onclick="changeSlide(1)"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="slider-dots">
            <span class="dot active" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Recursos</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-gamepad"></i></div>
                    <h3>Jogabilidade</h3>
                    <p>Experiência de jogo suave e divertida</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-trophy"></i></div>
                    <h3>Ranking</h3>
                    <p>Competa com outros jogadores</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-users"></i></div>
                    <h3>Comunidade</h3>
                    <p>Junte-se a uma comunidade ativa</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                    <h3>Performance</h3>
                    <p>Servidor rápido e estável</p>
                </div>
            </div>
        </div>
    </section>

    <?php if (isLoggedIn()): 
        $user_info = getUserInfo($_SESSION['user_id']);
    ?>
    <section class="user-stats-section">
        <div class="container">
            <h2 class="section-title">Suas Estatísticas</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?php echo number_format($user_info['TotalScore'] ?? 0); ?></div>
                    <div class="stat-label">Pontos Totais</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo number_format($user_info['Money'] ?? 0); ?></div>
                    <div class="stat-label">Gold</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">#<?php echo $user_info['TotalRank'] ?? 0; ?></div>
                    <div class="stat-label">Ranking</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo htmlspecialchars($user_info['Nickname'] ?? $user_info['NickName'] ?? 'N/A'); ?></div>
                    <div class="stat-label">Nickname</div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>

