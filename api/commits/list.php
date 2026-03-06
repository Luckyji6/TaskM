<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user = requireAuth();

$taskId = $_GET['task_id'] ?? '';
if (!$taskId) {
    jsonResponse(['error' => '缺少任务 ID'], 400);
}

$pdo  = getDB();
$stmt = $pdo->prepare('SELECT id FROM tasks WHERE id = ? AND user_id = ?');
$stmt->execute([$taskId, $user['id']]);
if (!$stmt->fetch()) {
    jsonResponse(['error' => '任务不存在'], 404);
}

$stmt = $pdo->prepare(
    'SELECT * FROM commits WHERE task_id = ? ORDER BY created_at DESC'
);
$stmt->execute([$taskId]);
$commits = $stmt->fetchAll();

jsonResponse(['success' => true, 'commits' => $commits]);
