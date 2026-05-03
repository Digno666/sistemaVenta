@extends('layouts.encargado-layout')

@section('title', 'Proveedores - BODY FIT Admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Proveedores</h1>
        <p class="page-subtitle">Gestiona los proveedores del sistema</p>
    </div>
    <a href="{{ route('proveedor.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Nuevo Proveedor
    </a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proveedores as $proveedor)
            <tr>
                <td class="text-center">
                    <span class="badge-code">#{{ $proveedor->codProveedor }}</span>
                </td>
                <td>
                    <div class="cell-content">
                        <div class="cell-title">{{ $proveedor->nombre }}</div>
                    </div>
                </td>
                <td>
                    <div class="address-cell">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ Str::limit($proveedor->direccion, 60) }}</span>
                    </div>
                </td>
                <td>
                    <div class="phone-cell">
                        <i class="fas fa-phone"></i>
                        <span>{{ $proveedor->telefono }}</span>
                    </div>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('proveedor.show', $proveedor->codProveedor) }}" class="action-icon view" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('proveedor.edit', $proveedor->codProveedor) }}" class="action-icon edit" title="Editar">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button type="button" class="action-icon delete" title="Eliminar" onclick="confirmDelete({{ $proveedor->codProveedor }}, '{{ $proveedor->nombre }}')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <form id="delete-form-{{ $proveedor->codProveedor }}" action="{{ route('proveedor.destroy', $proveedor->codProveedor) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="empty-state">
                    <i class="fas fa-truck-slash"></i>
                    <p>No hay proveedores registrados</p>
                    <a href="{{ route('proveedor.create') }}" class="btn-primary-small">Crear primer proveedor</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- PAGINACIÓN MINIMALISTA SOLO CON FLECHAS -->
@if($proveedores->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-links">
            {{-- Flecha Anterior --}}
            @if($proveedores->onFirstPage())
                <span class="pagination-disabled">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $proveedores->previousPageUrl() }}" class="pagination-link">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Página actual / Total --}}
            <span class="pagination-info">
                Página {{ $proveedores->currentPage() }} de {{ $proveedores->lastPage() }}
            </span>

            {{-- Flecha Siguiente --}}
            @if($proveedores->hasMorePages())
                <a href="{{ $proveedores->nextPageUrl() }}" class="pagination-link">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="pagination-disabled">
                    <i class="fas fa-chevron-right"></i>
                </span>
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

    .btn-primary-small:hover {
        background: #c93a3a;
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
        min-width: 700px;
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

    .cell-title {
        font-weight: 600;
        color: #1F2937;
    }

    .address-cell, .phone-cell {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .address-cell i, .phone-cell i {
        color: #9CA3AF;
        width: 16px;
        font-size: 0.85rem;
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
    .action-icon.edit {
        color: #F59E0B;
    }
    .action-icon.edit:hover {
        background: #FFFBEB;
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

    .empty-state p {
        margin-bottom: 16px;
        font-size: 0.9rem;
    }

    /* ========== PAGINACIÓN MINIMALISTA ========== */
    .pagination-wrapper {
        margin-top: 28px;
        display: flex;
        justify-content: center;
        align-items: center;
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
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
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

    .pagination-link i {
        font-size: 0.85rem;
    }

    .pagination-link:hover {
        background: #E04545;
        border-color: #E04545;
        color: white;
        transform: scale(1.05);
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

    .pagination-disabled i {
        font-size: 0.85rem;
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
        .table-container {
            border-radius: 16px;
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
        .pagination-info {
            font-size: 0.75rem;
            padding: 4px 12px;
        }
    }

    @media (max-width: 480px) {
        .pagination-links {
            gap: 10px;
            padding: 4px 12px;
        }
        .pagination-link,
        .pagination-disabled {
            width: 30px;
            height: 30px;
        }
        .pagination-info {
            font-size: 0.7rem;
            padding: 3px 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(id, nombre) {
        Swal.fire({
            title: '¿Eliminar proveedor?',
            html: `<p style="font-size: 1rem;">¿Estás seguro de eliminar al proveedor <strong>${nombre}</strong>?<br>Esta acción no se puede deshacer.</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E04545',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Eliminando...',
                    text: 'Por favor espera',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
    
    const style = document.createElement('style');
    style.textContent = `
        .swal2-popup-custom {
            font-family: 'Inter', sans-serif;
            border-radius: 20px !important;
        }
        .swal2-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: #1F2937 !important;
        }
        .swal2-html-container {
            font-size: 0.9rem !important;
            color: #4B5563 !important;
        }
        .swal2-confirm {
            border-radius: 12px !important;
            font-weight: 600 !important;
            padding: 10px 24px !important;
        }
        .swal2-cancel {
            border-radius: 12px !important;
            font-weight: 600 !important;
            padding: 10px 24px !important;
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
@endsection