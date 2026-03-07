<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Monkey Hi Hat</title>
<link rel="icon" type="image/png" href="/icons/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/icons/favicon.svg" />
<link rel="shortcut icon" href="/icons/favicon.ico" />
<style>
/* ─── Theme variables ─── */
:root {
    /* Dark mode — default */
    --sidebar-w:280px;
    --header-h:64px;
    --content-w:860px;
    --sidebar-bg:#142950;
    --sidebar-border:#2a4d7e;
    --content-bg:#1b3358;
    --text:#cde1f7;
    --text-muted:#7da8d0;
    --link:#79b4f7;
    --border:#2a4d7e;
    --code-bg:#0e2240;
    --code-text:#b8d8f7;
    --table-head-bg:#0e2240;
    --table-alt-bg:#142950;
    --blockquote-border:#2a4d7e;
    --blockquote-text:#7da8d0;
    --sidebar-link:#7da8d0;
    --sidebar-link-hover-bg:#1f3d65;
    --sidebar-link-active:#79b4f7;
    --strip-border:#2a4d7e;
    --home-link-color:#7da8d0;
    --toggle-color:#7da8d0;
    --resizer-color:125,168,208;
}
body.light {
    --sidebar-bg:#f6f8fa;
    --sidebar-border:#d0d7de;
    --content-bg:#ffffff;
    --text:#1f2328;
    --text-muted:#57606a;
    --link:#0969da;
    --border:#d0d7de;
    --code-bg:#f6f8fa;
    --code-text:#1f2328;
    --table-head-bg:#f6f8fa;
    --table-alt-bg:#f6f8fa;
    --blockquote-border:#d0d7de;
    --blockquote-text:#636c76;
    --sidebar-link:#57606a;
    --sidebar-link-hover-bg:#eaf0fb;
    --sidebar-link-active:#0969da;
    --strip-border:#d0d7de;
    --home-link-color:#4a7ab5;
    --toggle-color:#57606a;
    --resizer-color:80,120,170;
}

/* ─── Reset ─── */
*,*::before,*::after{box-sizing:border-box}
html,body{
    margin:0;padding:0;
    height:100%;
    overflow:hidden;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI","Noto Sans",Helvetica,Arial,sans-serif;
    background:var(--content-bg);
    color:var(--text);
    font-size:16px;
}

/* ─── Site header strip ─── */
.site-header{
    position:fixed;
    top:0;left:0;right:0;
    z-index:200;
    height:var(--header-h);
    background:#1b3358;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:12px 1.5rem;
}
.site-header .title{
    margin:0;
    font-size:clamp(1rem,2.8vw,2.4rem);
    font-weight:900;
    color:#fff;
    text-shadow:0 0 30px rgba(255,255,255,0.7);
    -webkit-text-stroke:2px rgba(0,0,0,0.85);
    paint-order:stroke fill;
    line-height:1;
}

/* ─── Docsify sidebar ─── */
.sidebar{
    position:fixed;
    top:var(--header-h);left:0;bottom:0;
    width:var(--sidebar-w);
    overflow-y:auto;
    background:var(--sidebar-bg);
    border-right:1px solid var(--sidebar-border);
    z-index:10;
    padding-bottom:2rem;
}
.sidebar > h1{display:none}
.sidebar-nav{padding:0.25rem 0}
.sidebar-nav ul{list-style:none;margin:0;padding:0}
.sidebar-nav ul li a{
    display:block;
    padding:0.3rem 1.2rem;
    color:var(--sidebar-link);
    text-decoration:none;
    font-size:0.875rem;
    line-height:1.5;
    transition:background .12s,color .12s;
}
.sidebar-nav ul li a:hover{color:var(--sidebar-link-active);background:var(--sidebar-link-hover-bg)}
.sidebar-nav ul li.active > a{color:var(--sidebar-link-active);font-weight:600}
.sidebar-nav ul ul{padding-left:0}
.sidebar-nav ul ul li a{
    padding-left:2.2rem;
    font-style:italic;
    font-size:0.83rem;
}
.sidebar-toggle{display:none}
.app-nav{display:none}

/* ─── Sidebar resizer ─── */
.sidebar-resizer{
    position:fixed;
    top:var(--header-h);
    bottom:0;
    left:var(--sidebar-w);
    width:5px;
    cursor:col-resize;
    z-index:50;
    background:transparent;
    transition:background .15s;
}
.sidebar-resizer:hover,
.sidebar-resizer.dragging{background:var(--sidebar-border)}

/* ─── Content width resizer ─── */
.content-resizer{
    position:fixed;
    top:var(--header-h);
    bottom:0;
    left:calc(var(--sidebar-w) + var(--content-w));
    width:5px;
    cursor:col-resize;
    z-index:50;
    background:transparent;
    transition:background .15s;
}
.content-resizer{background:rgba(var(--resizer-color),0.12)}
body.light .content-resizer{background:rgba(var(--resizer-color),0.28)}
.content-resizer:hover,
.content-resizer.dragging{background:rgba(var(--resizer-color),0.35)}
body.light .content-resizer:hover,
body.light .content-resizer.dragging{background:rgba(var(--resizer-color),0.55)}

/* ─── Sidebar top strip (home link + theme toggle) ─── */
.sidebar-strip{
    display:flex;
    align-items:center;
    justify-content:space-between;
    border-bottom:1px solid var(--strip-border);
    margin-bottom:0.25rem;
}
.sidebar-home-link{
    display:flex;
    align-items:center;
    gap:0.4rem;
    padding:0.5rem 0.6rem 0.5rem 1.2rem;
    color:var(--home-link-color);
    text-decoration:none;
    font-size:0.85rem;
    font-weight:600;
    flex:1;
    transition:color .2s;
}
.sidebar-home-link:hover{color:var(--link)}
.theme-toggle{
    background:none;
    border:none;
    cursor:pointer;
    padding:0.5rem 1rem 0.5rem 0.4rem;
    color:var(--toggle-color);
    display:flex;
    align-items:center;
    opacity:0.75;
    transition:opacity .2s, color .2s;
    flex-shrink:0;
}
.theme-toggle:hover{opacity:1;color:var(--link)}

/* ─── Docsify content pane ─── */
.content{
    position:fixed;
    top:var(--header-h);
    left:var(--sidebar-w);
    right:0;bottom:0;
    overflow-y:auto;
    background:var(--content-bg);
    padding:0;
}

/* ─── GitHub-style markdown ─── */
.markdown-section{
    max-width:var(--content-w);
    padding:2rem 2.5rem;
    color:var(--text);
    font-size:16px;
    line-height:1.5;
}
.markdown-section h1,
.markdown-section h2{
    border-bottom:1px solid var(--border);
    padding-bottom:0.3em;
    margin-top:1.5em;
    color:var(--text);
}
.markdown-section h1:first-child,
.markdown-section h2:first-child{margin-top:0}
.markdown-section h1{font-size:2em}
.markdown-section h2{font-size:1.5em}
.markdown-section h3{font-size:1.25em;color:var(--text)}
.markdown-section h4{font-size:1em;color:var(--text)}
.markdown-section p{margin:0 0 16px;color:var(--text)}
.markdown-section a{color:var(--link)}
.markdown-section a:hover{text-decoration:underline}
.markdown-section h1 a,
.markdown-section h2 a,
.markdown-section h3 a,
.markdown-section h4 a{color:inherit;text-decoration:none}
.markdown-section h1 a:hover,
.markdown-section h2 a:hover,
.markdown-section h3 a:hover,
.markdown-section h4 a:hover{text-decoration:none}
.markdown-section ul,.markdown-section ol{padding-left:2em;margin-bottom:16px;color:var(--text)}
.markdown-section li{margin:4px 0}
.markdown-section code{
    background:var(--code-bg);
    border:1px solid var(--border);
    border-radius:6px;
    padding:0.2em 0.4em;
    font-family:ui-monospace,SFMono-Regular,"SF Mono",Menlo,Consolas,"Liberation Mono",monospace;
    font-size:85%;
    color:var(--code-text);
}
.markdown-section pre{
    background:var(--code-bg);
    border:1px solid var(--border);
    border-radius:6px;
    padding:16px;
    overflow:auto;
    margin-bottom:16px;
}
.markdown-section pre code{background:none;border:none;padding:0;font-size:85%;color:var(--code-text)}
.markdown-section blockquote{
    border-left:4px solid var(--blockquote-border);
    padding:0 1em;
    margin:0 0 16px;
    color:var(--blockquote-text);
}
.markdown-section blockquote p{color:var(--blockquote-text)}
.markdown-section table{border-collapse:collapse;width:100%;margin-bottom:16px}
.markdown-section table th,
.markdown-section table td{border:1px solid var(--border);padding:6px 13px;color:var(--text)}
.markdown-section table th{background:var(--table-head-bg);font-weight:600}
.markdown-section table tr:nth-child(2n) td{background:var(--table-alt-bg)}
.markdown-section img{max-width:100%;border-radius:6px}
.markdown-section hr{border:none;border-top:1px solid var(--border);margin:24px 0}

/* ─── Mobile TOC button (hidden on desktop) ─── */
.mobile-toc-btn{
    display:none;
    position:absolute;
    right:1rem;
    top:50%;
    transform:translateY(-50%);
    background:none;
    border:1px solid rgba(255,255,255,0.35);
    border-radius:6px;
    color:#fff;
    cursor:pointer;
    padding:5px 10px;
    font-size:0.8rem;
    font-weight:600;
    align-items:center;
    gap:5px;
    white-space:nowrap;
    transition:background .15s,border-color .15s;
}
.mobile-toc-btn:hover{background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.6)}
body.light .mobile-toc-btn{border-color:rgba(0,0,0,0.25);color:#1f2328}
body.light .mobile-toc-btn:hover{background:rgba(0,0,0,0.07)}

/* ─── Mobile sidebar backdrop ─── */
.mobile-backdrop{
    display:none;
    position:fixed;
    top:var(--header-h);
    left:0;right:0;bottom:0;
    background:rgba(0,0,0,0.45);
    z-index:90;
}
.mobile-backdrop.active{display:block}

/* ─── Responsive: narrow / portrait phone ─── */
@media (max-width:768px){
    .mobile-toc-btn{display:flex}
    .sidebar-resizer,.content-resizer{display:none !important}

    .sidebar{
        width:100% !important;
        max-height:65vh;
        border-right:none;
        border-bottom:1px solid var(--sidebar-border);
        z-index:100;
        /* start off-screen above the header area, revealed by toggling display */
        display:none;
        overflow-y:auto;
        padding-bottom:1rem;
    }
    .sidebar.mobile-open{display:block}

    .content{
        left:0 !important;
    }

    .markdown-section{
        max-width:100% !important;
        padding:1.25rem 1rem;
    }
}
</style>
</head>
<body>

<header class="site-header">
    <p class="title">Monkey Hi Hat Docs</p>
    <button class="mobile-toc-btn" id="mobileTocBtn" aria-expanded="false" aria-label="Toggle table of contents">
        ☰ Contents
    </button>
</header>

<div id="app"></div>

<script>
var homeSVG = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>';
var sunSVG  = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';
var moonSVG = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';

// Apply saved theme and sidebar width before render to avoid flash
(function() {
    if (localStorage.getItem('docs-theme') === 'light') {
        document.body.classList.add('light');
    }
    var savedW = localStorage.getItem('docs-sidebar-w');
    if (savedW) {
        document.documentElement.style.setProperty('--sidebar-w', savedW);
    }
    var savedCW = localStorage.getItem('docs-content-w');
    if (savedCW) {
        document.documentElement.style.setProperty('--content-w', savedCW);
    }
})();

function updateToggleIcon() {
    var btn = document.querySelector('.theme-toggle');
    if (!btn) return;
    var isDark = !document.body.classList.contains('light');
    // In dark mode show sun (click → light); in light mode show moon (click → dark)
    btn.innerHTML = isDark ? sunSVG : moonSVG;
    btn.title = isDark ? 'Switch to light mode' : 'Switch to dark mode';
}

function toggleTheme() {
    var isNowLight = document.body.classList.toggle('light');
    localStorage.setItem('docs-theme', isNowLight ? 'light' : 'dark');
    updateToggleIcon();
}

// ─── Mobile sidebar toggle ───
(function() {
    var backdrop = document.createElement('div');
    backdrop.className = 'mobile-backdrop';
    document.body.appendChild(backdrop);

    function isMobile() { return window.innerWidth <= 768; }

    function getSidebar() { return document.querySelector('.sidebar'); }

    function closeMobileSidebar() {
        var s = getSidebar();
        if (s) s.classList.remove('mobile-open');
        backdrop.classList.remove('active');
        var btn = document.getElementById('mobileTocBtn');
        if (btn) btn.setAttribute('aria-expanded', 'false');
    }

    function openMobileSidebar() {
        var s = getSidebar();
        if (s) s.classList.add('mobile-open');
        backdrop.classList.add('active');
        var btn = document.getElementById('mobileTocBtn');
        if (btn) btn.setAttribute('aria-expanded', 'true');
    }

    document.getElementById('mobileTocBtn').addEventListener('click', function() {
        var s = getSidebar();
        if (s && s.classList.contains('mobile-open')) {
            closeMobileSidebar();
        } else {
            openMobileSidebar();
        }
    });

    backdrop.addEventListener('click', closeMobileSidebar);

    // Close sidebar when a nav link is tapped on mobile
    document.addEventListener('click', function(e) {
        if (!isMobile()) return;
        if (e.target.closest('.sidebar-nav a')) {
            setTimeout(closeMobileSidebar, 80);
        }
    });

    // Close sidebar if resized to desktop width
    window.addEventListener('resize', function() {
        if (!isMobile()) closeMobileSidebar();
    });
})();

window.$docsify = {
    el: '#app',
    basePath: '/docs/',
    loadSidebar: true,
    subMaxLevel: 2,
    homepage: 'introduction.md',
    plugins: [
        function(hook) {
            hook.mounted(function() {
                var nav = document.querySelector('.sidebar-nav');
                if (!nav) return;

                var strip = document.createElement('div');
                strip.className = 'sidebar-strip';

                var homeLink = document.createElement('a');
                homeLink.href = 'https://www.monkeyhihat.com/index.php';
                homeLink.className = 'sidebar-home-link';
                homeLink.innerHTML = homeSVG + ' Home';

                var toggle = document.createElement('button');
                toggle.className = 'theme-toggle';
                toggle.onclick = toggleTheme;

                strip.appendChild(homeLink);
                strip.appendChild(toggle);
                nav.parentNode.insertBefore(strip, nav);

                updateToggleIcon();

                // Inject resizer and wire up drag-to-resize
                var resizer = document.createElement('div');
                resizer.className = 'sidebar-resizer';
                document.body.appendChild(resizer);

                var isResizing = false;
                var startX, startW;

                resizer.addEventListener('mousedown', function(e) {
                    isResizing = true;
                    startX = e.clientX;
                    startW = parseInt(getComputedStyle(document.documentElement)
                        .getPropertyValue('--sidebar-w'), 10);
                    resizer.classList.add('dragging');
                    document.body.style.userSelect = 'none';
                    document.body.style.cursor = 'col-resize';
                    e.preventDefault();
                });

                document.addEventListener('mousemove', function(e) {
                    if (!isResizing) return;
                    var newW = Math.max(180, Math.min(520, startW + (e.clientX - startX)));
                    document.documentElement.style.setProperty('--sidebar-w', newW + 'px');
                });

                document.addEventListener('mouseup', function() {
                    if (!isResizing) return;
                    isResizing = false;
                    resizer.classList.remove('dragging');
                    document.body.style.userSelect = '';
                    document.body.style.cursor = '';
                    var finalW = getComputedStyle(document.documentElement)
                        .getPropertyValue('--sidebar-w').trim();
                    localStorage.setItem('docs-sidebar-w', finalW);
                });

                // Content width resizer
                var cResizer = document.createElement('div');
                cResizer.className = 'content-resizer';
                document.body.appendChild(cResizer);

                var isCResizing = false;
                var cStartX, cStartW;

                cResizer.addEventListener('mousedown', function(e) {
                    isCResizing = true;
                    cStartX = e.clientX;
                    cStartW = parseInt(getComputedStyle(document.documentElement)
                        .getPropertyValue('--content-w'), 10);
                    cResizer.classList.add('dragging');
                    document.body.style.userSelect = 'none';
                    document.body.style.cursor = 'col-resize';
                    e.preventDefault();
                });

                document.addEventListener('mousemove', function(e) {
                    if (!isCResizing) return;
                    var newW = Math.max(400, Math.min(1600, cStartW + (e.clientX - cStartX)));
                    document.documentElement.style.setProperty('--content-w', newW + 'px');
                });

                document.addEventListener('mouseup', function() {
                    if (!isCResizing) return;
                    isCResizing = false;
                    cResizer.classList.remove('dragging');
                    document.body.style.userSelect = '';
                    document.body.style.cursor = '';
                    var finalCW = getComputedStyle(document.documentElement)
                        .getPropertyValue('--content-w').trim();
                    localStorage.setItem('docs-content-w', finalCW);
                });
            });
        }
    ]
}
</script>
<script src="https://cdn.jsdelivr.net/npm/docsify@4/lib/docsify.min.js"></script>

</body>
</html>
