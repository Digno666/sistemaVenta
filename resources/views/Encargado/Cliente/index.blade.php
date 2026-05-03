@extends('layouts.encargado-layout')

@section('title', 'Clientes - BODY FIT Admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Clientes</h1>
        <p class="page-subtitle">Gestiona los clientes del sistema</p>
    </div>
    <a href="{{ route('cliente.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Nuevo Cliente
    </a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Carnet de Identidad</th>
                <th>Nombre Completo</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Celular</th>
                <th>Usuario Asociado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
            <tr>
                <td class="text-center">{{ ($cliente->carnetIdentidad) }}</td>
                <td>
                    <div class="cell-content">
                        <div class="cell-title">{{ $cliente->nombre_completo }}</div>
                    </div>
                </td>
                <td class="text-center">{{ $cliente->edad }} años</td>
                <td class="text-center">
                    <span class="badge {{ $cliente->sexo == 'M' ? 'badge-male' : 'badge-female' }}">
                        <i class="fas {{ $cliente->sexo == 'M' ? 'fa-mars' : 'fa-venus' }}"></i>
                        {{ $cliente->sexo_formateado }}
                    </span>
                </td>
                <td>
                    <div class="contact-cell">
                        <i class="fas fa-mobile-alt"></i> {{ $cliente->celular }}
                    </div>
                </td>
                <td>
                    <div class="user-cell">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ $cliente->usuario->name ?? 'No asignado' }}</span>
                    </div>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('cliente.show', $cliente->carnetIdentidad) }}" class="action-icon view" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('cliente.edit', $cliente->carnetIdentidad) }}" class="action-icon edit" title="Editar">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button type="button" class="action-icon delete" title="Eliminar" onclick="confirmDelete({{ $cliente->carnetIdentidad }}, '{{ $cliente->nombre_completo }}')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <form id="delete-form-{{ $cliente->carnetIdentidad }}" action="{{ route('cliente.destroy', $cliente->carnetIdentidad) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                 </td>
             </tr>
            @empty
             <tr>
                <td colspan="7" class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <p>No hay clientes registrados</p>
                    <a href="{{ route('cliente.create') }}" class="btn-primary-small">Crear primer cliente</a>
                 </td>
             </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-container">
    {{ $clientes->links() }}
</div>

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

    .cell-title {
        font-weight: 600;
        color: #1F2937;
    }

    .contact-cell, .user-cell {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-cell i, .user-cell i {
        color: #9CA3AF;
        width: 16px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-male {
        background: #DBEAFE;
        color: #1E40AF;
    }

    .badge-female {
        background: #FCE7F3;
        color: #BE185D;
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

    .pagination-container {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
    }

    .pagination-container nav {
        display: inline-flex;
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
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(id, nombre) {
        Swal.fire({
            title: '¿Eliminar cliente?',
            html: `<p style="font-size: 1rem;">¿Estás seguro de eliminar a <strong>${nombre}</strong>?<br>Esta acción no se puede deshacer.</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E04545',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
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
</script>
@endpush
@endsection