<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/captcha.php';

if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => '仅支持 POST 请求'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
$account = trim($body['account'] ?? '');
$hashClient = trim($body['hash_client'] ?? '');
$captchaVerifyParam = $body['captchaVerifyParam'] ?? '';

if (!$account || !$hashClient || !$captchaVerifyParam) {
    jsonResponse(['error' => '参数不完整'], 400);
}

if (strlen($hashClient) !== 64 || !ctype_xdigit($hashClient)) {
    jsonResponse(['error' => '密码格式不正确'], 400);
}

$captchaResult = verifyAliyunCaptcha($captchaVerifyParam);
if (!$captchaResult['success']) {
    jsonResponse([
        'error' => $captchaResult['error'],
        'captchaVerifyResult' => $captchaResult['captchaResult'],
    ], $captchaResult['captchaResult'] === false ? 400 : 500);
}

$pdo = getInitializedDB();

$stmt = $pdo->prepare('SELECT id, username, email, password_hash FROM users WHERE username = ?');
$stmt->execute([$account]);
$user = $stmt->fetch();

if (!$user) {
    $stmt = $pdo->prepare('SELECT id, username, email, password_hash FROM users WHERE email = ?');
    $stmt->execute([$account]);
    $user = $stmt->fetch();
}

if (!$user || !password_verify($hashClient, $user['password_hash'])) {
    jsonResponse(['error' => '用户名/邮箱或密码不正确'], 401);
}

$_SESSION['user_id']  = $user['id'];
$_SESSION['username'] = $user['username'];

jsonResponse([
    'success' => true,
    'captchaVerifyResult' => true,
    'user'    => ['id' => $user['id'], 'username' => $user['username'], 'email' => $user['email']],
]);
