@extends('layouts.encargado-layout')

@section('title', 'Detalle del Cliente - ' . $cliente->nombre . ' ' . $cliente->apellidoPaterno)

@section('content')
<div class="cliente-show-container">
    <div class="page-header">
        <div>
            <a href="{{ route('cliente.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver a clientes
            </a>
            <h1 class="page-title">Detalle del Cliente</h1>
            <p class="page-subtitle">Información completa del cliente</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('cliente.edit', $cliente->carnetIdentidad) }}" class="btn-edit">
                <i class="fas fa-pencil-alt"></i> Editar
            </a>
            <button type="button" class="btn-delete" onclick="confirmDelete({{ $cliente->carnetIdentidad }}, '{{ $cliente->nombre }} {{ $cliente->apellidoPaterno }}')">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
            <form id="delete-form-{{ $cliente->carnetIdentidad }}" action="{{ route('cliente.destroy', $cliente->carnetIdentidad) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <div class="cliente-card">
        <div class="cliente-grid">
            <!-- Columna izquierda - Avatar -->
            <div class="cliente-avatar">
                <div class="avatar-principal">
                    <div class="avatar-circle">
                        <span>{{ strtoupper(substr($cliente->nombre, 0, 1)) }}{{ strtoupper(substr($cliente->apellidoPaterno, 0, 1)) }}</span>
                    </div>
                </div>
                <div class="info-adicional">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Registrado: {{ date('d/m/Y', strtotime($cliente->created_at ?? now())) }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-id-card"></i>
                        <span>CI: {{ number_format($cliente->carnetIdentidad, 0, '', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Información -->
            <div class="cliente-info">
                <div class="cliente-header">
                    <span class="cliente-estado {{ $cliente->usuario->bloqueado == 0 ? 'estado-activo' : 'estado-bloqueado' }}">
                        <i class="fas {{ $cliente->usuario->bloqueado == 0 ? 'fa-check-circle' : 'fa-ban' }}"></i>
                        {{ $cliente->usuario->bloqueado == 0 ? 'Activo' : 'Bloqueado' }}
                    </span>
                </div>

                <h1 class="cliente-nombre">{{ $cliente->nombre }} {{ $cliente->apellidoPaterno }} {{ $cliente->apellidoMaterno }}</h1>

                <div class="cliente-info-grid">
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-user"></i> Nombre de usuario
                        </div>
                        <div class="info-value">{{ $cliente->usuario->name ?? 'No asignado' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i> Correo electrónico
                        </div>
                        <div class="info-value">{{ $cliente->usuario->email ?? 'No asignado' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-calendar-alt"></i> Edad
                        </div>
                        <div class="info-value">{{ $cliente->edad }} años</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-venus-mars"></i> Sexo
                        </div>
                        <div class="info-value">{{ $cliente->sexo == 'M' ? 'Masculino' : 'Femenino' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-mobile-alt"></i> Teléfono / Celular
                        </div>
                        <div class="info-value">{{ $cliente->celular }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de compras del cliente -->
    <div class="compras-section">
        <div class="section-header">
            <h3 class="section-title"><i class="fas fa-shopping-bag"></i> Historial de Compras</h3>
            <a href="{{ route('venta.index') }}?cliente={{ $cliente->carnetIdentidad }}" class="btn-view-all">
                Ver todas <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        @if($compras->count() > 0)
        <div class="compras-table-container">
            <table class="compras-table">
                <thead>
                    <tr>
                        <th># Venta</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $venta)
                    <tr class="compra-row">
                        <td class="text-center">#{{ $venta->codVenta }}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($venta->fechaVenta)) }}</td>
                        <td class="text-center">{{ number_format($venta->montoTotal, 2) }} Bs</td>
                        <td class="text-center">{{ $venta->detalles->count() }} productos</td>
                        <td class="text-center">
                            <a href="{{ route('venta.show', $venta->codVenta) }}" class="btn-ver-compra">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-compras">
            <i class="fas fa-shopping-bag"></i>
            <p>Este cliente no ha realizado ninguna compra</p>
        </div>
        @endif
    </div>

    <!-- Sección de estadísticas -->
    <div class="estadisticas-section">
        <h3 class="section-title"><i class="fas fa-chart-line"></i> Estadísticas del Cliente</h3>
        <div class="estadisticas-grid">
            <div class="estadistica-card">
                <div class="estadistica-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="estadistica-info">
                    <span class="estadistica-valor">{{ $totalComprasRealizadas ?? 0 }}</span>
                    <span class="estadistica-label">Compras realizadas</span>
                </div>
            </div>
            <div class="estadistica-card">
                <div class="estadistica-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="estadistica-info">
                    <span class="estadistica-valor">{{ number_format($totalGastado ?? 0, 2) }} Bs</span>
                    <span class="estadistica-label">Total gastado</span>
                </div>
            </div>
            <div class="estadistica-card">
                <div class="estadistica-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="estadistica-info">
                    <span class="estadistica-valor">{{ $totalProductosComprados ?? 0 }}</span>
                    <span class="estadistica-label">Productos comprados</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .cliente-show-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
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
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 4px;
    }

    .page-subtitle {
        color: #6B7280;
        font-size: 0.9rem;
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .btn-edit, .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .btn-edit {
        background: #EFF6FF;
        color: #3B82F6;
    }

    .btn-edit:hover {
        background: #DBEAFE;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: #FEF2F2;
        color: #E04545;
    }

    .btn-delete:hover {
        background: #FEE2E2;
        transform: translateY(-1px);
    }

    /* Tarjeta principal */
    .cliente-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        overflow: hidden;
        margin-bottom: 32px;
    }

    .cliente-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 32px;
        padding: 32px;
    }

    /* Avatar */
    .cliente-avatar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .avatar-principal {
        background: linear-gradient(135deg, rgba(224, 69, 69, 0.1), rgba(224, 69, 69, 0.05));
        border-radius: 20px;
        padding: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(224, 69, 69, 0.2);
    }

    .avatar-circle {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #E04545, #c93a3a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-circle span {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
    }

    .info-adicional {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.8rem;
        color: #6B7280;
    }

    .info-item i {
        color: #E04545;
        width: 20px;
    }

    /* Información del cliente */
    .cliente-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .cliente-header {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .cliente-estado {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .estado-activo {
        background: #ECFDF5;
        color: #065F46;
    }

    .estado-bloqueado {
        background: #FEF2F2;
        color: #991B1B;
    }

    .cliente-nombre {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1F2937;
        margin: 0;
    }

    .cliente-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: 8px;
    }

    .info-card {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 16px;
    }

    .info-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-label i {
        color: #E04545;
        width: 16px;
    }

    .info-value {
        font-size: 0.95rem;
        font-weight: 500;
        color: #1F2937;
    }

    /* Sección de compras */
    .compras-section {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        padding: 24px;
        margin-bottom: 32px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1F2937;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .section-title i {
        color: #E04545;
    }

    .btn-view-all {
        font-size: 0.8rem;
        color: #E04545;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-view-all:hover {
        gap: 10px;
    }

    .compras-table-container {
        overflow-x: auto;
    }

    .compras-table {
        width: 100%;
        border-collapse: collapse;
    }

    .compras-table thead th {
        text-align: left;
        padding: 12px;
        background: #F9FAFB;
        font-size: 0.75rem;
        font-weight: 600;
        color: #4B5563;
        border-bottom: 1px solid #E5E7EB;
    }

    .compras-table tbody td {
        padding: 12px;
        border-bottom: 1px solid #F3F4F6;
        font-size: 0.85rem;
        color: #374151;
    }

    .compras-table tbody tr:hover {
        background: #F9FAFB;
    }

    .text-center {
        text-align: center;
    }

    .btn-ver-compra {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        color: #3B82F6;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-ver-compra:hover {
        gap: 10px;
        color: #E04545;
    }

    /* Estado vacío */
    .empty-compras {
        text-align: center;
        padding: 50px 20px;
        color: #9CA3AF;
    }

    .empty-compras i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-compras p {
        margin-bottom: 0;
    }

    /* Sección de estadísticas */
    .estadisticas-section {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        padding: 24px;
    }

    .estadisticas-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .estadistica-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        background: #F9FAFB;
        border-radius: 16px;
    }

    .estadistica-icon {
        width: 50px;
        height: 50px;
        background: rgba(224, 69, 69, 0.1);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .estadistica-icon i {
        font-size: 1.5rem;
        color: #E04545;
    }

    .estadistica-info {
        display: flex;
        flex-direction: column;
    }

    .estadistica-valor {
        font-size: 1.4rem;
        font-weight: 800;
        color: #1F2937;
    }

    .estadistica-label {
        font-size: 0.7rem;
        color: #6B7280;
    }

    @media (max-width: 992px) {
        .cliente-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        .estadisticas-grid {
            grid-template-columns: 1fr;
        }
        .cliente-info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }
        .cliente-nombre {
            font-size: 1.4rem;
        }
        .cliente-grid {
            padding: 20px;
        }
        .avatar-principal {
            padding: 30px;
        }
        .avatar-circle {
            width: 100px;
            height: 100px;
        }
        .avatar-circle span {
            font-size: 2rem;
        }
        .compras-table thead th,
        .compras-table tbody td {
            padding: 8px;
        }
    }

    @media print {
        .sidebar, .top-bar, .header-actions, .back-link, .btn-edit, .btn-delete, .btn-view-all, .btn-ver-compra {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .cliente-card {
            box-shadow: none;
            border: none;
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
                    didOpen: () => { Swal.showLoading(); }
                });
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@endpush
@endsection