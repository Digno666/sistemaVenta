@extends('layouts.encargado-layout')

@section('title', 'Editar Cliente - BODY FIT Admin')

@section('content')
<div class="form-container">
    <div class="form-header">
        <a href="{{ route('cliente.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="form-title">Editar Cliente</h1>
        <p class="form-subtitle">Modifica los datos del cliente y su usuario asociado</p>
    </div>

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
        <form method="POST" action="{{ route('cliente.update', $cliente->carnetIdentidad) }}" id="clienteForm">
            @csrf
            @method('PUT')

            <!-- SECCIÓN: DATOS PERSONALES DEL CLIENTE -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user"></i>
                    <h3>Datos Personales del Cliente</h3>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="carnetIdentidad">Carnet de Identidad</label>
                        <div class="input-icon">
                            <i class="fas fa-id-card"></i>
                            <input type="text" class="form-control" value="{{ number_format($cliente->carnetIdentidad, 0, '', '.') }}" disabled>
                        </div>
                        <div class="input-help">
                            <i class="fas fa-info-circle"></i> El carnet de identidad no se puede modificar
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre', $cliente->nombre) }}" placeholder="Ej: Juan" required>
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
                                   value="{{ old('apellidoPaterno', $cliente->apellidoPaterno) }}" placeholder="Ej: Pérez" required>
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
                                   value="{{ old('apellidoMaterno', $cliente->apellidoMaterno) }}" placeholder="Ej: González" required>
                        </div>
                        @error('apellidoMaterno')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edad">Edad <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="number" name="edad" id="edad" class="form-control @error('edad') is-invalid @enderror" 
                                   value="{{ old('edad', $cliente->edad) }}" placeholder="Ej: 25" required min="18" max="80">
                        </div>
                        @error('edad')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                        <div class="input-help">
                            <i class="fas fa-info-circle"></i> Edad mínima: 18 años, máxima: 80 años
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sexo">Sexo <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-venus-mars"></i>
                            <select name="sexo" id="sexo" class="form-control @error('sexo') is-invalid @enderror" required>
                                <option value="">Seleccionar</option>
                                <option value="M" {{ old('sexo', $cliente->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('sexo', $cliente->sexo) == 'F' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>
                        @error('sexo')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="celular">Celular <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-mobile-alt"></i>
                            <input type="text" name="celular" id="celular" class="form-control @error('celular') is-invalid @enderror" 
                                   value="{{ old('celular', $cliente->celular) }}" placeholder="Ej: 71234567" required>
                        </div>
                        @error('celular')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SECCIÓN: DATOS DE USUARIO -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-key"></i>
                    <h3>Datos de Acceso (Usuario)</h3>
                    <span class="badge-info-auto">Tipo de usuario: Cliente</span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nombre de Usuario <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-user-circle"></i>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $cliente->usuario->name) }}" required>
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
                                   value="{{ old('email', $cliente->usuario->email) }}" required>
                        </div>
                        @error('email')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Dejar en blanco para mantener la actual">
                        </div>
                        <div class="input-help">
                            <i class="fas fa-info-circle"></i> Mínimo 6 caracteres. Solo completar si deseas cambiar la contraseña
                        </div>
                        @error('password')
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <div class="input-icon">
                            <i class="fas fa-check-circle"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                   placeholder="Repite la nueva contraseña">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('cliente.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Actualizar Cliente
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
        flex-wrap: wrap;
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

    .badge-info-auto {
        background: #E0F2FE;
        color: #0369A1;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
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

    .form-control:disabled {
        background: #F9FAFB;
        color: #6B7280;
        cursor: not-allowed;
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
        .section-title {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        
        function validatePasswordMatch() {
            if (password && confirmPassword && password.value !== confirmPassword.value && confirmPassword.value !== '') {
                confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                confirmPassword.classList.add('is-invalid');
            } else {
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('is-invalid');
            }
        }
        
        if (password && confirmPassword) {
            password.addEventListener('input', validatePasswordMatch);
            confirmPassword.addEventListener('input', validatePasswordMatch);
        }
    });

    const form = document.getElementById('clienteForm');
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
            
            const edad = document.getElementById('edad');
            if (edad && edad.value && (edad.value < 18 || edad.value > 80)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Edad fuera de rango',
                    text: 'La edad debe estar entre 18 y 80 años.',
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