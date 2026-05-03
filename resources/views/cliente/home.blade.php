@extends('layouts.cliente-layout')

@section('title', 'BODY FIT - Tienda Oficial de Fitness')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

<style>
/* ──────────────────────────────────────────────────────────────
   TOKENS / VARIABLES - Diseño Profesional Premium
   ────────────────────────────────────────────────────────────── */
:root {
    --primary:        #D93B3B;
    --primary-dark:   #B02E2E;
    --primary-light:  #FEE2E2;
    --primary-glow:   rgba(217, 59, 59, 0.12);
    --secondary:      #1A1A2E;
    --white:          #FFFFFF;
    --bg-light:       #FAFAFC;
    --bg-card:        #FFFFFF;
    --border:         rgba(0, 0, 0, 0.06);
    --border-focus:   rgba(217, 59, 59, 0.3);
    --text-primary:   #1A1A2E;
    --text-secondary: #4B5563;
    --text-muted:     #9CA3AF;
    --shadow-sm:      0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md:      0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg:      0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl:      0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --radius-sm:      8px;
    --radius-md:      12px;
    --radius-lg:      20px;
    --radius-xl:      28px;
    --radius-2xl:     32px;
}

*,
*::before,
*::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background: var(--bg-light);
    color: var(--text-primary);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ──────────────────────────────────────────────────────────────
   LAYOUT PRINCIPAL
   ────────────────────────────────────────────────────────────── */
.home-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 32px 80px;
}

/* ──────────────────────────────────────────────────────────────
   HERO SECTION - Premium
   ────────────────────────────────────────────────────────────── */
.hero-section {
    position: relative;
    min-height: 85vh;
    display: flex;
    align-items: flex-end;
    border-radius: var(--radius-2xl);
    overflow: hidden;
    margin-bottom: 80px;
}

.hero-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(105deg, rgba(0, 0, 0, 0.88) 0%, rgba(0, 0, 0, 0.55) 45%, rgba(0, 0, 0, 0.2) 100%),
                url('https://images.pexels.com/photos/1552242/pexels-photo-1552242.jpeg?auto=compress&cs=tinysrgb&w=1600') center/cover no-repeat;
    z-index: 0;
    transform: scale(1.02);
    transition: transform 0.7s ease;
}

.hero-section:hover .hero-bg {
    transform: scale(1);
}

/* Overlay premium */
.hero-bg::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(217, 59, 59, 0.08) 0%, transparent 60%);
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 2;
    padding: 80px 80px 100px;
    max-width: 680px;
    animation: fadeUp 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(217, 59, 59, 0.15);
    backdrop-filter: blur(8px);
    padding: 6px 16px 6px 12px;
    border-radius: 100px;
    margin-bottom: 28px;
    border: 1px solid rgba(217, 59, 59, 0.25);
}

.hero-badge-dot {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.85); }
}

.hero-badge-text {
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.9);
}

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(3.5rem, 7vw, 6rem);
    line-height: 1.05;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 24px;
    letter-spacing: -0.02em;
}

.hero-title span {
    color: var(--primary);
    font-style: italic;
}

.hero-description {
    font-size: 1rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.7);
    max-width: 460px;
    margin-bottom: 40px;
}

.hero-buttons {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: var(--primary);
    color: white;
    padding: 14px 32px;
    border-radius: 100px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    gap: 16px;
    box-shadow: 0 12px 24px -8px rgba(217, 59, 59, 0.4);
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(8px);
    color: white;
    padding: 13px 28px;
    border-radius: 100px;
    font-weight: 500;
    font-size: 0.9rem;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.12);
    border-color: rgba(255, 255, 255, 0.35);
    transform: translateY(-2px);
    gap: 14px;
}

.hero-scroll {
    position: absolute;
    bottom: 32px;
    right: 40px;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    opacity: 0.5;
    transition: opacity 0.3s;
}

.hero-scroll:hover {
    opacity: 1;
}

.hero-scroll span {
    font-size: 0.65rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    writing-mode: vertical-rl;
    color: rgba(255, 255, 255, 0.7);
}

.hero-scroll-line {
    width: 1px;
    height: 60px;
    background: linear-gradient(to bottom, rgba(255, 255, 255, 0.6), transparent);
    animation: scrollLine 2s ease-in-out infinite;
}

@keyframes scrollLine {
    0%, 100% { opacity: 0.3; transform: scaleY(1); }
    50% { opacity: 0.9; transform: scaleY(0.7); }
}

/* ──────────────────────────────────────────────────────────────
   SECTION HEADER
   ────────────────────────────────────────────────────────────── */
.section-header {
    text-align: center;
    margin-bottom: 56px;
}

.section-label {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--primary);
    background: var(--primary-light);
    padding: 5px 14px;
    border-radius: 100px;
    margin-bottom: 16px;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 2.8rem);
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 12px;
}

.section-title span {
    color: var(--primary);
    font-style: italic;
}

.section-subtitle {
    font-size: 0.95rem;
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto;
}

/* ──────────────────────────────────────────────────────────────
   CATEGORIES - Premium Cards
   ────────────────────────────────────────────────────────────── */
.categories-section {
    margin-bottom: 80px;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 20px;
}

.category-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 32px 20px;
    text-align: center;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.category-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--primary-glow) 0%, transparent 80%);
    opacity: 0;
    transition: opacity 0.4s;
}

.category-card:hover {
    transform: translateY(-6px);
    border-color: var(--primary);
    box-shadow: var(--shadow-xl);
}

.category-card:hover::before {
    opacity: 1;
}

.category-icon {
    width: 64px;
    height: 64px;
    background: var(--primary-light);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 18px;
    transition: all 0.3s;
}

.category-card:hover .category-icon {
    background: var(--primary);
}

.category-icon i {
    font-size: 1.6rem;
    color: var(--primary);
    transition: color 0.3s;
}

.category-card:hover .category-icon i {
    color: white;
}

.category-name {
    font-weight: 700;
    font-size: 1rem;
    color: var(--text-primary);
    margin-bottom: 6px;
}

.category-count {
    font-size: 0.7rem;
    color: var(--text-muted);
}

/* ──────────────────────────────────────────────────────────────
   PRODUCTS - Premium Grid
   ────────────────────────────────────────────────────────────── */
.featured-section {
    margin-bottom: 80px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

.product-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    border: 1px solid var(--border);
    position: relative;
}

.product-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary);
    box-shadow: var(--shadow-xl);
}

.product-image {
    position: relative;
    height: 240px;
    background: linear-gradient(135deg, #F8F9FC 0%, #F1F3F8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    overflow: hidden;
}

.product-image img {
    max-width: 100%;
    max-height: 180px;
    width: auto;
    height: auto;
    object-fit: contain;
    transition: transform 0.4s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.06);
}

.product-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    padding: 5px 12px;
    border-radius: 100px;
    font-size: 0.65rem;
    font-weight: 600;
    z-index: 2;
    backdrop-filter: blur(4px);
}

.product-badge.low-stock {
    background: rgba(245, 158, 11, 0.9);
    color: #FFFFFF;
}

.product-badge.out-stock {
    background: rgba(0, 0, 0, 0.7);
    color: #FFFFFF;
}

.product-info {
    padding: 20px 20px 24px;
}

.product-category {
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--primary);
    margin-bottom: 8px;
}

.product-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 12px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 16px;
}

.product-price {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--primary);
    letter-spacing: -0.5px;
}

.product-price small {
    font-size: 0.7rem;
    font-weight: 400;
    color: var(--text-muted);
}

.btn-cart {
    width: 44px;
    height: 44px;
    background: var(--secondary);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s;
}

.btn-cart:hover {
    background: var(--primary);
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(217, 59, 59, 0.3);
}

.btn-cart.disabled {
    background: #E5E7EB;
    color: #9CA3AF;
    cursor: not-allowed;
}

.btn-cart.disabled:hover {
    transform: none;
    box-shadow: none;
}

.view-all-wrapper {
    text-align: center;
    margin-top: 48px;
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 12px 32px;
    border: 2px solid var(--primary);
    border-radius: 100px;
    color: var(--primary);
    font-weight: 600;
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.25s;
}

.btn-outline:hover {
    background: var(--primary);
    color: white;
    gap: 16px;
    box-shadow: 0 8px 20px rgba(217, 59, 59, 0.25);
}

/* ──────────────────────────────────────────────────────────────
   BENEFITS - Premium Section
   ────────────────────────────────────────────────────────────── */
.benefits-section {
    background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFE 100%);
    border-radius: var(--radius-2xl);
    padding: 64px 56px;
    margin-bottom: 48px;
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
}

.benefits-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
    pointer-events: none;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 32px;
    position: relative;
    z-index: 1;
}

.benefit-card {
    text-align: center;
    padding: 0 16px;
}

.benefit-icon {
    width: 70px;
    height: 70px;
    background: var(--primary-light);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    transition: all 0.3s;
}

.benefit-card:hover .benefit-icon {
    background: var(--primary);
    transform: scale(1.05);
}

.benefit-icon i {
    font-size: 1.6rem;
    color: var(--primary);
    transition: color 0.3s;
}

.benefit-card:hover .benefit-icon i {
    color: white;
}

.benefit-title {
    font-weight: 700;
    font-size: 1rem;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.benefit-desc {
    font-size: 0.8rem;
    color: var(--text-secondary);
    line-height: 1.5;
}

/* ──────────────────────────────────────────────────────────────
   ANIMATIONS
   ────────────────────────────────────────────────────────────── */
.fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.fade-up.visible {
    opacity: 1;
    transform: translateY(0);
}

/* ──────────────────────────────────────────────────────────────
   RESPONSIVE
   ────────────────────────────────────────────────────────────── */
@media (max-width: 1100px) {
    .benefits-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
    }
}

@media (max-width: 900px) {
    .home-container {
        padding: 0 24px 60px;
    }
    .hero-content {
        padding: 60px 48px 80px;
    }
    .hero-title {
        font-size: 3.5rem;
    }
    .hero-scroll {
        display: none;
    }
}

@media (max-width: 768px) {
    .home-container {
        padding: 0 20px 48px;
    }
    .hero-section {
        min-height: 70vh;
        border-radius: var(--radius-xl);
    }
    .hero-content {
        padding: 48px 32px 60px;
    }
    .hero-title {
        font-size: 2.8rem;
    }
    .hero-description {
        font-size: 0.9rem;
    }
    .categories-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .products-grid {
        gap: 16px;
    }
    .benefits-section {
        padding: 48px 28px;
    }
    .benefits-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }
    .section-title {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .hero-content {
        padding: 40px 24px 50px;
    }
    .hero-title {
        font-size: 2.2rem;
    }
    .hero-buttons {
        flex-direction: column;
    }
    .btn-primary,
    .btn-secondary {
        width: 100%;
        justify-content: center;
    }
    .categories-grid {
        grid-template-columns: 1fr;
    }
    .products-grid {
        grid-template-columns: 1fr;
    }
    .section-title {
        font-size: 1.6rem;
    }
}
</style>
@endpush

@section('content')
<div class="home-container">

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- HERO SECTION --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="hero-section">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                <span class="hero-badge-text">Tienda Oficial</span>
            </div>
            <h1 class="hero-title">
                Forja tu<br><span>mejor versión</span>
            </h1>
            <p class="hero-description">
                Los mejores productos de fitness, suplementos y equipamiento para alcanzar tus metas. Calidad garantizada.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('cliente.productos') }}" class="btn-primary">
                    Comprar ahora <i class="fas fa-arrow-right"></i>
                </a>
                <a href="#productos" class="btn-secondary">
                    Explorar productos
                </a>
            </div>
        </div>
        <div class="hero-scroll">
            <div class="hero-scroll-line"></div>
            <span>Scroll</span>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- CATEGORIES --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="categories-section fade-up">
        <div class="section-header">
            <span class="section-label">Explorar</span>
            <h2 class="section-title">Categorías <span>destacadas</span></h2>
            <p class="section-subtitle">Explora nuestras categorías más populares</p>
        </div>
        <div class="categories-grid">
            @foreach($categorias->take(6) as $categoria)
            <a href="{{ route('cliente.productos') }}?categoria={{ $categoria->codCategoria }}" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <h3 class="category-name">{{ $categoria->nombre }}</h3>
                <p class="category-count">{{ $categoria->productos_count ?? 0 }} productos</p>
            </a>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- FEATURED PRODUCTS --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="featured-section fade-up" id="productos">
        <div class="section-header">
            <span class="section-label">Selección Premium</span>
            <h2 class="section-title">Productos <span>destacados</span></h2>
            <p class="section-subtitle">Los más vendidos y mejor calificados</p>
        </div>
        <div class="products-grid">
            @foreach($productosDestacados as $producto)
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" loading="lazy">
                    @if($producto->stock <= 5 && $producto->stock > 0)
                        <span class="product-badge low-stock">
                            <i class="fas fa-exclamation-triangle"></i> Últimas unidades
                        </span>
                    @elseif($producto->stock == 0)
                        <span class="product-badge out-stock">
                            <i class="fas fa-ban"></i> Agotado
                        </span>
                    @endif
                </div>
                <div class="product-info">
                    <div class="product-category">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</div>
                    <h3 class="product-title">{{ Str::limit($producto->nombre, 50) }}</h3>
                    <div class="product-footer">
                        <div class="product-price">
                            {{ number_format($producto->precio, 2) }} <small>Bs</small>
                        </div>
                        @if($producto->stock > 0)
                            <button class="btn-cart" title="Agregar al carrito"
                                onclick="addToCart({
                                    codProducto: '{{ $producto->codProducto }}',
                                    nombre: '{{ addslashes($producto->nombre) }}',
                                    precio: {{ $producto->precio }},
                                    stock: {{ $producto->stock }},
                                    imagen_url: '{{ $producto->imagen_url }}'
                                })">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        @else
                            <button class="btn-cart disabled" disabled>
                                <i class="fas fa-ban"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($productosDestacados->count() > 0)
        <div class="view-all-wrapper">
            <a href="{{ route('cliente.productos') }}" class="btn-outline">
                Ver todos los productos <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @endif
    </section>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- BENEFITS --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="benefits-section fade-up">
        <div class="section-header">
            <span class="section-label">Compromiso</span>
            <h2 class="section-title">¿Por qué <span>elegirnos</span>?</h2>
            <p class="section-subtitle">Más de 1,000 clientes satisfechos nos respaldan</p>
        </div>
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-truck"></i></div>
                <h3 class="benefit-title">Envío Rápido</h3>
                <p class="benefit-desc">Entregas en 24–48 horas hábiles directo a tu puerta, sin costos ocultos.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                <h3 class="benefit-title">Productos Originales</h3>
                <p class="benefit-desc">Garantía total de autenticidad. Trabajamos con marcas certificadas.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-credit-card"></i></div>
                <h3 class="benefit-title">Pagos Seguros</h3>
                <p class="benefit-desc">Múltiples métodos de pago con encriptación de última generación.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-headset"></i></div>
                <h3 class="benefit-title">Soporte 24/7</h3>
                <p class="benefit-desc">Atención al cliente personalizada en todo momento, cuando lo necesites.</p>
            </div>
        </div>
    </section>

</div>

<script>
    // Intersection Observer para animaciones
    document.addEventListener('DOMContentLoaded', function() {
        const fadeElements = document.querySelectorAll('.fade-up');
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        fadeElements.forEach(function(el) {
            observer.observe(el);
        });
    });
</script>
@endsection