@extends('layouts.encargado-layout')

@section('title', 'Reporte de Compras - BODY FIT Admin')

@section('content')
<div class="report-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Reporte de Compras</h1>
            <p class="page-subtitle">Historial detallado de todas las compras realizadas</p>
        </div>
        <a href="{{ route('reportes.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- Filtros -->
    <div class="filters-card">
        <form method="GET" action="{{ route('reportes.compras') }}" class="filters-form">
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
                    <label><i class="fas fa-building"></i> Proveedor</label>
                    <select name="codProveedor" class="form-control">
                        <option value="">Todos los proveedores</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->codProveedor }}" {{ request('codProveedor') == $proveedor->codProveedor ? 'selected' : '' }}>
                                {{ $proveedor->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group filter-actions">
                    <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Filtrar</button>
                    <a href="{{ route('reportes.compras') }}" class="btn-clear"><i class="fas fa-eraser"></i> Limpiar</a>
                </div>
            </div>
        </form>
        <div class="resumen-filtros">
            <div class="resumen-item">
                <span class="resumen-label">Total de Compras:</span>
                <span class="resumen-valor">{{ $totalCompras }}</span>
            </div>
            <div class="resumen-item">
                <span class="resumen-label">Monto Total:</span>
                <span class="resumen-valor">{{ number_format($montoTotal, 2) }} Bs</span>
            </div>
        </div>
    </div>

    <!-- Tabla de Compras -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Encargado</th>
                    <th>Productos</th>
                    <th>Monto Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compras as $compra)
                <tr class="table-row">
                    <td class="text-center"><span class="badge-code">#{{ $compra->codCompra }}</span></td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($compra->fechaCompra)) }}</td>
                    <td>{{ $compra->proveedor->nombre ?? 'N/A' }}</td>
                    <td>{{ $compra->encargado->nombre ?? 'N/A' }} {{ $compra->encargado->apellidoPaterno ?? '' }}</td>
                    <td class="text-center">{{ $compra->detalles->count() }}</td>
                    <td class="text-center"><span class="amount">{{ number_format($compra->montoTotal, 2) }} Bs</span></td>
                    <td class="text-center">
                        <a href="{{ route('compra.show', $compra->codCompra) }}" class="action-icon view" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="fas fa-shopping-cart-slash"></i>
                        <p>No hay compras registradas con los filtros seleccionados</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $compras->appends(request()->query())->links() }}
    </div>
</div>

@push('styles')
<style>
    .report-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 4px;
    }

    .page-subtitle {
        color: #6B7280;
        font-size: 0.9rem;
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

    /* Filtros */
    .filters-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid #E8ECEF;
    }

    .filters-form .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        align-items: end;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #4B5563;
    }

    .form-group label i {
        margin-right: 4px;
        width: 16px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #E5E7EB;
        border-radius: 12px;
        font-size: 0.85rem;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
    }

    .form-control:focus {
        outline: none;
        border-color: #E04545;
        box-shadow: 0 0 0 3px rgba(224, 69, 69, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 10px;
    }

    .btn-filter {
        background: #E04545;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-filter:hover {
        background: #c93a3a;
        transform: translateY(-1px);
    }

    .btn-clear {
        background: #F3F4F6;
        color: #4B5563;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-clear:hover {
        background: #E5E7EB;
    }

    .resumen-filtros {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #F3F4F6;
        display: flex;
        gap: 32px;
    }

    .resumen-item {
        display: flex;
        gap: 8px;
        align-items: baseline;
    }

    .resumen-label {
        font-size: 0.85rem;
        color: #6B7280;
    }

    .resumen-valor {
        font-size: 1.2rem;
        font-weight: 700;
        color: #E04545;
    }

    /* Tabla */
    .table-container {
        background: white;
        border-radius: 20px;
        overflow-x: auto;
        border: 1px solid #E8ECEF;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
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
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background: #F9FAFB;
    }

    .text-center {
        text-align: center;
    }

    .badge-code {
        display: inline-block;
        padding: 4px 10px;
        background: #F3F4F6;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #4B5563;
        font-family: monospace;
    }

    .amount {
        font-weight: 700;
        color: #E04545;
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

    .empty-state {
        text-align: center;
        padding: 60px 20px !important;
        color: #9CA3AF;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
        display: block;
    }

    .empty-state p {
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    /* Paginación */
    .pagination-container {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .filters-form .form-row {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .resumen-filtros {
            flex-direction: column;
            gap: 12px;
        }

        .data-table thead th,
        .data-table tbody td {
            padding: 12px 16px;
        }
    }
</style>
@endpush
@endsection