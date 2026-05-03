@extends('layouts.cliente-layout')

@section('title', 'Mis Compras - BODY FIT')

@section('content')
<div class="mis-compras-container">
    <div class="page-header">
        <h1 class="page-title">Mis Compras</h1>
        <p class="page-description">Historial de todas tus compras realizadas</p>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($ventas->count() > 0)
        <div class="compras-list">
            @foreach($ventas as $venta)
            <div class="compra-card">
                <div class="compra-header">
                    <div class="compra-info">
                        <span class="compra-code">#{{ $venta->codVenta }}</span>
                        <span class="compra-date">
                            <i class="fas fa-calendar-alt"></i> {{ date('d/m/Y', strtotime($venta->fechaVenta)) }}
                        </span>
                    </div>
                    <div class="compra-total">
                        <span class="total-label">Total:</span>
                        <span class="total-value">{{ number_format($venta->montoTotal, 2) }} Bs</span>
                    </div>
                </div>
                
                <div class="compra-body">
                    <div class="productos-lista">
                        @foreach($venta->detalles as $detalle)
                        <div class="producto-item">
                            <div class="producto-info">
                                <div class="producto-nombre">{{ $detalle->producto->nombre ?? 'Producto' }}</div>
                                <div class="producto-detalle">
                                    <span>Cantidad: {{ $detalle->cantidad }}</span>
                                    <span>Precio unitario: {{ number_format($detalle->precioVenta, 2) }} Bs</span>
                                </div>
                            </div>
                            <div class="producto-subtotal">
                                {{ number_format($detalle->cantidad * $detalle->precioVenta, 2) }} Bs
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="compra-footer">
                    <a href="{{ route('cliente.mis-compras.detalle', $venta->codVenta) }}" class="btn-view-details">
                        <i class="fas fa-eye"></i> Ver detalle
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-container">
            {{ $ventas->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-shopping-bag"></i>
            <p>No has realizado ninguna compra aún</p>
            <a href="{{ route('cliente.productos') }}" class="btn-shop">Explorar productos</a>
        </div>
    @endif
</div>

@push('styles')
<style>
    .mis-compras-container {
        max-width: 1000px;
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

    /* Alertas */
    .alert-success, .alert-error {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.85rem;
    }

    .alert-success {
        background: #ECFDF5;
        color: #065F46;
        border-left: 4px solid #10B981;
    }

    .alert-error {
        background: #FEF2F2;
        color: #991B1B;
        border-left: 4px solid #E04545;
    }

    /* Tarjetas de compra */
    .compras-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .compra-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E8ECEF;
        overflow: hidden;
        transition: all 0.2s;
    }

    .compra-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .compra-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: #F9FAFB;
        border-bottom: 1px solid #E8ECEF;
        flex-wrap: wrap;
        gap: 12px;
    }

    .compra-info {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .compra-code {
        font-family: monospace;
        font-weight: 700;
        color: #E04545;
        background: rgba(224, 69, 69, 0.1);
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.8rem;
    }

    .compra-date {
        font-size: 0.8rem;
        color: #6B7280;
    }

    .compra-date i {
        margin-right: 6px;
    }

    .compra-total {
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .total-label {
        font-size: 0.75rem;
        color: #6B7280;
    }

    .total-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #E04545;
    }

    .compra-body {
        padding: 16px 20px;
    }

    .productos-lista {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .producto-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #F3F4F6;
    }

    .producto-item:last-child {
        border-bottom: none;
    }

    .producto-info {
        flex: 1;
    }

    .producto-nombre {
        font-weight: 600;
        color: #1F2937;
        margin-bottom: 4px;
    }

    .producto-detalle {
        display: flex;
        gap: 16px;
        font-size: 0.7rem;
        color: #6B7280;
    }

    .producto-subtotal {
        font-weight: 700;
        color: #1F2937;
        font-size: 0.85rem;
    }

    .compra-footer {
        padding: 12px 20px;
        border-top: 1px solid #E8ECEF;
        text-align: right;
    }

    .btn-view-details {
        background: none;
        border: none;
        color: #3B82F6;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-view-details:hover {
        color: #E04545;
        gap: 10px;
    }

    /* Estado vacío */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
    }

    .empty-state i {
        font-size: 3.5rem;
        color: #9CA3AF;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state p {
        color: #6B7280;
        margin-bottom: 20px;
    }

    .btn-shop {
        background: #E04545;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-shop:hover {
        background: #c93a3a;
        transform: translateY(-2px);
    }

    /* Paginación */
    .pagination-container {
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }
        .compra-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .compra-info {
            flex-wrap: wrap;
        }
        .producto-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        .producto-subtotal {
            align-self: flex-end;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function viewDetails(codVenta) {
        Swal.fire({
            title: 'Detalle de Compra',
            html: '<div class="detail-loading">Cargando detalles...</div>',
            confirmButtonColor: '#E04545',
            width: '500px'
        });
        
        // Aquí puedes cargar más detalles vía AJAX si lo deseas
        // Por ahora solo mostramos un modal con la información básica
        Swal.fire({
            title: 'Compra #' + codVenta,
            text: 'Para ver más detalles, consulta el resumen de tu compra.',
            icon: 'info',
            confirmButtonColor: '#E04545'
        });
    }
</script>
@endpush
@endsection