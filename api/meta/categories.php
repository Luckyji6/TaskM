<?php
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user = requireAuth();

$pdo = getDB();

$stmt = $pdo->prepare(
    "SELECT DISTINCT category FROM tasks WHERE user_id = ? AND category IS NOT NULL AND category != '' ORDER BY category ASC"
);
$stmt->execute([$user['id']]);
$categories = array_column($stmt->fetchAll(), 'category');

$stmt = $pdo->prepare(
    "SELECT tags FROM tasks WHERE user_id = ? AND tags IS NOT NULL AND tags != 'null' AND tags != '[]'"
);
$stmt->execute([$user['id']]);
$rows = $stmt->fetchAll();

$tags = [];
foreach ($rows as $row) {
    $decoded = json_decode($row['tags'], true);
    if (is_array($decoded)) {
        foreach ($decoded as $tag) {
            $tag = trim($tag);
            if ($tag && !in_array($tag, $tags)) {
                $tags[] = $tag;
            }
        }
    }
}
sort($tags);

jsonResponse(['success' => true, 'categories' => $categories, 'tags' => $tags]);
