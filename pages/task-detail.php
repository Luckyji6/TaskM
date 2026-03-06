<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: /TaskM/pages/login.php');
    exit;
}
$taskId   = htmlspecialchars($_GET['id'] ?? '');
$username = htmlspecialchars($_SESSION['username']);
if (!$taskId) {
    header('Location: /TaskM/pages/dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>任务详情 — TaskM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="/TaskM/assets/css/app.css">
</head>
<body>

<nav class="app-nav">
    <div class="nav-wrapper container" style="max-width:800px">
        <a href="/TaskM/pages/dashboard.php" class="brand-logo">TaskM</a>
        <ul class="right hide-on-med-and-down">
            <li><a href="/TaskM/pages/dashboard.php"><i class="material-icons left">dashboard</i>主页</a></li>
            <li><a href="/TaskM/pages/myday.php"><i class="material-icons left">wb_sunny</i>我的一天</a></li>
            <li><a href="#" id="logoutBtn"><i class="material-icons left">logout</i><?= $username ?></a></li>
        </ul>
        <a href="#" data-target="mobile-nav" class="sidenav-trigger right"><i class="material-icons" style="color:#fff">menu</i></a>
    </div>
</nav>

<ul class="sidenav" id="mobile-nav">
    <li><a href="/TaskM/pages/dashboard.php"><i class="material-icons left">dashboard</i>主页</a></li>
    <li><a href="/TaskM/pages/myday.php"><i class="material-icons left">wb_sunny</i>我的一天</a></li>
    <li><a href="#" id="logoutBtnMobile"><i class="material-icons left">logout</i>退出</a></li>
</ul>

<div class="container" style="max-width:800px;padding:20px 16px 80px;" id="detailContainer">
    <div style="text-align:center;padding:60px 0;color:var(--text-muted)">
        <i class="material-icons" style="font-size:3rem">hourglass_empty</i>
        <p>加载中...</p>
    </div>
</div>

<div id="snackbar"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="/TaskM/assets/js/app.js"></script>
<script>
const TASK_ID = '<?= $taskId ?>';
let taskData  = null;

document.addEventListener('DOMContentLoaded', async () => {
    M.AutoInit();
    await loadDetail();
    document.getElementById('logoutBtn')?.addEventListener('click', logout);
    document.getElementById('logoutBtnMobile')?.addEventListener('click', logout);
});

async function loadDetail() {
    try {
        const data = await apiGet(`/TaskM/api/tasks/detail.php?id=${TASK_ID}`);
        if (!data.success) {
            document.getElementById('detailContainer').innerHTML =
                '<div style="text-align:center;padding:60px;color:var(--danger)">任务不存在或无权访问</div>';
            return;
        }
        taskData = data.task;
        renderDetail(data.task, data.commits || []);
    } catch(e) {
        document.getElementById('detailContainer').innerHTML =
            '<div style="text-align:center;padding:60px;color:var(--danger)">加载失败，请刷新重试</div>';
    }
}

function renderDetail(task, commits) {
    const tags = Array.isArray(task.tags) ? task.tags : [];
    const prog = parseInt(task.progress) || 0;
    const is100 = prog === 100;

    const tagHtml = tags.map(t => `<span class="chip tag">${escHtml(t)}</span>`).join('');
    const catHtml = task.category ? `<span class="chip">${escHtml(task.category)}</span>` : '';
    const ddlHtml = task.ddl
        ? `<span style="font-size:.85rem;${ddlClass(task.ddl)}"><i class="material-icons" style="font-size:.9rem;vertical-align:middle">event</i> DDL: ${formatDate(task.ddl)}</span>`
        : '';
    const completedBadge = task.is_completed == 1
        ? '<span class="chip completed"><i class="material-icons" style="font-size:.85rem;vertical-align:middle">check</i> 已完成</span>' : '';

    const timelineHtml = commits.length
        ? commits.map(c => renderCommit(c)).join('')
        : '<p style="color:var(--text-muted);font-size:.9rem;padding:20px 0">暂无提交记录</p>';

    document.getElementById('detailContainer').innerHTML = `
    <!-- 返回按钮 -->
    <a href="/TaskM/pages/dashboard.php" style="display:inline-flex;align-items:center;gap:4px;color:var(--text-muted);font-size:.88rem;margin-bottom:16px;text-decoration:none;">
        <i class="material-icons" style="font-size:1.1rem">arrow_back</i>返回主页
    </a>

    <!-- 任务信息头 -->
    <div class="detail-header">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;flex-wrap:wrap;">
            <h4 style="margin:0 0 10px;">${escHtml(task.title)}</h4>
            ${completedBadge}
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:10px">
            ${catHtml}${tagHtml}${ddlHtml}
        </div>
        ${task.description ? `<p style="color:var(--text-muted);font-size:.9rem;margin:0 0 12px;">${escHtml(task.description)}</p>` : ''}
        <div class="progress-wrap">
            <div class="progress-label">
                <span>整体进度</span><span>${prog}%</span>
            </div>
            <div class="progress ${is100 ? 'progress-100' : ''}">
                <div class="determinate" style="width:${prog}%"></div>
            </div>
        </div>
    </div>

    <!-- Commit 时间线 -->
    <div style="background:var(--surface);border-radius:var(--radius);box-shadow:var(--shadow);padding:24px;margin-bottom:0">
        <h6 style="font-weight:800;color:var(--text);margin:0 0 20px;display:flex;align-items:center;gap:6px;">
            <i class="material-icons" style="color:var(--primary)">history</i>历史提交记录
            <span style="font-size:.8rem;color:var(--text-muted);font-weight:400">(${commits.length} 条)</span>
        </h6>
        <ul class="timeline">
            ${timelineHtml}
        </ul>
    </div>

    <!-- 今日操作面板 -->
    ${task.is_completed != 1 ? `
    <div class="detail-actions-panel" id="actionsPanel">
        <h6 style="font-weight:800;color:var(--text);margin:0 0 14px;display:flex;align-items:center;gap:6px;">
            <i class="material-icons" style="color:var(--primary)">edit_note</i>今日记录
        </h6>
        <div class="panel-tabs">
            <button class="panel-tab active" data-panel="completed">
                <i class="material-icons" style="font-size:.95rem;vertical-align:middle">check_circle</i> 今天完成
            </button>
            <button class="panel-tab" data-panel="follow_up">
                <i class="material-icons" style="font-size:.95rem;vertical-align:middle">trending_up</i> 今天跟进
            </button>
        </div>

        <div class="panel-content active" id="panelCompleted">
            <textarea class="myday-textarea" id="completedContent" placeholder="记录你完成了什么，做到了什么..."></textarea>
            <div style="margin-top:12px;text-align:right">
                <button class="btn btn-primary waves-effect" id="submitCompleted">
                    <i class="material-icons left">send</i>提交完成
                </button>
            </div>
        </div>

        <div class="panel-content" id="panelFollowUp">
            <textarea class="myday-textarea" id="followUpContent" placeholder="记录今天对这个任务的进展、行动或思考..."></textarea>
            <div class="progress-input-row" style="margin-top:14px">
                <label>整体进度</label>
                <input type="range" id="followUpRange" min="0" max="100" value="${prog}" step="1">
                <input type="number" id="followUpNum" min="0" max="100" value="${prog}">
                <span style="font-size:.9rem;color:var(--text-muted)">%</span>
            </div>
            <div style="margin-top:12px;text-align:right">
                <button class="btn btn-primary waves-effect" id="submitFollowUp">
                    <i class="material-icons left">send</i>提交跟进
                </button>
            </div>
        </div>
    </div>` : ''}
    `;

    // Panel tab switching
    document.querySelectorAll('.panel-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.panel-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.panel-content').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById('panel' + capitalize(tab.dataset.panel))?.classList.add('active');
        });
    });

    // Sync range ↔ number
    document.getElementById('followUpRange')?.addEventListener('input', (e) => {
        document.getElementById('followUpNum').value = e.target.value;
    });
    document.getElementById('followUpNum')?.addEventListener('input', (e) => {
        let v = Math.max(0, Math.min(100, parseInt(e.target.value) || 0));
        e.target.value = v;
        document.getElementById('followUpRange').value = v;
    });

    document.getElementById('submitCompleted')?.addEventListener('click', () => {
        const content = document.getElementById('completedContent').value.trim();
        submitCommit('completed', content, 100);
    });

    document.getElementById('submitFollowUp')?.addEventListener('click', () => {
        const content  = document.getElementById('followUpContent').value.trim();
        const progress = parseInt(document.getElementById('followUpNum').value) || 0;
        submitCommit('follow_up', content, progress);
    });
}

function renderCommit(c) {
    const icon  = commitTypeIcon(c.type);
    const label = commitTypeLabel(c.type);
    return `
    <li class="timeline-item">
        <div class="timeline-dot dot-${c.type}">
            <i class="material-icons" style="font-size:1.1rem">${icon}</i>
        </div>
        <div class="timeline-body">
            <div class="tl-header">
                <span class="chip ${c.type === 'completed' ? 'completed' : ''}" style="margin:0">${label}</span>
                <span class="tl-date">${formatDatetime(c.created_at)}</span>
            </div>
            ${c.content ? `<div class="tl-content">${escHtml(c.content)}</div>` : ''}
            <div class="tl-progress">进度：${c.progress}%</div>
        </div>
    </li>`;
}

async function submitCommit(type, content, progress) {
    const btn = type === 'completed'
        ? document.getElementById('submitCompleted')
        : document.getElementById('submitFollowUp');
    if (btn) btn.disabled = true;

    try {
        const data = await apiPost('/TaskM/api/commits/create.php', {
            task_id: TASK_ID, type, content, progress
        });
        if (data.success) {
            showToast(type === 'completed' ? '已标记完成' : '跟进已提交');
            await loadDetail();
        } else {
            showToast(data.error || '提交失败');
            if (btn) btn.disabled = false;
        }
    } catch(e) {
        showToast('网络错误，请重试');
        if (btn) btn.disabled = false;
    }
}

async function logout() {
    await apiPost('/TaskM/api/auth/logout.php', {});
    window.location.href = '/TaskM/pages/login.php';
}

function capitalize(str) {
    const map = { completed: 'Completed', follow_up: 'FollowUp' };
    return map[str] || str;
}

function escHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
</body>
</html>
