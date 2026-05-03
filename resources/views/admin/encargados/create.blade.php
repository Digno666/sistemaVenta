@extends('layouts.admin-layout')

@section('title', 'Nuevo Encargado - BODY FIT Admin')

@section('content')
<div class="form-container">
    <div class="form-header">
        <a href="{{ route('encargado.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="form-title">Nuevo Encargado</h1>
        <p class="form-subtitle">Registra un nuevo encargado con sus datos personales y de usuario</p>
    </div>

    <!-- Mostrar errores generales -->
    @if($errors->any())
        <div class="alert-general">
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

    <div class="form-card">
        <form method="POST" action="{{ route('encargado.store') }}" id="encargadoForm">
            @csrf

            <!-- SECCIÓN: DATOS PERSONALES DEL ENCARGADO -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user-tie"></i>
                    <h3>Datos Personales del Encargado</h3>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="carnetIdentidad">Carnet de Identidad <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-id-card"></i>
                            <input type="number" name="carnetIdentidad" id="carnetIdentidad" class="form-control @error('carnetIdentidad') is-invalid @enderror" 
                                   value="{{ old('carnetIdentidad') }}" placeholder="Ej: 12345678" required>
                        </div>
                        @error('carnetIdentidad')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre') }}" placeholder="Ej: Juan" required>
                        </div>
                        @error('nombre')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="apellidoPaterno">Apellido Paterno <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="apellidoPaterno" id="apellidoPaterno" class="form-control @error('apellidoPaterno') is-invalid @enderror" 
                                   value="{{ old('apellidoPaterno') }}" placeholder="Ej: Pérez" required>
                        </div>
                        @error('apellidoPaterno')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="apellidoMaterno">Apellido Materno <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="apellidoMaterno" id="apellidoMaterno" class="form-control @error('apellidoMaterno') is-invalid @enderror" 
                                   value="{{ old('apellidoMaterno') }}" placeholder="Ej: González" required>
                        </div>
                        @error('apellidoMaterno')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sexo">Sexo <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-venus-mars"></i>
                            <select name="sexo" id="sexo" class="form-control @error('sexo') is-invalid @enderror" required>
                                <option value="">Seleccionar</option>
                                <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>
                        @error('sexo')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-phone"></i>
                            <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" 
                                   value="{{ old('telefono') }}" placeholder="Ej: 71234567" required>
                        </div>
                        @error('telefono')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                        <div class="input-help">
                            <i class="fas fa-info-circle"></i> Máximo 8 dígitos
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN: DATOS DE USUARIO -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-key"></i>
                    <h3>Datos de Acceso (Usuario)</h3>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nombre de Usuario <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-user-circle"></i>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="Ej: juan.perez" required>
                        </div>
                        @error('name')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" placeholder="Ej: juan.perez@bodyfit.com" required>
                        </div>
                        @error('email')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Contraseña <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Mínimo 6 caracteres" required>
                        </div>
                        @error('password')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-check-circle"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   placeholder="Repite la contraseña" required>
                        </div>
                        @error('password_confirmation')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="codTipoUsuario">Tipo de Usuario <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-tag"></i>
                            <select name="codTipoUsuario" id="codTipoUsuario" class="form-control @error('codTipoUsuario') is-invalid @enderror" required>
                                <option value="">Seleccionar tipo</option>
                                @foreach($tiposUsuario as $tipo)
                                    <option value="{{ $tipo->codTipoUsuario }}" {{ old('codTipoUsuario') == $tipo->codTipoUsuario ? 'selected' : '' }}>
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('codTipoUsuario')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="bloqueado">Estado</label>
                        <div class="input-icon">
                            <i class="fas fa-toggle-on"></i>
                            <select name="bloqueado" id="bloqueado" class="form-control">
                                <option value="0" {{ old('bloqueado') == '0' ? 'selected' : '' }}>Activo</option>
                                <option value="1" {{ old('bloqueado') == '1' ? 'selected' : '' }}>Bloqueado</option>
                            </select>
                        </div>
                        <div class="input-help">
                            <i class="fas fa-info-circle"></i> Si está bloqueado, no podrá iniciar sesión
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('encargado.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Registrar Encargado
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .form-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .form-header {
        margin-bottom: 28px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6B7280;
        text-decoration: none;
        font-size: 0.85rem;
        margin-bottom: 16px;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #E04545;
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 6px;
    }

    .form-subtitle {
        color: #6B7280;
        font-size: 0.9rem;
    }

    /* Estilos para alerta general de errores */
    .alert-general {
        background: #FEF2F2;
        border-left: 4px solid #E04545;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .alert-general i {
        color: #E04545;
        font-size: 1.2rem;
        margin-top: 2px;
    }

    .alert-content {
        flex: 1;
    }

    .alert-content strong {
        color: #991B1B;
        font-size: 0.85rem;
        display: block;
        margin-bottom: 8px;
    }

    .alert-content ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-content li {
        color: #991B1B;
        font-size: 0.8rem;
        margin: 4px 0;
    }

    .form-card {
        background: white;
        border-radius: 24px;
        padding: 32px;
        border: 1px solid #E8ECEF;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .form-section {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #F3F4F6;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
    }

    .section-title i {
        font-size: 1.3rem;
        color: #E04545;
    }

    .section-title h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
        margin: 0;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-row:last-child {
        margin-bottom: 0;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 0.85rem;
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
        pointer-events: none;
    }

    .input-icon select ~ i {
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border: 1.5px solid #E5E7EB;
        border-radius: 14px;
        font-size: 0.9rem;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
        background: white;
    }

    select.form-control {
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
    }

    .form-control:focus {
        outline: none;
        border-color: #E04545;
        box-shadow: 0 0 0 3px rgba(224, 69, 69, 0.1);
    }

    .form-control.is-invalid {
        border-color: #E04545;
        background: #FEF2F2;
    }

    .error-text {
        display: block;
        margin-top: 6px;
        font-size: 0.75rem;
        color: #E04545;
    }

    .error-text i {
        font-size: 0.7rem;
        margin-right: 4px;
    }

    .input-help {
        margin-top: 8px;
        font-size: 0.7rem;
        color: #9CA3AF;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #F3F4F6;
    }

    .btn-cancel {
        background: #F3F4F6;
        color: #4B5563;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #E5E7EB;
    }

    .btn-submit {
        background: #E04545;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: #c93a3a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(224, 69, 69, 0.3);
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 24px;
        }
        .form-title {
            font-size: 1.5rem;
        }
        .form-actions {
            flex-direction: column;
        }
        .btn-cancel, .btn-submit {
            text-align: center;
            justify-content: center;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación en tiempo real para contraseñas
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        
        function validatePasswordMatch() {
            if (password && confirmPassword) {
                if (password.value !== confirmPassword.value && confirmPassword.value !== '') {
                    confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                    confirmPassword.classList.add('is-invalid');
                    
                    let errorSpan = confirmPassword.parentElement.nextElementSibling;
                    if (!errorSpan || !errorSpan.classList.contains('error-text')) {
                        errorSpan = document.createElement('span');
                        errorSpan.className = 'error-text';
                        errorSpan.innerHTML = '<i class="fas fa-exclamation-circle"></i> Las contraseñas no coinciden';
                        confirmPassword.parentElement.parentElement.appendChild(errorSpan);
                    } else {
                        errorSpan.innerHTML = '<i class="fas fa-exclamation-circle"></i> Las contraseñas no coinciden';
                        errorSpan.style.display = 'block';
                    }
                } else {
                    confirmPassword.setCustomValidity('');
                    confirmPassword.classList.remove('is-invalid');
                    const errorSpan = confirmPassword.parentElement.parentElement.querySelector('.error-text');
                    if (errorSpan && errorSpan.innerHTML.includes('contraseñas')) {
                        errorSpan.style.display = 'none';
                    }
                }
            }
        }
        
        if (password && confirmPassword) {
            password.addEventListener('input', validatePasswordMatch);
            confirmPassword.addEventListener('input', validatePasswordMatch);
        }
    });

    // Validación antes de enviar el formulario
    const form = document.getElementById('encargadoForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            
            if (password && confirmPassword && password.value !== confirmPassword.value) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Contraseñas no coinciden',
                    text: 'Por favor, verifica que ambas contraseñas sean iguales.',
                    confirmButtonColor: '#E04545'
                });
                return false;
            }
            
            // Validar carnet (solo números)
            const carnet = document.getElementById('carnetIdentidad');
            if (carnet && carnet.value && !/^\d+$/.test(carnet.value)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Carnet inválido',
                    text: 'El carnet de identidad solo debe contener números.',
                    confirmButtonColor: '#E04545'
                });
                return false;
            }
            
            return true;
        });
    }
</script>
@endpush
@endsection