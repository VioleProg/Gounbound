<?php
/**
 * Funções para gerenciar missões e eventos
 */

/**
 * Atualiza o progresso de uma missão para um usuário
 * @param string $user_id ID do usuário
 * @param string $mission_type Tipo da missão (daily_login, play_games, win_games, send_tweets, reach_rank)
 * @param int $value Valor a adicionar ao progresso (padrão: 1)
 */
function updateMissionProgress($user_id, $mission_type, $value = 1) {
    global $conn;
    
    if (!$user_id || !$mission_type) {
        return false;
    }
    
    try {
        // Buscar missões do tipo especificado
        $missions_query = "SELECT * FROM missions WHERE mission_type = ? AND is_active = 1";
        $stmt = $conn->prepare($missions_query);
        $stmt->bind_param("s", $mission_type);
        $stmt->execute();
        $missions_result = $stmt->get_result();
        
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
                    // Login diário - verificar se é consecutivo (7 dias seguidos)
                    $today = date('Y-m-d');
                    $yesterday = date('Y-m-d', strtotime('-1 day'));
                    $last_login_date = null;
                    
                    // Buscar última data de login (usar updated_at como referência)
                    if ($progress && $progress['updated_at']) {
                        $last_login_date = date('Y-m-d', strtotime($progress['updated_at']));
                    }
                    
                    // Verificar se já fez login hoje
                    if ($last_login_date == $today) {
                        // Já fez login hoje - não incrementar novamente
                        // Manter o valor atual sem alterar
                    } else {
                        // Verificar se é login consecutivo
                        if ($last_login_date == $yesterday) {
                            // Login consecutivo - incrementar
                            $current_value = min($mission['target_value'], ($current_value > 0 ? $current_value : 0) + $value);
                        } else if ($last_login_date && $last_login_date != $today && $last_login_date != $yesterday) {
                            // Perdeu a sequência (último login foi antes de ontem) - resetar para dia 1
                            $current_value = 1;
                        } else {
                            // Primeiro login ou nunca fez login - começar do dia 1
                            $current_value = 1;
                        }
                    }
                } elseif ($mission_type == 'spend_cash') {
                    // Missão de gasto de cash - atualizar com o total gasto acumulado
                    $total_spent = getTotalCashSpent($user_id);
                    // O current_value deve ser o total gasto (até o limite da missão)
                    $current_value = min($mission['target_value'], $total_spent);
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
                }
            }
        }
        
        return true;
    } catch (Exception $e) {
        error_log("Erro ao atualizar progresso de missão: " . $e->getMessage());
        return false;
    }
}

/**
 * Registra um gasto de cash do usuário
 * @param string $user_id ID do usuário
 * @param int $amount Quantidade de cash gasta
 * @param string $description Descrição do gasto (opcional)
 */
function recordCashSpending($user_id, $amount, $description = '') {
    global $conn;
    
    if (!$user_id || $amount <= 0) {
        return false;
    }
    
    try {
        // Registrar no histórico
        $stmt = $conn->prepare("INSERT INTO cash_spending_history (user_id, amount, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $user_id, $amount, $description);
        $stmt->execute();
        $stmt->close();
        
        // Atualizar progresso das missões de gasto de cash (passar 0 como value, pois vamos calcular o total)
        updateMissionProgress($user_id, 'spend_cash', 0);
        
        return true;
    } catch (Exception $e) {
        error_log("Erro ao registrar gasto de cash: " . $e->getMessage());
        return false;
    }
}

/**
 * Obtém o total de cash gasto pelo usuário
 * @param string $user_id ID do usuário
 * @return int Total de cash gasto
 */
function getTotalCashSpent($user_id) {
    global $conn;
    
    if (!$user_id) {
        return 0;
    }
    
    try {
        $stmt = $conn->prepare("SELECT SUM(amount) as total FROM cash_spending_history WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return (int)($row['total'] ?? 0);
    } catch (Exception $e) {
        error_log("Erro ao obter total de cash gasto: " . $e->getMessage());
        return 0;
    }
}

/**
 * Verifica e atualiza missões de ranking (Top 1 e Top 3)
 * @param string $user_id ID do usuário
 */
function checkRankingMissions($user_id) {
    global $conn;
    
    if (!$user_id) {
        return false;
    }
    
    try {
        // Buscar rank atual do usuário
        $rank_query = "SELECT TotalRank FROM game WHERE Id = ?";
        $stmt = $conn->prepare($rank_query);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $rank_result = $stmt->get_result();
        $rank_data = $rank_result->fetch_assoc();
        $stmt->close();
        
        if (!$rank_data) {
            return false;
        }
        
        $current_rank = (int)($rank_data['TotalRank'] ?? 999999);
        
        // Verificar missão Top 1
        if ($current_rank == 1) {
            $mission_query = "SELECT * FROM missions WHERE mission_type = 'top_1_gp' AND is_active = 1 LIMIT 1";
            $mission_result = $conn->query($mission_query);
            
            if ($mission = $mission_result->fetch_assoc()) {
                // Buscar progresso
                $progress_query = "SELECT * FROM mission_progress WHERE user_id = ? AND mission_id = ?";
                $stmt2 = $conn->prepare($progress_query);
                $stmt2->bind_param("si", $user_id, $mission['id']);
                $stmt2->execute();
                $progress_result = $stmt2->get_result();
                $progress = $progress_result->fetch_assoc();
                $stmt2->close();
                
                if (!$progress || $progress['is_completed'] == 0) {
                    // Completar missão
                    if (!$progress) {
                        $insert = "INSERT INTO mission_progress (user_id, mission_id, current_value, is_completed, completed_at) VALUES (?, ?, 1, 1, NOW())";
                        $stmt3 = $conn->prepare($insert);
                        $stmt3->bind_param("si", $user_id, $mission['id']);
                        $stmt3->execute();
                        $stmt3->close();
                    } else {
                        $update = "UPDATE mission_progress SET current_value = 1, is_completed = 1, completed_at = NOW() WHERE user_id = ? AND mission_id = ?";
                        $stmt3 = $conn->prepare($update);
                        $stmt3->bind_param("si", $user_id, $mission['id']);
                        $stmt3->execute();
                        $stmt3->close();
                    }
                    
                    // Dar recompensa
                    $event_field = 'EventScore' . $mission['event_score_index'];
                    $update_event = "UPDATE game SET $event_field = $event_field + ? WHERE Id = ?";
                    $stmt4 = $conn->prepare($update_event);
                    $reward = $mission['event_points_reward'];
                    $stmt4->bind_param("is", $reward, $user_id);
                    $stmt4->execute();
                    $stmt4->close();
                    
                    // Registrar no eventlog
                    $insert_log = "INSERT INTO eventlog (Id, Code, AcquiredScore, Time) VALUES (?, ?, ?, NOW())";
                    $stmt5 = $conn->prepare($insert_log);
                    $code = $mission['event_score_index'];
                    $stmt5->bind_param("sii", $user_id, $code, $reward);
                    $stmt5->execute();
                    $stmt5->close();
                }
            }
        }
        
        // Verificar missão Top 3
        if ($current_rank >= 1 && $current_rank <= 3) {
            $mission_query = "SELECT * FROM missions WHERE mission_type = 'top_3_gp' AND is_active = 1 LIMIT 1";
            $mission_result = $conn->query($mission_query);
            
            if ($mission = $mission_result->fetch_assoc()) {
                // Buscar progresso
                $progress_query = "SELECT * FROM mission_progress WHERE user_id = ? AND mission_id = ?";
                $stmt2 = $conn->prepare($progress_query);
                $stmt2->bind_param("si", $user_id, $mission['id']);
                $stmt2->execute();
                $progress_result = $stmt2->get_result();
                $progress = $progress_result->fetch_assoc();
                $stmt2->close();
                
                if (!$progress || $progress['is_completed'] == 0) {
                    // Completar missão
                    if (!$progress) {
                        $insert = "INSERT INTO mission_progress (user_id, mission_id, current_value, is_completed, completed_at) VALUES (?, ?, ?, 1, NOW())";
                        $stmt3 = $conn->prepare($insert);
                        $stmt3->bind_param("sii", $user_id, $mission['id'], $current_rank);
                        $stmt3->execute();
                        $stmt3->close();
                    } else {
                        $update = "UPDATE mission_progress SET current_value = ?, is_completed = 1, completed_at = NOW() WHERE user_id = ? AND mission_id = ?";
                        $stmt3 = $conn->prepare($update);
                        $stmt3->bind_param("isi", $current_rank, $user_id, $mission['id']);
                        $stmt3->execute();
                        $stmt3->close();
                    }
                    
                    // Dar recompensa
                    $event_field = 'EventScore' . $mission['event_score_index'];
                    $update_event = "UPDATE game SET $event_field = $event_field + ? WHERE Id = ?";
                    $stmt4 = $conn->prepare($update_event);
                    $reward = $mission['event_points_reward'];
                    $stmt4->bind_param("is", $reward, $user_id);
                    $stmt4->execute();
                    $stmt4->close();
                    
                    // Registrar no eventlog
                    $insert_log = "INSERT INTO eventlog (Id, Code, AcquiredScore, Time) VALUES (?, ?, ?, NOW())";
                    $stmt5 = $conn->prepare($insert_log);
                    $code = $mission['event_score_index'];
                    $stmt5->bind_param("sii", $user_id, $code, $reward);
                    $stmt5->execute();
                    $stmt5->close();
                }
            }
        }
        
        return true;
    } catch (Exception $e) {
        error_log("Erro ao verificar missões de ranking: " . $e->getMessage());
        return false;
    }
}

/**
 * Verifica e atualiza missão de rank quando o usuário acessa o dashboard
 */
function checkRankMission($user_id) {
    global $conn;
    
    try {
        // Buscar rank atual do usuário
        $rank_query = "SELECT TotalRank FROM game WHERE Id = ?";
        $stmt = $conn->prepare($rank_query);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $rank_result = $stmt->get_result();
        $rank_data = $rank_result->fetch_assoc();
        
        if ($rank_data) {
            $current_rank = $rank_data['TotalRank'] ?? 999999;
            
            // Buscar missão de rank
            $mission_query = "SELECT * FROM missions WHERE mission_type = 'reach_rank' AND is_active = 1 LIMIT 1";
            $mission_result = $conn->query($mission_query);
            
            if ($mission = $mission_result->fetch_assoc()) {
                $target_rank = $mission['target_value'];
                
                // Se o rank atual é melhor (menor) que o alvo, completar
                if ($current_rank <= $target_rank) {
                    // Buscar progresso
                    $progress_query = "SELECT * FROM mission_progress WHERE user_id = ? AND mission_id = ?";
                    $stmt2 = $conn->prepare($progress_query);
                    $stmt2->bind_param("si", $user_id, $mission['id']);
                    $stmt2->execute();
                    $progress_result = $stmt2->get_result();
                    $progress = $progress_result->fetch_assoc();
                    
                    if (!$progress || $progress['is_completed'] == 0) {
                        // Atualizar progresso para completo
                        if (!$progress) {
                            $insert = "INSERT INTO mission_progress (user_id, mission_id, current_value, is_completed, completed_at) VALUES (?, ?, ?, 1, NOW())";
                            $stmt3 = $conn->prepare($insert);
                            $stmt3->bind_param("sii", $user_id, $mission['id'], $target_rank);
                            $stmt3->execute();
                        } else {
                            $update = "UPDATE mission_progress SET current_value = ?, is_completed = 1, completed_at = NOW() WHERE user_id = ? AND mission_id = ?";
                            $stmt3 = $conn->prepare($update);
                            $stmt3->bind_param("isi", $target_rank, $user_id, $mission['id']);
                            $stmt3->execute();
                        }
                        
                        // Dar recompensa
                        $event_field = 'EventScore' . $mission['event_score_index'];
                        $update_event = "UPDATE game SET $event_field = $event_field + ? WHERE Id = ?";
                        $stmt4 = $conn->prepare($update_event);
                        $reward = $mission['event_points_reward'];
                        $stmt4->bind_param("is", $reward, $user_id);
                        $stmt4->execute();
                        
                        // Registrar no eventlog
                        $insert_log = "INSERT INTO eventlog (Id, Code, AcquiredScore, Time) VALUES (?, ?, ?, NOW())";
                        $stmt5 = $conn->prepare($insert_log);
                        $code = $mission['event_score_index'];
                        $stmt5->bind_param("sii", $user_id, $code, $reward);
                        $stmt5->execute();
                    }
                }
            }
        }
    } catch (Exception $e) {
        error_log("Erro ao verificar missão de rank: " . $e->getMessage());
    }
}
?>

