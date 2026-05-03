@extends('layouts.admin-layout')

@section('title', 'Detalle Tipo de Usuario - BODY FIT Admin')

@section('content')
<div class="detail-container">
    <div class="detail-header">
        <a href="{{ route('tipos-usuario.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
        <div class="detail-actions">
            <a href="{{ route('tipos-usuario.edit', $tipoUsuario->codTipoUsuario) }}" class="btn-edit">
                <i class="fas fa-pencil-alt"></i> Editar
            </a>
            <form action="{{ route('tipos-usuario.destroy', $tipoUsuario->codTipoUsuario) }}" method="POST" class="delete-form" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este tipo de usuario?')">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </form>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-icon">
            <i class="fas fa-users"></i>
        </div>
        <h1 class="detail-title">{{ $tipoUsuario->nombre }}</h1>
        
        <div class="detail-info">
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-hashtag"></i> Código
                </div>
                <div class="info-value">#{{ $tipoUsuario->codTipoUsuario }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-align-left"></i> Descripción
                </div>
                <div class="info-value description">
                    {{ $tipoUsuario->descripcion }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-users"></i> Usuarios asociados
                </div>
                <div class="info-value">
                    <span class="badge">{{ $tipoUsuario->usuarios_count ?? 0 }} usuarios</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-calendar-alt"></i> Fecha de creación
                </div>
                <div class="info-value">
                    {{ $tipoUsuario->created_at ? $tipoUsuario->created_at->format('d/m/Y H:i') : 'No registrada' }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .detail-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6B7280;
        text-decoration: none;
        font-size: 0.85rem;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #E04545;
    }

    .detail-actions {
        display: flex;
        gap: 12px;
    }

    .btn-edit, .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .btn-edit {
        background: #EFF6FF;
        color: #3B82F6;
    }

    .btn-edit:hover {
        background: #DBEAFE;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: #FEF2F2;
        color: #E04545;
    }

    .btn-delete:hover {
        background: #FEE2E2;
        transform: translateY(-1px);
    }

    .detail-card {
        background: white;
        border-radius: 28px;
        padding: 40px;
        border: 1px solid #E8ECEF;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .detail-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(224, 69, 69, 0.1), rgba(224, 69, 69, 0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .detail-icon i {
        font-size: 2.5rem;
        color: #E04545;
    }

    .detail-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 28px;
    }

    .detail-info {
        text-align: left;
        border-top: 1px solid #F3F4F6;
        padding-top: 24px;
    }

    .info-row {
        display: flex;
        padding: 14px 0;
        border-bottom: 1px solid #F3F4F6;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 140px;
        font-weight: 600;
        color: #6B7280;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        width: 20px;
        color: #9CA3AF;
    }

    .info-value {
        flex: 1;
        color: #374151;
        font-size: 0.9rem;
    }

    .info-value.description {
        line-height: 1.5;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        background: #F3F4F6;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #4B5563;
    }

    @media (max-width: 768px) {
        .detail-card {
            padding: 28px 20px;
        }
        .detail-title {
            font-size: 1.6rem;
        }
        .info-row {
            flex-direction: column;
            gap: 6px;
        }
        .info-label {
            width: 100%;
        }
        .detail-header {
            flex-direction: column;
            align-items: stretch;
        }
        .detail-actions {
            justify-content: flex-start;
        }
    }
</style>
@endpush
@endsection