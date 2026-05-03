@extends('layouts.cliente-layout')

@section('title', 'Completar Perfil - BODY FIT')

@section('content')
<div class="perfil-completar-container">
    <div class="page-header">
        <h1 class="page-title">Completa tu Perfil</h1>
        <p class="page-description">Necesitamos algunos datos personales para procesar tus compras</p>
    </div>

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

    <div class="form-card">
        <form method="POST" action="{{ route('cliente.perfil.store') }}" id="perfilForm">
            @csrf

            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user"></i>
                    <h3>Datos Personales</h3>
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
                            <span class="error-text">{{ $message }}</span>
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
                            <span class="error-text">{{ $message }}</span>
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
                            <span class="error-text">{{ $message }}</span>
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
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edad">Edad <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="number" name="edad" id="edad" class="form-control @error('edad') is-invalid @enderror" 
                                   value="{{ old('edad') }}" placeholder="Ej: 25" required min="18" max="100">
                        </div>
                        @error('edad')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                        <div class="input-help">
                            <i class="fas fa-info-circle"></i> Debes ser mayor de 18 años
                        </div>
                    </div>

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
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="celular">Celular <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-mobile-alt"></i>
                            <input type="text" name="celular" id="celular" class="form-control @error('celular') is-invalid @enderror" 
                                   value="{{ old('celular') }}" placeholder="Ej: 71234567" required>
                        </div>
                        @error('celular')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('cliente.perfil') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Guardar Perfil
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .perfil-completar-container {
        max-width: 800px;
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

    .alert-error {
        background: #FEF2F2;
        border-left: 4px solid #E04545;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        gap: 12px;
    }

    .alert-error i {
        color: #E04545;
        font-size: 1.2rem;
    }

    .alert-content ul {
        margin: 8px 0 0 20px;
    }

    .form-card {
        background: white;
        border-radius: 24px;
        padding: 32px;
        border: 1px solid #E8ECEF;
    }

    .form-section {
        margin-bottom: 32px;
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
    }

    .form-control:focus {
        outline: none;
        border-color: #E04545;
        box-shadow: 0 0 0 3px rgba(224, 69, 69, 0.1);
    }

    .error-text {
        display: block;
        margin-top: 6px;
        font-size: 0.75rem;
        color: #E04545;
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
        text-decoration: none;
    }

    .btn-submit {
        background: #E04545;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover {
        background: #c93a3a;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 24px;
        }
        .page-title {
            font-size: 1.4rem;
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
@endsection