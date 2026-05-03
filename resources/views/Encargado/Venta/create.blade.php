@extends('layouts.encargado-layout')

@section('title', 'Nueva Venta - BODY FIT Encargado')

@section('content')
<div class="form-container">
    <div class="form-header">
        <a href="{{ route('venta.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="form-title">Nueva Venta</h1>
        <p class="form-subtitle">Registra una nueva venta</p>
    </div>

    @if($errors->any())
        <div class="alert-general">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="alert-content">
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('venta.store') }}" id="ventaForm">
            @csrf

            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Datos de la Venta</h3>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cliente-search">Cliente <span class="required">*</span></label>
                        <div class="search-client-container">
                            <div id="search-input-wrapper" class="input-icon" style="display: flex;">
                                <i class="fas fa-user"></i>
                                <input type="text" id="cliente-search" class="form-control" placeholder="Escribe el nombre o carnet del cliente..." autocomplete="off">
                            </div>
                            <input type="hidden" name="codCliente" id="codCliente" required>
                            <div id="clientes-list" class="clientes-list"></div>
                        </div>
                        <div id="cliente-seleccionado" class="cliente-seleccionado" style="display: none;">
                            <div class="selected-card">
                                <i class="fas fa-check-circle"></i>
                                <span id="cliente-nombre-seleccionado"></span>
                                <button type="button" class="btn-cambiar-cliente" id="cambiarClienteBtn">
                                    <i class="fas fa-edit"></i> Cambiar
                                </button>
                            </div>
                        </div>
                        <div class="input-help">
                            <i class="fas fa-info-circle"></i> Busca por nombre o carnet de identidad
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Encargado</label>
                        <div class="input-icon">
                            <i class="fas fa-user-tie"></i>
                            <input type="text" class="form-control" value="{{ $encargado->nombre ?? 'No asignado' }} {{ $encargado->apellidoPaterno ?? '' }}" disabled>
                        </div>
                        <div class="input-help">
                            <i class="fas fa-info-circle"></i> Encargado que realiza la venta (usuario actual)
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-boxes"></i>
                    <h3>Productos</h3>
                    <button type="button" class="btn-add-product" id="openProductModalBtn">
                        <i class="fas fa-plus"></i> Agregar Producto
                    </button>
                </div>

                <div id="productos-container" class="productos-container">
                    <div class="empty-products-message">
                        <i class="fas fa-box-open"></i>
                        <p>No hay productos agregados. Haz clic en "Agregar Producto" para comenzar.</p>
                    </div>
                </div>

                <div class="total-container">
                    <div class="total-box">
                        <span class="total-label">MONTO TOTAL:</span>
                        <span class="total-value" id="totalValue">Bs 0.00</span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('venta.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Registrar Venta
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL PARA BUSCAR PRODUCTOS -->
<div id="productModal" class="venta-modal">
    <div class="venta-modal-content">
        <div class="venta-modal-header">
            <h3><i class="fas fa-search"></i> Buscar Producto</h3>
            <button class="venta-modal-close">&times;</button>
        </div>
        <div class="venta-modal-body">
            <div class="search-box-modal">
                <i class="fas fa-search"></i>
                <input type="text" id="searchProductInput" placeholder="Buscar por código o nombre...">
            </div>
            <div class="products-list" id="productsList">
                <!-- Lista de productos se cargará aquí -->
            </div>
        </div>
        <div class="venta-modal-footer">
            <button type="button" class="btn-cancel-modal" id="closeModalBtn">Cancelar</button>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-container { max-width: 1200px; margin: 0 auto; }
    .form-header { margin-bottom: 28px; }
    .back-link { display: inline-flex; align-items: center; gap: 8px; color: #6B7280; text-decoration: none; font-size: 0.85rem; margin-bottom: 16px; transition: color 0.2s; }
    .back-link:hover { color: #E04545; }
    .form-title { font-size: 1.8rem; font-weight: 700; color: #1F2937; margin-bottom: 6px; }
    .form-subtitle { color: #6B7280; font-size: 0.9rem; }
    .alert-general { background: #FEF2F2; border-left: 4px solid #E04545; border-radius: 14px; padding: 16px 20px; margin-bottom: 24px; display: flex; gap: 12px; }
    .alert-general i { color: #E04545; font-size: 1.2rem; }
    .alert-content strong { color: #991B1B; font-size: 0.85rem; display: block; margin-bottom: 8px; }
    .alert-content ul { margin: 0; padding-left: 20px; }
    .alert-content li { color: #991B1B; font-size: 0.8rem; }
    .form-card { background: white; border-radius: 24px; padding: 32px; border: 1px solid #E8ECEF; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .form-section { margin-bottom: 32px; }
    .section-title { display: flex; align-items: center; gap: 10px; margin-bottom: 24px; flex-wrap: wrap; }
    .section-title i { font-size: 1.3rem; color: #E04545; }
    .section-title h3 { font-size: 1.1rem; font-weight: 600; color: #374151; margin: 0; }
    .btn-add-product { background: #E04545; color: white; border: none; padding: 8px 16px; border-radius: 20px; font-size: 0.8rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; }
    .btn-add-product:hover { background: #c93a3a; transform: translateY(-1px); }
    .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px; }
    .form-group { margin-bottom: 0; position: relative; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.85rem; color: #374151; }
    .required { color: #E04545; }
    .input-icon { position: relative; }
    .input-icon i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9CA3AF; font-size: 1rem; pointer-events: none; }
    .form-control { width: 100%; padding: 12px 14px 12px 42px; border: 1.5px solid #E5E7EB; border-radius: 14px; font-size: 0.9rem; transition: all 0.2s; font-family: 'Inter', sans-serif; background: white; }
    .form-control:focus { outline: none; border-color: #E04545; box-shadow: 0 0 0 3px rgba(224,69,69,0.1); }
    .input-help { margin-top: 8px; font-size: 0.7rem; color: #9CA3AF; display: flex; align-items: center; gap: 6px; }
    
    .search-client-container { position: relative; }
    .clientes-list { position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #E5E7EB; border-radius: 14px; max-height: 250px; overflow-y: auto; z-index: 100; display: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .clientes-list.show { display: block; }
    .cliente-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; cursor: pointer; transition: all 0.2s; border-bottom: 1px solid #F3F4F6; }
    .cliente-item:hover { background: #FEF2F2; }
    .cliente-item:last-child { border-bottom: none; }
    .cliente-info strong { display: block; color: #1F2937; }
    .cliente-info small { font-size: 0.7rem; color: #6B7280; }
    .cliente-ci { font-size: 0.75rem; color: #9CA3AF; font-family: monospace; }
    .cliente-seleccionado { margin-top: 12px; }
    .selected-card { background: #ECFDF5; border: 1px solid #10B981; border-radius: 14px; padding: 12px 16px; display: flex; align-items: center; gap: 12px; }
    .selected-card i { color: #10B981; font-size: 1.2rem; }
    .selected-card span { flex: 1; font-weight: 500; color: #065F46; }
    .btn-cambiar-cliente { background: #F3F4F6; color: #4B5563; border: none; padding: 6px 12px; border-radius: 8px; font-size: 0.7rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; }
    .btn-cambiar-cliente:hover { background: #E5E7EB; }

    .productos-container { margin-top: 16px; }
    .empty-products-message { text-align: center; padding: 50px 20px; color: #9CA3AF; border: 1px dashed #E5E7EB; border-radius: 16px; background: #F9FAFB; }
    .empty-products-message i { font-size: 2.5rem; margin-bottom: 12px; display: block; }
    .products-table { width: 100%; border-collapse: collapse; background: white; border-radius: 16px; overflow: hidden; }
    .products-table thead th { text-align: left; padding: 14px 12px; background: #F9FAFB; font-size: 0.75rem; font-weight: 600; color: #4B5563; border-bottom: 1px solid #E5E7EB; }
    .products-table tbody td { padding: 12px; border-bottom: 1px solid #F3F4F6; font-size: 0.85rem; vertical-align: middle; }
    .product-code { font-family: monospace; background: #F3F4F6; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; display: inline-block; }
    .quantity-input { width: 80px; padding: 8px 10px; border: 1.5px solid #E5E7EB; border-radius: 10px; text-align: center; font-size: 0.85rem; }
    .price-input { width: 110px; padding: 8px 10px; border: 1.5px solid #E5E7EB; border-radius: 10px; text-align: right; font-size: 0.85rem; background: #F9FAFB; cursor: not-allowed; }
    .price-input:focus { outline: none; border-color: #E5E7EB; box-shadow: none; }
    .quantity-input:focus { outline: none; border-color: #E04545; box-shadow: 0 0 0 2px rgba(224,69,69,0.1); }
    .btn-remove { background: #FEF2F2; color: #E04545; border: none; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; transition: all 0.2s; }
    .btn-remove:hover { background: #FEE2E2; transform: scale(1.05); }
    .subtotal-cell { font-weight: 600; color: #1F2937; }
    .total-container { display: flex; justify-content: flex-end; margin-top: 24px; padding-top: 20px; border-top: 2px solid #E5E7EB; }
    .total-box { background: #F9FAFB; padding: 12px 28px; border-radius: 16px; text-align: right; border: 1px solid #E5E7EB; }
    .total-label { font-size: 1rem; font-weight: 600; color: #374151; margin-right: 16px; }
    .total-value { font-size: 1.6rem; font-weight: 800; color: #E04545; }
    .form-actions { display: flex; justify-content: flex-end; gap: 16px; margin-top: 32px; padding-top: 24px; border-top: 1px solid #F3F4F6; }
    .btn-cancel { background: #F3F4F6; color: #4B5563; border: none; padding: 10px 28px; border-radius: 12px; font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: all 0.2s; cursor: pointer; }
    .btn-cancel:hover { background: #E5E7EB; }
    .btn-submit { background: #E04545; color: white; border: none; padding: 10px 28px; border-radius: 12px; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
    .btn-submit:hover { background: #c93a3a; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(224,69,69,0.3); }

    .venta-modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1001; align-items: center; justify-content: center; }
    .venta-modal-content { background: white; border-radius: 24px; width: 90%; max-width: 700px; max-height: 85vh; overflow: hidden; animation: modalFadeIn 0.2s ease; box-shadow: 0 20px 35px -10px rgba(0,0,0,0.2); }
    .venta-modal-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #E5E7EB; background: white; }
    .venta-modal-header h3 { font-size: 1.2rem; font-weight: 600; color: #1F2937; margin: 0; display: flex; align-items: center; gap: 8px; }
    .venta-modal-close { background: none; border: none; font-size: 1.6rem; cursor: pointer; color: #9CA3AF; transition: color 0.2s; line-height: 1; }
    .venta-modal-close:hover { color: #E04545; }
    .venta-modal-body { padding: 20px 24px; max-height: 55vh; overflow-y: auto; }
    .venta-modal-footer { padding: 16px 24px; border-top: 1px solid #E5E7EB; display: flex; justify-content: flex-end; background: #F9FAFB; }
    .search-box-modal { display: flex; align-items: center; background: #F3F4F6; border-radius: 40px; padding: 10px 18px; margin-bottom: 20px; border: 1px solid transparent; transition: all 0.2s; }
    .search-box-modal:focus-within { background: white; border-color: #E04545; box-shadow: 0 0 0 3px rgba(224,69,69,0.1); }
    .search-box-modal i { color: #9CA3AF; font-size: 1rem; }
    .search-box-modal input { flex: 1; border: none; background: transparent; padding: 8px 12px; outline: none; font-size: 0.9rem; font-family: 'Inter', sans-serif; }
    .products-list { display: flex; flex-direction: column; gap: 10px; max-height: 400px; overflow-y: auto; }
    .product-item { display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; border: 1px solid #E5E7EB; border-radius: 14px; cursor: pointer; transition: all 0.2s; background: white; }
    .product-item:hover { background: #FEF2F2; border-color: #E04545; transform: translateX(4px); }
    .product-item-info { flex: 1; }
    .product-item-code { font-family: monospace; font-size: 0.7rem; color: #6B7280; margin-bottom: 4px; }
    .product-item-name { font-weight: 600; color: #1F2937; margin-bottom: 4px; }
    .product-item-stock { font-size: 0.7rem; color: #10B981; }
    .product-item-price { text-align: right; }
    .product-item-price .label { font-size: 0.7rem; color: #6B7280; display: block; }
    .product-item-price .value { font-weight: 700; color: #E04545; font-size: 1rem; }
    .btn-cancel-modal { background: #F3F4F6; color: #4B5563; border: none; padding: 10px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
    .btn-cancel-modal:hover { background: #E5E7EB; }
    @keyframes modalFadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    @media (max-width: 768px) {
        .form-card { padding: 24px; }
        .form-title { font-size: 1.5rem; }
        .form-actions { flex-direction: column; }
        .btn-cancel, .btn-submit { text-align: center; justify-content: center; }
        .products-table thead th { font-size: 0.7rem; padding: 10px 8px; }
        .products-table tbody td { padding: 10px 8px; }
        .quantity-input { width: 60px; font-size: 0.75rem; padding: 6px; }
        .price-input { width: 80px; font-size: 0.75rem; padding: 6px; }
        .total-box { padding: 10px 20px; }
        .total-value { font-size: 1.3rem; }
        .venta-modal-content { width: 95%; margin: 10px; }
        .product-item { flex-direction: column; text-align: center; gap: 10px; }
        .product-item-price { text-align: center; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Array de clientes disponibles (pasado desde el backend)
    const clientesDisponibles = @json($clientes);
    
    // Array de productos disponibles (con stock incluido)
    const productosDisponibles = @json($productos);
    let productosSeleccionados = [];

    // Elementos DOM para clientes
    const searchInputWrapper = document.getElementById('search-input-wrapper');
    const clienteSearchInput = document.getElementById('cliente-search');
    const clientesList = document.getElementById('clientes-list');
    const codClienteInput = document.getElementById('codCliente');
    const clienteSeleccionadoDiv = document.getElementById('cliente-seleccionado');
    const clienteNombreSpan = document.getElementById('cliente-nombre-seleccionado');
    const cambiarClienteBtn = document.getElementById('cambiarClienteBtn');

    // Elementos DOM para productos
    const modal = document.getElementById('productModal');
    const openModalBtn = document.getElementById('openProductModalBtn');
    const closeModalBtn = document.querySelector('.venta-modal-close');
    const closeModalFooterBtn = document.getElementById('closeModalBtn');
    const productsList = document.getElementById('productsList');
    const searchProductInput = document.getElementById('searchProductInput');
    const productosContainer = document.getElementById('productos-container');
    const totalValueSpan = document.getElementById('totalValue');

    // Mapa de stock de productos
    const stockMap = new Map();
    for (var i = 0; i < productosDisponibles.length; i++) {
        stockMap.set(productosDisponibles[i].codProducto, productosDisponibles[i].stock);
    }

    // ========== FUNCIONES PARA CLIENTES ==========
    function renderClientesList(filter) {
        filter = filter || '';
        var term = filter.toLowerCase();
        var filtered = [];
        for (var i = 0; i < clientesDisponibles.length; i++) {
            var c = clientesDisponibles[i];
            if ((c.nombre && c.nombre.toLowerCase().indexOf(term) !== -1) || 
                (c.apellidoPaterno && c.apellidoPaterno.toLowerCase().indexOf(term) !== -1) ||
                (c.carnetIdentidad && c.carnetIdentidad.toString().indexOf(term) !== -1)) {
                filtered.push(c);
            }
        }
        
        if (filtered.length === 0) {
            clientesList.innerHTML = '<div class="cliente-item" style="justify-content: center; color: #9CA3AF;">No se encontraron clientes</div>';
        } else {
            var html = '';
            for (var i = 0; i < filtered.length; i++) {
                var cliente = filtered[i];
                html += '<div class="cliente-item" onclick="seleccionarCliente(' + cliente.carnetIdentidad + ', \'' + cliente.nombre + ' ' + cliente.apellidoPaterno + ' ' + cliente.apellidoMaterno + '\')">' +
                            '<div class="cliente-info">' +
                                '<strong>' + cliente.nombre + ' ' + cliente.apellidoPaterno + ' ' + cliente.apellidoMaterno + '</strong>' +
                                '<small>Cel: ' + cliente.celular + '</small>' +
                                '<div class="cliente-ci">CI: ' + cliente.carnetIdentidad + '</div>' +
                            '</div>' +
                        '</div>';
            }
            clientesList.innerHTML = html;
        }
        clientesList.classList.add('show');
    }

    window.seleccionarCliente = function(carnet, nombreCompleto) {
        codClienteInput.value = carnet;
        clienteNombreSpan.innerText = nombreCompleto;
        searchInputWrapper.style.display = 'none';
        clienteSeleccionadoDiv.style.display = 'block';
        clienteSearchInput.value = '';
        clientesList.classList.remove('show');
    };

    function limpiarClienteSeleccionado() {
        codClienteInput.value = '';
        clienteSearchInput.value = '';
        searchInputWrapper.style.display = 'flex';
        clienteSeleccionadoDiv.style.display = 'none';
        clienteSearchInput.focus();
    }

    if (cambiarClienteBtn) {
        cambiarClienteBtn.addEventListener('click', limpiarClienteSeleccionado);
    }

    if (clienteSearchInput) {
        clienteSearchInput.addEventListener('input', function(e) {
            renderClientesList(e.target.value);
        });
        
        clienteSearchInput.addEventListener('focus', function() {
            if (clienteSearchInput.value !== '') {
                renderClientesList(clienteSearchInput.value);
            }
        });
    }

    document.addEventListener('click', function(e) {
        if (!clienteSearchInput || !clientesList || !searchInputWrapper) return;
        if (!clienteSearchInput.contains(e.target) && !clientesList.contains(e.target) && !searchInputWrapper.contains(e.target)) {
            clientesList.classList.remove('show');
        }
    });

    // ========== FUNCIONES PARA PRODUCTOS ==========
    function formatNumber(value) {
        var num = parseFloat(value);
        return isNaN(num) ? 0 : num;
    }

    function calcularSubtotal(cantidad, precio) {
        return formatNumber(cantidad) * formatNumber(precio);
    }

    if (openModalBtn) {
        openModalBtn.addEventListener('click', function() {
            renderProductsList(productosDisponibles);
            modal.style.display = 'flex';
        });
    }

    function closeModal() {
        modal.style.display = 'none';
        if (searchProductInput) searchProductInput.value = '';
        renderProductsList(productosDisponibles);
    }

    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (closeModalFooterBtn) closeModalFooterBtn.addEventListener('click', closeModal);
    if (modal) {
        modal.addEventListener('click', function(e) { 
            if (e.target === modal) closeModal(); 
        });
    }

    if (searchProductInput) {
        searchProductInput.addEventListener('input', function(e) {
            var searchTerm = e.target.value.toLowerCase();
            var filtered = [];
            for (var i = 0; i < productosDisponibles.length; i++) {
                var p = productosDisponibles[i];
                if ((p.codProducto && p.codProducto.toLowerCase().indexOf(searchTerm) !== -1) || 
                    (p.nombre && p.nombre.toLowerCase().indexOf(searchTerm) !== -1)) {
                    filtered.push(p);
                }
            }
            renderProductsList(filtered);
        });
    }

    function renderProductsList(productos) {
        if (!productsList) return;
        if (!productos || productos.length === 0) {
            productsList.innerHTML = '<div class="empty-products-message" style="padding: 40px;"><i class="fas fa-box-open"></i><p>No se encontraron productos</p></div>';
            return;
        }
        var html = '';
        for (var i = 0; i < productos.length; i++) {
            var producto = productos[i];
            var precio = formatNumber(producto.precio);
            var stock = formatNumber(producto.stock);
            var nombreEscapado = producto.nombre.replace(/'/g, "\\'");
            html += '<div class="product-item" onclick="seleccionarProducto(\'' + producto.codProducto + '\', \'' + nombreEscapado + '\', ' + precio + ', ' + stock + ')">' +
                        '<div class="product-item-info">' +
                            '<div class="product-item-code">' + (producto.codProducto || '') + '</div>' +
                            '<div class="product-item-name">' + (producto.nombre || '') + '</div>' +
                            '<div class="product-item-stock"><i class="fas fa-boxes"></i> Stock disponible: ' + stock + '</div>' +
                        '</div>' +
                        '<div class="product-item-price">' +
                            '<span class="label">Precio de venta</span>' +
                            '<span class="value">Bs ' + precio.toFixed(2) + '</span>' +
                        '</div>' +
                    '</div>';
        }
        productsList.innerHTML = html;
    }

    window.seleccionarProducto = function(codProducto, nombre, precioSugerido, stockDisponible) {
        var precioNum = formatNumber(precioSugerido);
        var existe = false;
        for (var i = 0; i < productosSeleccionados.length; i++) {
            if (productosSeleccionados[i].codProducto === codProducto) {
                existe = true;
                break;
            }
        }
        if (existe) {
            Swal.fire({ icon: 'warning', title: 'Producto duplicado', text: 'Este producto ya ha sido agregado.', confirmButtonColor: '#E04545' });
            closeModal();
            return;
        }
        
        if (stockDisponible <= 0) {
            Swal.fire({ icon: 'error', title: 'Stock insuficiente', text: 'No hay stock disponible de este producto.', confirmButtonColor: '#E04545' });
            closeModal();
            return;
        }
        
        productosSeleccionados.push({
            codProducto: codProducto,
            nombre: nombre,
            cantidad: 1,
            precioVenta: precioNum,
            stockMaximo: stockDisponible,
            subtotal: precioNum
        });
        renderTablaProductos();
        closeModal();
    };

    function renderTablaProductos() {
        if (!productosContainer) return;
        if (productosSeleccionados.length === 0) {
            productosContainer.innerHTML = '<div class="empty-products-message"><i class="fas fa-box-open"></i><p>No hay productos agregados. Haz clic en "Agregar Producto" para comenzar.</p></div>';
            if (totalValueSpan) totalValueSpan.innerText = 'Bs 0.00';
            return;
        }
        
        var html = '<table class="products-table">' +
                        '<thead>' +
                            '<tr><th>Código</th><th>Producto</th><th>Cantidad</th><th>Precio Unitario (Bs)</th><th>Subtotal</th><th></th></tr>' +
                        '</thead>' +
                        '<tbody>';
        
        for (var i = 0; i < productosSeleccionados.length; i++) {
            var p = productosSeleccionados[i];
            var subtotal = calcularSubtotal(p.cantidad, p.precioVenta);
            html += '<tr>' +
                        '<td><span class="product-code">' + p.codProducto + '</span></td>' +
                        '<td>' + p.nombre + '</td>' +
                        '<td><input type="number" class="quantity-input" value="' + p.cantidad + '" min="1" max="' + p.stockMaximo + '" data-index="' + i + '" onchange="actualizarCantidad(' + i + ', this.value)">' +
                        '<td><input type="number" step="0.01" class="price-input" value="' + p.precioVenta.toFixed(2) + '" readonly disabled></td>' +
                        '<td class="subtotal-cell">Bs ' + subtotal.toFixed(2) + '</td>' +
                        '<td><button type="button" class="btn-remove" onclick="eliminarProducto(' + i + ')"><i class="fas fa-trash-alt"></i></button></td>' +
                    '</tr>';
        }
        
        html += '</tbody></table>';
        productosContainer.innerHTML = html;
        actualizarTotal();
    }

    window.actualizarCantidad = function(index, nuevaCantidad) {
        var cantidad = parseInt(nuevaCantidad) || 0;
        var stockMaximo = productosSeleccionados[index].stockMaximo;
        
        if (cantidad <= 0) {
            eliminarProducto(index);
            return;
        }
        
        if (cantidad > stockMaximo) {
            Swal.fire({ 
                icon: 'error', 
                title: 'Stock insuficiente', 
                text: 'La cantidad solicitada (' + cantidad + ') supera el stock disponible (' + stockMaximo + ').', 
                confirmButtonColor: '#E04545' 
            });
            // Restaurar valor anterior
            renderTablaProductos();
            return;
        }
        
        productosSeleccionados[index].cantidad = cantidad;
        productosSeleccionados[index].subtotal = calcularSubtotal(productosSeleccionados[index].cantidad, productosSeleccionados[index].precioVenta);
        renderTablaProductos();
    };

    window.eliminarProducto = function(index) {
        productosSeleccionados.splice(index, 1);
        renderTablaProductos();
    };

    function actualizarTotal() {
        if (!totalValueSpan) return;
        var total = 0;
        for (var i = 0; i < productosSeleccionados.length; i++) {
            total += calcularSubtotal(productosSeleccionados[i].cantidad, productosSeleccionados[i].precioVenta);
        }
        totalValueSpan.innerText = 'Bs ' + total.toFixed(2);
    }

    var ventaForm = document.getElementById('ventaForm');
    if (ventaForm) {
        ventaForm.addEventListener('submit', function(e) {
            if (productosSeleccionados.length === 0) {
                e.preventDefault();
                Swal.fire({ icon: 'error', title: 'Sin productos', text: 'Debe agregar al menos un producto a la venta.', confirmButtonColor: '#E04545' });
                return;
            }
            if (!codClienteInput.value) {
                e.preventDefault();
                Swal.fire({ icon: 'error', title: 'Cliente no seleccionado', text: 'Debe seleccionar un cliente para la venta.', confirmButtonColor: '#E04545' });
                return;
            }
            
            var existingInputs = ventaForm.querySelectorAll('input[name^="productos["]');
            for (var i = 0; i < existingInputs.length; i++) {
                existingInputs[i].remove();
            }
            
            for (var idx = 0; idx < productosSeleccionados.length; idx++) {
                var producto = productosSeleccionados[idx];
                
                var inputCod = document.createElement('input');
                inputCod.type = 'hidden';
                inputCod.name = 'productos[' + idx + '][codProducto]';
                inputCod.value = producto.codProducto;
                ventaForm.appendChild(inputCod);
                
                var inputCant = document.createElement('input');
                inputCant.type = 'hidden';
                inputCant.name = 'productos[' + idx + '][cantidad]';
                inputCant.value = producto.cantidad;
                ventaForm.appendChild(inputCant);
                
                var inputPrecio = document.createElement('input');
                inputPrecio.type = 'hidden';
                inputPrecio.name = 'productos[' + idx + '][precioVenta]';
                inputPrecio.value = producto.precioVenta;
                ventaForm.appendChild(inputPrecio);
            }
        });
    }
</script>
@endpush
@endsection