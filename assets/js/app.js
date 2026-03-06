// ── SHA-256 via Web Crypto API ──
async function sha256(message) {
    const msgBuffer = new TextEncoder().encode(message);
    const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
    const hashArray  = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

// ── Toast / Snackbar ──
function showToast(msg, duration = 3000) {
    let sb = document.getElementById('snackbar');
    if (!sb) {
        sb = document.createElement('div');
        sb.id = 'snackbar';
        document.body.appendChild(sb);
    }
    sb.textContent = msg;
    sb.className   = 'show';
    setTimeout(() => { sb.className = ''; }, duration);
}

// ── Fetch helpers ──
async function apiPost(url, data) {
    const res = await fetch(url, {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify(data),
    });
    return res.json();
}

async function apiGet(url) {
    const res = await fetch(url);
    return res.json();
}

// ── Format helpers ──
function formatDate(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleDateString('zh-CN', { year: 'numeric', month: '2-digit', day: '2-digit' });
}

function formatDatetime(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleString('zh-CN', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' });
}

function commitTypeLabel(type) {
    const map = { no_progress: '无进展', completed: '已完成', follow_up: '进度跟进' };
    return map[type] || type;
}

function commitTypeIcon(type) {
    const map = { no_progress: 'sentiment_neutral', completed: 'check_circle', follow_up: 'trending_up' };
    return map[type] || 'circle';
}

// ── DDL color ──
function ddlClass(ddlStr) {
    if (!ddlStr) return '';
    const diff = new Date(ddlStr) - new Date();
    if (diff < 0)                 return 'color: var(--danger);';
    if (diff < 86400000 * 3)      return 'color: var(--warning);';
    return '';
}
