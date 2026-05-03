@extends('layouts.app')

@section('title', 'Iniciar Sesión - BODY FIT')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

:root {
    --red:        #D93B3B;
    --red-dark:   #B02E2E;
    --red-pale:   #FFF0F0;
    --white:      #FFFFFF;
    --bg:         #F7F5F2;
    --border:     rgba(0,0,0,0.09);
    --border-hot: rgba(217,59,59,0.45);
    --text:       #1A1A1A;
    --muted:      #9A9A9A;
    --subtle:     #F2F0ED;
}

html, body {
    height: 100%;
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    overflow: hidden;
}

.page {
    display: grid;
    grid-template-columns: 1fr 1fr;
    height: 100vh;
    overflow: hidden;
}

/* ── LEFT PANEL (imagen, igual que antes) ── */
.brand-panel {
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 48px;
}

.brand-panel::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(to top, rgba(0,0,0,0.90) 0%, rgba(0,0,0,0.38) 55%, rgba(0,0,0,0.12) 100%),
        url('https://images.pexels.com/photos/1552242/pexels-photo-1552242.jpeg?auto=compress&cs=tinysrgb&w=1600')
        center/cover no-repeat;
    z-index: 0;
}

.brand-panel::after {
    content: '';
    position: absolute;
    inset: -50%;
    width: 200%; height: 200%;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
    opacity: 0.22;
    animation: grain 8s steps(10) infinite;
    z-index: 1;
    pointer-events: none;
}

@keyframes grain {
    0%,100%{transform:translate(0,0)} 10%{transform:translate(-2%,-3%)} 20%{transform:translate(3%,2%)}
    30%{transform:translate(-1%,4%)} 40%{transform:translate(4%,-1%)} 50%{transform:translate(-3%,3%)}
    60%{transform:translate(2%,-4%)} 70%{transform:translate(-4%,1%)} 80%{transform:translate(1%,3%)}
    90%{transform:translate(3%,-2%)}
}

.brand-content {
    position: relative;
    z-index: 2;
    animation: fadeUp 0.9s cubic-bezier(0.22,1,0.36,1) both;
}

@keyframes fadeUp {
    from { opacity:0; transform:translateY(28px); }
    to   { opacity:1; transform:translateY(0); }
}

.logo-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--red);
    color: white;
    padding: 6px 14px 6px 10px;
    border-radius: 50px;
    margin-bottom: 28px;
    width: fit-content;
}
.logo-badge .dot {
    width: 8px; height: 8px;
    background: white; border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.45;transform:scale(.85)} }
.logo-badge span { font-family:'Bebas Neue',sans-serif; font-size:.85rem; letter-spacing:2px; }

.accent-line { width:40px; height:3px; background:var(--red); border-radius:2px; margin-bottom:24px; }

.brand-headline {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(3.5rem,5vw,5.5rem);
    line-height: 0.92;
    color: #F0EDE8;
    margin-bottom: 20px;
}
.brand-headline em {
    font-family: 'DM Serif Display', serif;
    font-style: italic;
    color: var(--red);
    display: block;
}

.brand-desc {
    font-size: 0.85rem;
    color: rgba(240,237,232,0.5);
    max-width: 320px;
    line-height: 1.7;
    font-weight: 300;
    margin-bottom: 36px;
}

.brand-stats { display:flex; gap:32px; }
.stat-number { font-family:'Bebas Neue',sans-serif; font-size:1.8rem; color:#F0EDE8; letter-spacing:1px; }
.stat-label { font-size:.7rem; color:rgba(240,237,232,.4); letter-spacing:1px; text-transform:uppercase; font-weight:500; }

/* ── RIGHT PANEL (BLANCO) ──────────── */
.form-panel {
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px;
    position: relative;
    overflow: hidden;
}

/* orb decorativo suave */
.form-panel::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(217,59,59,0.05) 0%, transparent 70%);
    pointer-events: none;
}

.form-inner {
    width: 100%;
    max-width: 380px;
    position: relative;
    z-index: 1;
    animation: fadeUp 0.9s 0.15s cubic-bezier(0.22,1,0.36,1) both;
}

.form-header { margin-bottom: 36px; }
.form-header .eyebrow {
    font-size: .7rem; letter-spacing: 3px; text-transform: uppercase;
    color: var(--red); font-weight: 600; margin-bottom: 10px;
}
.form-header h2 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2.6rem; letter-spacing: 1px;
    color: var(--text); line-height: 1; margin-bottom: 8px; text-align: left;
}
.form-header p { font-size: .82rem; color: var(--muted); font-weight: 300; }

/* ── INPUTS ──────────────────────────── */
.field { margin-bottom: 18px; }
.field label {
    display: block; font-size: .72rem; letter-spacing: 1.5px;
    text-transform: uppercase; color: rgba(26,26,26,.4);
    margin-bottom: 8px; font-weight: 500;
}
.input-wrap { position: relative; }
.input-wrap .icon {
    position: absolute; left: 16px; top: 50%;
    transform: translateY(-50%);
    color: var(--muted); font-size: .85rem;
    pointer-events: none; transition: color .25s;
}
.input-wrap input {
    width: 100%;
    padding: 13px 16px 13px 44px;
    background: var(--subtle);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: .88rem; color: var(--text);
    transition: all .25s ease;
    -webkit-appearance: none; appearance: none;
    caret-color: var(--red);
}
.input-wrap input::placeholder { color: #C8C5C0; }
.input-wrap input:hover { border-color: rgba(0,0,0,.14); background: #EDEBE8; }
.input-wrap input:focus {
    outline: none;
    border-color: var(--border-hot);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(217,59,59,0.07);
}
.input-wrap:focus-within .icon { color: var(--red); }

.eye-toggle {
    position: absolute; right: 14px; top: 50%;
    transform: translateY(-50%);
    cursor: pointer; color: var(--muted); font-size: .9rem;
    transition: color .2s; background: none; border: none; padding: 4px; z-index: 2;
}
.eye-toggle:hover { color: var(--red); }
.pass-input { padding-right: 44px; }

/* ── REMEMBER ────────────────────────── */
.footer-row { display:flex; align-items:center; margin-bottom:24px; }
.remember { display:flex; align-items:center; gap:8px; cursor:pointer; }
.remember input[type="checkbox"] {
    appearance: none; -webkit-appearance: none;
    width: 17px; height: 17px;
    border: 1.5px solid var(--border); border-radius: 5px;
    background: var(--subtle); cursor: pointer;
    position: relative; transition: all .2s; flex-shrink: 0;
}
.remember input[type="checkbox"]:checked { background: var(--red); border-color: var(--red); }
.remember input[type="checkbox"]:checked::after {
    content:''; position:absolute; left:4px; top:1.5px;
    width:5px; height:9px; border:2px solid white;
    border-top:none; border-left:none; transform:rotate(45deg);
}
.remember span { font-size:.78rem; color:var(--muted); user-select:none; }

/* ── SUBMIT ──────────────────────────── */
.btn-submit {
    width: 100%; padding: 14px;
    background: var(--red); color: white; border: none;
    border-radius: 12px;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1rem; letter-spacing: 3px;
    cursor: pointer; overflow: hidden;
    transition: all .25s ease; margin-bottom: 20px;
    position: relative;
}
.btn-submit::before {
    content:''; position:absolute; inset:0;
    background:linear-gradient(135deg,rgba(255,255,255,.12) 0%,transparent 50%);
    opacity:0; transition:opacity .25s;
}
.btn-submit:hover {
    background: var(--red-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(217,59,59,0.25);
}
.btn-submit:hover::before { opacity:1; }
.btn-submit:active { transform:translateY(0); }

/* ── DIVIDER ─────────────────────────── */
.divider { display:flex; align-items:center; gap:12px; margin-bottom:20px; }
.divider::before, .divider::after { content:''; flex:1; height:1px; background:var(--border); }
.divider span { font-size:.7rem; letter-spacing:2px; color:var(--muted); text-transform:uppercase; }

/* ── GOOGLE ──────────────────────────── */
.btn-google {
    width: 100%;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    padding: 12px;
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    color: rgba(26,26,26,.65);
    font-family: 'DM Sans', sans-serif;
    font-size: .84rem; font-weight: 500;
    text-decoration: none;
    transition: all .25s ease;
    margin-bottom: 28px;
}
.btn-google i { font-size:1rem; color:#EA4335; }
.btn-google:hover {
    border-color: rgba(0,0,0,.15);
    background: var(--subtle);
    color: var(--text);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

/* ── REGISTER ────────────────────────── */
.register-row { text-align:center; font-size:.8rem; color:var(--muted); }
.register-row a { color:var(--red); text-decoration:none; font-weight:600; margin-left:4px; transition:color .2s; }
.register-row a:hover { color:var(--red-dark); }

/* ── ERROR ───────────────────────────── */
.alert-error {
    display:flex; align-items:flex-start; gap:10px;
    background:#FFF0F0;
    border:1px solid rgba(217,59,59,.18);
    border-radius:12px; padding:12px 14px;
    margin-bottom:20px;
    font-size:.8rem; color:var(--red-dark); line-height:1.5;
}
.alert-error i { font-size:.9rem; margin-top:1px; flex-shrink:0; }

/* ── RESPONSIVE ──────────────────────── */
@media (max-width: 900px) {
    html, body { overflow: auto; }
    .page { grid-template-columns:1fr; height:auto; min-height:100vh; }
    .brand-panel { min-height:280px; padding:36px 32px; }
    .brand-stats, .brand-desc { display:none; }
    .form-panel { padding:40px 24px 56px; }
}
@media (max-width: 480px) {
    .brand-panel { min-height:220px; padding:28px 24px; }
    .form-panel { padding:32px 20px 48px; }
    .form-inner { max-width:100%; }
}
</style>
@endsection

@section('content')
<div class="page">

    <!-- LEFT: Brand con foto -->
    <div class="brand-panel">
        <div class="brand-content">
            <div class="logo-badge"><span class="dot"></span><span>BODY FIT</span></div>
            <div class="accent-line"></div>
            <h1 class="brand-headline">Forja tu<br><em>mejor versión</em></h1>
            <p class="brand-desc">Entrena con propósito. Cada repetición cuenta, cada sesión te acerca más a quien quieres ser.</p>
            
        </div>
    </div>

    <!-- RIGHT: Formulario blanco -->
    <div class="form-panel">
        <div class="form-inner">

            <div class="form-header">
                <div class="eyebrow">Bienvenido de nuevo</div>
                <h2>INICIA SESIÓN</h2>
                <p>Accede a tu cuenta y retoma tu progreso.</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label>Correo electrónico</label>
                    <div class="input-wrap">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" required autofocus>
                        <i class="icon fas fa-envelope"></i>
                    </div>
                </div>
                <div class="field">
                    <label>Contraseña</label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="password" class="pass-input" placeholder="••••••••" required>
                        <i class="icon fas fa-lock"></i>
                        <button type="button" class="eye-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye-slash" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="footer-row">
                    <label class="remember">
                        <input type="checkbox" name="remember" value="1">
                        <span>Recordarme</span>
                    </label>
                </div>
                <button type="submit" class="btn-submit">Iniciar Sesión</button>
            </form>

            <div class="divider"><span>o continúa con</span></div>
            <a href="{{ url('auth/google') }}" class="btn-google">
                <i class="fab fa-google"></i> Continuar con Google
            </a>
            <div class="register-row">
                ¿No tienes cuenta?<a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        </div>
    </div>

</div>
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('toggleIcon');
    const h = input.type === 'password';
    input.type = h ? 'text' : 'password';
    icon.classList.toggle('fa-eye-slash', !h);
    icon.classList.toggle('fa-eye', h);
}
</script>
@endsection