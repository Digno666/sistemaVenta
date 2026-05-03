@extends('layouts.encargado-layout')

@section('title', 'Compras - BODY FIT Admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Compras</h1>
        <p class="page-subtitle">Gestiona las compras realizadas a proveedores</p>
    </div>
    <a href="{{ route('compra.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Nueva Compra
    </a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Encargado</th>
                <th>Monto Total</th>
                <th>Productos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($compras as $compra)
            <tr>
                <td class="text-center">
                    <span class="badge-code">#{{ $compra->codCompra }}</span>
                </td>
                <td class="text-center">
                    <div class="date-cell">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $compra->fechaCompra_formateada }}</span>
                    </div>
                </td>
                <td>
                    <div class="cell-content">
                        <div class="cell-title">{{ $compra->proveedor->nombre ?? 'N/A' }}</div>
                    </div>
                </td>
                <td>
                    <div class="cell-content">
                        <div class="cell-subtitle">{{ $compra->encargado->nombre ?? 'N/A' }} {{ $compra->encargado->apellidoPaterno ?? '' }}</div>
                    </div>
                </td>
                <td class="text-center">
                    <span class="badge-price">{{ $compra->montoTotal_formateado }}</span>
                </td>
                <td class="text-center">
                    <span class="badge-products">
                        <i class="fas fa-boxes"></i> {{ $compra->detalles->count() }} productos
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('compra.show', $compra->codCompra) }}" class="action-icon view" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" class="action-icon delete" title="Eliminar" onclick="confirmDelete({{ $compra->codCompra }}, '#{{ $compra->codCompra }}')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <form id="delete-form-{{ $compra->codCompra }}" action="{{ route('compra.destroy', $compra->codCompra) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty-state">
                    <i class="fas fa-shopping-cart-slash"></i>
                    <p>No hay compras registradas</p>
                    <a href="{{ route('compra.create') }}" class="btn-primary-small">Registrar primera compra</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- PAGINACIÓN MINIMALISTA -->
@if($compras->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-links">
            @if($compras->onFirstPage())
                <span class="pagination-disabled"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $compras->previousPageUrl() }}" class="pagination-link"><i class="fas fa-chevron-left"></i></a>
            @endif
            <span class="pagination-info">Página {{ $compras->currentPage() }} de {{ $compras->lastPage() }}</span>
            @if($compras->hasMorePages())
                <a href="{{ $compras->nextPageUrl() }}" class="pagination-link"><i class="fas fa-chevron-right"></i></a>
            @else
                <span class="pagination-disabled"><i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
    </div>
@endif

@push('styles')
<style>
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

    .btn-primary {
        background: #E04545;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background: #c93a3a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(224, 69, 69, 0.3);
    }

    .btn-primary-small {
        background: #E04545;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        transition: all 0.2s;
    }

    .table-container {
        background: white;
        border-radius: 20px;
        overflow-x: auto;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
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
        padding: 16px 20px;
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

    .badge-price {
        display: inline-block;
        padding: 4px 10px;
        background: #ECFDF5;
        color: #065F46;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .badge-products {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: #E0F2FE;
        color: #0369A1;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .date-cell {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .date-cell i {
        color: #9CA3AF;
    }

    .cell-title {
        font-weight: 600;
        color: #1F2937;
    }

    .cell-subtitle {
        font-size: 0.75rem;
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
        cursor: pointer;
        border: none;
        background: transparent;
    }

    .action-icon.view {
        color: #3B82F6;
    }
    .action-icon.view:hover {
        background: #EFF6FF;
    }
    .action-icon.delete {
        color: #E04545;
    }
    .action-icon.delete:hover {
        background: #FEF2F2;
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
    }

    .pagination-wrapper {
        margin-top: 28px;
        display: flex;
        justify-content: center;
        padding: 16px 0 8px;
    }

    .pagination-links {
        display: flex;
        align-items: center;
        gap: 16px;
        background: white;
        padding: 6px 20px;
        border-radius: 40px;
        border: 1px solid #E5E7EB;
    }

    .pagination-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: #F9FAFB;
        color: #4B5563;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid #E5E7EB;
    }

    .pagination-link:hover {
        background: #E04545;
        border-color: #E04545;
        color: white;
    }

    .pagination-disabled {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: #F3F4F6;
        color: #9CA3AF;
        border: 1px solid #E5E7EB;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .pagination-info {
        font-size: 0.85rem;
        font-weight: 500;
        color: #4B5563;
        background: #F9FAFB;
        padding: 6px 16px;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .page-title {
            font-size: 1.5rem;
        }
        .data-table thead th,
        .data-table tbody td {
            padding: 12px 16px;
        }
        .pagination-links {
            gap: 12px;
            padding: 6px 16px;
        }
        .pagination-link,
        .pagination-disabled {
            width: 32px;
            height: 32px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(id, nombre) {
        Swal.fire({
            title: '¿Anular compra?',
            html: `<p style="font-size: 1rem;">¿Estás seguro de anular la compra <strong>${nombre}</strong>?<br>Se revertirá el stock de los productos.<br>Esta acción no se puede deshacer.</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E04545',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Sí, anular',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: { popup: 'swal2-popup-custom' }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Anulando...', text: 'Por favor espera', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@endpush
@endsection