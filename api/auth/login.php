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
$account = trim($body['account'] ?? '');
$hashClient = trim($body['hash_client'] ?? '');
$captchaVerifyParam = $body['captchaVerifyParam'] ?? '';

if (!$account || !$hashClient || !$captchaVerifyParam) {
    jsonResponse(['error_key' => 'common.missing_params'], 400);
}

if (strlen($hashClient) !== 64 || !ctype_xdigit($hashClient)) {
    jsonResponse(['error_key' => 'common.invalid_password_hash'], 400);
}

$captchaResult = verifyAliyunCaptcha($captchaVerifyParam);
if (!$captchaResult['success']) {
    $response = [
        'captchaVerifyResult' => $captchaResult['captchaResult'],
    ];
    if (!empty($captchaResult['error_key'])) {
        $response['error_key'] = $captchaResult['error_key'];
    } else {
        $response['error'] = $captchaResult['error'] ?? t('captcha.verify_failed');
    }
    jsonResponse($response, $captchaResult['captchaResult'] === false ? 400 : 500);
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
    jsonResponse(['error_key' => 'auth.invalid_credentials'], 401);
}

$_SESSION['user_id']  = $user['id'];
$_SESSION['username'] = $user['username'];

jsonResponse([
    'success' => true,
    'captchaVerifyResult' => true,
    'user'    => ['id' => $user['id'], 'username' => $user['username'], 'email' => $user['email']],
]);
