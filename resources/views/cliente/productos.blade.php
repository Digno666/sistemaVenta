@extends('layouts.cliente-layout')

@section('title', 'Productos - BODY FIT Tienda')

@section('content')
<div class="products-page">
    <!-- Encabezado -->
    <div class="page-header">
        <h1 class="page-title">Nuestros Productos</h1>
        <p class="page-description">Equipamiento, suplementos y accesorios para tu mejor versión</p>
    </div>

    <!-- Barra de búsqueda y filtros -->
    <div class="filters-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Buscar productos..." autocomplete="off">
        </div>
        <div class="category-filter">
            <select id="categoryFilter" class="category-select">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->codCategoria }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Grid de productos -->
    <div class="products-grid" id="productsGrid">
        @foreach($productos as $producto)
        <div class="product-card" data-category="{{ $producto->codCategoria }}" data-name="{{ strtolower($producto->nombre) }}" data-code="{{ strtolower($producto->codProducto) }}">
            <div class="product-image">
                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
                @if($producto->stock <= 5 && $producto->stock > 0)
                    <span class="badge low-stock">¡Últimas unidades!</span>
                @elseif($producto->stock == 0)
                    <span class="badge out-stock">Agotado</span>
                @endif
            </div>
            <div class="product-info">
                <div class="product-category">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</div>
                <h3 class="product-title">{{ $producto->nombre }}</h3>
                <p class="product-description">{{ Str::limit($producto->descripcion, 80) }}</p>
                <div class="product-price">
                    <span class="price">{{ number_format($producto->precio, 2) }} Bs</span>
                </div>
                @if($producto->stock > 0)
                    <button class="btn-add-cart" onclick="addToCart({
                        codProducto: '{{ $producto->codProducto }}',
                        nombre: '{{ addslashes($producto->nombre) }}',
                        precio: {{ $producto->precio }},
                        stock: {{ $producto->stock }},
                        imagen_url: '{{ $producto->imagen_url }}'
                    })">
                        <i class="fas fa-shopping-cart"></i> Agregar al carrito
                    </button>
                @else
                    <button class="btn-add-cart disabled" disabled>
                        <i class="fas fa-ban"></i> No disponible
                    </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    @if($productos->isEmpty())
        <div class="empty-products">
            <i class="fas fa-box-open"></i>
            <p>No hay productos disponibles en este momento</p>
        </div>
    @endif
</div>

@push('styles')
<style>
    .products-page {
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1F2937;
        margin-bottom: 8px;
    }

    .page-description {
        color: #6B7280;
        font-size: 0.9rem;
    }

    /* Filtros */
    .filters-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .search-box {
        flex: 1;
        max-width: 400px;
        display: flex;
        align-items: center;
        background: white;
        border: 1.5px solid #E5E7EB;
        border-radius: 40px;
        padding: 10px 18px;
        transition: all 0.2s;
    }

    .search-box:focus-within {
        border-color: #E04545;
        box-shadow: 0 0 0 3px rgba(224, 69, 69, 0.1);
    }

    .search-box i {
        color: #9CA3AF;
    }

    .search-box input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 0 12px;
        outline: none;
        font-size: 0.9rem;
    }

    .category-select {
        padding: 10px 18px;
        border: 1.5px solid #E5E7EB;
        border-radius: 40px;
        background: white;
        font-size: 0.85rem;
        cursor: pointer;
        outline: none;
    }

    .category-select:focus {
        border-color: #E04545;
    }

    /* Grid de productos */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 28px;
    }

    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s;
        border: 1px solid #E8ECEF;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.12);
        border-color: rgba(224, 69, 69, 0.2);
    }

    /* IMAGEN CORREGIDA - Ahora se muestra completa y proporcionada */
    .product-image {
        position: relative;
        width: 100%;
        height: 180px;
        background: #F9FAFB;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        border-bottom: 1px solid #F3F4F6;
    }

    .product-image img {
        max-width: 100%;
        max-height: 140px;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
        transition: transform 0.3s;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        z-index: 1;
    }

    .low-stock {
        background: #FEF3C7;
        color: #92400E;
    }

    .out-stock {
        background: #FEF2F2;
        color: #991B1B;
    }

    .product-info {
        padding: 20px;
    }

    .product-category {
        font-size: 0.7rem;
        color: #E04545;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .product-description {
        font-size: 0.8rem;
        color: #6B7280;
        line-height: 1.4;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price {
        margin-bottom: 16px;
    }

    .price {
        font-size: 1.3rem;
        font-weight: 800;
        color: #E04545;
    }

    .btn-add-cart {
        width: 100%;
        background: #1F2937;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-add-cart:hover {
        background: #E04545;
        transform: translateY(-2px);
    }

    .btn-add-cart.disabled {
        background: #E5E7EB;
        cursor: not-allowed;
        color: #9CA3AF;
    }

    .empty-products {
        text-align: center;
        padding: 80px 20px;
        color: #9CA3AF;
    }

    .empty-products i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .page-title { font-size: 1.6rem; }
        .filters-bar { flex-direction: column; }
        .search-box { max-width: 100%; }
        .category-filter { width: 100%; }
        .category-select { width: 100%; }
        .products-grid { gap: 20px; }
        .product-image { height: 160px; }
        .product-image img { max-height: 120px; }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
        }
        .product-image { height: 180px; }
        .product-image img { max-height: 140px; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Filtros de productos
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const products = document.querySelectorAll('.product-card');

    function filterProducts() {
        const searchTerm = searchInput?.value.toLowerCase() || '';
        const category = categoryFilter?.value || '';

        products.forEach(product => {
            const productName = product.dataset.name || '';
            const productCode = product.dataset.code || '';
            const productCategory = product.dataset.category || '';
            
            const matchesSearch = productName.includes(searchTerm) || productCode.includes(searchTerm);
            const matchesCategory = !category || productCategory === category;
            
            if (matchesSearch && matchesCategory) {
                product.style.display = '';
            } else {
                product.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('keyup', filterProducts);
    if (categoryFilter) categoryFilter.addEventListener('change', filterProducts);
</script>
@endpush
@endsection