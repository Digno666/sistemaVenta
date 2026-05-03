@extends('layouts.encargado-layout')

@section('title', 'Detalle Compra - BODY FIT Admin')

@section('content')
<div class="detail-container">
    <div class="detail-header">
        <a href="{{ route('compra.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
        <div class="detail-actions">
            <button type="button" class="btn-delete" onclick="confirmDelete({{ $compra->codCompra }}, '#{{ $compra->codCompra }}')">
                <i class="fas fa-trash-alt"></i> Anular Compra
            </button>
            <form id="delete-form-{{ $compra->codCompra }}" action="{{ route('compra.destroy', $compra->codCompra) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-header-info">
            <div class="detail-icon"><i class="fas fa-shopping-cart"></i></div>
            <h1 class="detail-title">Compra #{{ $compra->codCompra }}</h1>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <span class="info-label"><i class="fas fa-calendar-alt"></i> Fecha</span>
                <span class="info-value">{{ $compra->fechaCompra_formateada }}</span>
            </div>
            <div class="info-item">
                <span class="info-label"><i class="fas fa-building"></i> Proveedor</span>
                <span class="info-value">{{ $compra->proveedor->nombre ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label"><i class="fas fa-user-tie"></i> Encargado</span>
                <span class="info-value">{{ $compra->encargado->nombre ?? 'N/A' }} {{ $compra->encargado->apellidoPaterno ?? '' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label"><i class="fas fa-dollar-sign"></i> Monto Total</span>
                <span class="info-value total">{{ $compra->montoTotal_formateado }}</span>
            </div>
        </div>

        <div class="detail-table">
            <h3 class="table-title"><i class="fas fa-boxes"></i> Productos de la Compra</h3>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>Código</th><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody>
                        @foreach($compra->detalles as $detalle)
                        <tr>
                            <td><span class="badge-code">{{ $detalle->codProducto }}</span></td>
                            <td>{{ $detalle->producto->nombre ?? 'N/A' }}</td>
                            <td class="text-center">{{ number_format($detalle->cantidad) }}</td>
                            <td class="text-center">{{ $detalle->precioCompra_formateado }}</td>
                            <td class="text-center">{{ 'Bs ' . number_format($detalle->subtotal, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><th colspan="4" class="text-right">TOTAL</th><th class="total-footer">{{ $compra->montoTotal_formateado }}</th></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .detail-container { max-width: 1000px; margin: 0 auto; }
    .detail-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px; }
    .back-link { display: inline-flex; align-items: center; gap: 8px; color: #6B7280; text-decoration: none; font-size: 0.85rem; }
    .back-link:hover { color: #E04545; }
    .btn-delete { background: #FEF2F2; color: #E04545; border: none; padding: 8px 18px; border-radius: 10px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-delete:hover { background: #FEE2E2; transform: translateY(-1px); }
    .detail-card { background: white; border-radius: 24px; padding: 32px; border: 1px solid #E8ECEF; }
    .detail-header-info { text-align: center; margin-bottom: 32px; }
    .detail-icon { width: 70px; height: 70px; background: linear-gradient(135deg, rgba(224,69,69,0.1), rgba(224,69,69,0.05)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
    .detail-icon i { font-size: 2rem; color: #E04545; }
    .detail-title { font-size: 1.8rem; font-weight: 700; color: #1F2937; margin: 0; }
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px; padding: 20px; background: #F9FAFB; border-radius: 20px; }
    .info-item { display: flex; flex-direction: column; gap: 8px; }
    .info-label { font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px; }
    .info-label i { width: 16px; }
    .info-value { font-size: 1rem; font-weight: 600; color: #1F2937; }
    .info-value.total { color: #E04545; font-size: 1.2rem; }
    .table-title { font-size: 1.1rem; font-weight: 600; color: #374151; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .table-container { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead th { text-align: left; padding: 12px 16px; background: #F9FAFB; font-weight: 600; font-size: 0.8rem; color: #4B5563; border-bottom: 1px solid #E8ECEF; }
    .data-table tbody td { padding: 12px 16px; border-bottom: 1px solid #F3F4F6; font-size: 0.85rem; }
    .data-table tfoot th { padding: 12px 16px; font-weight: 600; background: #F9FAFB; }
    .data-table tfoot .total-footer { font-size: 1rem; font-weight: 700; color: #E04545; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .badge-code { display: inline-block; padding: 4px 10px; background: #F3F4F6; border-radius: 8px; font-size: 0.7rem; font-weight: 600; font-family: monospace; }
    @media (max-width: 768px) {
        .detail-card { padding: 24px; }
        .detail-title { font-size: 1.5rem; }
        .info-grid { grid-template-columns: 1fr; gap: 12px; }
        .data-table thead th, .data-table tbody td { padding: 10px 12px; }
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(id, nombre) {
        Swal.fire({
            title: '¿Anular compra?',
            html: `<p>¿Estás seguro de anular la compra <strong>${nombre}</strong>?<br>Se revertirá el stock de los productos.<br>Esta acción no se puede deshacer.</p>`,
            icon: 'warning', showCancelButton: true, confirmButtonColor: '#E04545', cancelButtonColor: '#6B7280',
            confirmButtonText: 'Sí, anular', cancelButtonText: 'Cancelar', reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) { Swal.fire({ title: 'Anulando...', allowOutsideClick: false, didOpen: () => Swal.showLoading() }); document.getElementById(`delete-form-${id}`).submit(); }
        });
    }
</script>
@endpush
@endsection