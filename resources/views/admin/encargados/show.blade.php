@extends('layouts.admin-layout')

@section('title', 'Detalle del Encargado - ' . $encargado->nombre . ' ' . $encargado->apellidoPaterno)

@section('content')
<div class="encargado-show-container">
    <div class="page-header">
        <div>
            <a href="{{ route('encargado.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver a encargados
            </a>
            <h1 class="page-title">Detalle del Encargado</h1>
            <p class="page-subtitle">Información completa del encargado</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('encargado.edit', $encargado->carnetIdentidad) }}" class="btn-edit">
                <i class="fas fa-pencil-alt"></i> Editar
            </a>
            <button type="button" class="btn-delete" onclick="confirmDelete({{ $encargado->carnetIdentidad }}, '{{ $encargado->nombre }} {{ $encargado->apellidoPaterno }}')">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
            <form id="delete-form-{{ $encargado->carnetIdentidad }}" action="{{ route('encargado.destroy', $encargado->carnetIdentidad) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <div class="encargado-card">
        <div class="encargado-grid">
            <!-- Columna izquierda - Avatar -->
            <div class="encargado-avatar">
                <div class="avatar-principal">
                    <div class="avatar-circle">
                        <span>{{ strtoupper(substr($encargado->nombre, 0, 1)) }}{{ strtoupper(substr($encargado->apellidoPaterno, 0, 1)) }}</span>
                    </div>
                </div>
                <div class="info-adicional">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Registrado: {{ date('d/m/Y', strtotime($encargado->created_at ?? now())) }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-id-card"></i>
                        <span>CI: {{ number_format($encargado->carnetIdentidad, 0, '', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Información -->
            <div class="encargado-info">
                <div class="encargado-header">
                    <span class="encargado-estado {{ $encargado->usuario->bloqueado == 0 ? 'estado-activo' : 'estado-bloqueado' }}">
                        <i class="fas {{ $encargado->usuario->bloqueado == 0 ? 'fa-check-circle' : 'fa-ban' }}"></i>
                        {{ $encargado->usuario->bloqueado == 0 ? 'Activo' : 'Bloqueado' }}
                    </span>
                </div>

                <h1 class="encargado-nombre">{{ $encargado->nombre }} {{ $encargado->apellidoPaterno }} {{ $encargado->apellidoMaterno }}</h1>

                <div class="encargado-info-grid">
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-user"></i> Nombre de usuario
                        </div>
                        <div class="info-value">{{ $encargado->usuario->name ?? 'No asignado' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i> Correo electrónico
                        </div>
                        <div class="info-value">{{ $encargado->usuario->email ?? 'No asignado' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-venus-mars"></i> Sexo
                        </div>
                        <div class="info-value">{{ $encargado->sexo == 'M' ? 'Masculino' : 'Femenino' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-phone"></i> Teléfono
                        </div>
                        <div class="info-value">{{ $encargado->telefono }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-tag"></i> Tipo de Usuario
                        </div>
                        <div class="info-value">{{ $encargado->usuario->tipoUsuario->nombre ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de compras realizadas por el encargado -->
    <div class="compras-section">
        <div class="section-header">
            <h3 class="section-title"><i class="fas fa-shopping-cart"></i> Compras realizadas</h3>
            <a href="{{ route('compra.index') }}?encargado={{ $encargado->carnetIdentidad }}" class="btn-view-all">
                Ver todas <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        @if($compras->count() > 0)
        <div class="compras-table-container">
            <table class="compras-table">
                <thead>
                    <tr>
                        <th># Compra</th>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Total</th>
                        <th>Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                    <tr class="compra-row">
                        <td class="text-center">#{{ $compra->codCompra }}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($compra->fechaCompra)) }}</td>
                        <td class="text-center">{{ $compra->proveedor->nombre ?? 'N/A' }}</td>
                        <td class="text-center">{{ number_format($compra->montoTotal, 2) }} Bs</td>
                        <td class="text-center">{{ $compra->detalles->count() }} productos</td>
                        <td class="text-center">
                            <a href="{{ route('compra.show', $compra->codCompra) }}" class="btn-ver-compra">
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
            <i class="fas fa-shopping-cart"></i>
            <p>No se han registrado compras realizadas por este encargado</p>
        </div>
        @endif
    </div>

    <!-- Sección de ventas realizadas por el encargado -->
    <div class="ventas-section">
        <div class="section-header">
            <h3 class="section-title"><i class="fas fa-cash-register"></i> Ventas realizadas</h3>
            <a href="{{ route('venta.index') }}?encargado={{ $encargado->carnetIdentidad }}" class="btn-view-all">
                Ver todas <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        @if($ventas->count() > 0)
        <div class="ventas-table-container">
            <table class="ventas-table">
                <thead>
                    <tr>
                        <th># Venta</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                    <tr class="venta-row">
                        <td class="text-center">#{{ $venta->codVenta }}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($venta->fechaVenta)) }}</td>
                        <td class="text-center">{{ $venta->cliente->nombre ?? 'N/A' }} {{ $venta->cliente->apellidoPaterno ?? '' }}</td>
                        <td class="text-center">{{ number_format($venta->montoTotal, 2) }} Bs</td>
                        <td class="text-center">{{ $venta->detalles->count() }} productos</td>
                        <td class="text-center">
                            <a href="{{ route('venta.show', $venta->codVenta) }}" class="btn-ver-venta">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </table>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-ventas">
            <i class="fas fa-cash-register"></i>
            <p>No se han registrado ventas realizadas por este encargado</p>
        </div>
        @endif
    </div>

    <!-- Sección de estadísticas -->
    <div class="estadisticas-section">
        <h3 class="section-title"><i class="fas fa-chart-line"></i> Estadísticas del Encargado</h3>
        <div class="estadisticas-grid">
            <div class="estadistica-card">
                <div class="estadistica-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="estadistica-info">
                    <span class="estadistica-valor">{{ $totalCompras ?? 0 }}</span>
                    <span class="estadistica-label">Compras realizadas</span>
                </div>
            </div>
            <div class="estadistica-card">
                <div class="estadistica-icon">
                    <i class="fas fa-cash-register"></i>
                </div>
                <div class="estadistica-info">
                    <span class="estadistica-valor">{{ $totalVentas ?? 0 }}</span>
                    <span class="estadistica-label">Ventas realizadas</span>
                </div>
            </div>
            <div class="estadistica-card">
                <div class="estadistica-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="estadistica-info">
                    <span class="estadistica-valor">{{ number_format($totalMontoCompras ?? 0, 2) }} Bs</span>
                    <span class="estadistica-label">Total en compras</span>
                </div>
            </div>
            <div class="estadistica-card">
                <div class="estadistica-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="estadistica-info">
                    <span class="estadistica-valor">{{ number_format($totalMontoVentas ?? 0, 2) }} Bs</span>
                    <span class="estadistica-label">Total en ventas</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .encargado-show-container {
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
    .encargado-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        overflow: hidden;
        margin-bottom: 32px;
    }

    .encargado-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 32px;
        padding: 32px;
    }

    /* Avatar */
    .encargado-avatar {
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

    /* Información del encargado */
    .encargado-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .encargado-header {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .encargado-estado {
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

    .encargado-nombre {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1F2937;
        margin: 0;
    }

    .encargado-info-grid {
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

    /* Secciones de compras y ventas */
    .compras-section, .ventas-section {
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

    .compras-table-container, .ventas-table-container {
        overflow-x: auto;
    }

    .compras-table, .ventas-table {
        width: 100%;
        border-collapse: collapse;
    }

    .compras-table thead th, .ventas-table thead th {
        text-align: left;
        padding: 12px;
        background: #F9FAFB;
        font-size: 0.75rem;
        font-weight: 600;
        color: #4B5563;
        border-bottom: 1px solid #E5E7EB;
    }

    .compras-table tbody td, .ventas-table tbody td {
        padding: 12px;
        border-bottom: 1px solid #F3F4F6;
        font-size: 0.85rem;
        color: #374151;
    }

    .compras-table tbody tr:hover, .ventas-table tbody tr:hover {
        background: #F9FAFB;
    }

    .text-center {
        text-align: center;
    }

    .btn-ver-compra, .btn-ver-venta {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        color: #3B82F6;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-ver-compra:hover, .btn-ver-venta:hover {
        gap: 10px;
        color: #E04545;
    }

    /* Estados vacíos */
    .empty-compras, .empty-ventas {
        text-align: center;
        padding: 50px 20px;
        color: #9CA3AF;
    }

    .empty-compras i, .empty-ventas i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
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
        grid-template-columns: repeat(4, 1fr);
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
        .encargado-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        .estadisticas-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .encargado-info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }
        .encargado-nombre {
            font-size: 1.4rem;
        }
        .encargado-grid {
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
        .estadisticas-grid {
            grid-template-columns: 1fr;
        }
        .compras-table thead th, .compras-table tbody td,
        .ventas-table thead th, .ventas-table tbody td {
            padding: 8px;
        }
    }

    @media print {
        .sidebar, .top-bar, .header-actions, .back-link, .btn-edit, .btn-delete, .btn-view-all, .btn-ver-compra, .btn-ver-venta {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .encargado-card {
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
            title: '¿Eliminar encargado?',
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