@extends('layouts.encargado-layout')

@section('title', 'Productos Más Vendidos - BODY FIT Admin')

@section('content')
<div class="report-container">
    <div class="report-header">
        <h1><i class="fas fa-trophy"></i> TOP 10 PRODUCTOS MÁS VENDIDOS</h1>
        <p>Ranking de productos con mayor demanda en el mercado</p>
        <div class="report-meta">
            <span><i class="fas fa-calendar-alt"></i> {{ now()->format('d/m/Y') }}</span>
            <span><i class="fas fa-chart-line"></i> {{ isset($totalVendido) ? number_format($totalVendido) : 0 }} unidades vendidas en total</span>
        </div>
    </div>

    @if(isset($topProductos) && $topProductos->count() > 0)
    <div class="ranking-container">
        @foreach($topProductos as $index => $producto)
        <div class="ranking-item">
            <div class="ranking-number {{ $index < 3 ? 'top-' . ($index + 1) : '' }}">{{ $index + 1 }}</div>
            <div class="ranking-info">
                <div class="ranking-name">{{ $producto->producto_nombre ?? $producto->nombre ?? 'Producto' }}</div>
                <div class="ranking-stats">
                    <span><i class="fas fa-boxes"></i> {{ number_format($producto->total_vendido ?? 0) }} unidades</span>
                    <span><i class="fas fa-dollar-sign"></i> {{ number_format($producto->total_recaudado ?? 0, 2) }} Bs</span>
                </div>
            </div>
            <div class="ranking-bar">
                @php
                    $porcentaje = isset($totalVendido) && $totalVendido > 0 ? ($producto->total_vendido / $totalVendido) * 100 : 0;
                @endphp
                <div class="ranking-progress" style="width: {{ $porcentaje }}%;"></div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-chart-line"></i>
        <p>No hay datos de ventas registrados</p>
        <small>Realiza ventas para ver el ranking de productos</small>
    </div>
    @endif

    <div class="export-actions">
        <button onclick="window.print()" class="btn-print"><i class="fas fa-print"></i> Imprimir</button>
    </div>
</div>

@push('styles')
<style>
    .report-container {
        max-width: 1000px;
        margin: 0 auto;
        background: white;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #E8ECEF;
    }

    .report-header {
        text-align: center;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 2px solid #E04545;
    }

    .report-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 8px;
    }

    .report-header p {
        color: #6B7280;
        font-size: 0.85rem;
        margin-bottom: 12px;
    }

    .report-meta {
        display: flex;
        justify-content: center;
        gap: 24px;
        font-size: 0.75rem;
        color: #6B7280;
    }

    .report-meta i {
        margin-right: 6px;
        color: #E04545;
    }

    .ranking-container {
        margin-top: 24px;
    }

    .ranking-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        margin-bottom: 12px;
        transition: all 0.2s;
    }

    .ranking-item:hover {
        transform: translateX(5px);
        border-color: #E04545;
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .ranking-number {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F3F4F6;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.2rem;
        color: #4B5563;
    }

    .ranking-number.top-1 {
        background: linear-gradient(135deg, #FFD700, #FFA500);
        color: #B45309;
    }

    .ranking-number.top-2 {
        background: linear-gradient(135deg, #C0C0C0, #A8A8A8);
        color: #4B5563;
    }

    .ranking-number.top-3 {
        background: linear-gradient(135deg, #CD7F32, #B87333);
        color: white;
    }

    .ranking-info {
        flex: 1;
    }

    .ranking-name {
        font-weight: 600;
        color: #1F2937;
        margin-bottom: 6px;
    }

    .ranking-stats {
        display: flex;
        gap: 16px;
        font-size: 0.7rem;
        color: #6B7280;
    }

    .ranking-stats i {
        margin-right: 4px;
        width: 14px;
    }

    .ranking-bar {
        width: 200px;
        height: 8px;
        background: #E5E7EB;
        border-radius: 4px;
        overflow: hidden;
    }

    .ranking-progress {
        height: 100%;
        background: linear-gradient(90deg, #E04545, #F59E0B);
        border-radius: 4px;
        transition: width 0.5s ease;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9CA3AF;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .empty-state small {
        font-size: 0.75rem;
    }

    .export-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid #E8ECEF;
    }

    .btn-print {
        background: #F3F4F6;
        color: #4B5563;
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

    .btn-print:hover {
        background: #E5E7EB;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .report-container {
            padding: 20px;
        }

        .report-header h1 {
            font-size: 1.2rem;
        }

        .ranking-item {
            flex-wrap: wrap;
        }

        .ranking-bar {
            width: 100%;
            margin-top: 10px;
        }

        .ranking-stats {
            flex-wrap: wrap;
            gap: 12px;
        }

        .report-meta {
            flex-direction: column;
            gap: 8px;
            align-items: center;
        }
    }

    @media print {
        .sidebar, .top-bar, .export-actions, .form-actions {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        .report-container {
            box-shadow: none;
            padding: 0;
        }
    }
</style>
@endpush
@endsection