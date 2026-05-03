@extends('layouts.encargado-layout')

@section('title', 'Detalle del Proveedor - ' . $proveedor->nombre)

@section('content')
<div class="proveedor-show-container">
    <div class="page-header">
        <div>
            <a href="{{ route('proveedor.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver a proveedores
            </a>
            <h1 class="page-title">Detalle del Proveedor</h1>
            <p class="page-subtitle">Información completa del proveedor</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('proveedor.edit', $proveedor->codProveedor) }}" class="btn-edit">
                <i class="fas fa-pencil-alt"></i> Editar
            </a>
            <button type="button" class="btn-delete" onclick="confirmDelete({{ $proveedor->codProveedor }}, '{{ $proveedor->nombre }}')">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
            <form id="delete-form-{{ $proveedor->codProveedor }}" action="{{ route('proveedor.destroy', $proveedor->codProveedor) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <div class="proveedor-card">
        <div class="proveedor-grid">
            <!-- Columna izquierda - Icono -->
            <div class="proveedor-icono">
                <div class="icono-principal">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="info-adicional">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Registrado: {{ date('d/m/Y', strtotime($proveedor->created_at ?? now())) }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-code-branch"></i>
                        <span>Código: #{{ $proveedor->codProveedor }}</span>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Información -->
            <div class="proveedor-info">
                <h1 class="proveedor-nombre">{{ $proveedor->nombre }}</h1>

                <div class="proveedor-info-grid">
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i> Dirección
                        </div>
                        <div class="info-value">{{ $proveedor->direccion }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">
                            <i class="fas fa-phone"></i> Teléfono
                        </div>
                        <div class="info-value">{{ $proveedor->telefono }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de compras realizadas a este proveedor -->
    <div class="compras-section">
        <div class="section-header">
            <h3 class="section-title"><i class="fas fa-shopping-cart"></i> Compras realizadas a este proveedor</h3>
            <a href="{{ route('compra.index') }}?proveedor={{ $proveedor->codProveedor }}" class="btn-view-all">
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
                        <th>Encargado</th>
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
                        <td class="text-center">{{ $compra->encargado->nombre ?? 'N/A' }} {{ $compra->encargado->apellidoPaterno ?? '' }}</td>
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
            <p>No se han registrado compras a este proveedor</p>
            <a href="{{ route('compra.create') }}?proveedor={{ $proveedor->codProveedor }}" class="btn-add-compra">
                <i class="fas fa-plus"></i> Registrar compra
            </a>
        </div>
        @endif
    </div>

    <!-- Sección de productos que provee -->
    <div class="productos-section">
        <div class="section-header">
            <h3 class="section-title"><i class="fas fa-boxes"></i> Productos que provee</h3>
            <a href="{{ route('producto.index') }}?proveedor={{ $proveedor->codProveedor }}" class="btn-view-all">
                Ver todos <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        @if($productos->count() > 0)
        <div class="productos-grid">
            @foreach($productos as $producto)
            <div class="producto-card">
                <div class="producto-imagen">
                    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
                </div>
                <div class="producto-info">
                    <h4 class="producto-nombre">{{ $producto->nombre }}</h4>
                    <div class="producto-precio">{{ $producto->precio_formateado }}</div>
                    <div class="producto-stock {{ $producto->stock <= 5 ? 'stock-bajo' : 'stock-normal' }}">
                        <i class="fas fa-boxes"></i> Stock: {{ $producto->stock }}
                    </div>
                    <a href="{{ route('producto.show', $producto->codProducto) }}" class="btn-ver-producto">
                        Ver producto <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-productos">
            <i class="fas fa-box-open"></i>
            <p>No hay productos registrados de este proveedor</p>
        </div>
        @endif
    </div>

    <!-- Sección de estadísticas -->
    <div class="estadisticas-section">
        <h3 class="section-title"><i class="fas fa-chart-line"></i> Estadísticas del Proveedor</h3>
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
                    <span class="estadistica-valor">{{ $totalProductos ?? 0 }}</span>
                    <span class="estadistica-label">Productos asociados</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .proveedor-show-container {
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
    .proveedor-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        overflow: hidden;
        margin-bottom: 32px;
    }

    .proveedor-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 32px;
        padding: 32px;
    }

    /* Icono */
    .proveedor-icono {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .icono-principal {
        background: linear-gradient(135deg, rgba(224, 69, 69, 0.1), rgba(224, 69, 69, 0.05));
        border-radius: 20px;
        padding: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(224, 69, 69, 0.2);
    }

    .icono-principal i {
        font-size: 5rem;
        color: #E04545;
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

    /* Información del proveedor */
    .proveedor-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .proveedor-nombre {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1F2937;
        margin: 0;
    }

    .proveedor-info-grid {
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

    /* Estado vacío compras */
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
        margin-bottom: 16px;
    }

    .btn-add-compra {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        background: #E04545;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-add-compra:hover {
        background: #c93a3a;
        transform: translateY(-2px);
    }

    /* Sección de productos */
    .productos-section {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        padding: 24px;
        margin-bottom: 32px;
    }

    .productos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    .producto-card {
        background: #F9FAFB;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.2s;
        border: 1px solid #E5E7EB;
    }

    .producto-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-color: rgba(224, 69, 69, 0.3);
    }

    .producto-imagen {
        width: 100%;
        height: 140px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        border-bottom: 1px solid #E5E7EB;
    }

    .producto-imagen img {
        max-width: 100%;
        max-height: 100px;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
    }

    .producto-info {
        padding: 16px;
    }

    .producto-nombre {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1F2937;
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .producto-precio {
        font-size: 1rem;
        font-weight: 700;
        color: #E04545;
        margin-bottom: 8px;
    }

    .producto-stock {
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 12px;
    }

    .stock-normal {
        color: #065F46;
    }

    .stock-bajo {
        color: #92400E;
    }

    .btn-ver-producto {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        color: #3B82F6;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-ver-producto:hover {
        gap: 10px;
        color: #E04545;
    }

    .empty-productos {
        text-align: center;
        padding: 50px 20px;
        color: #9CA3AF;
    }

    .empty-productos i {
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
        .proveedor-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        .estadisticas-grid {
            grid-template-columns: 1fr;
        }
        .proveedor-info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }
        .proveedor-nombre {
            font-size: 1.4rem;
        }
        .proveedor-grid {
            padding: 20px;
        }
        .icono-principal {
            padding: 30px;
        }
        .icono-principal i {
            font-size: 4rem;
        }
        .productos-grid {
            grid-template-columns: 1fr;
        }
        .compras-table thead th,
        .compras-table tbody td {
            padding: 8px;
        }
    }

    @media print {
        .sidebar, .top-bar, .header-actions, .back-link, .btn-edit, .btn-delete, .btn-view-all, .btn-ver-compra, .btn-ver-producto, .btn-add-compra {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .proveedor-card {
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
            title: '¿Eliminar proveedor?',
            html: `<p style="font-size: 1rem;">¿Estás seguro de eliminar al proveedor <strong>${nombre}</strong>?<br>Esta acción no se puede deshacer.</p>`,
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