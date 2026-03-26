<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/captcha.php';

if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error_key' => 'common.post_only'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
$username  = trim($body['username'] ?? '');
$email     = trim($body['email'] ?? '');
$hashClient = trim($body['hash_client'] ?? '');
$captchaVerifyParam = $body['captchaVerifyParam'] ?? '';

if (!$username || !$email || !$hashClient || !$captchaVerifyParam) {
    jsonResponse(['error_key' => 'common.missing_params'], 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['error_key' => 'auth.invalid_email'], 400);
}

if (strlen($hashClient) !== 64 || !ctype_xdigit($hashClient)) {
    jsonResponse(['error_key' => 'common.invalid_password_hash'], 400);
}

$captchaResult = verifyAliyunCaptcha($captchaVerifyParam);
if (!$captchaResult['success']) {
    jsonResponse([
        'error_key' => $captchaResult['error_key'] ?? 'captcha.verify_failed',
        'captchaVerifyResult' => $captchaResult['captchaResult'],
    ], $captchaResult['captchaResult'] === false ? 400 : 500);
}

$pdo = getInitializedDB();

$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    jsonResponse(['error_key' => 'auth.email_taken'], 409);
}

$stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
$stmt->execute([$username]);
if ($stmt->fetch()) {
    jsonResponse(['error_key' => 'auth.username_taken'], 409);
}

$passwordHash = password_hash($hashClient, PASSWORD_BCRYPT, ['cost' => 12]);
$userId = generateId('USER');

$stmt = $pdo->prepare('INSERT INTO users (id, username, email, password_hash) VALUES (?, ?, ?, ?)');
$stmt->execute([$userId, $username, $email, $passwordHash]);

$_SESSION['user_id']  = $userId;
$_SESSION['username'] = $username;

jsonResponse([
    'success' => true,
    'captchaVerifyResult' => true,
    'user'    => ['id' => $userId, 'username' => $username, 'email' => $email],
]);
