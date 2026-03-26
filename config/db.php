<?php

date_default_timezone_set('Asia/Shanghai'); // GMT+8

// 关闭 PHP 错误 HTML 输出，防止污染 JSON 响应
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);

// 将所有未捕获异常统一转为 JSON 响应
set_exception_handler(function (Throwable $e) {
    while (ob_get_level()) ob_end_clean();
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => '服务器内部错误：' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
    exit;
});

function loadDbConfig(): array {
    $config = [
        'host' => getenv('TASKM_DB_HOST') !== false ? getenv('TASKM_DB_HOST') : null,
        'name' => getenv('TASKM_DB_NAME') !== false ? getenv('TASKM_DB_NAME') : null,
        'user' => getenv('TASKM_DB_USER') !== false ? getenv('TASKM_DB_USER') : null,
        'pass' => getenv('TASKM_DB_PASS') !== false ? getenv('TASKM_DB_PASS') : null,
        'charset' => getenv('TASKM_DB_CHARSET') !== false ? getenv('TASKM_DB_CHARSET') : 'utf8mb4',
    ];

    $localConfigPath = __DIR__ . '/db.local.php';
    if (is_file($localConfigPath)) {
        $localConfig = require $localConfigPath;
        if (!is_array($localConfig)) {
            throw new RuntimeException('数据库本地配置文件格式错误');
        }

        foreach (['host', 'name', 'user', 'pass', 'charset'] as $key) {
            if (array_key_exists($key, $localConfig)) {
                $config[$key] = $localConfig[$key];
            }
        }
    }

    foreach (['host', 'name', 'user', 'pass'] as $key) {
        if ($config[$key] === null) {
            throw new RuntimeException('缺少数据库配置：' . $key);
        }
    }

    return $config;
}

$dbConfig = loadDbConfig();

define('DB_HOST', $dbConfig['host']);
define('DB_NAME', $dbConfig['name']);
define('DB_USER', $dbConfig['user']);
define('DB_PASS', $dbConfig['pass']);
define('DB_CHARSET', $dbConfig['charset'] ?: 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        // 尝试自动建库（若用户无 CREATE DATABASE 权限则跳过，假设库已存在）
        try {
            $pdoRoot = new PDO(
                'mysql:host=' . DB_HOST . ';charset=' . DB_CHARSET,
                DB_USER, DB_PASS, $options
            );
            $pdoRoot->exec(
                'CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'
            );
        } catch (PDOException $e) {
            // 权限不足时忽略，直接尝试连接已有数据库
        }

        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
            DB_USER, DB_PASS, $options
        );
        $pdo->exec("SET time_zone = '+08:00'"); // GMT+8
    }
    return $pdo;
}

function initDB(): void {
    $pdo = getDB();

    $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
        `id`            VARCHAR(50)  NOT NULL,
        `username`      VARCHAR(100) NOT NULL UNIQUE,
        `email`         VARCHAR(255) NOT NULL UNIQUE,
        `password_hash` VARCHAR(255) NOT NULL,
        `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    try {
        $pdo->exec("ALTER TABLE `users` ADD UNIQUE INDEX `idx_username` (`username`)");
    } catch (PDOException $e) {
    }

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

function getInitializedDB(): PDO {
    initDB();
    return getDB();
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
    while (ob_get_level()) ob_end_clean();
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
