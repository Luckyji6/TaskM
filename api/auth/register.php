<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => '仅支持 POST 请求'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
$username  = trim($body['username'] ?? '');
$email     = trim($body['email'] ?? '');
$hashClient = trim($body['hash_client'] ?? '');

if (!$username || !$email || !$hashClient) {
    jsonResponse(['error' => '参数不完整'], 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['error' => '邮箱格式不正确'], 400);
}

if (strlen($hashClient) !== 64 || !ctype_xdigit($hashClient)) {
    jsonResponse(['error' => '密码格式不正确'], 400);
}

$pdo = getDB();

$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    jsonResponse(['error' => '该邮箱已被注册'], 409);
}

$passwordHash = password_hash($hashClient, PASSWORD_BCRYPT, ['cost' => 12]);
$userId = generateId('USER');

$stmt = $pdo->prepare('INSERT INTO users (id, username, email, password_hash) VALUES (?, ?, ?, ?)');
$stmt->execute([$userId, $username, $email, $passwordHash]);

$_SESSION['user_id']  = $userId;
$_SESSION['username'] = $username;

jsonResponse([
    'success' => true,
    'user'    => ['id' => $userId, 'username' => $username, 'email' => $email],
]);
