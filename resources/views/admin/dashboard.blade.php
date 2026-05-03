@extends('layouts.admin-layout')

@section('title', 'Dashboard - BODY FIT Admin')

@section('content')
<div class="dashboard-container">
    <!-- Encabezado de bienvenida -->
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title">
                ¡Bienvenido, {{ Auth::user()->name ?? 'Administrador' }}!
            </h1>
            <p class="welcome-subtitle">
                Panel de control del sistema BODY FIT
            </p>
        </div>
        <div class="welcome-date">
            <i class="fas fa-calendar-alt"></i>
            <span>{{ now()->format('l, d \\d\\e F \\d\\e Y') }}</span>
        </div>
    </div>

    <!-- Tarjetas de resumen (estadísticas) -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalTiposUsuario ?? 0 }}</h3>
                <p class="stat-label">Tipos de Usuario</p>
            </div>
            <div class="stat-link">
                <a href="{{ route('tipos-usuario.index') }}" class="stat-btn">
                    Ver todos <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalEncargados ?? 0 }}</h3>
                <p class="stat-label">Encargados Registrados</p>
            </div>
            <div class="stat-link">
                <a href="{{ route('encargado.index') }}" class="stat-btn">
                    Ver todos <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $ultimoRegistro ?? 'N/A' }}</h3>
                <p class="stat-label">Último Encargado</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalUsuariosSistema ?? 0 }}</h3>
                <p class="stat-label">Usuarios en Sistema</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Sección de bienvenida */
    .welcome-section {
        background: linear-gradient(135deg, #FFF5F5 0%, #FFFFFF 100%);
        border-radius: 24px;
        padding: 28px 32px;
        margin-bottom: 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        border: 1px solid rgba(224, 69, 69, 0.15);
    }

    .welcome-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 8px;
    }

    .welcome-subtitle {
        color: #6B7280;
        font-size: 0.9rem;
    }

    .welcome-date {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        background: white;
        border-radius: 40px;
        font-size: 0.85rem;
        color: #4B5563;
        border: 1px solid #E5E7EB;
    }

    .welcome-date i {
        color: #E04545;
    }

    /* Tarjetas de estadísticas */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #E8ECEF;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-color: rgba(224, 69, 69, 0.2);
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        background: rgba(224, 69, 69, 0.1);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon i {
        font-size: 1.8rem;
        color: #E04545;
    }

    .stat-info {
        flex: 1;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #1F2937;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #6B7280;
        margin-top: 4px;
    }

    .stat-link {
        width: 100%;
        margin-top: 12px;
        text-align: right;
    }

    .stat-btn {
        font-size: 0.75rem;
        color: #E04545;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .stat-btn:hover {
        gap: 10px;
    }

    /* Acciones rápidas */
    .quick-actions {
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #E04545;
        font-size: 1.2rem;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
    }

    .action-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        border: 1px solid #E8ECEF;
        text-decoration: none;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        border-color: rgba(224, 69, 69, 0.3);
    }

    .action-icon {
        width: 50px;
        height: 50px;
        background: rgba(224, 69, 69, 0.1);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-icon i {
        font-size: 1.5rem;
        color: #E04545;
    }

    .action-info h4 {
        font-size: 1rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 4px;
    }

    .action-info p {
        font-size: 0.75rem;
        color: #6B7280;
    }

    /* Sección de tablas recientes */
    .recent-section {
        margin-bottom: 40px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .view-all-link {
        font-size: 0.85rem;
        color: #E04545;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .view-all-link:hover {
        gap: 12px;
    }

    .table-container {
        background: white;
        border-radius: 20px;
        overflow-x: auto;
        border: 1px solid #E8ECEF;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .data-table thead th {
        text-align: left;
        padding: 16px 20px;
        background: #F9FAFB;
        font-weight: 600;
        font-size: 0.85rem;
        color: #4B5563;
        border-bottom: 1px solid #E8ECEF;
    }

    .data-table tbody td {
        padding: 14px 20px;
        border-bottom: 1px solid #F3F4F6;
        font-size: 0.85rem;
        color: #374151;
    }

    .data-table tbody tr:hover {
        background: #F9FAFB;
    }

    .text-center {
        text-align: center;
    }

    .cell-title {
        font-weight: 600;
        color: #1F2937;
    }

    .description-cell {
        max-width: 250px;
        color: #6B7280;
        line-height: 1.4;
    }

    .contact-cell, .user-cell {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-cell i, .user-cell i {
        color: #9CA3AF;
        width: 16px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-active {
        background: #ECFDF5;
        color: #065F46;
    }

    .badge-inactive {
        background: #FEF2F2;
        color: #991B1B;
    }

    .badge-info {
        background: #E0F2FE;
        color: #0369A1;
    }

    .badge-secondary {
        background: #F3F4F6;
        color: #6B7280;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .action-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
        background: transparent;
    }

    .action-icon.view {
        color: #3B82F6;
    }
    .action-icon.view:hover {
        background: #EFF6FF;
    }
    .action-icon.edit {
        color: #F59E0B;
    }
    .action-icon.edit:hover {
        background: #FFFBEB;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px !important;
        color: #9CA3AF;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        opacity: 0.5;
    }

    .empty-state p {
        margin-bottom: 12px;
        font-size: 0.85rem;
    }

    .btn-primary-small {
        background: #E04545;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-primary-small:hover {
        background: #c93a3a;
    }

    @media (max-width: 768px) {
        .welcome-section {
            flex-direction: column;
            text-align: center;
        }
        .welcome-title {
            font-size: 1.5rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .actions-grid {
            grid-template-columns: 1fr;
        }
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush
@endsection