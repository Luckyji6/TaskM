<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user = requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => '仅支持 POST 请求'], 405);
}

$body   = json_decode(file_get_contents('php://input'), true);
$taskId = $body['id'] ?? '';

if (!$taskId) {
    jsonResponse(['error' => '缺少任务 ID'], 400);
}

$pdo  = getInitializedDB();
$stmt = $pdo->prepare('SELECT id FROM tasks WHERE id = ? AND user_id = ?');
$stmt->execute([$taskId, $user['id']]);
if (!$stmt->fetch()) {
    jsonResponse(['error' => '任务不存在'], 404);
}

$fields = [];
$values = [];

$allowed = ['title', 'description', 'category', 'ddl', 'progress', 'is_completed'];
foreach ($allowed as $field) {
    if (array_key_exists($field, $body)) {
        $val = $body[$field];
        if ($field === 'ddl') {
            $val = $val ? date('Y-m-d H:i:s', strtotime($val)) : null;
        }
        if ($field === 'progress') {
            $val = max(0, min(100, (int)$val));
        }
        if ($field === 'is_completed') {
            $val = $val ? 1 : 0;
        }
        $fields[] = "`{$field}` = ?";
        $values[]  = $val;
    }
}

if (array_key_exists('tags', $body)) {
    $tags = is_array($body['tags']) ? $body['tags'] : [];
    $tags = array_values(array_filter(array_map('trim', $tags)));
    $fields[] = '`tags` = ?';
    $values[]  = json_encode($tags, JSON_UNESCAPED_UNICODE);
}

if (empty($fields)) {
    jsonResponse(['error' => '没有可更新的字段'], 400);
}

$values[] = $taskId;
$sql      = 'UPDATE tasks SET ' . implode(', ', $fields) . ' WHERE id = ?';
$pdo->prepare($sql)->execute($values);

$stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = ?');
$stmt->execute([$taskId]);
$task = $stmt->fetch();
$task['tags'] = json_decode($task['tags'] ?? '[]', true);

jsonResponse(['success' => true, 'task' => $task]);
