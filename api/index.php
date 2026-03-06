<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: /TaskM/pages/dashboard.html');
} else {
    header('Location: /TaskM/pages/login.html');
}
exit;
