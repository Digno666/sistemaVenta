@extends('layouts.encargado-layout')

@section('title', 'Detalle del Producto - BODY FIT Encargado')

@section('content')
<div class="producto-show-container">
    <div class="page-header">
        <div>
            <a href="{{ route('producto.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver a productos
            </a>
            <h1 class="page-title">Detalle del Producto</h1>
            <p class="page-subtitle">Información completa del producto</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('producto.edit', $producto->codProducto) }}" class="btn-edit">
                <i class="fas fa-pencil-alt"></i> Editar
            </a>
            <button type="button" class="btn-delete" onclick="confirmDelete('{{ $producto->codProducto }}', '{{ $producto->nombre }}')">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
            <form id="delete-form-{{ $producto->codProducto }}" action="{{ route('producto.destroy', $producto->codProducto) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <div class="producto-card">
        <div class="producto-grid">
            <!-- Columna izquierda - Imagen -->
            <div class="producto-imagen">
                <div class="imagen-principal">
                    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
                </div>
                <div class="info-adicional">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Registrado: {{ date('d/m/Y', strtotime($producto->created_at ?? now())) }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-code-branch"></i>
                        <span>Código único: {{ $producto->codProducto }}</span>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Información -->
            <div class="producto-info">
                <div class="producto-header">
                    <span class="producto-codigo">Código: {{ $producto->codProducto }}</span>
                    <div class="stock-badge 
                        @if($producto->stock == 0) sin-stock
                        @elseif($producto->stock <= 5) stock-bajo
                        @else stock-normal @endif">
                        @if($producto->stock == 0)
                            <i class="fas fa-ban"></i> Sin stock
                        @elseif($producto->stock <= 5)
                            <i class="fas fa-exclamation-triangle"></i> Stock bajo: {{ $producto->stock }} unidades
                        @else
                            <i class="fas fa-check-circle"></i> Stock disponible: {{ $producto->stock }} unidades
                        @endif
                    </div>
                </div>

                <h1 class="producto-nombre">{{ $producto->nombre }}</h1>

                <div class="producto-precio">
                    <div class="precio-item">
                        <span class="precio-label">Precio de venta</span>
                        <span class="precio-valor">{{ $producto->precio_formateado }}</span>
                    </div>
                </div>

                <div class="producto-categoria">
                    <i class="fas fa-tag"></i>
                    <span>Categoría: <strong>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</strong></span>
                    @if($producto->categoria)
                        <span class="categoria-codigo">({{ $producto->categoria->codCategoria }})</span>
                    @endif
                </div>

                <div class="producto-descripcion">
                    <h3><i class="fas fa-align-left"></i> Descripción del producto</h3>
                    <p>{{ $producto->descripcion }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de estadísticas del producto -->
    <div class="estadisticas-section">
        <h3 class="section-title"><i class="fas fa-chart-line"></i> Estadísticas del Producto</h3>
        <div class="estadisticas-grid">
            <div class="estadistica-card">
                <div class="estadistica-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="estadistica-info">
                    <span class="estadistica-valor">{{ $totalVentas ?? 0 }}</span>
                    <span class="estadistica-label">Unidades vendidas</span>
                </div>
            </div>
            <div class="estadistica-card">
                <div class="estadistica-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="estadistica-info">
                    <span class="estadistica-valor">{{ number_format($totalRecaudado ?? 0, 2) }} Bs</span>
                    <span class="estadistica-label">Total recaudado</span>
                </div>
            </div>
            <div class="estadistica-card">
                <div class="estadistica-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="estadistica-info">
                    <span class="estadistica-valor">{{ $totalCompras ?? 0 }}</span>
                    <span class="estadistica-label">Unidades compradas</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .producto-show-container {
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
    .producto-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        overflow: hidden;
        margin-bottom: 32px;
    }

    .producto-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 32px;
        padding: 32px;
    }

    /* Imagen - CORREGIDA */
    .producto-imagen {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .imagen-principal {
        background: #F9FAFB;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #E5E7EB;
        max-height: 400px;
    }

    .imagen-principal img {
        width: 100%;
        max-height: 400px;
        object-fit: contain;
        display: block;
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

    /* Información del producto */
    .producto-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .producto-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .producto-codigo {
        font-family: monospace;
        background: #F3F4F6;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        color: #4B5563;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .stock-normal {
        background: #ECFDF5;
        color: #065F46;
    }

    .stock-bajo {
        background: #FEF3C7;
        color: #92400E;
    }

    .sin-stock {
        background: #FEF2F2;
        color: #991B1B;
    }

    .producto-nombre {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1F2937;
        margin: 0;
    }

    .producto-precio {
        background: #FEF2F2;
        border-radius: 16px;
        padding: 16px;
    }

    .precio-item {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    .precio-label {
        font-size: 0.85rem;
        color: #6B7280;
    }

    .precio-valor {
        font-size: 2rem;
        font-weight: 800;
        color: #E04545;
    }

    .producto-categoria {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        font-size: 0.9rem;
        color: #4B5563;
        padding: 12px 0;
        border-bottom: 1px solid #F3F4F6;
    }

    .producto-categoria i {
        color: #E04545;
    }

    .categoria-codigo {
        font-size: 0.7rem;
        color: #9CA3AF;
        font-family: monospace;
    }

    .producto-descripcion h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .producto-descripcion p {
        color: #6B7280;
        line-height: 1.6;
        font-size: 0.9rem;
    }

    /* Sección de estadísticas */
    .estadisticas-section {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        padding: 24px;
    }

    .section-title {
        font-size: 1.1rem;
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
        .producto-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        .estadisticas-grid {
            grid-template-columns: 1fr;
        }
        .imagen-principal {
            max-height: 300px;
        }
        .imagen-principal img {
            max-height: 300px;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }
        .producto-nombre {
            font-size: 1.4rem;
        }
        .precio-valor {
            font-size: 1.5rem;
        }
        .producto-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .producto-grid {
            padding: 20px;
        }
        .estadisticas-grid {
            gap: 12px;
        }
        .estadistica-card {
            padding: 12px;
        }
        .imagen-principal {
            max-height: 250px;
        }
        .imagen-principal img {
            max-height: 250px;
        }
    }

    @media print {
        .sidebar, .top-bar, .header-actions, .back-link, .btn-edit, .btn-delete {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .producto-card {
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
            title: '¿Eliminar producto?',
            html: `<p style="font-size: 1rem;">¿Estás seguro de eliminar el producto <strong>${nombre}</strong>?<br>Esta acción no se puede deshacer.</p>`,
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