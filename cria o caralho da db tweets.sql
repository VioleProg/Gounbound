-- Essa buceta tem limite de 100 caracteres por mensagem

SET NAMES 'utf8mb4';
SET CHARACTER SET utf8mb4;

CREATE TABLE `tweets` (
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

ALTER TABLE `tweets` 
    MODIFY `user_id` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    MODIFY `nickname` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    MODIFY `message` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

SELECT 
    TABLE_COLLATION,
    CCSA.character_set_name as CHARSET
FROM information_schema.TABLES T
JOIN information_schema.COLLATION_CHARACTER_SET_APPLICABILITY CCSA 
    ON CCSA.collation_name = T.table_collation
WHERE T.table_schema = DATABASE() 
    AND T.table_name = 'tweets';