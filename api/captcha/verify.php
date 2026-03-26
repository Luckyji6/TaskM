<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/captcha.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error_key' => 'common.post_only'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
$captchaVerifyParam = $body['captchaVerifyParam'] ?? '';

if (!$captchaVerifyParam) {
    jsonResponse(['error_key' => 'captcha.param_missing'], 400);
}
$result = verifyAliyunCaptcha($captchaVerifyParam);
jsonResponse($result);
