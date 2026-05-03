@extends('layouts.encargado-layout')

@section('title', 'Detalle de Categoría - ' . $categoria->nombre)

@section('content')
<div class="categoria-show-container">
    <div class="page-header">
        <div>
            <a href="{{ route('categoria.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver a categorías
            </a>
            <h1 class="page-title">Detalle de Categoría</h1>
            <p class="page-subtitle">Información completa de la categoría</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('categoria.edit', $categoria->codCategoria) }}" class="btn-edit">
                <i class="fas fa-pencil-alt"></i> Editar
            </a>
            <button type="button" class="btn-delete" onclick="confirmDelete('{{ $categoria->codCategoria }}', '{{ $categoria->nombre }}')">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
            <form id="delete-form-{{ $categoria->codCategoria }}" action="{{ route('categoria.destroy', $categoria->codCategoria) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <div class="categoria-card">
        <div class="categoria-grid">
            <!-- Columna izquierda - Icono -->
            <div class="categoria-icono">
                <div class="icono-principal">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="info-adicional">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Registrado: {{ date('d/m/Y', strtotime($categoria->created_at ?? now())) }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-code-branch"></i>
                        <span>Código único: {{ $categoria->codCategoria }}</span>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Información -->
            <div class="categoria-info">
                <div class="categoria-header">
                    <span class="categoria-codigo">Código: {{ $categoria->codCategoria }}</span>
                </div>

                <h1 class="categoria-nombre">{{ $categoria->nombre }}</h1>

                <div class="categoria-descripcion">
                    <h3><i class="fas fa-align-left"></i> Descripción</h3>
                    <p>{{ $categoria->descripcion }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de productos asociados -->
    <div class="productos-section">
        <div class="section-header">
            <h3 class="section-title"><i class="fas fa-boxes"></i> Productos en esta categoría</h3>
            <a href="{{ route('producto.index') }}?categoria={{ $categoria->codCategoria }}" class="btn-view-all">
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
        <div class="empty-products">
            <i class="fas fa-box-open"></i>
            <p>No hay productos en esta categoría</p>
            <a href="{{ route('producto.create') }}?categoria={{ $categoria->codCategoria }}" class="btn-add-product">
                <i class="fas fa-plus"></i> Agregar producto
            </a>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .categoria-show-container {
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
    .categoria-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #E8ECEF;
        overflow: hidden;
        margin-bottom: 32px;
    }

    .categoria-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 32px;
        padding: 32px;
    }

    /* Icono */
    .categoria-icono {
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

    /* Información de la categoría */
    .categoria-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .categoria-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .categoria-codigo {
        font-family: monospace;
        background: #F3F4F6;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        color: #4B5563;
        display: inline-block;
    }

    .categoria-nombre {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1F2937;
        margin: 0;
    }

    .categoria-descripcion h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .categoria-descripcion p {
        color: #6B7280;
        line-height: 1.6;
        font-size: 0.9rem;
    }

    /* Sección de productos - IMAGEN CORREGIDA */
    .productos-section {
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

    /* IMAGEN CORREGIDA - Se muestra completa */
    .producto-imagen {
        width: 100%;
        height: 160px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        border-bottom: 1px solid #E5E7EB;
    }

    .producto-imagen img {
        max-width: 100%;
        max-height: 120px;
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

    /* Estado vacío */
    .empty-products {
        text-align: center;
        padding: 50px 20px;
        color: #9CA3AF;
    }

    .empty-products i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-products p {
        margin-bottom: 16px;
    }

    .btn-add-product {
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

    .btn-add-product:hover {
        background: #c93a3a;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }
        .categoria-nombre {
            font-size: 1.4rem;
        }
        .categoria-grid {
            padding: 20px;
        }
        .productos-grid {
            grid-template-columns: 1fr;
        }
        .estadisticas-grid {
            gap: 12px;
        }
        .estadistica-card {
            padding: 12px;
        }
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .producto-imagen {
            height: 140px;
        }
        .producto-imagen img {
            max-height: 100px;
        }
    }

    @media print {
        .sidebar, .top-bar, .header-actions, .back-link, .btn-edit, .btn-delete, .btn-view-all, .btn-ver-producto, .btn-add-product {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .categoria-card {
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
            title: '¿Eliminar categoría?',
            html: `<p style="font-size: 1rem;">¿Estás seguro de eliminar la categoría <strong>${nombre}</strong>?<br>Esta acción no se puede deshacer.</p>`,
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