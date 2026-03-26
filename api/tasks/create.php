<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user = requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error_key' => 'common.post_only'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
$title       = trim($body['title'] ?? '');
$description = trim($body['description'] ?? '');
$category    = trim($body['category'] ?? '') ?: null;
$tags        = $body['tags'] ?? [];
$ddl         = $body['ddl'] ?? null;

if (!$title) {
    jsonResponse(['error_key' => 'common.task_title_required'], 400);
}

if ($ddl && !strtotime($ddl)) {
    jsonResponse(['error_key' => 'common.invalid_ddl'], 400);
}

if (!is_array($tags)) {
    $tags = [];
}
$tags = array_values(array_filter(array_map('trim', $tags)));

$pdo    = getInitializedDB();
$taskId = generateId('TASK');

$stmt = $pdo->prepare(
    'INSERT INTO tasks (id, user_id, title, description, category, tags, ddl) VALUES (?, ?, ?, ?, ?, ?, ?)'
);
$stmt->execute([
    $taskId,
    $user['id'],
    $title,
    $description ?: null,
    $category,
    json_encode($tags, JSON_UNESCAPED_UNICODE),
    $ddl ? date('Y-m-d H:i:s', strtotime($ddl)) : null,
]);

$stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = ?');
$stmt->execute([$taskId]);
$task = $stmt->fetch();
$task['tags'] = json_decode($task['tags'] ?? '[]', true);

jsonResponse(['success' => true, 'task' => $task], 201);
