<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'taskm');
define('DB_USER', 'TaskM');
define('DB_PASS', 'WBwTxTMhczpHfhdM');
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }
    return $pdo;
}

function initDB(): void {
    $pdo = getDB();

    $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
        `id`            VARCHAR(50)  NOT NULL,
        `username`      VARCHAR(100) NOT NULL,
        `email`         VARCHAR(255) NOT NULL UNIQUE,
        `password_hash` VARCHAR(255) NOT NULL,
        `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    $pdo->exec("CREATE TABLE IF NOT EXISTS `tasks` (
        `id`           VARCHAR(50)   NOT NULL,
        `user_id`      VARCHAR(50)   NOT NULL,
        `title`        VARCHAR(255)  NOT NULL,
        `description`  TEXT,
        `category`     VARCHAR(100)  DEFAULT NULL,
        `tags`         JSON          DEFAULT NULL,
        `ddl`          DATETIME      DEFAULT NULL,
        `progress`     INT           NOT NULL DEFAULT 0,
        `is_completed` TINYINT(1)    NOT NULL DEFAULT 0,
        `created_at`   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at`   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    $pdo->exec("CREATE TABLE IF NOT EXISTS `commits` (
        `id`         VARCHAR(50) NOT NULL,
        `task_id`    VARCHAR(50) NOT NULL,
        `user_id`    VARCHAR(50) NOT NULL,
        `type`       ENUM('no_progress','completed','follow_up') NOT NULL,
        `content`    TEXT,
        `progress`   INT         NOT NULL DEFAULT 0,
        `created_at` DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`task_id`) REFERENCES `tasks`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
}

function generateId(string $prefix): string {
    return $prefix . '_' . sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function jsonResponse(array $data, int $status = 200): never {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function requireAuth(): array {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['user_id'])) {
        jsonResponse(['error' => '未登录'], 401);
    }
    return ['id' => $_SESSION['user_id'], 'username' => $_SESSION['username']];
}

initDB();
