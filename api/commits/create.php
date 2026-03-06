<?php
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user = requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => '仅支持 POST 请求'], 405);
}

$body    = json_decode(file_get_contents('php://input'), true);
$taskId  = $body['task_id'] ?? '';
$type    = $body['type'] ?? '';
$content = trim($body['content'] ?? '');
$progress = isset($body['progress']) ? (int)$body['progress'] : null;

if (!$taskId || !$type) {
    jsonResponse(['error' => '参数不完整'], 400);
}

$allowedTypes = ['no_progress', 'completed', 'follow_up'];
if (!in_array($type, $allowedTypes)) {
    jsonResponse(['error' => '无效的 commit 类型'], 400);
}

$pdo  = getDB();
$stmt = $pdo->prepare('SELECT id, progress FROM tasks WHERE id = ? AND user_id = ?');
$stmt->execute([$taskId, $user['id']]);
$task = $stmt->fetch();

if (!$task) {
    jsonResponse(['error' => '任务不存在'], 404);
}

if ($type === 'no_progress') {
    $content  = $content ?: '今日无进展';
    $progress = $task['progress'];
}

if ($type === 'completed') {
    $progress = 100;
}

if ($type === 'follow_up') {
    if ($progress === null) {
        $progress = $task['progress'];
    }
    $progress = max(0, min(100, $progress));
}

$commitId = generateId('COMMIT');
$stmt = $pdo->prepare(
    'INSERT INTO commits (id, task_id, user_id, type, content, progress) VALUES (?, ?, ?, ?, ?, ?)'
);
$stmt->execute([$commitId, $taskId, $user['id'], $type, $content, $progress]);

$updateProgress = $progress;
$isCompleted    = ($type === 'completed') ? 1 : 0;

$pdo->prepare('UPDATE tasks SET progress = ?, is_completed = ?, updated_at = NOW() WHERE id = ?')
    ->execute([$updateProgress, $isCompleted, $taskId]);

$stmt = $pdo->prepare('SELECT * FROM commits WHERE id = ?');
$stmt->execute([$commitId]);
$commit = $stmt->fetch();

jsonResponse(['success' => true, 'commit' => $commit], 201);
