@extends('layouts.admin-layout')

@section('title', 'Nuevo Tipo de Usuario - BODY FIT Admin')

@section('content')
<div class="form-container">
    <div class="form-header">
        <a href="{{ route('tipos-usuario.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="form-title">Nuevo Tipo de Usuario</h1>
        <p class="form-subtitle">Crea un nuevo rol o tipo para gestionar usuarios</p>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('tipos-usuario.store') }}">
            @csrf

            <div class="form-group">
                <label for="nombre">Nombre del Tipo <span class="required">*</span></label>
                <div class="input-icon">
                    <i class="fas fa-tag"></i>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre') }}" placeholder="Ej: Administrador, Cliente, Entrenador" required>
                </div>
                @error('nombre')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción <span class="required">*</span></label>
                <div class="input-icon">
                    <i class="fas fa-align-left"></i>
                    <textarea name="descripcion" id="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror" 
                              placeholder="Describe las responsabilidades o características de este tipo de usuario..." required>{{ old('descripcion') }}</textarea>
                </div>
                @error('descripcion')
                    <span class="error-text">{{ $message }}</span>
                @enderror
                <div class="input-help">
                    <i class="fas fa-info-circle"></i> Máximo 500 caracteres
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('tipos-usuario.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Crear Tipo de Usuario
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .form-container {
        max-width: 700px;
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

    .form-card {
        background: white;
        border-radius: 24px;
        padding: 32px;
        border: 1px solid #E8ECEF;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .form-group {
        margin-bottom: 24px;
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
    }

    .input-icon textarea ~ i {
        top: 18px;
        transform: none;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border: 1.5px solid #E5E7EB;
        border-radius: 14px;
        font-size: 0.9rem;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
    }

    textarea.form-control {
        padding: 12px 14px 12px 42px;
        resize: vertical;
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
    }
</style>
@endpush
@endsection