<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user = requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error_key' => 'common.post_only'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
$taskId = trim($body['id'] ?? '');

if (!$taskId) {
    jsonResponse(['error_key' => 'common.task_id_required'], 400);
}

$pdo = getInitializedDB();

$stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = ? AND user_id = ?');
$stmt->execute([$taskId, $user['id']]);
$task = $stmt->fetch();

if (!$task) {
    jsonResponse(['error_key' => 'common.task_delete_forbidden'], 404);
}

$stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
$stmt->execute([$taskId, $user['id']]);

jsonResponse(['success' => true, 'message_key' => 'common.deleted']);