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
