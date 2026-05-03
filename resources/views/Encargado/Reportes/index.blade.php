@extends('layouts.encargado-layout')

@section('title', 'Reportes - BODY FIT Admin')

@section('content')
<div class="reports-container">
    <!-- Encabezado -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Reportes y Estadísticas</h1>
            <p class="page-subtitle">Análisis completo de ventas, compras y productos</p>
        </div>
    </div>

    <!-- Tarjetas de resumen -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-primary">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ number_format($montoTotalVentas, 2) }} Bs</h3>
                <p class="stat-label">Total en Ventas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-success">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalVentas }}</h3>
                <p class="stat-label">Ventas Realizadas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-warning">
                <i class="fas fa-truck"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalCompras }}</h3>
                <p class="stat-label">Compras Registradas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-info">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ number_format($montoTotalCompras, 2) }} Bs</h3>
                <p class="stat-label">Total en Compras</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-danger">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ number_format($productosVendidos) }}</h3>
                <p class="stat-label">Productos Vendidos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-secondary">
                <i class="fas fa-percent"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ number_format(($montoTotalVentas - $montoTotalCompras), 2) }} Bs</h3>
                <p class="stat-label">Ganancia Estimada</p>
            </div>
        </div>
    </div>

    <!-- Gráfico de Ventas vs Compras -->
    <div class="chart-container">
        <div class="chart-header">
            <h3><i class="fas fa-chart-bar"></i> Ventas vs Compras (Últimos 12 meses)</h3>
        </div>
        <canvas id="ventasComprasChart" style="height: 350px;"></canvas>
    </div>

    <!-- Top Productos y Clientes -->
    <div class="two-columns">
        <div class="column-card">
            <h3><i class="fas fa-trophy"></i> Top 5 Productos Más Vendidos</h3>
            <div class="top-list">
                @foreach($topProductos as $index => $producto)
                <div class="top-item">
                    <div class="top-rank">{{ $index + 1 }}</div>
                    <div class="top-info">
                        <div class="top-name">{{ $producto->nombre }}</div>
                        <div class="top-stats">{{ $producto->total_vendido }} unidades vendidas</div>
                    </div>
                    <div class="top-value">{{ number_format($producto->total_vendido) }}</div>
                </div>
                @endforeach
                @if($topProductos->isEmpty())
                <div class="empty-state">No hay datos disponibles</div>
                @endif
            </div>
        </div>

        <div class="column-card">
            <h3><i class="fas fa-star"></i> Top 5 Clientes que más Gastan</h3>
            <div class="top-list">
                @foreach($topClientes as $index => $clienteData)
                <div class="top-item">
                    <div class="top-rank">{{ $index + 1 }}</div>
                    <div class="top-info">
                        <div class="top-name">{{ $clienteData->cliente->nombre ?? 'N/A' }} {{ $clienteData->cliente->apellidoPaterno ?? '' }}</div>
                        <div class="top-stats">{{ $clienteData->ventas_count ?? 0 }} compras</div>
                    </div>
                    <div class="top-value">{{ number_format($clienteData->total_gastado ?? 0, 2) }} Bs</div>
                </div>
                @endforeach
                @if($topClientes->isEmpty())
                <div class="empty-state">No hay datos disponibles</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Botones de acceso rápido -->
    <div class="quick-reports">
        <h3><i class="fas fa-file-alt"></i> Reportes Detallados</h3>
        <div class="report-buttons">
            <a href="{{ route('reportes.ventas') }}" class="btn-report">
                <i class="fas fa-chart-line"></i> Reporte de Ventas
                <span>Ver detalle completo</span>
            </a>
            <a href="{{ route('reportes.compras') }}" class="btn-report">
                <i class="fas fa-shopping-cart"></i> Reporte de Compras
                <span>Ver detalle completo</span>
            </a>
            <a href="{{ route('reportes.productos') }}" class="btn-report">
                <i class="fas fa-boxes"></i> Reporte de Productos
                <span>Inventario y stock</span>
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .reports-container { max-width: 1400px; margin: 0 auto; }
    .page-header { margin-bottom: 28px; }
    .page-title { font-size: 1.8rem; font-weight: 700; color: #1F2937; margin-bottom: 4px; }
    .page-subtitle { color: #6B7280; font-size: 0.9rem; }
    
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 32px; }
    .stat-card { background: white; border-radius: 20px; padding: 24px; display: flex; align-items: center; gap: 16px; border: 1px solid #E8ECEF; transition: all 0.2s; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
    .stat-icon { width: 55px; height: 55px; border-radius: 16px; display: flex; align-items: center; justify-content: center; }
    .stat-icon i { font-size: 1.6rem; color: white; }
    .bg-primary { background: #E04545; }
    .bg-success { background: #10B981; }
    .bg-warning { background: #F59E0B; }
    .bg-info { background: #3B82F6; }
    .bg-danger { background: #EF4444; }
    .bg-secondary { background: #8B5CF6; }
    .stat-number { font-size: 1.6rem; font-weight: 800; color: #1F2937; }
    .stat-label { font-size: 0.8rem; color: #6B7280; margin-top: 4px; }
    
    .chart-container { background: white; border-radius: 24px; padding: 24px; margin-bottom: 32px; border: 1px solid #E8ECEF; }
    .chart-header { margin-bottom: 20px; }
    .chart-header h3 { font-size: 1.1rem; font-weight: 600; color: #374151; display: flex; align-items: center; gap: 8px; }
    
    .two-columns { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 24px; margin-bottom: 32px; }
    .column-card { background: white; border-radius: 24px; padding: 24px; border: 1px solid #E8ECEF; }
    .column-card h3 { font-size: 1.1rem; font-weight: 600; color: #374151; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    
    .top-list { display: flex; flex-direction: column; gap: 12px; }
    .top-item { display: flex; align-items: center; gap: 16px; padding: 12px; background: #F9FAFB; border-radius: 14px; transition: all 0.2s; }
    .top-item:hover { background: #FEF2F2; transform: translateX(4px); }
    .top-rank { width: 32px; height: 32px; background: #E04545; color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; }
    .top-info { flex: 1; }
    .top-name { font-weight: 600; color: #1F2937; }
    .top-stats { font-size: 0.7rem; color: #6B7280; }
    .top-value { font-weight: 700; color: #E04545; }
    
    .quick-reports { background: white; border-radius: 24px; padding: 24px; border: 1px solid #E8ECEF; }
    .quick-reports h3 { font-size: 1.1rem; font-weight: 600; color: #374151; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    .report-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
    .btn-report { background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 16px; padding: 20px; text-decoration: none; transition: all 0.2s; }
    .btn-report:hover { background: #FEF2F2; border-color: #E04545; transform: translateY(-2px); }
    .btn-report i { font-size: 2rem; color: #E04545; display: block; margin-bottom: 12px; }
    .btn-report span { display: block; font-size: 0.7rem; color: #6B7280; margin-top: 6px; }
    
    .empty-state { text-align: center; padding: 40px; color: #9CA3AF; }
    
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .two-columns { grid-template-columns: 1fr; }
        .report-buttons { grid-template-columns: 1fr; }
        .page-title { font-size: 1.5rem; }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos para el gráfico
    const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    
    // Datos de ventas por mes
    @php
        $ventasPorMesArray = [];
        $comprasPorMesArray = [];
        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $mesNum = $fecha->month;
            $anio = $fecha->year;
            
            $venta = $ventasPorMes->firstWhere(function($item) use ($mesNum, $anio) {
                return $item->mes == $mesNum && $item->año == $anio;
            });
            $ventasPorMesArray[] = $venta ? floatval($venta->total) : 0;
            
            $compra = $comprasPorMes->firstWhere(function($item) use ($mesNum, $anio) {
                return $item->mes == $mesNum && $item->año == $anio;
            });
            $comprasPorMesArray[] = $compra ? floatval($compra->total) : 0;
        }
    @endphp
    
    const labels = [];
    for (let i = 11; i >= 0; i--) {
        const fecha = new Date();
        fecha.setMonth(fecha.getMonth() - i);
        labels.push(fecha.toLocaleString('es', { month: 'short' }));
    }
    
    const ctx = document.getElementById('ventasComprasChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Ventas (Bs)',
                    data: @json(array_reverse($ventasPorMesArray)),
                    borderColor: '#E04545',
                    backgroundColor: 'rgba(224, 69, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Compras (Bs)',
                    data: @json(array_reverse($comprasPorMesArray)),
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { callbacks: { label: function(context) { return context.dataset.label + ': ' + context.raw.toFixed(2) + ' Bs'; } } }
            },
            scales: { y: { beginAtZero: true, ticks: { callback: function(value) { return value.toFixed(2) + ' Bs'; } } } }
        }
    });
</script>
@endpush
@endsection