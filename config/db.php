<?php

// 关闭 PHP 错误 HTML 输出，防止污染 JSON 响应
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);

const TASKM_LANG_ZH = 'zh-CN';
const TASKM_LANG_EN = 'en';

function normalizeLanguage(?string $language): string {
    $normalized = strtolower(trim((string) $language));
    if ($normalized === '') {
        return TASKM_LANG_ZH;
    }
    if (str_starts_with($normalized, 'en')) {
        return TASKM_LANG_EN;
    }
    if (str_starts_with($normalized, 'zh')) {
        return TASKM_LANG_ZH;
    }
    return TASKM_LANG_ZH;
}

function getRequestLanguage(): string {
    static $language = null;
    if ($language !== null) {
        return $language;
    }

    $headerLanguage = $_SERVER['HTTP_X_TASKM_LANG'] ?? '';
    if ($headerLanguage !== '') {
        $language = normalizeLanguage($headerLanguage);
        return $language;
    }

    $acceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    if ($acceptLanguage !== '') {
        foreach (explode(',', $acceptLanguage) as $part) {
            $candidate = trim(explode(';', $part)[0] ?? '');
            if ($candidate !== '') {
                $language = normalizeLanguage($candidate);
                return $language;
            }
        }
    }

    $language = TASKM_LANG_ZH;
    return $language;
}

function taskmTranslations(): array {
    static $translations = null;
    if ($translations !== null) {
        return $translations;
    }

    $translations = [
        TASKM_LANG_ZH => [
            'common.post_only' => '仅支持 POST 请求',
            'common.missing_params' => '参数不完整',
            'common.invalid_password_hash' => '密码格式不正确',
            'common.internal_error' => '服务器内部错误，请稍后重试',
            'common.unauthorized' => '未登录',
            'common.missing_task_id' => '缺少任务 ID',
            'common.task_not_found' => '任务不存在',
            'common.task_title_required' => '任务标题不能为空',
            'common.invalid_ddl' => 'DDL 时间格式不正确',
            'common.no_fields_to_update' => '没有可更新的字段',
            'common.task_id_required' => '任务 ID 不能为空',
            'common.task_delete_forbidden' => '任务不存在或无权删除',
            'common.invalid_commit_type' => '无效的 commit 类型',
            'common.deleted' => '任务已删除',
            'auth.invalid_email' => '邮箱格式不正确',
            'auth.email_taken' => '该邮箱已被注册',
            'auth.username_taken' => '该用户名已被使用',
            'auth.invalid_credentials' => '用户名/邮箱或密码不正确',
            'captcha.param_missing' => '验证码参数缺失',
            'captcha.request_failed' => '验证码服务请求失败',
            'captcha.invalid_response' => '验证码服务返回异常',
            'captcha.invalid_permission' => '验证码服务配置错误，请联系管理员',
            'captcha.verify_failed' => '验证码服务校验失败',
            'captcha.verify_rejected' => '验证码校验未通过',
            'commits.default_no_progress' => '今日无进展',
        ],
        TASKM_LANG_EN => [
            'common.post_only' => 'Only POST requests are supported',
            'common.missing_params' => 'Missing required parameters',
            'common.invalid_password_hash' => 'Invalid password format',
            'common.internal_error' => 'Internal server error. Please try again later.',
            'common.unauthorized' => 'Not signed in',
            'common.missing_task_id' => 'Missing task ID',
            'common.task_not_found' => 'Task not found',
            'common.task_title_required' => 'Task title is required',
            'common.invalid_ddl' => 'Invalid deadline format',
            'common.no_fields_to_update' => 'No updatable fields were provided',
            'common.task_id_required' => 'Task ID is required',
            'common.task_delete_forbidden' => 'Task not found or you do not have permission to delete it',
            'common.invalid_commit_type' => 'Invalid commit type',
            'common.deleted' => 'Task deleted',
            'auth.invalid_email' => 'Invalid email format',
            'auth.email_taken' => 'This email is already registered',
            'auth.username_taken' => 'This username is already in use',
            'auth.invalid_credentials' => 'Incorrect username/email or password',
            'captcha.param_missing' => 'Missing captcha parameters',
            'captcha.request_failed' => 'Captcha service request failed',
            'captcha.invalid_response' => 'Captcha service returned an invalid response',
            'captcha.invalid_permission' => 'Captcha service is misconfigured. Please contact the administrator.',
            'captcha.verify_failed' => 'Captcha verification failed',
            'captcha.verify_rejected' => 'Captcha verification did not pass',
            'commits.default_no_progress' => 'No progress today',
        ],
    ];

    return $translations;
}

function t(string $key, array $params = []): string {
    $translations = taskmTranslations();
    $language = getRequestLanguage();
    $message = $translations[$language][$key] ?? $translations[TASKM_LANG_ZH][$key] ?? $key;

    foreach ($params as $paramKey => $paramValue) {
        $message = str_replace('{' . $paramKey . '}', (string) $paramValue, $message);
    }

    return $message;
}

function localizeResponse(array $data): array {
    if (isset($data['error_key'])) {
        $data['error'] = t($data['error_key'], $data['error_params'] ?? []);
        unset($data['error_key'], $data['error_params']);
    }
    if (isset($data['message_key'])) {
        $data['message'] = t($data['message_key'], $data['message_params'] ?? []);
        unset($data['message_key'], $data['message_params']);
    }
    return $data;
}

// 将所有未捕获异常统一转为 JSON 响应
set_exception_handler(function (Throwable $e) {
    while (ob_get_level()) ob_end_clean();
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => t('common.internal_error')], JSON_UNESCAPED_UNICODE);
    exit;
});

define('DB_HOST', 'localhost');
define('DB_NAME', 'taskm');
define('DB_USER', 'root');
define('DB_PASS', '123456jx');
define('DB_CHARSET', 'utf8mb4');

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
    $data = localizeResponse($data);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function requireAuth(): array {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['user_id'])) {
        jsonResponse(['error_key' => 'common.unauthorized'], 401);
    }
    return ['id' => $_SESSION['user_id'], 'username' => $_SESSION['username']];
}

function defaultNoProgressContent(): string {
    return t('commits.default_no_progress');
}
