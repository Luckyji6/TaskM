<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['user_id'])) {
    header('Location: /TaskM/pages/dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录 — TaskM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="/TaskM/assets/css/app.css">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">TaskM</div>
        <div class="auth-sub">追踪每一步进展，完成每一个目标</div>

        <form id="loginForm" novalidate>
            <div class="input-field">
                <i class="material-icons prefix" style="color:var(--primary)">email</i>
                <input type="email" id="email" required autocomplete="email">
                <label for="email">邮箱</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix" style="color:var(--primary)">lock</i>
                <input type="password" id="password" required autocomplete="current-password">
                <label for="password">密码</label>
            </div>

            <div id="errorMsg" style="color:var(--danger);font-size:.88rem;margin-bottom:12px;display:none;"></div>

            <button type="submit" class="btn btn-primary waves-effect waves-light w100" style="width:100%;margin-top:8px;padding:12px;">
                <i class="material-icons left">login</i>登录
            </button>
        </form>

        <div style="text-align:center;margin-top:20px;font-size:.9rem;color:var(--text-muted)">
            还没有账号？
            <a href="/TaskM/pages/register.php" style="color:var(--primary);font-weight:700;">立即注册</a>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="/TaskM/assets/js/app.js"></script>
<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const errEl = document.getElementById('errorMsg');
    errEl.style.display = 'none';

    const email    = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!email || !password) {
        errEl.textContent = '请填写完整信息';
        errEl.style.display = 'block';
        return;
    }

    const btn = e.target.querySelector('button[type=submit]');
    btn.disabled = true;
    btn.innerHTML = '<i class="material-icons left">hourglass_empty</i>登录中...';

    try {
        const hashClient = await sha256(password);
        const data = await apiPost('/TaskM/api/auth/login.php', { email, hash_client: hashClient });

        if (data.success) {
            window.location.href = '/TaskM/pages/dashboard.php';
        } else {
            errEl.textContent = data.error || '登录失败';
            errEl.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = '<i class="material-icons left">login</i>登录';
        }
    } catch (err) {
        errEl.textContent = '网络错误，请重试';
        errEl.style.display = 'block';
        btn.disabled = false;
        btn.innerHTML = '<i class="material-icons left">login</i>登录';
    }
});
</script>
</body>
</html>
