@extends('layouts.cliente-layout')

@section('title', 'Detalle de Compra #' . $venta->codVenta . ' - BODY FIT')

@section('content')
<div class="detalle-container">
    <div class="page-header">
        <a href="{{ route('cliente.mis-compras') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver a Mis Compras
        </a>
        <h1 class="page-title">Detalle de Compra</h1>
        <p class="page-description">Información completa de tu pedido</p>
    </div>

    <div class="detalle-card">
        <!-- Encabezado del pedido -->
        <div class="pedido-header">
            <div class="pedido-number">
                <span class="label">Número de pedido</span>
                <span class="value">#{{ $venta->codVenta }}</span>
            </div>
            <div class="pedido-date">
                <span class="label">Fecha de compra</span>
                <span class="value">{{ date('d/m/Y H:i', strtotime($venta->fechaVenta)) }}</span>
            </div>
            <div class="pedido-total">
                <span class="label">Total</span>
                <span class="value">{{ number_format($venta->montoTotal, 2) }} Bs</span>
            </div>
        </div>

        <!-- Resumen del pedido -->
        <div class="resumen-section">
            <h3 class="section-title">
                <i class="fas fa-boxes"></i> Productos
            </h3>
            <div class="productos-table">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </thead>
                    </thead>
                    <tbody>
                        @foreach($venta->detalles as $detalle)
                        <tr class="producto-row">
                            <td>
                                <div class="producto-info">
                                    <div class="producto-nombre">{{ $detalle->producto->nombre ?? 'Producto' }}</div>
                                    @if($detalle->producto && $detalle->producto->codProducto)
                                        <div class="producto-codigo">Código: {{ $detalle->producto->codProducto }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">{{ $detalle->cantidad }}</td>
                            <td class="text-center">{{ number_format($detalle->precioVenta, 2) }} Bs</td>
                            <td class="text-right">{{ number_format($detalle->cantidad * $detalle->precioVenta, 2) }} Bs</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="subtotal-row">
                            <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                            <td class="text-right">{{ number_format($venta->montoTotal - 15, 2) }} Bs</td>
                        </tr>
                        <tr class="envio-row">
                            <td colspan="3" class="text-right"><strong>Envío:</strong></td>
                            <td class="text-right">15.00 Bs</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="3" class="text-right"><strong>TOTAL:</strong></td>
                            <td class="text-right total">{{ number_format($venta->montoTotal, 2) }} Bs</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="info-adicional">
            <div class="info-card">
                <i class="fas fa-truck"></i>
                <div>
                    <h4>Estado del pedido</h4>
                    <p class="estado entregado">
                        <i class="fas fa-check-circle"></i> Entregado
                    </p>
                </div>
            </div>
            <div class="info-card">
                <i class="fas fa-credit-card"></i>
                <div>
                    <h4>Método de pago</h4>
                    <p>Transferencia bancaria / QR</p>
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="acciones">
            <a href="{{ route('cliente.productos') }}" class="btn-comprar">
                <i class="fas fa-shopping-bag"></i> Seguir comprando
            </a>
            <button onclick="window.print()" class="btn-imprimir">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>
</div>

@push('styles')
<style>
    .detalle-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .page-header {
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

    .detalle-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        overflow: hidden;
    }

    /* Encabezado del pedido */
    .pedido-header {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 24px;
        background: linear-gradient(135deg, #FFF5F5 0%, #FFFFFF 100%);
        border-bottom: 1px solid #E8ECEF;
    }

    .pedido-number, .pedido-date, .pedido-total {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .pedido-number .label,
    .pedido-date .label,
    .pedido-total .label {
        font-size: 0.7rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pedido-number .value {
        font-family: monospace;
        font-size: 1.2rem;
        font-weight: 700;
        color: #E04545;
    }

    .pedido-date .value {
        font-size: 0.9rem;
        font-weight: 500;
        color: #1F2937;
    }

    .pedido-total .value {
        font-size: 1.2rem;
        font-weight: 800;
        color: #E04545;
    }

    /* Sección de productos */
    .resumen-section {
        padding: 24px;
        border-bottom: 1px solid #F3F4F6;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: #E04545;
    }

    .productos-table {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        text-align: left;
        padding: 12px;
        background: #F9FAFB;
        font-size: 0.75rem;
        font-weight: 600;
        color: #4B5563;
        border-bottom: 1px solid #E5E7EB;
    }

    .data-table tbody td {
        padding: 12px;
        border-bottom: 1px solid #F3F4F6;
        font-size: 0.85rem;
        color: #374151;
    }

    .data-table tfoot td {
        padding: 12px;
        font-size: 0.85rem;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .producto-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .producto-nombre {
        font-weight: 600;
        color: #1F2937;
    }

    .producto-codigo {
        font-size: 0.7rem;
        color: #9CA3AF;
        font-family: monospace;
    }

    .subtotal-row td,
    .envio-row td {
        color: #6B7280;
    }

    .total-row td {
        font-weight: 700;
        font-size: 1rem;
    }

    .total-row .total {
        color: #E04545;
        font-size: 1.2rem;
    }

    /* Información adicional */
    .info-adicional {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        padding: 24px;
        border-bottom: 1px solid #F3F4F6;
    }

    .info-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #F9FAFB;
        border-radius: 16px;
    }

    .info-card i {
        font-size: 1.8rem;
        color: #E04545;
    }

    .info-card h4 {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6B7280;
        margin-bottom: 4px;
    }

    .info-card p {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1F2937;
    }

    .estado.entregado {
        color: #10B981;
    }

    .estado.entregado i {
        font-size: 0.8rem;
        margin-right: 4px;
    }

    /* Acciones */
    .acciones {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        padding: 20px 24px;
        background: #F9FAFB;
    }

    .btn-comprar, .btn-imprimir {
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-comprar {
        background: #E04545;
        color: white;
        border: none;
    }

    .btn-comprar:hover {
        background: #c93a3a;
        transform: translateY(-2px);
    }

    .btn-imprimir {
        background: #F3F4F6;
        color: #4B5563;
        border: none;
    }

    .btn-imprimir:hover {
        background: #E5E7EB;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }

        .pedido-header {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .info-adicional {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .acciones {
            flex-direction: column;
        }

        .btn-comprar, .btn-imprimir {
            justify-content: center;
        }

        .data-table thead th,
        .data-table tbody td {
            padding: 8px;
        }
    }

    @media print {
        .sidebar, .top-bar, .back-link, .acciones, .header-actions {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .detalle-card {
            box-shadow: none;
            border: none;
        }
        .btn-print {
            display: none;
        }
    }
</style>
@endpush
@endsection