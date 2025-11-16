<?php
require_once 'config.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_info = getUserInfo($_SESSION['user_id']);
$user_id = $_SESSION['user_id'];

// Buscar informações adicionais
global $conn;

// Cash
$stmt = $conn->prepare("SELECT Cash FROM cash WHERE ID = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$cash_result = $stmt->get_result();
$cash_data = $cash_result->fetch_assoc();
$cash = $cash_data['Cash'] ?? 0;

// Login do usuário
$stmt = $conn->prepare("SELECT user FROM gunwcuser WHERE Id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$login_result = $stmt->get_result();
$login_data = $login_result->fetch_assoc();
$login = $login_data['user'] ?? $user_id;

// Amigos (Buddy)
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM buddylist WHERE Id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$buddy_result = $stmt->get_result();
$buddy_data = $buddy_result->fetch_assoc();
$total_buddies = $buddy_data['total'] ?? 0;

// Amigos online (simulado - pode precisar de verificação real)
$buddies_online = 0; // TODO: Implementar verificação de amigos online

// Avatares (contar itens no chest)
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM chest WHERE Owner = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$avatar_result = $stmt->get_result();
$avatar_data = $avatar_result->fetch_assoc();
$total_avatars = $avatar_data['total'] ?? 0;

// Clan/Guild
$guild = $user_info['Guild'] ?? '';
$guild_rank = $user_info['GuildRank'] ?? 0;

// Ponto Evento (soma de EventScore0-3)
$event_score = ($user_info['EventScore0'] ?? 0) + 
               ($user_info['EventScore1'] ?? 0) + 
               ($user_info['EventScore2'] ?? 0) + 
               ($user_info['EventScore3'] ?? 0);

// GPontos e GBCoin (usando campos existentes ou valores padrão)
$gpontos = $user_info['TotalScore'] ?? 0; // Usando TotalScore como GPontos
$gbcoin = $cash; // Usando Cash como GBCoin

// VIP Status (verificar se existe campo VIP ou usar Authority)
$has_vip = ($user_info['Authority'] ?? 1) >= 50; // Assumindo que Authority >= 50 = VIP
$vip_level = $has_vip ? 'VIP' : 'Normal';

// Est. Drag e Buzinas (placeholder - pode precisar de tabelas específicas)
$has_est_drag = false;
$horns = 0;

// Win Rate (precisaria de tabela de batalhas - usando placeholder)
$win_rate = 0; // TODO: Calcular de tabela de batalhas se existir

// GP Mensal (usando SeasonScore)
$gp_mensal = $user_info['SeasonScore'] ?? 0;

// Ranking de Clan (usando GuildRank e MemberCount)
$clan_ranking = '';
if ($guild) {
    $member_count = $user_info['MemberCount'] ?? 0;
    $clan_ranking = '[' . $guild_rank . ' / ' . $member_count . ']';
}

// Progresso do jogo (GP necessário para próximo nível)
$current_gp = $user_info['TotalScore'] ?? 0;
$gp_needed = 1000; // Valor padrão
$gp_progress = min(100, ($current_gp % $gp_needed) / $gp_needed * 100);

$page_title = 'Dashboard';
include 'includes/header.php';
?>

<main class="main-content">
    <div class="container">
        <div class="dashboard-header">
            <h1 class="page-title">Dashboard</h1>
        </div>
        
        <!-- Progresso do Jogo -->
        <div class="dashboard-progress-section">
            <div class="progress-header">
                <i class="fas fa-shield-alt progress-icon"></i>
                <h2 class="progress-title">Progresso do seu jogo</h2>
                <i class="fas fa-trophy progress-icon-right"></i>
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-bar-fill" style="width: <?php echo $gp_progress; ?>%"></div>
                </div>
                <div class="progress-text">Faltam <?php echo number_format($gp_needed - ($current_gp % $gp_needed)); ?> GPs</div>
            </div>
        </div>
        
        <!-- Minhas Informações -->
        <div class="dashboard-section">
            <h2 class="section-title">Minhas Informações</h2>
            <div class="info-grid">
                <div class="info-column">
                    <div class="info-item">
                        <span class="info-label">Login:</span>
                        <span class="info-value"><?php echo htmlspecialchars($login); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">NickName:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user_info['Nickname'] ?? $user_info['NickName'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Amigos (Buddy):</span>
                        <span class="info-value">
                            <?php echo $total_buddies; ?> 
                            <span class="online-text">(<?php echo $buddies_online; ?> online agora)</span>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">GPontos:</span>
                        <span class="info-value"><?php echo number_format($gpontos); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">GBCoin <span class="new-badge">[new]</span>:</span>
                        <span class="info-value"><?php echo number_format($gbcoin); ?></span>
                    </div>
                </div>
                <div class="info-column">
                    <div class="info-item">
                        <span class="info-label">Gold:</span>
                        <span class="info-value"><?php echo number_format($user_info['Money'] ?? 0); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Cash:</span>
                        <span class="info-value"><?php echo number_format($cash); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Avatares:</span>
                        <span class="info-value">
                            <?php echo $total_avatars; ?>
                            <button class="btn-listar" onclick="alert('Funcionalidade em desenvolvimento')">LISTAR</button>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Clan:</span>
                        <span class="info-value">
                            <?php echo $guild ? htmlspecialchars($guild) : 'Sem clan'; ?>
                            <?php if ($guild): ?>
                                <button class="btn-pagina" onclick="alert('Funcionalidade em desenvolvimento')">PÁGINA</button>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Ponto Evento:</span>
                        <span class="info-value"><?php echo number_format($event_score); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Itens -->
        <div class="dashboard-section">
            <h2 class="section-title">Itens</h2>
            <div class="info-grid">
                <div class="info-column">
                    <div class="info-item">
                        <span class="info-label">VIP:</span>
                        <span class="info-value error-text"><?php echo $has_vip ? 'VIP Ativo' : 'Não tem VIP'; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Nível:</span>
                        <span class="info-value error-text">
                            <?php echo $vip_level; ?>
                            <?php if (!$has_vip): ?>
                                <span class="error-text">Sem direito ao LEVEL VIP</span>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
                <div class="info-column">
                    <div class="info-item">
                        <span class="info-label">Est. Drag:</span>
                        <span class="info-value error-text"><?php echo $has_est_drag ? 'Tem Est. Drag' : 'Não tem Est. Drag'; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Buzinas:</span>
                        <span class="info-value"><?php echo $horns; ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Ranking -->
        <div class="dashboard-section">
            <h2 class="section-title">Ranking</h2>
            <div class="ranking-info">
                <div class="ranking-item">
                    <i class="fas fa-shield-alt ranking-icon"></i>
                    <span class="ranking-label">Ranking Total:</span>
                    <span class="ranking-value"><?php echo number_format($user_info['TotalRank'] ?? 0); ?> [<?php echo number_format($gpontos); ?> GP]</span>
                </div>
                <div class="ranking-item">
                    <span class="ranking-label">GP Mensal:</span>
                    <span class="ranking-value"><?php echo number_format($gp_mensal); ?></span>
                </div>
                <div class="ranking-item">
                    <span class="ranking-label">Ranking de Clan:</span>
                    <span class="ranking-value"><?php echo $clan_ranking ?: '[Sem clan]'; ?></span>
                </div>
                <div class="ranking-item">
                    <span class="ranking-label">Win Rate:</span>
                    <span class="ranking-value">/ [<?php echo $win_rate; ?>%]</span>
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

.dashboard-progress-section {
    background: var(--bg-white);
    padding: 1.5rem 2rem;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.progress-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1rem;
    position: relative;
}

.progress-icon {
    color: #fbbf24;
    font-size: 1.5rem;
}

.progress-icon-right {
    color: var(--text-dark);
    font-size: 1.2rem;
    position: absolute;
    right: 0;
}

.progress-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
}

.progress-bar-container {
    margin-top: 1rem;
}

.progress-bar {
    width: 100%;
    height: 24px;
    background: #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    transition: width 0.3s ease;
}

.progress-text {
    margin-top: 0.5rem;
    text-align: center;
    color: var(--text-light);
    font-size: 0.9rem;
}

.dashboard-section {
    background: var(--bg-white);
    padding: 2rem;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin: 0 0 1.5rem 0;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--border-color);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
}

.info-column {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: var(--bg-gray);
    border-radius: 8px;
}

.info-label {
    font-weight: 500;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-value {
    font-weight: 600;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.online-text {
    color: #10b981;
    font-size: 0.9rem;
}

.new-badge {
    color: #ef4444;
    font-size: 0.75rem;
    font-weight: 700;
}

.error-text {
    color: #ef4444;
}

.btn-listar, .btn-pagina {
    padding: 0.25rem 0.75rem;
    background: #f97316;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-left: 0.5rem;
}

.btn-listar:hover, .btn-pagina:hover {
    background: #ea580c;
    transform: scale(1.05);
}

.ranking-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.ranking-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-gray);
    border-radius: 8px;
}

.ranking-icon {
    color: #fbbf24;
    font-size: 1.5rem;
}

.ranking-label {
    font-weight: 500;
    color: var(--text-dark);
    flex: 1;
}

.ranking-value {
    font-weight: 700;
    color: var(--primary-color);
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .dashboard-section {
        padding: 1.5rem;
    }
    
    .progress-header {
        flex-wrap: wrap;
    }
    
    .progress-icon-right {
        position: static;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
