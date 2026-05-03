@extends('layouts.encargado-layout')

@section('title', 'Reporte de Ventas - BODY FIT Admin')

@section('content')
<div class="report-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Reporte de Ventas</h1>
            <p class="page-subtitle">Historial detallado de todas las ventas realizadas</p>
        </div>
        <a href="{{ route('reportes.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- Filtros -->
    <div class="filters-card">
        <form method="GET" action="{{ route('reportes.ventas') }}" class="filters-form">
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Fecha Desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Cliente</label>
                    <select name="codCliente" class="form-control">
                        <option value="">Todos los clientes</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->carnetIdentidad }}" {{ request('codCliente') == $cliente->carnetIdentidad ? 'selected' : '' }}>
                                {{ $cliente->nombre }} {{ $cliente->apellidoPaterno }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group filter-actions">
                    <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Filtrar</button>
                    <a href="{{ route('reportes.ventas') }}" class="btn-clear"><i class="fas fa-eraser"></i> Limpiar</a>
                </div>
            </div>
        </form>
        <div class="resumen-filtros">
            <div class="resumen-item">
                <span class="resumen-label">Total de Ventas:</span>
                <span class="resumen-valor">{{ $totalVentas }}</span>
            </div>
            <div class="resumen-item">
                <span class="resumen-label">Monto Total:</span>
                <span class="resumen-valor">{{ number_format($montoTotal, 2) }} Bs</span>
            </div>
        </div>
    </div>

    <!-- Tabla de Ventas -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Encargado</th>
                    <th>Productos</th>
                    <th>Monto Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                <tr>
                    <td class="text-center">#{{ $venta->codVenta }}</td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($venta->fechaVenta)) }}</td>
                    <td>{{ $venta->cliente->nombre ?? 'N/A' }} {{ $venta->cliente->apellidoPaterno ?? '' }}</td>
                    <td>{{ $venta->encargado->nombre ?? 'N/A' }} {{ $venta->encargado->apellidoPaterno ?? '' }}</td>
                    <td class="text-center">{{ $venta->detalles->count() }}</td>
                    <td class="text-center">{{ number_format($venta->montoTotal, 2) }} Bs</td>
                    <td class="text-center">
                        <a href="{{ route('venta.show', $venta->codVenta) }}" class="action-icon view">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="fas fa-receipt"></i>
                        <p>No hay ventas registradas con los filtros seleccionados</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $ventas->appends(request()->query())->links() }}
    </div>
</div>

@push('styles')
<style>
    .report-container { max-width: 1400px; margin: 0 auto; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px; }
    .page-title { font-size: 1.8rem; font-weight: 700; color: #1F2937; margin-bottom: 4px; }
    .page-subtitle { color: #6B7280; font-size: 0.9rem; }
    .back-link { display: inline-flex; align-items: center; gap: 8px; color: #6B7280; text-decoration: none; font-size: 0.85rem; }
    .back-link:hover { color: #E04545; }
    
    .filters-card { background: white; border-radius: 20px; padding: 24px; margin-bottom: 24px; border: 1px solid #E8ECEF; }
    .filters-form .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; align-items: end; }
    .form-group label { display: block; margin-bottom: 6px; font-size: 0.75rem; font-weight: 600; color: #4B5563; }
    .form-group label i { width: 16px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #E5E7EB; border-radius: 12px; font-size: 0.85rem; transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: #E04545; box-shadow: 0 0 0 3px rgba(224,69,69,0.1); }
    .filter-actions { display: flex; gap: 10px; }
    .btn-filter { background: #E04545; color: white; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
    .btn-filter:hover { background: #c93a3a; transform: translateY(-1px); }
    .btn-clear { background: #F3F4F6; color: #4B5563; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
    .btn-clear:hover { background: #E5E7EB; }
    
    .resumen-filtros { margin-top: 20px; padding-top: 20px; border-top: 1px solid #F3F4F6; display: flex; gap: 32px; }
    .resumen-item { display: flex; gap: 8px; align-items: baseline; }
    .resumen-label { font-size: 0.85rem; color: #6B7280; }
    .resumen-valor { font-size: 1.2rem; font-weight: 700; color: #E04545; }
    
    .table-container { background: white; border-radius: 20px; overflow-x: auto; border: 1px solid #E8ECEF; }
    .data-table { width: 100%; border-collapse: collapse; min-width: 800px; }
    .data-table thead th { text-align: left; padding: 16px 20px; background: #F9FAFB; font-weight: 600; font-size: 0.85rem; color: #4B5563; border-bottom: 1px solid #E8ECEF; }
    .data-table tbody td { padding: 14px 20px; border-bottom: 1px solid #F3F4F6; font-size: 0.85rem; color: #374151; }
    .data-table tbody tr:hover { background: #F9FAFB; }
    .text-center { text-align: center; }
    .action-icon { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; color: #3B82F6; transition: all 0.2s; }
    .action-icon:hover { background: #EFF6FF; }
    .empty-state { text-align: center; padding: 60px 20px !important; color: #9CA3AF; }
    .empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.5; }
    .pagination-container { margin-top: 24px; display: flex; justify-content: flex-end; }
    
    @media (max-width: 768px) {
        .filters-form .form-row { grid-template-columns: 1fr; }
        .page-title { font-size: 1.5rem; }
        .resumen-filtros { flex-direction: column; gap: 12px; }
    }
</style>
@endpush
@endsection