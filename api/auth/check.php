<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['user_id'])) {
    jsonResponse(['authenticated' => false], 401);
}

jsonResponse([
    'authenticated' => true,
    'user' => [
        'id'       => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
    ],
]);
