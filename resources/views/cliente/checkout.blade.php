@extends('layouts.cliente-layout')

@section('title', 'Checkout - Finalizar Compra - BODY FIT')

@section('content')
<div class="checkout-container">
    <div class="page-header">
        <h1 class="page-title">Finalizar Compra</h1>
        <p class="page-description">Revisa tu pedido y completa los datos para finalizar</p>
    </div>

    <div class="checkout-grid">
        <!-- Columna Izquierda - Datos de envío y pago -->
        <div class="checkout-form">
            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-user"></i>
                    <h3>Datos de Contacto</h3>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label>Nombre completo</label>
                        <input type="text" id="nombre" class="form-control" value="{{ $cliente->nombre ?? '' }} {{ $cliente->apellidoPaterno ?? '' }}" readonly disabled>
                    </div>
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" id="email" class="form-control" value="{{ Auth::user()->email ?? '' }}" readonly disabled>
                    </div>
                    <div class="form-group">
                        <label>Teléfono / Celular <span class="required">*</span></label>
                        <input type="text" id="telefono" class="form-control" value="{{ $cliente->celular ?? '' }}" placeholder="Ej: 71234567" required>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Dirección de Envío</h3>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label>Dirección <span class="required">*</span></label>
                        <textarea id="direccion" rows="3" class="form-control" placeholder="Calle, número, zona, referencia..."></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Ciudad <span class="required">*</span></label>
                            <input type="text" id="ciudad" class="form-control" placeholder="Ej: La Paz">
                        </div>
                        <div class="form-group">
                            <label>Código Postal</label>
                            <input type="text" id="codigo_postal" class="form-control" placeholder="Ej: 1234">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-credit-card"></i>
                    <h3>Método de Pago</h3>
                </div>
                <div class="form-body">
                    <div class="payment-methods">
                        <label class="payment-option">
                            <input type="radio" name="metodo_pago" value="transferencia" checked>
                            <div class="payment-card">
                                <i class="fas fa-university"></i>
                                <div>
                                    <strong>Transferencia Bancaria</strong>
                                    <small>Paga con transferencia o depósito</small>
                                </div>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="metodo_pago" value="qr">
                            <div class="payment-card">
                                <i class="fas fa-qrcode"></i>
                                <div>
                                    <strong>Pago con QR</strong>
                                    <small>Escanea y paga con tu billetera móvil</small>
                                </div>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="metodo_pago" value="efectivo">
                            <div class="payment-card">
                                <i class="fas fa-money-bill-wave"></i>
                                <div>
                                    <strong>Pago contra entrega</strong>
                                    <small>Paga al recibir tu pedido</small>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Información de transferencia (mostrar solo cuando se selecciona) -->
                    <div id="info-transferencia" class="payment-info">
                        <div class="info-box">
                            <i class="fas fa-info-circle"></i>
                            <div>
                                <strong>Datos para transferencia:</strong>
                                <p>Banco: BODY FIT S.A.<br>
                                N° Cuenta: 123-456789-0<br>
                                CI/NIT: 123456789<br>
                                Email: pagos@bodyfit.com</p>
                            </div>
                        </div>
                    </div>
                    <div id="info-qr" class="payment-info" style="display: none;">
                        <div class="info-box text-center">
                            <i class="fas fa-qrcode fa-3x" style="color: #E04545;"></i>
                            <p>Escanea el código QR desde tu billetera móvil</p>
                            <div class="qr-placeholder">
                                <i class="fas fa-qrcode" style="font-size: 80px; color: #1F2937;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha - Resumen del pedido -->
        <div class="order-summary">
            <div class="summary-card">
                <div class="summary-header">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Resumen del Pedido</h3>
                </div>
                <div class="summary-body">
                    <div class="summary-items" id="orderItems">
                        <!-- Los productos se cargarán aquí dinámicamente -->
                    </div>
                    <div class="summary-totals">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span id="subtotal">Bs 0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Envío:</span>
                            <span id="envio">Bs 15.00</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span id="total">Bs 0.00</span>
                        </div>
                    </div>
                </div>
                <div class="summary-footer">
                    <button class="btn-confirm" id="confirmarCompraBtn">
                        <i class="fas fa-check-circle"></i> Confirmar Compra
                    </button>
                    <a href="{{ route('cliente.productos') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Seguir comprando
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1F2937;
        margin-bottom: 8px;
    }

    .page-description {
        color: #6B7280;
        font-size: 0.9rem;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 32px;
    }

    .form-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E8ECEF;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 24px;
        background: #F9FAFB;
        border-bottom: 1px solid #E8ECEF;
    }

    .form-header i {
        font-size: 1.3rem;
        color: #E04545;
    }

    .form-header h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #1F2937;
        margin: 0;
    }

    .form-body {
        padding: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        color: #374151;
    }

    .required {
        color: #E04545;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #E5E7EB;
        border-radius: 12px;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #E04545;
        box-shadow: 0 0 0 3px rgba(224, 69, 69, 0.1);
    }

    .form-control:disabled {
        background: #F9FAFB;
        color: #6B7280;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .payment-option {
        cursor: pointer;
    }

    .payment-option input[type="radio"] {
        display: none;
    }

    .payment-option input[type="radio"]:checked + .payment-card {
        border-color: #E04545;
        background: #FEF2F2;
    }

    .payment-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px;
        border: 2px solid #E5E7EB;
        border-radius: 14px;
        transition: all 0.2s;
    }

    .payment-card i {
        font-size: 1.8rem;
        color: #E04545;
    }

    .payment-card strong {
        display: block;
        font-size: 0.85rem;
        margin-bottom: 4px;
    }

    .payment-card small {
        font-size: 0.7rem;
        color: #6B7280;
    }

    .payment-info {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #F3F4F6;
    }

    .info-box {
        display: flex;
        gap: 16px;
        padding: 16px;
        background: #F0FDF4;
        border-radius: 14px;
        border-left: 4px solid #10B981;
    }

    .info-box i {
        color: #10B981;
        font-size: 1.2rem;
    }

    .info-box p {
        font-size: 0.8rem;
        color: #065F46;
        margin-top: 6px;
    }

    .qr-placeholder {
        background: white;
        padding: 16px;
        border-radius: 16px;
        display: inline-block;
        margin-top: 12px;
    }

    .order-summary {
        position: sticky;
        top: 90px;
    }

    .summary-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E8ECEF;
        overflow: hidden;
    }

    .summary-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 24px;
        background: #F9FAFB;
        border-bottom: 1px solid #E8ECEF;
    }

    .summary-header i {
        font-size: 1.3rem;
        color: #E04545;
    }

    .summary-header h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #1F2937;
        margin: 0;
    }

    .summary-body {
        padding: 24px;
    }

    .summary-items {
        max-height: 300px;
        overflow-y: auto;
        margin-bottom: 20px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #F3F4F6;
    }

    .summary-item-info {
        flex: 1;
    }

    .summary-item-name {
        font-weight: 600;
        font-size: 0.85rem;
        color: #1F2937;
    }

    .summary-item-qty {
        font-size: 0.7rem;
        color: #6B7280;
    }

    .summary-item-price {
        font-weight: 600;
        color: #E04545;
    }

    .summary-totals {
        border-top: 1px solid #E8ECEF;
        padding-top: 16px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 0.85rem;
    }

    .summary-row.total {
        margin-top: 8px;
        padding-top: 12px;
        border-top: 2px solid #E8ECEF;
        font-size: 1rem;
        font-weight: 700;
    }

    .summary-row.total span:last-child {
        color: #E04545;
        font-size: 1.2rem;
    }

    .summary-footer {
        padding: 20px 24px;
        border-top: 1px solid #E8ECEF;
    }

    .btn-confirm {
        width: 100%;
        background: #E04545;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .btn-confirm:hover {
        background: #c93a3a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(224, 69, 69, 0.3);
    }

    .btn-back {
        width: 100%;
        background: #F3F4F6;
        color: #4B5563;
        border: none;
        padding: 12px;
        border-radius: 14px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: #E5E7EB;
    }

    @media (max-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
        .order-summary {
            position: static;
            margin-top: 24px;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.4rem;
        }
        .form-row {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        .form-header, .form-body {
            padding: 16px 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    (function() {
        // Función para cargar el carrito correctamente
        function loadCartFromStorage() {
            const savedCart = localStorage.getItem('bodyfit_cart');
            if (savedCart) {
                try {
                    return JSON.parse(savedCart);
                } catch (e) {
                    console.error('Error parsing cart:', e);
                    return [];
                }
            }
            return [];
        }

        const envioCosto = 15.00;

        function renderOrderSummary() {
            const container = document.getElementById('orderItems');
            const subtotalSpan = document.getElementById('subtotal');
            const totalSpan = document.getElementById('total');
            
            if (!container) return;
            
            // Recargar carrito
            var cartItems = loadCartFromStorage();
            
            if (!cartItems || cartItems.length === 0) {
                container.innerHTML = '<div style="text-align: center; padding: 20px; color: #9CA3AF;">No hay productos en el carrito</div>';
                if (subtotalSpan) subtotalSpan.innerText = 'Bs 0.00';
                if (totalSpan) totalSpan.innerText = 'Bs 0.00';
                return;
            }
            
            var subtotal = 0;
            var html = '';
            
            for (var i = 0; i < cartItems.length; i++) {
                var item = cartItems[i];
                var itemSubtotal = (item.precio || 0) * (item.cantidad || 0);
                subtotal += itemSubtotal;
                html += '<div class="summary-item">' +
                            '<div class="summary-item-info">' +
                                '<div class="summary-item-name">' + escapeHtml(item.nombre) + '</div>' +
                                '<div class="summary-item-qty">Cantidad: ' + (item.cantidad || 0) + '</div>' +
                            '</div>' +
                            '<div class="summary-item-price">Bs ' + itemSubtotal.toFixed(2) + '</div>' +
                        '</div>';
            }
            
            container.innerHTML = html;
            if (subtotalSpan) subtotalSpan.innerText = 'Bs ' + subtotal.toFixed(2);
            var total = subtotal + envioCosto;
            if (totalSpan) totalSpan.innerText = 'Bs ' + total.toFixed(2);
        }

        // Función para escapar HTML
        function escapeHtml(text) {
            if (!text) return '';
            var div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Cambio de método de pago
        var radios = document.querySelectorAll('input[name="metodo_pago"]');
        for (var i = 0; i < radios.length; i++) {
            radios[i].addEventListener('change', function() {
                var transferenciaDiv = document.getElementById('info-transferencia');
                var qrDiv = document.getElementById('info-qr');
                
                if (transferenciaDiv) transferenciaDiv.style.display = 'none';
                if (qrDiv) qrDiv.style.display = 'none';
                
                if (this.value === 'transferencia' && transferenciaDiv) {
                    transferenciaDiv.style.display = 'block';
                } else if (this.value === 'qr' && qrDiv) {
                    qrDiv.style.display = 'block';
                }
            });
        }

        // Confirmar compra
        var confirmarBtn = document.getElementById('confirmarCompraBtn');
        if (confirmarBtn) {
            confirmarBtn.addEventListener('click', function() {
                // Recargar carrito
                var cartItems = loadCartFromStorage();
                
                // Validar campos requeridos
                var telefono = document.getElementById('telefono').value;
                var direccion = document.getElementById('direccion').value;
                var ciudad = document.getElementById('ciudad').value;
                
                if (!telefono) {
                    Swal.fire({ icon: 'error', title: 'Campo requerido', text: 'Por favor ingresa tu número de teléfono.', confirmButtonColor: '#E04545' });
                    return;
                }
                
                if (!direccion) {
                    Swal.fire({ icon: 'error', title: 'Campo requerido', text: 'Por favor ingresa tu dirección de envío.', confirmButtonColor: '#E04545' });
                    return;
                }
                
                if (!ciudad) {
                    Swal.fire({ icon: 'error', title: 'Campo requerido', text: 'Por favor ingresa tu ciudad.', confirmButtonColor: '#E04545' });
                    return;
                }
                
                if (!cartItems || cartItems.length === 0) {
                    Swal.fire({ icon: 'error', title: 'Carrito vacío', text: 'No hay productos para comprar.', confirmButtonColor: '#E04545' });
                    return;
                }
                
                var metodoPagoRadio = document.querySelector('input[name="metodo_pago"]:checked');
                var metodoPagoValue = metodoPagoRadio ? metodoPagoRadio.value : 'transferencia';
                
                // Calcular total correctamente
                var subtotal = 0;
                for (var i = 0; i < cartItems.length; i++) {
                    subtotal += (cartItems[i].precio || 0) * (cartItems[i].cantidad || 0);
                }
                var total = subtotal + envioCosto;
                
                Swal.fire({
                    title: '¿Confirmar compra?',
                    html: '<p>Total a pagar: <strong>Bs ' + total.toFixed(2) + '</strong></p>' +
                           '<p>Método de pago: <strong>' + (metodoPagoValue === 'transferencia' ? 'Transferencia bancaria' : (metodoPagoValue === 'qr' ? 'Pago con QR' : 'Pago contra entrega')) + '</strong></p>',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#E04545',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Sí, confirmar compra',
                    cancelButtonText: 'Cancelar'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Procesando compra...',
                            text: 'Por favor espera',
                            allowOutsideClick: false,
                            didOpen: function() { Swal.showLoading(); }
                        });
                        
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("cliente.checkout") }}';
                        form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                        '<input type="hidden" name="cart" value=\'' + JSON.stringify(cartItems) + '\'>' +
                                        '<input type="hidden" name="telefono" value="' + escapeHtml(telefono) + '">' +
                                        '<input type="hidden" name="direccion" value="' + escapeHtml(direccion) + '">' +
                                        '<input type="hidden" name="ciudad" value="' + escapeHtml(ciudad) + '">' +
                                        '<input type="hidden" name="codigo_postal" value="' + escapeHtml(document.getElementById('codigo_postal').value) + '">' +
                                        '<input type="hidden" name="metodo_pago" value="' + metodoPagoValue + '">';
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            renderOrderSummary();
            
            var cartItems = loadCartFromStorage();
            if (!cartItems || cartItems.length === 0) {
                setTimeout(function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Carrito vacío',
                        text: 'No tienes productos en tu carrito. Serás redirigido a la tienda.',
                        confirmButtonColor: '#E04545',
                        timer: 2000,
                        showConfirmButton: true
                    }).then(function() {
                        window.location.href = '{{ route("cliente.productos") }}';
                    });
                }, 500);
            }
        });
    })();
</script>
@endpush
@endsection