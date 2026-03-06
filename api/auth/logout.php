<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$_SESSION = [];
session_destroy();

header('Content-Type: application/json; charset=utf-8');
jsonResponse(['success' => true]);
