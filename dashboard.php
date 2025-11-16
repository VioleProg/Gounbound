<?php
require_once 'config.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_info = getUserInfo($_SESSION['user_id']);

// Buscar informações adicionais
global $conn;
$stmt = $conn->prepare("SELECT Cash FROM cash WHERE ID = ?");
$stmt->bind_param("s", $_SESSION['user_id']);
$stmt->execute();
$cash_result = $stmt->get_result();
$cash_data = $cash_result->fetch_assoc();
$cash = $cash_data['Cash'] ?? 0;

$page_title = 'Dashboard';
include 'includes/header.php';
?>

<main class="main-content">
    <div class="container">
        <div class="dashboard-header">
            <h1 class="page-title">Dashboard</h1>
            <p class="welcome-message">Bem-vindo, <strong><?php echo htmlspecialchars($user_info['Nickname'] ?? $user_info['NickName'] ?? 'Jogador'); ?>!</strong></p>
        </div>
        
        <div class="dashboard-grid">
            <!-- Card de Estatísticas Principais -->
            <div class="dashboard-card stats-card">
                <h2>Estatísticas do Jogo</h2>
                <div class="stats-list">
                    <div class="stat-row">
                        <span class="stat-label">Pontos Totais:</span>
                        <span class="stat-value"><?php echo number_format($user_info['TotalScore'] ?? 0); ?></span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Gold:</span>
                        <span class="stat-value"><?php echo number_format($user_info['Money'] ?? 0); ?></span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Cash:</span>
                        <span class="stat-value"><?php echo number_format($cash); ?></span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Ranking:</span>
                        <span class="stat-value">#<?php echo $user_info['TotalRank'] ?? 0; ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Card de Informações da Conta -->
            <div class="dashboard-card account-card">
                <h2>Informações da Conta</h2>
                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">ID:</span>
                        <span class="info-value"><?php echo htmlspecialchars($_SESSION['user_id']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nickname:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user_info['Nickname'] ?? $user_info['NickName'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user_info['E_Mail'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status:</span>
                        <span class="info-value status-badge status-active">Ativo</span>
                    </div>
                </div>
            </div>
            
            <!-- Card de Progresso -->
            <div class="dashboard-card progress-card">
                <h2>Progresso</h2>
                <div class="progress-list">
                    <div class="progress-item">
                        <span class="progress-label">Grade Total:</span>
                        <span class="progress-value"><?php echo $user_info['TotalGrade'] ?? 0; ?></span>
                    </div>
                    <div class="progress-item">
                        <span class="progress-label">Grade Temporada:</span>
                        <span class="progress-value"><?php echo $user_info['SeasonGrade'] ?? 0; ?></span>
                    </div>
                    <div class="progress-item">
                        <span class="progress-label">Ranking Temporada:</span>
                        <span class="progress-value">#<?php echo $user_info['SeasonRank'] ?? 0; ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Card de Ações Rápidas -->
            <div class="dashboard-card actions-card">
                <h2>Ações Rápidas</h2>
                <div class="actions-list">
                    <a href="profile.php" class="action-btn">
                        <span class="action-icon"><i class="fas fa-user"></i></span>
                        <span>Ver Perfil Completo</span>
                    </a>
                    <a href="ranking.php" class="action-btn">
                        <span class="action-icon"><i class="fas fa-trophy"></i></span>
                        <span>Ver Ranking</span>
                    </a>
                    <?php if (isAdmin()): ?>
                        <a href="admin/index.php" class="action-btn admin-btn">
                            <span class="action-icon"><i class="fas fa-cog"></i></span>
                            <span>Painel Admin</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.dashboard-header {
    margin-bottom: 2rem;
    text-align: center;
}

.welcome-message {
    font-size: 1.25rem;
    color: var(--text-light);
    margin-top: 0.5rem;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.dashboard-card {
    background: var(--bg-white);
    padding: 2rem;
    border-radius: 15px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.dashboard-card h2 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: var(--primary-color);
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 0.5rem;
}

.stats-list, .info-list, .progress-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-row, .info-row, .progress-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: var(--bg-gray);
    border-radius: 8px;
}

.stat-label, .info-label, .progress-label {
    font-weight: 500;
    color: var(--text-dark);
}

.stat-value, .info-value, .progress-value {
    font-weight: 700;
    color: var(--primary-color);
    font-size: 1.1rem;
}

.actions-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-gray);
    border-radius: 10px;
    text-decoration: none;
    color: var(--text-dark);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.action-btn:hover {
    background: var(--primary-color);
    color: white;
    transform: translateX(5px);
    border-color: var(--primary-color);
}

.action-btn.admin-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.action-btn.admin-btn:hover {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
}

.action-icon {
    font-size: 1.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
}

.action-icon i {
    color: var(--primary-color);
    transition: color 0.3s ease;
}

.action-btn:hover .action-icon i {
    color: white;
}

.action-btn.admin-btn .action-icon i {
    color: white;
}

@media (max-width: 768px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include 'includes/footer.php'; ?>

