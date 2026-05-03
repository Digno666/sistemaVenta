<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>@yield('title', 'BODY FIT - Tienda Oficial')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    @stack('styles')

    <style>
    /* ── TOKENS ─────────────────────────────────── */
    :root {
        --red:       #D93B3B;
        --red-dark:  #B02E2E;
        --red-pale:  #FFF0F0;
        --red-glow:  rgba(217,59,59,0.07);
        --white:     #FFFFFF;
        --bg:        #F7F5F2;
        --border:    rgba(0,0,0,0.08);
        --border-md: rgba(0,0,0,0.13);
        --text:      #1A1A1A;
        --text-2:    #4A4A4A;
        --muted:     #9A9A9A;
        --subtle:    #F2F0ED;
        --subtle-2:  #EDEAE6;
        --hh:        68px;
    }

    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }

    /* ═══ HEADER ══════════════════════════════════ */
    .cliente-header {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: var(--hh);
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-bottom: 1px solid var(--border);
        z-index: 1000;
        transition: box-shadow 0.3s;
    }
    .cliente-header.scrolled {
        box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    }

    .header-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 32px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    /* LOGO */
    .logo {
        display: flex; align-items: center; gap: 10px;
        text-decoration: none; flex-shrink: 0;
    }
    .logo-mark {
        width: 38px; height: 38px;
        background: var(--red);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        transition: transform 0.25s ease;
    }
    .logo:hover .logo-mark { transform: rotate(-6deg) scale(1.06); }
    .logo-mark i { font-size: 1.1rem; color: white; }
    .logo-wordmark { display: flex; flex-direction: column; line-height: 1; }
    .logo-name { font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem; color: var(--text); letter-spacing: 2px; }
    .logo-sub  { font-size: 0.6rem; color: var(--muted); letter-spacing: 2px; text-transform: uppercase; font-weight: 500; margin-top: 1px; }

    /* NAV */
    .nav-links { display: flex; align-items: center; gap: 4px; }
    .nav-link {
        position: relative;
        text-decoration: none;
        color: var(--text-2);
        font-weight: 500; font-size: 0.84rem;
        padding: 7px 14px; border-radius: 8px;
        transition: all 0.2s; letter-spacing: 0.2px;
    }
    .nav-link::after {
        content: ''; position: absolute;
        bottom: 4px; left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 16px; height: 2px;
        background: var(--red); border-radius: 2px;
        transition: transform 0.25s ease;
    }
    .nav-link:hover { color: var(--text); background: var(--subtle); }
    .nav-link:hover::after, .nav-link.active::after { transform: translateX(-50%) scaleX(1); }
    .nav-link.active { color: var(--red); font-weight: 600; }

    /* ACTIONS */
    .header-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

    .cart-btn {
        position: relative;
        width: 40px; height: 40px;
        background: transparent;
        border: 1px solid var(--border);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--text-2); font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .cart-btn:hover { background: var(--red-pale); border-color: rgba(217,59,59,0.2); color: var(--red); }

    .cart-badge {
        position: absolute; top: -5px; right: -5px;
        background: var(--red); color: white;
        font-size: 0.55rem; font-weight: 700;
        min-width: 17px; height: 17px;
        border-radius: 50px;
        display: flex; align-items: center; justify-content: center;
        padding: 0 4px;
        border: 2px solid var(--bg);
        font-family: 'DM Sans', sans-serif;
    }

    .header-sep { width: 1px; height: 22px; background: var(--border); margin: 0 2px; }

    /* USER DROPDOWN */
    .user-dropdown { position: relative; }
    .user-trigger {
        display: flex; align-items: center; gap: 9px;
        padding: 5px 12px 5px 5px;
        border-radius: 50px; border: 1px solid var(--border);
        background: var(--white); cursor: pointer;
        transition: all 0.2s;
    }
    .user-trigger:hover { border-color: var(--border-md); box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .user-avatar {
        width: 30px; height: 30px; border-radius: 50%;
        background: var(--red);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 0.7rem; font-weight: 700;
        letter-spacing: 0.5px; flex-shrink: 0;
    }
    .user-name  { font-size: 0.82rem; font-weight: 600; color: var(--text); max-width: 110px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-caret { font-size: 0.65rem; color: var(--muted); transition: transform 0.2s; }
    .user-dropdown.open .user-caret { transform: rotate(180deg); }

    .dropdown-panel {
        position: absolute; top: calc(100% + 10px); right: 0;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 16px; box-shadow: 0 12px 40px rgba(0,0,0,0.10);
        width: 220px; padding: 6px; z-index: 200;
        opacity: 0; pointer-events: none;
        transform: translateY(-8px);
        transition: all 0.2s cubic-bezier(0.22,1,0.36,1);
    }
    .user-dropdown.open .dropdown-panel { opacity: 1; pointer-events: all; transform: translateY(0); }

    .dd-head { padding: 12px 14px 10px; border-bottom: 1px solid var(--border); margin-bottom: 6px; }
    .dd-name  { font-weight: 600; font-size: 0.88rem; color: var(--text); margin-bottom: 2px; }
    .dd-role  { font-size: 0.7rem; color: var(--muted); }

    .dropdown-item {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 12px; border-radius: 10px;
        text-decoration: none; color: var(--text-2);
        font-size: 0.82rem; font-weight: 500;
        transition: all 0.15s; cursor: pointer;
        background: none; border: none; width: 100%;
        text-align: left; font-family: 'DM Sans', sans-serif;
    }
    .dropdown-item i { width:16px; font-size:0.78rem; color:var(--muted); text-align:center; transition:color .15s; }
    .dropdown-item:hover { background: var(--subtle); color: var(--text); }
    .dropdown-item:hover i { color: var(--red); }
    .dd-sep { height:1px; background:var(--border); margin:6px 0; }
    .dropdown-item.danger { color: var(--red); }
    .dropdown-item.danger i { color: var(--red); }
    .dropdown-item.danger:hover { background: var(--red-pale); }

    /* MOBILE BTN */
    .mobile-menu-btn {
        display: none;
        width: 38px; height: 38px;
        background: transparent; border: 1px solid var(--border); border-radius: 10px;
        align-items: center; justify-content: center;
        cursor: pointer; color: var(--text-2); font-size: 1rem;
        transition: all 0.2s;
    }
    .mobile-menu-btn:hover { background: var(--subtle); color: var(--text); }

    /* ═══ MOBILE DRAWER ═══════════════════════════ */
    .mobile-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.4);
        backdrop-filter: blur(3px);
        z-index: 1050;
        opacity: 0; pointer-events: none;
        transition: opacity 0.35s;
    }
    .mobile-overlay.show { opacity: 1; pointer-events: all; }

    .mobile-nav {
        position: fixed; top: 0; left: 0; bottom: 0;
        width: 300px;
        background: var(--white);
        z-index: 1100;
        transform: translateX(-100%);
        transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
        display: flex; flex-direction: column;
        border-right: 1px solid var(--border);
    }
    .mobile-nav.open { transform: translateX(0); }

    .mn-top {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid var(--border);
        flex-shrink: 0;
    }
    .mn-close {
        width: 32px; height: 32px;
        background: var(--subtle); border: none; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--text-2); font-size: 0.88rem;
        transition: all 0.2s;
    }
    .mn-close:hover { background: var(--red-pale); color: var(--red); }

    .mn-user {
        display: flex; align-items: center; gap: 12px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--border);
        background: var(--subtle);
    }
    .mn-avatar {
        width: 42px; height: 42px; border-radius: 50%;
        background: var(--red);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 0.82rem; font-weight: 700; flex-shrink: 0;
    }
    .mn-uname { font-weight: 600; font-size: 0.9rem; color: var(--text); }
    .mn-urole { font-size: 0.68rem; color: var(--muted); }

    .mn-links { flex: 1; padding: 14px 12px; overflow-y: auto; }

    .mn-section {
        font-size: 0.6rem; letter-spacing: 2.5px; text-transform: uppercase;
        color: var(--muted); font-weight: 600;
        padding: 0 8px; margin-bottom: 8px; margin-top: 16px;
    }
    .mn-section:first-child { margin-top: 0; }

    .mn-link {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 10px; border-radius: 10px;
        text-decoration: none; color: var(--text-2);
        font-size: 0.86rem; font-weight: 500;
        transition: all 0.15s; margin-bottom: 2px;
        background: none; border: none; width: 100%;
        text-align: left; font-family: 'DM Sans', sans-serif; cursor: pointer;
    }
    .mn-link i { width:18px; font-size:0.82rem; color:var(--muted); text-align:center; }
    .mn-link:hover { background: var(--subtle); color: var(--text); }
    .mn-link.active { background: var(--red-pale); color: var(--red); font-weight: 600; }
    .mn-link.active i { color: var(--red); }
    .mn-link.danger { color: var(--red); }
    .mn-link.danger i { color: var(--red); }
    .mn-link.danger:hover { background: var(--red-pale); }

    .mn-bottom { padding: 14px 12px 24px; border-top: 1px solid var(--border); flex-shrink: 0; }

    /* ═══ MAIN ════════════════════════════════════ */
    .main-content {
        padding-top: calc(var(--hh) + 28px);
        padding-bottom: 60px;
        padding-left: 24px;
        padding-right: 24px;
        max-width: 1300px;
        margin: 0 auto;
    }

    /* ═══ CART MODAL ══════════════════════════════ */
    .cart-modal {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.4);
        backdrop-filter: blur(4px);
        z-index: 1200; align-items: center; justify-content: center;
        padding: 20px;
    }
    .cart-modal.show { display: flex; }

    .cart-modal-content {
        background: var(--white);
        border-radius: 24px;
        width: 100%; max-width: 520px; max-height: 88vh;
        display: flex; flex-direction: column;
        overflow: hidden;
        animation: modalIn 0.25s cubic-bezier(0.22,1,0.36,1) both;
        box-shadow: 0 32px 64px -16px rgba(0,0,0,0.18);
        border: 1px solid var(--border);
    }

    @keyframes modalIn {
        from { opacity:0; transform:scale(0.94) translateY(12px); }
        to   { opacity:1; transform:scale(1) translateY(0); }
    }

    .cart-modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 22px;
        border-bottom: 1px solid var(--border);
        flex-shrink: 0;
    }
    .cart-modal-title { display: flex; align-items: center; gap: 10px; }
    .cart-modal-icon {
        width: 36px; height: 36px; background: var(--red-pale);
        border-radius: 10px; display: flex; align-items: center; justify-content: center;
    }
    .cart-modal-icon i { font-size: 0.9rem; color: var(--red); }
    .cart-modal-title h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.25rem; letter-spacing: 1px; color: var(--text);
    }
    .cart-modal-close {
        width: 32px; height: 32px; background: var(--subtle);
        border: none; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--text-2); font-size: 0.82rem;
        transition: all 0.2s;
    }
    .cart-modal-close:hover { background: var(--red-pale); color: var(--red); }

    .cart-modal-body {
        flex: 1; overflow-y: auto; padding: 18px 22px;
        scrollbar-width: thin; scrollbar-color: var(--subtle-2) transparent;
    }

    .cart-items-list { display: flex; flex-direction: column; gap: 10px; }

    .cart-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px;
        background: var(--subtle); border-radius: 14px;
        border: 1px solid transparent;
        transition: all 0.2s;
    }
    .cart-item:hover { border-color: rgba(217,59,59,0.14); background: #F8EFF0; }

    .cart-item-img {
        width: 52px; height: 52px; border-radius: 10px;
        background: var(--white); border: 1px solid var(--border);
        overflow: hidden; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; padding: 6px;
    }
    .cart-item-img img { max-width:100%; max-height:100%; object-fit:contain; }
    .cart-item-info { flex:1; min-width:0; }
    .cart-item-name { font-weight:600; font-size:0.82rem; color:var(--text); margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .cart-item-unit { font-size:0.7rem; color:var(--muted); }
    .cart-item-controls { display:flex; align-items:center; gap:6px; flex-shrink:0; }

    .qty-btn {
        width: 28px; height: 28px;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 0.9rem; font-weight: 700;
        color: var(--text-2); transition: all 0.15s;
    }
    .qty-btn:hover { background: var(--red); color: white; border-color: var(--red); }
    .qty-num { min-width: 22px; text-align: center; font-size: 0.85rem; font-weight: 600; color: var(--text); }

    .cart-item-price {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.05rem; color: var(--text); letter-spacing: 0.5px;
        min-width: 68px; text-align: right; flex-shrink: 0;
    }

    .cart-item-remove {
        width: 28px; height: 28px;
        background: none; border: none; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--muted); font-size: 0.72rem;
        transition: all 0.15s; flex-shrink: 0;
    }
    .cart-item-remove:hover { background: var(--red-pale); color: var(--red); }

    /* empty */
    .cart-empty {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 56px 20px; text-align: center; gap: 10px;
    }
    .cart-empty-icon {
        width: 60px; height: 60px; background: var(--subtle);
        border-radius: 18px; display: flex; align-items: center; justify-content: center;
        margin-bottom: 6px;
    }
    .cart-empty-icon i { font-size: 1.5rem; color: var(--muted); }
    .cart-empty h4 { font-size: 0.95rem; font-weight: 600; color: var(--text); }
    .cart-empty p  { font-size: 0.8rem; color: var(--muted); font-weight: 300; line-height: 1.5; }

    /* footer */
    .cart-modal-footer {
        padding: 16px 22px 20px;
        border-top: 1px solid var(--border);
        flex-shrink: 0;
    }

    .cart-summary {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 14px; padding-bottom: 14px;
        border-bottom: 1px dashed rgba(0,0,0,0.1);
    }
    .cart-summary-label { font-size: 0.8rem; color: var(--muted); font-weight: 500; }
    .cart-summary-value {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.65rem; color: var(--text); letter-spacing: 0.5px; line-height: 1;
    }
    .cart-currency { font-family:'DM Sans',sans-serif; font-size:0.68rem; color:var(--muted); font-weight:400; display:block; text-align:right; margin-top:2px; }

    .btn-checkout {
        width: 100%; padding: 13px;
        background: var(--red); color: white; border: none;
        border-radius: 12px;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 0.95rem; letter-spacing: 2.5px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 10px;
        transition: all 0.25s ease; position: relative; overflow: hidden;
    }
    .btn-checkout::before {
        content:''; position:absolute; inset:0;
        background:linear-gradient(135deg,rgba(255,255,255,.1) 0%,transparent 50%);
        opacity:0; transition:opacity .25s;
    }
    .btn-checkout:hover { background: var(--red-dark); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(217,59,59,0.28); }
    .btn-checkout:hover::before { opacity:1; }
    .btn-checkout:active { transform: translateY(0); }

    /* ═══ RESPONSIVE ══════════════════════════════ */
    @media (max-width: 1024px) {
        .nav-links { display: none; }
        .mobile-menu-btn { display: flex; }
        .user-name, .user-caret { display: none; }
        .user-trigger { padding: 4px; border: none; background: transparent; }
    }
    @media (max-width: 768px) {
        .header-container { padding: 0 16px; }
        .main-content { padding-left: 16px; padding-right: 16px; }
        .header-sep { display: none; }
    }
    @media (max-width: 480px) {
        .logo-sub { display: none; }
        .cart-modal { padding: 0; align-items: flex-end; }
        .cart-modal-content { border-radius: 24px 24px 0 0; max-height: 92vh; }
    }
    </style>
</head>
<body>

<!-- ══════════════════════════════
     HEADER
══════════════════════════════ -->
<header class="cliente-header" id="siteHeader">
    <div class="header-container">

        <a href="{{ route('cliente.home') }}" class="logo">
            <div class="logo-mark"><i class="fas fa-dumbbell"></i></div>
            <div class="logo-wordmark">
                <span class="logo-name">BODY FIT</span>
                <span class="logo-sub">Tienda Oficial</span>
            </div>
        </a>

        <nav class="nav-links">
            <a href="{{ route('cliente.home') }}"        class="nav-link {{ request()->routeIs('cliente.home')        ? 'active' : '' }}">Inicio</a>
            <a href="{{ route('cliente.productos') }}"   class="nav-link {{ request()->routeIs('cliente.productos')   ? 'active' : '' }}">Productos</a>
            <a href="{{ route('cliente.mis-compras') }}" class="nav-link {{ request()->routeIs('cliente.mis-compras') ? 'active' : '' }}">Mis Compras</a>
        </nav>

        <div class="header-actions">

            @if(!request()->routeIs('cliente.checkout.form') && !request()->routeIs('cliente.checkout'))
            <button class="cart-btn" id="cartBtn" title="Mi carrito">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-badge" id="cartCount">0</span>
            </button>
            @endif

            <div class="header-sep"></div>

            <div class="user-dropdown" id="userDropWrap">
                <div class="user-trigger" id="userMenuBtn">
                    <div class="user-avatar">
                        <span>{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}</span>
                    </div>
                    <span class="user-name">{{ Auth::user()->name ?? 'Usuario' }}</span>
                    <i class="fas fa-chevron-down user-caret"></i>
                </div>

                <div class="dropdown-panel" id="userDropPanel">
                    <div class="dd-head">
                        <div class="dd-name">{{ Auth::user()->name ?? 'Usuario' }}</div>
                        <div class="dd-role">Cliente</div>
                    </div>
                    <a href="{{ route('cliente.perfil') }}" class="dropdown-item"><i class="fas fa-user-circle"></i>Mi perfil</a>
                    <a href="{{ route('cliente.mis-compras') }}" class="dropdown-item"><i class="fas fa-receipt"></i>Mis compras</a>
                    <div class="dd-sep"></div>
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">@csrf</form>
                    <button type="button" class="dropdown-item danger" onclick="document.getElementById('logoutForm').submit()">
                        <i class="fas fa-sign-out-alt"></i>Cerrar sesión
                    </button>
                </div>
            </div>

            <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="fas fa-bars"></i></button>
        </div>
    </div>
</header>

<!-- ══════════════════════════════
     MOBILE DRAWER
══════════════════════════════ -->
<div class="mobile-overlay" id="mobileOverlay"></div>

<nav class="mobile-nav" id="mobileNav">
    <div class="mn-top">
        <a href="{{ route('cliente.home') }}" class="logo">
            <div class="logo-mark"><i class="fas fa-dumbbell"></i></div>
            <div class="logo-wordmark"><span class="logo-name">BODY FIT</span></div>
        </a>
        <button class="mn-close" id="closeMobileMenu"><i class="fas fa-times"></i></button>
    </div>

    <div class="mn-user">
        <div class="mn-avatar"><span>{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}</span></div>
        <div>
            <div class="mn-uname">{{ Auth::user()->name ?? 'Usuario' }}</div>
            <div class="mn-urole">Cliente</div>
        </div>
    </div>

    <div class="mn-links">
        <div class="mn-section">Navegación</div>
        <a href="{{ route('cliente.home') }}"        class="mn-link {{ request()->routeIs('cliente.home')        ? 'active' : '' }}"><i class="fas fa-home"></i>Inicio</a>
        <a href="{{ route('cliente.productos') }}"   class="mn-link {{ request()->routeIs('cliente.productos')   ? 'active' : '' }}"><i class="fas fa-box-open"></i>Productos</a>
        <a href="{{ route('cliente.mis-compras') }}" class="mn-link {{ request()->routeIs('cliente.mis-compras') ? 'active' : '' }}"><i class="fas fa-receipt"></i>Mis Compras</a>
        <div class="mn-section">Mi cuenta</div>
        <a href="{{ route('cliente.perfil') }}" class="mn-link"><i class="fas fa-user-circle"></i>Mi Perfil</a>
    </div>

    <div class="mn-bottom">
        <button class="mn-link danger" onclick="document.getElementById('logoutForm').submit()">
            <i class="fas fa-sign-out-alt"></i>Cerrar sesión
        </button>
    </div>
</nav>

<!-- ══════════════════════════════
     MAIN
══════════════════════════════ -->
<main class="main-content">@yield('content')</main>

<!-- ══════════════════════════════
     CART MODAL
══════════════════════════════ -->
<div id="cartModal" class="cart-modal">
    <div class="cart-modal-content">

        <div class="cart-modal-header">
            <div class="cart-modal-title">
                <div class="cart-modal-icon"><i class="fas fa-shopping-bag"></i></div>
                <h3>MI CARRITO</h3>
            </div>
            <button class="cart-modal-close" id="cartModalClose"><i class="fas fa-times"></i></button>
        </div>

        <div class="cart-modal-body" id="cartItemsContainer">
            <div class="cart-empty">
                <div class="cart-empty-icon"><i class="fas fa-shopping-bag"></i></div>
                <h4>Tu carrito está vacío</h4>
                <p>Agrega productos para comenzar tu compra</p>
            </div>
        </div>

        <div class="cart-modal-footer">
            <div class="cart-summary">
                <div><div class="cart-summary-label">Total a pagar</div></div>
                <div style="text-align:right;">
                    <div class="cart-summary-value" id="cartTotal">0.00</div>
                    <span class="cart-currency">Bolivianos (Bs)</span>
                </div>
            </div>
            <button class="btn-checkout" id="checkoutBtn">
                <i class="fas fa-credit-card"></i> Finalizar Compra
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* HEADER SCROLL */
const siteHeader = document.getElementById('siteHeader');
window.addEventListener('scroll', () => { siteHeader.classList.toggle('scrolled', scrollY > 10); }, { passive: true });

/* MOBILE NAV */
const mobileNav     = document.getElementById('mobileNav');
const mobileOverlay = document.getElementById('mobileOverlay');
const openMN  = () => { mobileNav.classList.add('open'); mobileOverlay.classList.add('show'); document.body.style.overflow = 'hidden'; };
const closeMN = () => { mobileNav.classList.remove('open'); mobileOverlay.classList.remove('show'); document.body.style.overflow = ''; };
document.getElementById('mobileMenuBtn')?.addEventListener('click', openMN);
document.getElementById('closeMobileMenu')?.addEventListener('click', closeMN);
mobileOverlay?.addEventListener('click', closeMN);

/* USER DROPDOWN */
const userDropWrap = document.getElementById('userDropWrap');
document.getElementById('userMenuBtn')?.addEventListener('click', e => { e.stopPropagation(); userDropWrap.classList.toggle('open'); });
document.addEventListener('click', e => { if (!userDropWrap?.contains(e.target)) userDropWrap?.classList.remove('open'); });

/* CART MODAL */
const cartModal = document.getElementById('cartModal');
document.getElementById('cartBtn')?.addEventListener('click', () => { loadCart(); cartModal.classList.add('show'); });
document.getElementById('cartModalClose')?.addEventListener('click', () => cartModal.classList.remove('show'));
cartModal?.addEventListener('click', e => { if (e.target === cartModal) cartModal.classList.remove('show'); });
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { cartModal.classList.remove('show'); userDropWrap?.classList.remove('open'); closeMN(); }
});

/* CART LOGIC */
let cart = [];

function loadCart() {
    try { const s = localStorage.getItem('bodyfit_cart'); if (s) cart = JSON.parse(s); } catch(e) { cart = []; }
    updateCartUI(); updateCartCount();
}

function saveCart() { localStorage.setItem('bodyfit_cart', JSON.stringify(cart)); updateCartCount(); }

function addToCart(product) {
    const ex = cart.find(p => p.codProducto === product.codProducto);
    if (ex) {
        if (ex.cantidad + 1 > product.stock) {
            Swal.fire({ icon:'error', title:'Sin stock', text:'No hay más unidades disponibles.', confirmButtonColor:'#D93B3B', timer:2000, showConfirmButton:false, toast:true, position:'bottom-end' });
            return false;
        }
        ex.cantidad++; ex.subtotal = ex.cantidad * ex.precio;
    } else {
        cart.push({ codProducto:product.codProducto, nombre:product.nombre, precio:product.precio, cantidad:1, stock:product.stock, imagen:product.imagen_url, subtotal:product.precio });
    }
    saveCart();
    Swal.fire({ icon:'success', title:'¡Agregado!', text:product.nombre, confirmButtonColor:'#D93B3B', timer:1400, showConfirmButton:false, toast:true, position:'bottom-end' });
}

function updateCartCount() {
    const n = cart.reduce((s,i) => s + i.cantidad, 0);
    const el = document.getElementById('cartCount');
    if (el) el.textContent = n;
}

function updateCartUI() {
    const c = document.getElementById('cartItemsContainer');
    const t = document.getElementById('cartTotal');
    if (!c) return;
    if (!cart.length) {
        c.innerHTML = `<div class="cart-empty"><div class="cart-empty-icon"><i class="fas fa-shopping-bag"></i></div><h4>Tu carrito está vacío</h4><p>Agrega productos para comenzar tu compra</p></div>`;
        if (t) t.textContent = '0.00'; return;
    }
    let total = 0;
    c.innerHTML = '<div class="cart-items-list">' + cart.map((item, i) => {
        total += item.subtotal;
        return `<div class="cart-item">
            <div class="cart-item-img"><img src="${item.imagen}" alt="${item.nombre}" onerror="this.style.display='none'"></div>
            <div class="cart-item-info">
                <div class="cart-item-name">${item.nombre}</div>
                <div class="cart-item-unit">Bs ${item.precio.toFixed(2)} c/u</div>
            </div>
            <div class="cart-item-controls">
                <button class="qty-btn" onclick="updateQty(${i},-1)">−</button>
                <span class="qty-num">${item.cantidad}</span>
                <button class="qty-btn" onclick="updateQty(${i},1)">+</button>
            </div>
            <div class="cart-item-price">Bs ${item.subtotal.toFixed(2)}</div>
            <button class="cart-item-remove" onclick="removeItem(${i})" title="Eliminar"><i class="fas fa-trash"></i></button>
        </div>`;
    }).join('') + '</div>';
    if (t) t.textContent = total.toFixed(2);
}

window.updateQty = function(i, d) {
    const it = cart[i]; const nxt = it.cantidad + d;
    if (nxt <= 0) { removeItem(i); return; }
    if (nxt > it.stock) { Swal.fire({ icon:'error', title:'Sin stock', text:'No hay más unidades.', confirmButtonColor:'#D93B3B', timer:2000, showConfirmButton:false, toast:true, position:'bottom-end' }); return; }
    it.cantidad = nxt; it.subtotal = nxt * it.precio;
    saveCart(); updateCartUI();
};

window.removeItem = function(i) { cart.splice(i, 1); saveCart(); updateCartUI(); };

document.getElementById('checkoutBtn')?.addEventListener('click', () => {
    if (!cart.length) { Swal.fire({ icon:'warning', title:'Carrito vacío', text:'Agrega productos antes de continuar.', confirmButtonColor:'#D93B3B' }); return; }
    cartModal.classList.remove('show');
    window.location.href = '{{ route("cliente.checkout.form") }}';
});

loadCart();
</script>

@stack('scripts')
</body>
</html>