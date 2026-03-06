<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: /pages/dashboard.html');
} else {
    header('Location: /pages/login.html');
}
exit;
