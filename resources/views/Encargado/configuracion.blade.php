@extends('layouts.encargado-layout')

@section('title', 'Configuración - BODY FIT Encargado')

@section('content')
<div class="config-container">
    <div class="page-header">
        <h1 class="page-title">Configuración</h1>
        <p class="page-description">Personaliza tu experiencia en el sistema</p>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="alert-content">
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="config-card">
        <div class="config-tabs">
            <button class="tab-btn active" data-tab="seguridad">
                <i class="fas fa-shield-alt"></i> Seguridad
            </button>
            <button class="tab-btn" data-tab="notificaciones">
                <i class="fas fa-bell"></i> Notificaciones
            </button>
            <button class="tab-btn" data-tab="apariencia">
                <i class="fas fa-palette"></i> Apariencia
            </button>
        </div>

        <!-- Pestaña de Seguridad -->
        <div id="tab-seguridad" class="tab-content active">
            <form method="POST" action="{{ route('encargado.configuracion.seguridad') }}" id="seguridadForm">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-lock"></i> Cambiar Contraseña
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="current_password">Contraseña actual <span class="required">*</span></label>
                            <div class="input-icon">
                                <i class="fas fa-key"></i>
                                <input type="password" name="current_password" id="current_password" class="form-control" 
                                       placeholder="Ingresa tu contraseña actual" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Nueva contraseña <span class="required">*</span></label>
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" id="password" class="form-control" 
                                       placeholder="Mínimo 6 caracteres" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmar contraseña <span class="required">*</span></label>
                            <div class="input-icon">
                                <i class="fas fa-check-circle"></i>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                       placeholder="Repite la nueva contraseña" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Actualizar Contraseña
                    </button>
                </div>
            </form>

            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Recomendaciones de seguridad:</strong>
                    <ul>
                        <li>Usa una contraseña de al menos 8 caracteres</li>
                        <li>Combina letras mayúsculas, minúsculas, números y símbolos</li>
                        <li>No uses la misma contraseña en otros servicios</li>
                        <li>Cambia tu contraseña periódicamente</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Pestaña de Notificaciones -->
        <div id="tab-notificaciones" class="tab-content">
            <form method="POST" action="{{ route('encargado.configuracion.notificaciones') }}" id="notificacionesForm">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-bell"></i> Preferencias de Notificaciones
                    </h3>

                    <div class="settings-list">
                        <label class="setting-item">
                            <div class="setting-info">
                                <strong>Notificaciones por email</strong>
                                <small>Recibe alertas sobre nuevas ventas y compras</small>
                            </div>
                            <div class="setting-toggle">
                                <input type="checkbox" name="email_notifications" value="1" {{ auth()->user()->email_notifications ?? true ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                        </label>

                        <label class="setting-item">
                            <div class="setting-info">
                                <strong>Notificaciones de stock bajo</strong>
                                <small>Alerta cuando un producto tiene stock bajo</small>
                            </div>
                            <div class="setting-toggle">
                                <input type="checkbox" name="stock_notifications" value="1" {{ auth()->user()->stock_notifications ?? true ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                        </label>

                        <label class="setting-item">
                            <div class="setting-info">
                                <strong>Reportes semanales</strong>
                                <small>Recibe un resumen semanal de actividades</small>
                            </div>
                            <div class="setting-toggle">
                                <input type="checkbox" name="weekly_reports" value="1" {{ auth()->user()->weekly_reports ?? false ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Guardar Preferencias
                    </button>
                </div>
            </form>
        </div>

        <!-- Pestaña de Apariencia -->
        <div id="tab-apariencia" class="tab-content">
            <form method="POST" action="{{ route('encargado.configuracion.apariencia') }}" id="aparienciaForm">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-palette"></i> Tema y Apariencia
                    </h3>

                    <div class="theme-options">
                        <label class="theme-card selected">
                            <input type="radio" name="theme" value="light" checked>
                            <div class="theme-preview light">
                                <div class="theme-color-bar"></div>
                                <div class="theme-preview-content">
                                    <div class="preview-header"></div>
                                    <div class="preview-body"></div>
                                </div>
                            </div>
                            <span class="theme-name">Claro</span>
                        </label>

                        <label class="theme-card">
                            <input type="radio" name="theme" value="dark">
                            <div class="theme-preview dark">
                                <div class="theme-color-bar"></div>
                                <div class="theme-preview-content">
                                    <div class="preview-header"></div>
                                    <div class="preview-body"></div>
                                </div>
                            </div>
                            <span class="theme-name">Oscuro</span>
                        </label>

                        <label class="theme-card">
                            <input type="radio" name="theme" value="auto">
                            <div class="theme-preview auto">
                                <div class="theme-color-bar"></div>
                                <div class="theme-preview-content">
                                    <div class="preview-header"></div>
                                    <div class="preview-body"></div>
                                </div>
                            </div>
                            <span class="theme-name">Automático</span>
                        </label>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-columns"></i> Diseño del Dashboard
                    </h3>

                    <div class="layout-options">
                        <label class="layout-card">
                            <input type="radio" name="layout" value="compact" checked>
                            <span>Compacto</span>
                            <small>Más información en menos espacio</small>
                        </label>
                        <label class="layout-card">
                            <input type="radio" name="layout" value="comfortable">
                            <span>Cómodo</span>
                            <small>Más espacio entre elementos</small>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Guardar Preferencias
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .config-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .page-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1F2937;
        margin-bottom: 8px;
    }

    .page-description {
        color: #6B7280;
        font-size: 0.9rem;
    }

    .alert-success, .alert-error {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #ECFDF5;
        color: #065F46;
        border-left: 4px solid #10B981;
    }

    .alert-error {
        background: #FEF2F2;
        color: #991B1B;
        border-left: 4px solid #E04545;
    }

    .alert-content ul {
        margin: 8px 0 0 20px;
        font-size: 0.8rem;
    }

    .config-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        overflow: hidden;
    }

    .config-tabs {
        display: flex;
        gap: 4px;
        padding: 16px 20px;
        background: #F9FAFB;
        border-bottom: 1px solid #E8ECEF;
    }

    .tab-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: none;
        border: none;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #6B7280;
        cursor: pointer;
        transition: all 0.2s;
    }

    .tab-btn i {
        font-size: 1rem;
    }

    .tab-btn:hover {
        background: #FEF2F2;
        color: #E04545;
    }

    .tab-btn.active {
        background: #E04545;
        color: white;
    }

    .tab-content {
        display: none;
        padding: 24px;
    }

    .tab-content.active {
        display: block;
    }

    .form-section {
        margin-bottom: 24px;
    }

    .form-section-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        color: #374151;
    }

    .required {
        color: #E04545;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        font-size: 1rem;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px 10px 42px;
        border: 1.5px solid #E5E7EB;
        border-radius: 12px;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #E04545;
        box-shadow: 0 0 0 3px rgba(224, 69, 69, 0.1);
    }

    .info-box {
        display: flex;
        gap: 16px;
        padding: 16px;
        background: #F0FDF4;
        border-radius: 14px;
        border-left: 4px solid #10B981;
        margin-top: 24px;
    }

    .info-box i {
        color: #10B981;
        font-size: 1.2rem;
    }

    .info-box ul {
        margin: 8px 0 0 20px;
        font-size: 0.8rem;
        color: #065F46;
    }

    .settings-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        background: #F9FAFB;
        border-radius: 16px;
        cursor: pointer;
    }

    .setting-info strong {
        display: block;
        font-size: 0.85rem;
        color: #1F2937;
        margin-bottom: 4px;
    }

    .setting-info small {
        font-size: 0.7rem;
        color: #6B7280;
    }

    .setting-toggle {
        position: relative;
        width: 50px;
        height: 26px;
    }

    .setting-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.3s;
        border-radius: 34px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
    }

    .setting-toggle input:checked + .toggle-slider {
        background-color: #E04545;
    }

    .setting-toggle input:checked + .toggle-slider:before {
        transform: translateX(24px);
    }

    .theme-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .theme-card {
        cursor: pointer;
        text-align: center;
    }

    .theme-card input {
        display: none;
    }

    .theme-preview {
        border-radius: 16px;
        overflow: hidden;
        border: 2px solid #E5E7EB;
        transition: all 0.2s;
        margin-bottom: 8px;
    }

    .theme-card.selected .theme-preview {
        border-color: #E04545;
        box-shadow: 0 0 0 2px rgba(224, 69, 69, 0.2);
    }

    .theme-color-bar {
        height: 8px;
        background: #E04545;
    }

    .theme-preview-content {
        padding: 12px;
        background: white;
    }

    .preview-header {
        height: 20px;
        background: #F3F4F6;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .preview-body {
        height: 40px;
        background: #E5E7EB;
        border-radius: 4px;
    }

    .theme-preview.dark .theme-preview-content {
        background: #1F2937;
    }

    .theme-preview.dark .preview-header {
        background: #374151;
    }

    .theme-preview.dark .preview-body {
        background: #4B5563;
    }

    .theme-name {
        font-size: 0.8rem;
        font-weight: 500;
        color: #374151;
    }

    .layout-options {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .layout-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 16px;
        background: #F9FAFB;
        border-radius: 16px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s;
    }

    .layout-card input {
        display: none;
    }

    .layout-card:has(input:checked) {
        border-color: #E04545;
        background: #FEF2F2;
    }

    .layout-card span {
        font-weight: 600;
        color: #1F2937;
    }

    .layout-card small {
        font-size: 0.7rem;
        color: #6B7280;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #F3F4F6;
    }

    .btn-submit {
        background: #E04545;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: #c93a3a;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }
        .config-tabs {
            flex-wrap: wrap;
            justify-content: center;
        }
        .theme-options {
            grid-template-columns: 1fr;
        }
        .layout-options {
            grid-template-columns: 1fr;
        }
        .setting-item {
            flex-direction: column;
            text-align: center;
            gap: 12px;
        }
    }
</style>
@endpush
@push('scripts')
<script>
    // Tabs de configuración
    const configTabBtns = document.querySelectorAll('.config-tabs .tab-btn');
    const configTabContents = document.querySelectorAll('.tab-content');

    configTabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.dataset.tab;
            configTabBtns.forEach(b => b.classList.remove('active'));
            configTabContents.forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(`tab-${tabId}`).classList.add('active');
        });
    });

    // Selección de tarjeta de tema (solo UI)
    const themeCardsContainer = document.querySelectorAll('.theme-card');
    themeCardsContainer.forEach(card => {
        card.addEventListener('click', () => {
            const radio = card.querySelector('input');
            if (radio) {
                radio.checked = true;
                themeCardsContainer.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
            }
        });
    });

    // Sincronizar el tema seleccionado con el layout
    const themeRadios = document.querySelectorAll('input[name="theme"]');
    themeRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            if (e.target.checked) {
                const newTheme = e.target.value;
                // Llamar a la función global applyTheme (definida en el layout)
                if (typeof window.applyTheme === 'function') {
                    window.applyTheme(newTheme);
                } else {
                    // Si no está disponible, recargar la página
                    location.reload();
                }
                
                // Actualizar clase selected
                themeCardsContainer.forEach(card => {
                    if (card.querySelector('input').value === newTheme) {
                        card.classList.add('selected');
                    } else {
                        card.classList.remove('selected');
                    }
                });
            }
        });
    });

    // Envío del formulario de apariencia
    const aparienciaForm = document.getElementById('aparienciaForm');
    if (aparienciaForm) {
        aparienciaForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const selectedTheme = document.querySelector('input[name="theme"]:checked').value;
            if (typeof window.applyTheme === 'function') {
                window.applyTheme(selectedTheme);
            }
            
            Swal.fire({
                icon: 'success',
                title: 'Preferencias guardadas',
                text: 'Las preferencias de apariencia se han guardado',
                confirmButtonColor: '#E04545',
                timer: 1500,
                showConfirmButton: false
            });
        });
    }
</script>
@endpush
@endsection