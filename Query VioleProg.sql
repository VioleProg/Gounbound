-- Configuração de charset
SET NAMES 'utf8mb4';
SET CHARACTER SET utf8mb4;

-- Criar tabela de tweets
CREATE TABLE IF NOT EXISTS `tweets` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` VARCHAR(16) NOT NULL,
    `nickname` VARCHAR(16) NOT NULL,
    `message` VARCHAR(100) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_user` (`user_id`),
    INDEX `idx_created` (`created_at`)
) ENGINE=InnoDB 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_general_ci;

-- Garantir charset nas colunas
ALTER TABLE `tweets` 
    MODIFY `user_id`   VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    MODIFY `nickname`  VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    MODIFY `message`   VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

-- Criar tabela de logs de mute
CREATE TABLE IF NOT EXISTS `mute_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `admin_id` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mute_time` datetime NOT NULL,
  `unmute_time` datetime DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `is_permanent` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `mute_time` (`mute_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Adicionar colunas muted_until e is_muted se não existirem
SET @dbname = DATABASE();
SET @tablename = 'tweets';
SET @columnname1 = 'muted_until';
SET @columnname2 = 'is_muted';

-- muted_until
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
   WHERE table_schema=@dbname AND table_name=@tablename AND column_name=@columnname1) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname1, ' datetime DEFAULT NULL')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- is_muted
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
   WHERE table_schema=@dbname AND table_name=@tablename AND column_name=@columnname2) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname2, ' tinyint(1) DEFAULT 0')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Criar tabela de tokens
CREATE TABLE IF NOT EXISTS `tokens` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `token_code` VARCHAR(32) NOT NULL UNIQUE,
    `type` ENUM('cash', 'gold', 'avatar', 'item') NOT NULL,
    `item_id` INT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    `expire_days` INT NULL COMMENT 'Dias até o item expirar (apenas avatar/item)',
    `uses_left` INT NOT NULL DEFAULT 1,
    `expires_at` DATETIME NULL COMMENT 'Data de expiração do token',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `created_by` VARCHAR(16) NOT NULL,
    `description` TEXT NULL,
    INDEX `idx_token_code` (`token_code`),
    INDEX `idx_type` (`type`),
    INDEX `idx_expires_at` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de logs de tokens
CREATE TABLE IF NOT EXISTS `token_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `token_id` INT NOT NULL,
    `token_code` VARCHAR(32) NOT NULL,
    `redeemed_by` VARCHAR(16) NOT NULL,
    `redeemed_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `item_inserted` TINYINT(1) DEFAULT 0,
    `chest_id` INT NULL COMMENT 'ID do item inserido no chest',
    INDEX `idx_token_id` (`token_id`),
    INDEX `idx_redeemed_by` (`redeemed_by`),
    INDEX `idx_redeemed_at` (`redeemed_at`),
    FOREIGN KEY (`token_id`) REFERENCES `tokens`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela para rastrear gastos de cash dos usuários
CREATE TABLE IF NOT EXISTS `cash_spending_history` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` VARCHAR(16) NOT NULL,
    `amount` INT NOT NULL COMMENT 'Quantidade de cash gasta',
    `spent_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `description` VARCHAR(255) NULL COMMENT 'Descrição do gasto (ex: compra de item, tweet, etc)',
    INDEX `idx_user` (`user_id`),
    INDEX `idx_spent_at` (`spent_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabela de Missões/Eventos
CREATE TABLE IF NOT EXISTS `missions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `mission_type` VARCHAR(50) NOT NULL COMMENT 'daily_login, play_games, win_games, send_tweets, reach_level, etc',
    `target_value` INT NOT NULL COMMENT 'Valor alvo para completar a missão',
    `event_points_reward` INT NOT NULL DEFAULT 0 COMMENT 'Pontos de evento a receber',
    `event_score_index` TINYINT NOT NULL DEFAULT 0 COMMENT 'Qual EventScore usar (0-3)',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `start_date` DATETIME NULL,
    `end_date` DATETIME NULL,
    `repeatable` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Se pode ser repetida (ex: diária)',
    `repeat_interval` VARCHAR(20) NULL COMMENT 'daily, weekly, monthly',
    `icon` VARCHAR(100) NULL COMMENT 'Ícone Font Awesome',
    `color` VARCHAR(20) NULL COMMENT 'Cor do card',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_active` (`is_active`),
    INDEX `idx_type` (`mission_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de Progresso de Missões por Usuário
CREATE TABLE IF NOT EXISTS `mission_progress` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` VARCHAR(16) NOT NULL,
    `mission_id` INT NOT NULL,
    `current_value` INT NOT NULL DEFAULT 0,
    `is_completed` TINYINT(1) NOT NULL DEFAULT 0,
    `completed_at` DATETIME NULL,
    `last_reset` DATETIME NULL COMMENT 'Última vez que foi resetada (para missões repetíveis)',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `unique_user_mission` (`user_id`, `mission_id`),
    INDEX `idx_user` (`user_id`),
    INDEX `idx_mission` (`mission_id`),
    INDEX `idx_completed` (`is_completed`),
    FOREIGN KEY (`mission_id`) REFERENCES `missions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserir missões padrão
INSERT INTO `missions` (`title`, `description`, `mission_type`, `target_value`, `event_points_reward`, `event_score_index`, `is_active`, `repeatable`, `repeat_interval`, `icon`, `color`) VALUES
('Login Diário', 'Faça login 7 dias seguidos para completar a missão!', 'daily_login', 7, 100, 0, 1, 1, 'daily', 'fa-calendar-check', '#4CAF50'),
('Jogador Ativo', 'Jogue 10 partidas para ganhar pontos de evento!', 'play_games', 10, 500, 0, 1, 0, NULL, 'fa-gamepad', '#2196F3'),
('Vencedor', 'Ganhe 5 partidas e mostre sua habilidade!', 'win_games', 5, 750, 1, 1, 0, NULL, 'fa-trophy', '#FF9800'),
('Comunidade Ativa', 'Envie 10 mensagens no chat para ganhar pontos!', 'send_tweets', 10, 300, 2, 1, 0, NULL, 'fa-comments', '#9C27B0'),
('Alcance o Topo', 'Alcance o rank 100 ou melhor para ganhar pontos!', 'reach_rank', 100, 1000, 3, 1, 0, NULL, 'fa-star', '#F44336'),
-- Missões de gasto de cash
('Gastador Iniciante', 'Gaste 15.000 cash para ganhar pontos!', 'spend_cash', 15000, 200, 0, 1, 0, NULL, 'fa-coins', '#FFC107'),
('Gastador Intermediário', 'Gaste 25.000 cash para ganhar pontos!', 'spend_cash', 25000, 400, 0, 1, 0, NULL, 'fa-coins', '#FF9800'),
('Gastador Avançado', 'Gaste 45.000 cash para ganhar pontos!', 'spend_cash', 45000, 600, 1, 1, 0, NULL, 'fa-coins', '#FF5722'),
('Gastador Expert', 'Gaste 65.000 cash para ganhar pontos!', 'spend_cash', 65000, 800, 1, 1, 0, NULL, 'fa-coins', '#E91E63'),
('Gastador Master', 'Gaste 100.000 cash para ganhar pontos!', 'spend_cash', 100000, 1200, 2, 1, 0, NULL, 'fa-coins', '#9C27B0'),
('Gastador Lendário', 'Gaste 150.000 cash para ganhar pontos!', 'spend_cash', 150000, 2000, 3, 1, 0, NULL, 'fa-coins', '#673AB7'),
-- Missões de ranking
('Top 1 GP', 'Alcance o primeiro lugar no ranking de GP!', 'top_1_gp', 1, 5000, 0, 1, 0, NULL, 'fa-crown', '#FFD700'),
('Top 3 GP', 'Fique entre os 3 primeiros no ranking de GP!', 'top_3_gp', 3, 3000, 1, 1, 0, NULL, 'fa-medal', '#C0C0C0');

-- Atualizar missão de Login Diário para 7 dias consecutivos
UPDATE `missions` 
SET 
    `target_value` = 7,
    `description` = 'Faça login 7 dias seguidos para completar a missão!',
    `updated_at` = NOW()
WHERE `mission_type` = 'daily_login';

-- Resetar progresso de todos os usuários para a missão de login diário
-- (para que todos comecem do zero com a nova regra de 7 dias)
UPDATE `mission_progress` 
SET 
    `current_value` = 0,
    `is_completed` = 0,
    `completed_at` = NULL,
    `last_reset` = NULL,
    `updated_at` = NOW()
WHERE `mission_id` IN (SELECT `id` FROM `missions` WHERE `mission_type` = 'daily_login');


-- Atualizar missão de Login Diário para 7 dias consecutivos
UPDATE `missions` 
SET 
    `target_value` = 7,
    `description` = 'Faça login 7 dias seguidos para completar a missão!',
    `updated_at` = NOW()
WHERE `mission_type` = 'daily_login';

-- Resetar progresso de todos os usuários para a missão de login diário
-- (para que todos comecem do zero com a nova regra de 7 dias)
UPDATE `mission_progress` 
SET 
    `current_value` = 0,
    `is_completed` = 0,
    `completed_at` = NULL,
    `last_reset` = NULL,
    `updated_at` = NOW()
WHERE `mission_id` IN (SELECT `id` FROM `missions` WHERE `mission_type` = 'daily_login');

