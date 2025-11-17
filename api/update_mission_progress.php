<?php
require_once '../config.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

$user_id = $_SESSION['user_id'];
$mission_type = $_POST['mission_type'] ?? $_GET['mission_type'] ?? '';
$value = isset($_POST['value']) ? (int)$_POST['value'] : (isset($_GET['value']) ? (int)$_GET['value'] : 1);

if (empty($mission_type)) {
    echo json_encode(['success' => false, 'message' => 'Tipo de missão não fornecido']);
    exit;
}

global $conn;

try {
    // Buscar missões do tipo especificado
    $missions_query = "SELECT * FROM missions WHERE mission_type = ? AND is_active = 1";
    $stmt = $conn->prepare($missions_query);
    $stmt->bind_param("s", $mission_type);
    $stmt->execute();
    $missions_result = $stmt->get_result();
    
    $updated_missions = [];
    
    while ($mission = $missions_result->fetch_assoc()) {
        // Verificar se é missão repetível e precisa resetar
        $needs_reset = false;
        if ($mission['repeatable'] == 1) {
            $progress_query = "SELECT * FROM mission_progress WHERE user_id = ? AND mission_id = ?";
            $stmt2 = $conn->prepare($progress_query);
            $stmt2->bind_param("si", $user_id, $mission['id']);
            $stmt2->execute();
            $progress_result = $stmt2->get_result();
            $progress = $progress_result->fetch_assoc();
            
            if ($progress && $progress['is_completed'] == 1) {
                // Verificar se precisa resetar baseado no intervalo
                $last_reset = $progress['last_reset'] ? strtotime($progress['last_reset']) : 0;
                $now = time();
                $should_reset = false;
                
                if ($mission['repeat_interval'] == 'daily') {
                    $should_reset = date('Y-m-d', $last_reset) != date('Y-m-d', $now);
                } elseif ($mission['repeat_interval'] == 'weekly') {
                    $should_reset = date('W', $last_reset) != date('W', $now) || date('Y', $last_reset) != date('Y', $now);
                } elseif ($mission['repeat_interval'] == 'monthly') {
                    $should_reset = date('Y-m', $last_reset) != date('Y-m', $now);
                }
                
                if ($should_reset) {
                    $needs_reset = true;
                }
            }
        }
        
        // Buscar ou criar progresso
        $progress_query = "SELECT * FROM mission_progress WHERE user_id = ? AND mission_id = ?";
        $stmt2 = $conn->prepare($progress_query);
        $stmt2->bind_param("si", $user_id, $mission['id']);
        $stmt2->execute();
        $progress_result = $stmt2->get_result();
        $progress = $progress_result->fetch_assoc();
        
        if (!$progress) {
            // Criar novo progresso
            $insert_progress = "INSERT INTO mission_progress (user_id, mission_id, current_value, is_completed) VALUES (?, ?, 0, 0)";
            $stmt3 = $conn->prepare($insert_progress);
            $stmt3->bind_param("si", $user_id, $mission['id']);
            $stmt3->execute();
            $current_value = 0;
            $is_completed = 0;
        } else {
            $current_value = $progress['current_value'];
            $is_completed = $progress['is_completed'];
        }
        
        // Resetar se necessário
        if ($needs_reset) {
            $current_value = 0;
            $is_completed = 0;
        }
        
        // Atualizar progresso baseado no tipo de missão
        if (!$is_completed || $needs_reset) {
            if ($mission_type == 'daily_login') {
                // Login diário - apenas incrementar se ainda não completou hoje
                if ($current_value < $mission['target_value']) {
                    $current_value = min($mission['target_value'], $current_value + $value);
                }
            } else {
                // Outras missões - incrementar normalmente
                $current_value = min($mission['target_value'], $current_value + $value);
            }
            
            // Verificar se completou
            $new_completed = ($current_value >= $mission['target_value']) ? 1 : 0;
            $completed_at = $new_completed && !$is_completed ? date('Y-m-d H:i:s') : ($progress['completed_at'] ?? null);
            
            // Atualizar no banco
            $update_progress = "UPDATE mission_progress SET 
                                current_value = ?, 
                                is_completed = ?, 
                                completed_at = ?,
                                last_reset = ?
                                WHERE user_id = ? AND mission_id = ?";
            $reset_time = $needs_reset ? date('Y-m-d H:i:s') : ($progress['last_reset'] ?? null);
            $stmt4 = $conn->prepare($update_progress);
            $stmt4->bind_param("iisssi", $current_value, $new_completed, $completed_at, $reset_time, $user_id, $mission['id']);
            $stmt4->execute();
            
            // Se completou, dar recompensa
            if ($new_completed && !$is_completed) {
                // Adicionar pontos de evento
                $event_field = 'EventScore' . $mission['event_score_index'];
                $update_event = "UPDATE game SET $event_field = $event_field + ? WHERE Id = ?";
                $stmt5 = $conn->prepare($update_event);
                $reward = $mission['event_points_reward'];
                $stmt5->bind_param("is", $reward, $user_id);
                $stmt5->execute();
                
                // Registrar no eventlog
                $insert_log = "INSERT INTO eventlog (Id, Code, AcquiredScore, Time) VALUES (?, ?, ?, NOW())";
                $stmt6 = $conn->prepare($insert_log);
                $code = $mission['event_score_index'];
                $stmt6->bind_param("sii", $user_id, $code, $reward);
                $stmt6->execute();
                
                $updated_missions[] = [
                    'id' => $mission['id'],
                    'title' => $mission['title'],
                    'completed' => true,
                    'reward' => $reward
                ];
            } else {
                $updated_missions[] = [
                    'id' => $mission['id'],
                    'title' => $mission['title'],
                    'completed' => false,
                    'current' => $current_value,
                    'target' => $mission['target_value']
                ];
            }
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Progresso atualizado',
        'missions' => $updated_missions
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao atualizar progresso: ' . $e->getMessage()
    ]);
}
?>

