@extends('layouts.encargado-layout')

@section('title', 'Dashboard - BODY FIT Encargado')

@section('content')
<div class="dashboard-container">
    <!-- Encabezado de bienvenida -->
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title">
                ¡Bienvenido, {{ $encargado->nombre ?? 'Encargado' }} {{ $encargado->apellidoPaterno ?? '' }}!
            </h1>
            <p class="welcome-subtitle">
                Panel de control del encargado - Sistema BODY FIT
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
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalCompras }}</h3>
                <p class="stat-label">Compras Registradas</p>
                <small class="stat-amount">Total: {{ number_format($montoTotalCompras, 2) }} Bs</small>
            </div>
            <div class="stat-link">
                <a href="{{ route('compra.index') }}" class="stat-btn">
                    Ver todas <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-cash-register"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalVentas }}</h3>
                <p class="stat-label">Ventas Realizadas</p>
                <small class="stat-amount">Total: {{ number_format($montoTotalVentas, 2) }} Bs</small>
            </div>
            <div class="stat-link">
                <a href="{{ route('venta.index') }}" class="stat-btn">
                    Ver todas <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalClientes }}</h3>
                <p class="stat-label">Clientes Registrados</p>
            </div>
            <div class="stat-link">
                <a href="{{ route('cliente.index') }}" class="stat-btn">
                    Ver todos <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalProductos }}</h3>
                <p class="stat-label">Productos en Inventario</p>
            </div>
            <div class="stat-link">
                <a href="{{ route('producto.index') }}" class="stat-btn">
                    Ver todos <i class="fas fa-arrow-right"></i>
                </a>
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

    .stat-amount {
        font-size: 0.7rem;
        color: #10B981;
        display: block;
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
</style>
@endpush
@endsection