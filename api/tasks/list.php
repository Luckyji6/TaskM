<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user = requireAuth();

$sort = $_GET['sort'] ?? 'created_at';
$allowedSorts = ['created_at', 'ddl', 'category', 'progress'];
if (!in_array($sort, $allowedSorts)) {
    $sort = 'created_at';
}

$pdo = getDB();

$orderBy = match($sort) {
    'ddl'      => 'ISNULL(t.ddl), t.ddl ASC',
    'category' => 't.category ASC, t.created_at DESC',
    'progress' => 't.progress ASC',
    default    => 't.created_at DESC',
};

$sql = "
    SELECT
        t.*,
        c.content   AS last_commit_content,
        c.type      AS last_commit_type,
        c.created_at AS last_commit_at
    FROM tasks t
    LEFT JOIN commits c ON c.id = (
        SELECT id FROM commits
        WHERE task_id = t.id
        ORDER BY created_at DESC
        LIMIT 1
    )
    WHERE t.user_id = ?
    ORDER BY {$orderBy}
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$user['id']]);
$tasks = $stmt->fetchAll();

foreach ($tasks as &$task) {
    $task['tags'] = json_decode($task['tags'] ?? '[]', true);
}

jsonResponse(['success' => true, 'tasks' => $tasks]);
