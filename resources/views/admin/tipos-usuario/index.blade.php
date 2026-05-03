@extends('layouts.admin-layout')

@section('title', 'Tipos de Usuario - BODY FIT Admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tipos de Usuario</h1>
        <p class="page-subtitle">Gestiona los roles y tipos de usuario del sistema</p>
    </div>
    <a href="{{ route('tipos-usuario.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Nuevo Tipo
    </a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Usuarios Asociados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tiposUsuario as $tipo)
            <tr>
                <td class="text-center">#{{ $tipo->codTipoUsuario }}</td>
                <td>
                    <div class="cell-content">
                        <div class="cell-title">{{ $tipo->nombre }}</div>
                    </div>
                </td>
                <td>
                    <div class="description-cell">
                        {{ Str::limit($tipo->descripcion, 60) }}
                    </div>
                </td>
                <td class="text-center">
                    <span class="badge {{ $tipo->usuarios_count > 0 ? 'badge-info' : 'badge-secondary' }}">
                        {{ $tipo->usuarios_count }} usuarios
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('tipos-usuario.show', $tipo->codTipoUsuario) }}" class="action-icon view" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('tipos-usuario.edit', $tipo->codTipoUsuario) }}" class="action-icon edit" title="Editar">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button type="button" class="action-icon delete" title="Eliminar" onclick="confirmDelete({{ $tipo->codTipoUsuario }}, '{{ $tipo->nombre }}', {{ $tipo->usuarios_count }})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <form id="delete-form-{{ $tipo->codTipoUsuario }}" action="{{ route('tipos-usuario.destroy', $tipo->codTipoUsuario) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <p>No hay tipos de usuario registrados</p>
                    <a href="{{ route('ipos-usuario.create') }}" class="btn-primary-small">Crear primer tipo</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-container">
    {{ $tiposUsuario->links() }}
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
        min-width: 650px;
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

    .description-cell {
        max-width: 300px;
        color: #6B7280;
        line-height: 1.4;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-info {
        background: #E0F2FE;
        color: #0369A1;
    }

    .badge-secondary {
        background: #F3F4F6;
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
    // Función para confirmar eliminación con SweetAlert2
    function confirmDelete(id, nombre, usuariosCount) {
        let warningMessage = '';
        let confirmButtonText = 'Sí, eliminar';
        
        if (usuariosCount > 0) {
            warningMessage = `⚠️ Este tipo de usuario tiene ${usuariosCount} usuario(s) asociado(s). ¿Estás seguro de que deseas eliminarlo?`;
            confirmButtonText = 'Sí, eliminar de todas formas';
        } else {
            warningMessage = `¿Estás seguro de eliminar el tipo "${nombre}"? Esta acción no se puede deshacer.`;
        }
        
        Swal.fire({
            title: '¿Eliminar tipo de usuario?',
            html: `<p style="font-size: 1rem;">${warningMessage}</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E04545',
            cancelButtonColor: '#6B7280',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Eliminando...',
                    text: 'Por favor espera',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Enviar el formulario
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
    
    // Estilos personalizados para SweetAlert2
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
        .swal2-timer-progress-bar {
            background: #E04545 !important;
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
@endsection 