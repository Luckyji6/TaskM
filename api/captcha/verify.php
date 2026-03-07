<?php
ob_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/captcha.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => '仅支持 POST 请求'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
$captchaVerifyParam = $body['captchaVerifyParam'] ?? '';

if (!$captchaVerifyParam) {
    jsonResponse(['error' => '验证码参数缺失'], 400);
}
$result = verifyAliyunCaptcha($captchaVerifyParam);
jsonResponse($result);
