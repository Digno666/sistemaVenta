@extends('layouts.app')

@section('title', 'Crear Cuenta - BODY FIT')

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

/* ── LEFT PANEL (imagen) ── */
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

/* ── RIGHT PANEL (BLANCO) ──────────── */
.form-panel {
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 190px;
    padding-bottom: 45px;
    position: relative;
    overflow-y: auto;
}

.form-panel::before {
    content: '';
    position: absolute;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(217,59,59,0.05) 0%, transparent 70%);
    pointer-events: none;
}

.form-inner {
    width: 100%;
    max-width: 500px;
    position: relative;
    z-index: 1;
    animation: fadeUp 0.9s 0.15s cubic-bezier(0.22,1,0.36,1) both;
}

.form-header { margin-bottom: 28px; }
.form-header .eyebrow {
    font-size: .7rem; letter-spacing: 3px; text-transform: uppercase;
    color: var(--red); font-weight: 600; margin-bottom: 10px;
}
.form-header h2 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2.2rem; letter-spacing: 1px;
    color: var(--text); line-height: 1; margin-bottom: 8px; text-align: left;
}
.form-header p { font-size: .82rem; color: var(--muted); font-weight: 300; }

/* ── INPUTS ── */
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
.input-wrap input, .input-wrap select {
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
.input-wrap select {
    cursor: pointer;
    padding-right: 40px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239A9A9A' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
}
.input-wrap input::placeholder { color: #C8C5C0; }
.input-wrap input:hover, .input-wrap select:hover { border-color: rgba(0,0,0,.14); background: #EDEBE8; }
.input-wrap input:focus, .input-wrap select:focus {
    outline: none;
    border-color: var(--border-hot);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(217,59,59,0.07);
}
.input-wrap:focus-within .icon { color: var(--red); }

/* filas de dos columnas */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

/* ojo para contraseña */
.eye-toggle {
    position: absolute; right: 14px; top: 50%;
    transform: translateY(-50%);
    cursor: pointer; color: var(--muted); font-size: .9rem;
    transition: color .2s; background: none; border: none; padding: 4px; z-index: 2;
}
.eye-toggle:hover { color: var(--red); }
.pass-input { padding-right: 44px; }

/* ── BOTÓN ── */
.btn-submit {
    width: 100%; padding: 14px;
    background: var(--red); color: white; border: none;
    border-radius: 12px;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1rem; letter-spacing: 3px;
    cursor: pointer; overflow: hidden;
    transition: all .25s ease; margin-top: 12px;
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

/* ── REGISTER LINK ── */
.login-link {
    text-align: center;
    margin-top: 24px;
    font-size: .8rem;
    color: var(--muted);
}
.login-link a {
    color: var(--red);
    text-decoration: none;
    font-weight: 600;
    margin-left: 4px;
    transition: color .2s;
}
.login-link a:hover { color: var(--red-dark); text-decoration: underline; }

/* ── ERROR ── */
.alert-error {
    display:flex; align-items:flex-start; gap:10px;
    background:#FFF0F0;
    border:1px solid rgba(217,59,59,.18);
    border-radius:12px; padding:12px 14px;
    margin-bottom:20px;
    font-size:.8rem; color:var(--red-dark); line-height:1.5;
}
.alert-error i { font-size:.9rem; margin-top:1px; flex-shrink:0; }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    html, body { overflow: auto; }
    .page { grid-template-columns:1fr; height:auto; min-height:100vh; }
    .brand-panel { min-height:240px; padding:36px 32px; }
    .brand-desc { display: none; }
    .form-panel { padding:40px 24px 56px; }
}
@media (max-width: 480px) {
    .brand-panel { min-height:200px; padding:28px 24px; }
    .form-panel { padding:32px 20px 48px; }
    .form-inner { max-width:100%; }
    .form-row { grid-template-columns: 1fr; gap: 12px; }
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
            <h1 class="brand-headline">Empieza tu<br><em>transformación</em></h1>
            <p class="brand-desc">Crea tu cuenta y accede a productos exclusivos, rutinas personalizadas y el mejor contenido fitness.</p>
        </div>
    </div>

    <div class="form-panel">
        <div class="form-inner">

            <div class="form-header">
                <div class="eyebrow">Únete ahora</div>
                <h2>CREAR CUENTA</h2>
                <p>Regístrate y completa tus datos personales.</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </span>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-row">
                    <div class="field">
                        <label>Carnet de Identidad <span class="required">*</span></label>
                        <div class="input-wrap">
                            <input type="number" name="carnetIdentidad" value="{{ old('carnetIdentidad') }}" placeholder="12345678" required>
                            <i class="icon fas fa-id-card"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>Edad <span class="required">*</span></label>
                        <div class="input-wrap">
                            <input type="number" name="edad" value="{{ old('edad') }}" placeholder="25" required min="18" max="100">
                            <i class="icon fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="field">
                        <label>Nombre <span class="required">*</span></label>
                        <div class="input-wrap">
                            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Juan" required>
                            <i class="icon fas fa-user"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>Apellido Paterno <span class="required">*</span></label>
                        <div class="input-wrap">
                            <input type="text" name="apellidoPaterno" value="{{ old('apellidoPaterno') }}" placeholder="Pérez" required>
                            <i class="icon fas fa-user"></i>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="field">
                        <label>Apellido Materno <span class="required">*</span></label>
                        <div class="input-wrap">
                            <input type="text" name="apellidoMaterno" value="{{ old('apellidoMaterno') }}" placeholder="González" required>
                            <i class="icon fas fa-user"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>Sexo <span class="required">*</span></label>
                        <div class="input-wrap">
                            <select name="sexo" required>
                                <option value="">Seleccionar</option>
                                <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                            </select>
                            <i class="icon fas fa-venus-mars"></i>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="field">
                        <label>Celular <span class="required">*</span></label>
                        <div class="input-wrap">
                            <input type="text" name="celular" value="{{ old('celular') }}" placeholder="71234567" required>
                            <i class="icon fas fa-mobile-alt"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>Nombre de usuario <span class="required">*</span></label>
                        <div class="input-wrap">
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="juan.perez" required>
                            <i class="icon fas fa-user-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label>Correo electrónico <span class="required">*</span></label>
                    <div class="input-wrap">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" required>
                        <i class="icon fas fa-envelope"></i>
                    </div>
                </div>

                <div class="form-row">
                    <div class="field">
                        <label>Contraseña <span class="required">*</span></label>
                        <div class="input-wrap">
                            <input type="password" name="password" id="password" class="pass-input" placeholder="••••••••" required>
                            <i class="icon fas fa-lock"></i>
                            <button type="button" class="eye-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye-slash" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="field">
                        <label>Confirmar contraseña <span class="required">*</span></label>
                        <div class="input-wrap">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="pass-input" placeholder="••••••••" required>
                            <i class="icon fas fa-check-circle"></i>
                            <button type="button" class="eye-toggle" onclick="toggleConfirmPassword()">
                                <i class="fas fa-eye-slash" id="toggleConfirmIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Registrarme</button>
            </form>

            <div class="login-link">
                ¿Ya tienes cuenta?<a href="{{ route('login') }}">Inicia sesión aquí</a>
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

function toggleConfirmPassword() {
    const input = document.getElementById('password_confirmation');
    const icon  = document.getElementById('toggleConfirmIcon');
    const h = input.type === 'password';
    input.type = h ? 'text' : 'password';
    icon.classList.toggle('fa-eye-slash', !h);
    icon.classList.toggle('fa-eye', h);
}
</script>
@endsection