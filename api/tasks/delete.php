<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user = requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => '仅支持 POST 请求'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
$taskId = trim($body['id'] ?? '');

if (!$taskId) {
    jsonResponse(['error' => '任务 ID 不能为空'], 400);
}

$pdo = getInitializedDB();

$stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = ? AND user_id = ?');
$stmt->execute([$taskId, $user['id']]);
$task = $stmt->fetch();

if (!$task) {
    jsonResponse(['error' => '任务不存在或无权删除'], 404);
}

$stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
$stmt->execute([$taskId, $user['id']]);

jsonResponse(['success' => true, 'message' => '任务已删除']);