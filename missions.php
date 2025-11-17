<?php
require_once 'config.php';
require_once 'includes/functions.php';
require_once 'includes/mission_functions.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit;
}

// Verificar missões de rank e ranking ao acessar a página de missões
checkRankMission($_SESSION['user_id']);
checkRankingMissions($_SESSION['user_id']);

$user_id = $_SESSION['user_id'];

// Verificar se a tabela missions existe
global $conn;
$table_check = $conn->query("SHOW TABLES LIKE 'missions'");
$missions = [];

if ($table_check && $table_check->num_rows > 0) {
    // Buscar missões ativas
    $missions_query = "SELECT * FROM missions WHERE is_active = 1 ORDER BY id ASC";
    $missions_result = $conn->query($missions_query);
    if ($missions_result) {
        while ($row = $missions_result->fetch_assoc()) {
            $missions[] = $row;
        }
    }
}

// Buscar progresso do usuário para cada missão
$user_progress = [];
$progress_table_check = $conn->query("SHOW TABLES LIKE 'mission_progress'");

if ($progress_table_check && $progress_table_check->num_rows > 0) {
    foreach ($missions as $mission) {
        $progress_query = "SELECT * FROM mission_progress WHERE user_id = ? AND mission_id = ?";
        $stmt = $conn->prepare($progress_query);
        $stmt->bind_param("si", $user_id, $mission['id']);
        $stmt->execute();
        $progress_result = $stmt->get_result();
        $progress = $progress_result->fetch_assoc();
        
        if ($progress) {
            $user_progress[$mission['id']] = $progress;
        } else {
            // Criar registro de progresso se não existir
            $insert_progress = "INSERT INTO mission_progress (user_id, mission_id, current_value, is_completed) VALUES (?, ?, 0, 0)";
            $stmt2 = $conn->prepare($insert_progress);
            $stmt2->bind_param("si", $user_id, $mission['id']);
            $stmt2->execute();
            
            $user_progress[$mission['id']] = [
                'current_value' => 0,
                'is_completed' => 0,
                'completed_at' => null
            ];
        }
    }
}

// Buscar pontos de evento do usuário
$game_query = "SELECT EventScore0, EventScore1, EventScore2, EventScore3 FROM game WHERE Id = ?";
$stmt = $conn->prepare($game_query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$game_result = $stmt->get_result();
$game_data = $game_result->fetch_assoc();
$event_scores = [
    0 => $game_data['EventScore0'] ?? 0,
    1 => $game_data['EventScore1'] ?? 0,
    2 => $game_data['EventScore2'] ?? 0,
    3 => $game_data['EventScore3'] ?? 0
];

$page_title = 'Missões e Eventos';
include 'includes/header.php';
?>

<main class="main-content">
    <div class="container">
        <h1 class="page-title">
            <i class="fas fa-tasks"></i> Missões e Eventos
        </h1>
        
        <div class="missions-header">
            <div class="event-points-display">
                <h3>Seus Pontos de Evento</h3>
                <?php 
                $total_points = $event_scores[0] + $event_scores[1] + $event_scores[2] + $event_scores[3];
                ?>
                <div class="event-points-total">
                    <div class="event-point-total-item">
                        <span class="event-point-total-label">Total de Pontos:</span>
                        <span class="event-point-total-value"><?php echo number_format($total_points); ?></span>
                    </div>
                </div>
                <div class="event-points-grid">
                    <div class="event-point-item">
                        <span class="event-point-label">Evento 0:</span>
                        <span class="event-point-value"><?php echo number_format($event_scores[0]); ?></span>
                    </div>
                    <div class="event-point-item">
                        <span class="event-point-label">Evento 1:</span>
                        <span class="event-point-value"><?php echo number_format($event_scores[1]); ?></span>
                    </div>
                    <div class="event-point-item">
                        <span class="event-point-label">Evento 2:</span>
                        <span class="event-point-value"><?php echo number_format($event_scores[2]); ?></span>
                    </div>
                    <div class="event-point-item">
                        <span class="event-point-label">Evento 3:</span>
                        <span class="event-point-value"><?php echo number_format($event_scores[3]); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="missions-list">
            <?php if (empty($missions)): ?>
                <div class="no-missions">
                    <p>Nenhuma missão disponível no momento.</p>
                </div>
            <?php else: ?>
                <?php foreach ($missions as $mission): 
                    $progress = $user_progress[$mission['id']] ?? ['current_value' => 0, 'is_completed' => 0];
                    $current = $progress['current_value'];
                    $target = $mission['target_value'];
                    $percentage = $target > 0 ? min(100, ($current / $target) * 100) : 0;
                    $is_completed = $progress['is_completed'] ?? 0;
                    $color = $mission['color'] ?? '#6366f1';
                    $icon = $mission['icon'] ?? 'fa-star';
                ?>
                <div class="mission-item <?php echo $is_completed ? 'completed' : ''; ?>">
                    <div class="mission-item-content">
                        <div class="mission-item-header">
                            <h3 class="mission-item-title">
                                <?php if ($is_completed): ?>
                                    <i class="fas fa-check-circle mission-check"></i>
                                <?php else: ?>
                                    <i class="fas <?php echo $icon; ?> mission-icon"></i>
                                <?php endif; ?>
                                <?php echo htmlspecialchars($mission['title']); ?>
                            </h3>
                            <span class="mission-reward-badge">+<?php echo number_format($mission['event_points_reward']); ?> pts</span>
                        </div>
                        
                        <p class="mission-item-description"><?php echo htmlspecialchars($mission['description']); ?></p>
                        
                        <div class="mission-item-progress">
                            <div class="mission-progress-bar">
                                <div class="mission-progress-fill" style="width: <?php echo $percentage; ?>%; background-color: <?php echo $color; ?>;"></div>
                            </div>
                            <div class="mission-progress-text">
                                <span><?php echo number_format($current); ?> / <?php echo number_format($target); ?></span>
                                <span class="mission-percentage"><?php echo number_format($percentage, 0); ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

