<?php
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => '仅支持 POST 请求'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
$email      = trim($body['email'] ?? '');
$hashClient = trim($body['hash_client'] ?? '');

if (!$email || !$hashClient) {
    jsonResponse(['error' => '参数不完整'], 400);
}

if (strlen($hashClient) !== 64 || !ctype_xdigit($hashClient)) {
    jsonResponse(['error' => '密码格式不正确'], 400);
}

$pdo = getDB();

$stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($hashClient, $user['password_hash'])) {
    jsonResponse(['error' => '邮箱或密码不正确'], 401);
}

$_SESSION['user_id']  = $user['id'];
$_SESSION['username'] = $user['username'];

jsonResponse([
    'success' => true,
    'user'    => ['id' => $user['id'], 'username' => $user['username'], 'email' => $email],
]);
