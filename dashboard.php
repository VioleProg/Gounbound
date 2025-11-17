<?php
require_once 'config.php';
require_once 'includes/functions.php';
require_once 'includes/rank_functions.php';
require_once 'includes/mission_functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Verificar missões de rank e ranking ao acessar o dashboard
require_once 'includes/mission_functions.php';
checkRankMission($_SESSION['user_id']);
checkRankingMissions($_SESSION['user_id']);

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

// Win Rate (calcular da tabela playlog)
$win_rate = 0;
$win_count = 0;
$total_games = 0;
try {
    $stmt = $conn->prepare("SELECT * FROM playlog WHERE S0_ID = ? OR S1_ID = ? OR S2_ID = ? OR S3_ID = ? OR S4_ID = ? OR S5_ID = ? OR S6_ID = ? OR S7_ID = ?");
    $stmt->bind_param("ssssssss", $user_id, $user_id, $user_id, $user_id, $user_id, $user_id, $user_id, $user_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $total_games++;
            $win_team = $row['WinTeamOrPlayer'] ?? 0;
            // Verificar se o usuário está no time vencedor
            if (($win_team == 0 && $row['S0_ID'] == $user_id) ||
                ($win_team == 1 && $row['S1_ID'] == $user_id) ||
                ($win_team == 2 && $row['S2_ID'] == $user_id) ||
                ($win_team == 3 && $row['S3_ID'] == $user_id) ||
                ($win_team == 4 && $row['S4_ID'] == $user_id) ||
                ($win_team == 5 && $row['S5_ID'] == $user_id) ||
                ($win_team == 6 && $row['S6_ID'] == $user_id) ||
                ($win_team == 7 && $row['S7_ID'] == $user_id)) {
                $win_count++;
            }
        }
        if ($total_games > 0) {
            $win_rate = round(($win_count / $total_games) * 100, 0);
        }
    }
    $stmt->close();
} catch (Exception $e) {
    // Se a tabela não existir, manter win_rate = 0
    error_log("Erro ao calcular win rate: " . $e->getMessage());
}

// GP Mensal (usando SeasonScore)
$gp_mensal = $user_info['SeasonScore'] ?? 0;

// Ranking de Clan (usando GuildRank e MemberCount)
$clan_ranking = '';
if ($guild) {
    $member_count = $user_info['MemberCount'] ?? 0;
    $clan_ranking = '[' . $guild_rank . ' / ' . $member_count . ']';
}

// Progresso do jogo baseado no sistema de ranks
$current_gp = $user_info['TotalScore'] ?? 0;
$rank_progress = getRankProgress($current_gp);
$gp_needed = $rank_progress['gp_needed'];
$gp_progress = $rank_progress['progress'];
$current_rank = $rank_progress['current'];
$next_rank = $rank_progress['next'];

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
                <h2 class="progress-title">Progresso do seu jogo</h2>
                <i class="fas fa-trophy progress-icon-right"></i>
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar-wrapper">
                    <?php if ($next_rank): ?>
                        <div class="progress-rank-image progress-rank-left">
                            <?php echo getRankImage($current_rank['grade'], 'large'); ?>
                            <div class="progress-rank-name"><?php echo htmlspecialchars($current_rank['name']); ?></div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="progress-bar-middle">
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: <?php echo $gp_progress; ?>%"></div>
                            <?php if ($next_rank): ?>
                                <div class="progress-percentage"><?php echo number_format($gp_progress, 1); ?>%</div>
                            <?php endif; ?>
                        </div>
                        <div class="progress-info">
                            <?php if ($next_rank): ?>
                                <div class="progress-text">
                                    <strong><?php echo number_format($current_gp); ?></strong> / <strong><?php echo number_format($next_rank['gp']); ?></strong> GP
                                </div>
                                <div class="progress-text">
                                    Faltam <strong><?php echo number_format($gp_needed); ?> GP</strong> para o próximo rank
                                </div>
                            <?php else: ?>
                                <div class="progress-text">
                                    <strong>Rank Máximo Alcançado!</strong>
                                </div>
                                <div class="progress-text">
                                    Você está no rank <strong><?php echo htmlspecialchars($current_rank['name']); ?></strong> com <?php echo number_format($current_gp); ?> GP
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if ($next_rank): ?>
                        <div class="progress-rank-image progress-rank-right">
                            <?php echo getRankImage($next_rank['grade'], 'large'); ?>
                            <div class="progress-rank-name"><?php echo htmlspecialchars($next_rank['name']); ?></div>
                        </div>
                    <?php else: ?>
                        <div class="progress-rank-image progress-rank-right">
                            <?php echo getRankImage($current_rank['grade'], 'large'); ?>
                            <div class="progress-rank-name"><?php echo htmlspecialchars($current_rank['name']); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
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
                            <button class="btn-listar" onclick="openModal('avatarsModal'); loadAvatars();">LISTAR</button>
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
                    <span class="ranking-value">
                        <?php if ($total_games > 0): ?>
                            <?php echo $win_count; ?> / <?php echo $total_games; ?> [<?php echo $win_rate; ?>%]
                        <?php else: ?>
                            / [0%]
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Resgatar Token -->
        <div class="dashboard-section">
            <h2 class="section-title"><i class="fas fa-gift"></i> Resgatar Token</h2>
            <div style="padding: 1.5rem; background: var(--bg-white); border-radius: 12px; box-shadow: var(--shadow-md); border: 1px solid var(--border-color);">
                <form id="redeemTokenForm" style="display: flex; gap: 1rem; align-items: flex-end;">
                    <div style="flex: 1;">
                        <label for="token_code" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">
                            Código do Token:
                        </label>
                        <input type="text" id="token_code" name="token_code" required 
                               placeholder="Digite o código do token"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 8px; font-size: 1rem; font-family: monospace; text-transform: uppercase;"
                               maxlength="32">
                    </div>
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; white-space: nowrap;">
                        <i class="fas fa-key"></i> Resgatar
                    </button>
                </form>
                <div id="tokenRedeemAlert" style="margin-top: 1rem; display: none;"></div>
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

.progress-bar-wrapper {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    width: 100%;
}

.progress-rank-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
}

.progress-rank-image img {
    width: 56px;
    height: 56px;
    object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.progress-rank-name {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-dark);
    text-align: center;
    max-width: 80px;
    word-wrap: break-word;
}

.progress-bar-middle {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    min-width: 0;
}

.progress-bar {
    width: 100%;
    height: 32px;
    background: #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    transition: width 0.5s ease;
    position: relative;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
}

.progress-percentage {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-weight: 700;
    font-size: 0.9rem;
    color: #fff;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    z-index: 10;
}

.progress-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.progress-text {
    text-align: center;
    color: var(--text-light);
    font-size: 0.9rem;
}

.progress-text strong {
    color: var(--primary-color);
    font-weight: 700;
}

@media (max-width: 768px) {
    .progress-bar-wrapper {
        flex-direction: column;
        gap: 1rem;
    }
    
    .progress-rank-image {
        flex-direction: row;
        gap: 0.75rem;
    }
    
    .progress-rank-image img {
        width: 48px;
        height: 48px;
    }
    
    .progress-rank-name {
        max-width: none;
        font-size: 0.85rem;
    }
    
    .progress-bar {
        height: 28px;
    }
    
    .progress-percentage {
        font-size: 0.8rem;
    }
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
