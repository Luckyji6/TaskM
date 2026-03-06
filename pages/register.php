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
    <title>注册 — TaskM</title>
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
        <div class="auth-sub">创建账号，开始追踪你的目标</div>

        <form id="registerForm" novalidate>
            <div class="input-field">
                <i class="material-icons prefix" style="color:var(--primary)">person</i>
                <input type="text" id="username" required minlength="2" autocomplete="username">
                <label for="username">用户名</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix" style="color:var(--primary)">email</i>
                <input type="email" id="email" required autocomplete="email">
                <label for="email">邮箱</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix" style="color:var(--primary)">lock</i>
                <input type="password" id="password" required minlength="6" autocomplete="new-password">
                <label for="password">密码（至少6位）</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix" style="color:var(--primary)">lock_outline</i>
                <input type="password" id="passwordConfirm" required autocomplete="new-password">
                <label for="passwordConfirm">确认密码</label>
            </div>

            <div id="errorMsg" style="color:var(--danger);font-size:.88rem;margin-bottom:12px;display:none;"></div>

            <button type="submit" class="btn btn-primary waves-effect waves-light" style="width:100%;margin-top:8px;padding:12px;">
                <i class="material-icons left">person_add</i>注册
            </button>
        </form>

        <div style="text-align:center;margin-top:20px;font-size:.9rem;color:var(--text-muted)">
            已有账号？
            <a href="/TaskM/pages/login.php" style="color:var(--primary);font-weight:700;">立即登录</a>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="/TaskM/assets/js/app.js"></script>
<script>
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const errEl = document.getElementById('errorMsg');
    errEl.style.display = 'none';

    const username        = document.getElementById('username').value.trim();
    const email           = document.getElementById('email').value.trim();
    const password        = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('passwordConfirm').value;

    if (!username || !email || !password) {
        errEl.textContent = '请填写完整信息';
        errEl.style.display = 'block';
        return;
    }
    if (username.length < 2) {
        errEl.textContent = '用户名至少需要2个字符';
        errEl.style.display = 'block';
        return;
    }
    if (password.length < 6) {
        errEl.textContent = '密码至少需要6位';
        errEl.style.display = 'block';
        return;
    }
    if (password !== passwordConfirm) {
        errEl.textContent = '两次密码输入不一致';
        errEl.style.display = 'block';
        return;
    }

    const btn = e.target.querySelector('button[type=submit]');
    btn.disabled = true;
    btn.innerHTML = '<i class="material-icons left">hourglass_empty</i>注册中...';

    try {
        const hashClient = await sha256(password);
        const data = await apiPost('/TaskM/api/auth/register.php', { username, email, hash_client: hashClient });

        if (data.success) {
            window.location.href = '/TaskM/pages/dashboard.php';
        } else {
            errEl.textContent = data.error || '注册失败';
            errEl.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = '<i class="material-icons left">person_add</i>注册';
        }
    } catch (err) {
        errEl.textContent = '网络错误，请重试';
        errEl.style.display = 'block';
        btn.disabled = false;
        btn.innerHTML = '<i class="material-icons left">person_add</i>注册';
    }
});
</script>
</body>
</html>
