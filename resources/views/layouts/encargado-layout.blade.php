<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>@yield('title', 'BODY FIT Encargado')</title>
    <!-- Google Fonts + Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F8F9FA;
            color: #1A1A1A;
            overflow-x: hidden;
        }

        /* ========== BARRA SUPERIOR (TOP BAR) ========== */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: white;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .top-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu-toggle-btn {
            background: transparent;
            border: none;
            font-size: 1.4rem;
            cursor: pointer;
            color: #5F6368;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .menu-toggle-btn:hover {
            background: #F1F3F4;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .logo i {
            font-size: 1.8rem;
            color: #E04545;
        }

        .logo span {
            font-size: 1.3rem;
            font-weight: 700;
            color: #E04545;
            letter-spacing: -0.5px;
        }

        .search-container {
            flex: 1;
            max-width: 500px;
            margin: 0 20px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #F1F3F4;
            border-radius: 40px;
            padding: 6px 16px;
            border: 1px solid transparent;
            transition: all 0.2s;
        }

        .search-box:hover {
            background: #E8EAED;
        }

        .search-box:focus-within {
            background: white;
            border-color: #E04545;
            box-shadow: 0 0 0 2px rgba(224, 69, 69, 0.2);
        }

        .search-box i {
            color: #5F6368;
            font-size: 1.1rem;
        }

        .search-box input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px 12px;
            font-size: 0.9rem;
            outline: none;
            font-family: 'Inter', sans-serif;
        }

        /* Resultados de búsqueda */
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border: 1px solid #E5E7EB;
            margin-top: 8px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .search-results.show {
            display: block;
        }

        .search-results .result-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            color: #374151;
            transition: background 0.2s;
            border-bottom: 1px solid #F3F4F6;
        }

        .search-results .result-item:hover {
            background: #FEF2F2;
        }

        .search-results .result-item i {
            width: 24px;
            color: #E04545;
        }

        .result-title {
            font-weight: 600;
            font-size: 0.85rem;
        }

        .result-subtitle {
            font-size: 0.7rem;
            color: #6B7280;
        }

        .no-results {
            padding: 20px;
            text-align: center;
            color: #9CA3AF;
        }

        .top-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .icon-btn {
            background: transparent;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: #5F6368;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .icon-btn:hover {
            background: #F1F3F4;
        }

        /* Avatar con foto o iniciales */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            overflow: hidden;
            background: linear-gradient(135deg, #E04545, #c93a3a);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: white;
        }

        .avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(224, 69, 69, 0.3);
        }

        /* ========== BARRA LATERAL (SIDEBAR) ========== */
        .sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            bottom: 0;
            width: 260px;
            background: white;
            border-right: 1px solid #E5E7EB;
            transition: transform 0.25s ease;
            z-index: 99;
            overflow-y: auto;
            padding: 16px 0;
        }

        .sidebar.closed {
            transform: translateX(-260px);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 24px;
            margin: 4px 12px;
            border-radius: 12px;
            text-decoration: none;
            color: #2D2D2D;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .nav-item i {
            width: 24px;
            font-size: 1.2rem;
            color: #5F6368;
        }

        .nav-item:hover {
            background: #F1F3F4;
        }

        .nav-item.active {
            background: rgba(224, 69, 69, 0.1);
            color: #E04545;
        }

        .nav-item.active i {
            color: #E04545;
        }

        /* Contenido principal */
        .main-content {
            margin-top: 64px;
            margin-left: 260px;
            padding: 24px 32px;
            transition: margin-left 0.25s ease;
            min-height: calc(100vh - 64px);
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F1F3F4;
        }
        ::-webkit-scrollbar-thumb {
            background: #C1C1C1;
            border-radius: 10px;
        }

        /* Dropdown para el avatar */
        .avatar-dropdown {
            position: relative;
        }
        .dropdown-menu {
            position: absolute;
            top: 55px;
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            width: 240px;
            padding: 8px 0;
            z-index: 200;
            display: none;
            border: 1px solid #E5E7EB;
        }
        .dropdown-menu.show {
            display: block;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            text-decoration: none;
            color: #2D2D2D;
            font-size: 0.85rem;
            transition: background 0.2s;
        }
        .dropdown-item i {
            width: 20px;
            color: #5F6368;
        }
        .dropdown-item:hover {
            background: #F1F3F4;
        }
        .dropdown-divider {
            height: 1px;
            background: #E5E7EB;
            margin: 8px 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .top-bar {
                padding: 0 16px;
            }
            .logo span {
                display: none;
            }
            .search-container {
                max-width: 200px;
                margin: 0 12px;
            }
            .search-box input {
                display: none;
            }
            .search-box:focus-within input {
                display: block;
                width: 150px;
            }
            .main-content {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .search-container {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- BARRA SUPERIOR -->
    <div class="top-bar">
        <div class="top-left">
            <button class="menu-toggle-btn" id="menuToggleBtn">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('encargado.dashboard') }}" class="logo">
                <i class="fas fa-dumbbell"></i>
                <span>BODY FIT</span>
            </a>
        </div>

        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="globalSearch" placeholder="Buscar clientes, productos..." autocomplete="off">
            </div>
            <div id="searchResults" class="search-results"></div>
        </div>

        <div class="top-right">
            <button class="icon-btn" id="searchMobileBtn" style="display: none;">
                <i class="fas fa-search"></i>
            </button>
            <div class="avatar-dropdown">
                @php
                    $encargadoActual = App\Models\Encargado::where('codUsuario', Auth::user()->codUsuario ?? 0)->first();
                    $fotoPerfil = $encargadoActual && $encargadoActual->foto ? Storage::url($encargadoActual->foto) : null;
                @endphp
                <div class="avatar" id="avatarBtn">
                    @if($fotoPerfil)
                        <img src="{{ $fotoPerfil }}" alt="Foto de perfil">
                    @else
                        <span>{{ strtoupper(substr(Auth::user()->name ?? 'EC', 0, 2)) }}</span>
                    @endif
                </div>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="{{ route('encargado.perfil.index') }}" class="dropdown-item">
                        <i class="fas fa-user-circle"></i> Mi perfil
                    </a>
                    <a href="{{ route('encargado.configuracion.index') }}" class="dropdown-item">
                        <i class="fas fa-cog"></i> Configuración
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- BARRA LATERAL - Opciones para el Encargado -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('encargado.dashboard') }}" class="nav-item {{ request()->routeIs('encargado.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Inicio</span>
        </a>
        <a href="{{ route('cliente.index') }}" class="nav-item {{ request()->routeIs('encargado.cliente.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Gestionar Clientes</span>
        </a>
        <a href="{{ route('categoria.index') }}" class="nav-item {{ request()->routeIs('encargado.categoria.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>
            <span>Gestionar Categorías</span>
        </a>
        <a href="{{ route('producto.index') }}" class="nav-item {{ request()->routeIs('encargado.producto.*') ? 'active' : '' }}">
            <i class="fas fa-boxes"></i>
            <span>Gestionar Productos</span>
        </a>
        <a href="{{ route('proveedor.index') }}" class="nav-item {{ request()->routeIs('encargado.proveedor.*') ? 'active' : '' }}">
            <i class="fas fa-truck"></i>
            <span>Gestionar Proveedores</span>
        </a>
        <a href="{{ route('compra.index') }}" class="nav-item {{ request()->routeIs('encargado.compra.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Gestionar Compras</span>
        </a>
        <a href="{{ route('venta.index') }}" class="nav-item {{ request()->routeIs('encargado.venta.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Gestionar Ventas</span>
        </a>
        <a href="{{ route('reportes.index') }}" class="nav-item {{ request()->routeIs('encargado.reportes.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <span>Reportes</span>
        </a>
    </div>

    <!-- CONTENIDO PRINCIPAL DINÁMICO -->
    <div class="main-content" id="mainContent">
        @yield('content')
    </div>

    <script>
        // Elementos DOM
        const menuToggleBtn = document.getElementById('menuToggleBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const avatarBtn = document.getElementById('avatarBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const searchMobileBtn = document.getElementById('searchMobileBtn');
        const searchContainer = document.querySelector('.search-container');
        const globalSearch = document.getElementById('globalSearch');
        const searchResults = document.getElementById('searchResults');

        // Toggle menú lateral
        if (menuToggleBtn) {
            menuToggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('closed');
                mainContent.classList.toggle('expanded');
            });
        }

        // Dropdown del avatar
        if (avatarBtn) {
            avatarBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });
        }

        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (dropdownMenu && avatarBtn && !avatarBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
            // Cerrar resultados de búsqueda al hacer clic fuera
            if (searchResults && !searchContainer.contains(e.target)) {
                searchResults.classList.remove('show');
            }
        });

        // Mostrar buscador móvil
        function checkMobileSearch() {
            if (window.innerWidth <= 480) {
                if (searchMobileBtn) searchMobileBtn.style.display = 'flex';
                if (searchContainer) searchContainer.style.display = 'none';
            } else {
                if (searchMobileBtn) searchMobileBtn.style.display = 'none';
                if (searchContainer) searchContainer.style.display = 'block';
            }
        }

        if (searchMobileBtn) {
            searchMobileBtn.addEventListener('click', () => {
                const query = prompt('🔍 Ingresa tu búsqueda:');
                if (query && query.trim() !== '') {
                    performSearch(query);
                }
            });
        }

        // Función para realizar la búsqueda
        let searchTimeout;
        
        function performSearch(query) {
            if (query.length < 2) {
                searchResults.classList.remove('show');
                return;
            }

            // Mostrar loading
            searchResults.innerHTML = '<div class="no-results"><i class="fas fa-spinner fa-spin"></i> Buscando...</div>';
            searchResults.classList.add('show');

            // Realizar petición AJAX
            fetch(`{{ route('encargado.search') }}?q=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.results.length === 0) {
                    searchResults.innerHTML = '<div class="no-results"><i class="fas fa-search"></i> No se encontraron resultados</div>';
                    return;
                }

                let html = '';
                data.results.forEach(result => {
                    html += `
                        <a href="${result.url}" class="result-item">
                            <i class="${result.icon}"></i>
                            <div>
                                <div class="result-title">${result.title}</div>
                                <div class="result-subtitle">${result.subtitle}</div>
                            </div>
                        </a>
                    `;
                });
                searchResults.innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                searchResults.innerHTML = '<div class="no-results"><i class="fas fa-exclamation-triangle"></i> Error al buscar</div>';
            });
        }

        // Búsqueda global en tiempo real
        if (globalSearch) {
            globalSearch.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                const query = e.target.value.trim();
                searchTimeout = setTimeout(() => {
                    performSearch(query);
                }, 300);
            });
            
            globalSearch.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    const query = e.target.value.trim();
                    if (query !== '') {
                        window.location.href = `{{ route('encargado.search') }}?q=${encodeURIComponent(query)}`;
                    }
                }
            });
        }

        window.addEventListener('resize', checkMobileSearch);
        checkMobileSearch();
    </script>

    @stack('scripts')
    
    <!-- SweetAlert2 CSS y JS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script para mostrar mensajes flash -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#E04545',
                    confirmButtonText: 'Aceptar',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#E04545',
                    confirmButtonText: 'Entendido'
                });
            @endif

            @if(session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: '¡Atención!',
                    text: '{{ session('warning') }}',
                    confirmButtonColor: '#E04545',
                    confirmButtonText: 'Aceptar'
                });
            @endif

            @if(session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Información',
                    text: '{{ session('info') }}',
                    confirmButtonColor: '#E04545',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
    <script>
    // ========== FUNCIONALIDAD DE TEMA (CLARO/OSCURO) ==========
    
    // Obtener el tema guardado o el tema del sistema
    function getInitialTheme() {
        const savedTheme = localStorage.getItem('bodyfit_theme');
        if (savedTheme) {
            return savedTheme;
        }
        // Detectar preferencia del sistema
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    // Aplicar tema
    function applyTheme(theme) {
        if (theme === 'dark') {
            let style = document.getElementById('dark-theme-style');
            if (!style) {
                style = document.createElement('style');
                style.id = 'dark-theme-style';
                style.textContent = `
                    body { background: #1a1a1a !important; color: #e5e5e5 !important; }
                    .top-bar, .sidebar, .form-card, .config-card, .perfil-card,
                    .producto-card, .categoria-card, .proveedor-card, .encargado-card, 
                    .cliente-card, .table-container, .stat-card, .chart-container,
                    .column-card, .quick-reports, .recent-section, .dashboard-container,
                    .filters-card, .compra-card, .venta-card, .detail-card, .summary-card {
                        background: #2d2d2d !important;
                        border-color: #404040 !important;
                        color: #e5e5e5 !important;
                    }
                    .data-table thead th, .summary-header, .form-header, .compra-header,
                    .venta-header, .detail-header, .modal-header, .card-header {
                        background: #3a3a3a !important;
                        color: #e5e5e5 !important;
                    }
                    .data-table tbody td, .summary-body, .form-body, .compra-body,
                    .venta-body, .detail-body, .modal-body {
                        border-color: #404040 !important;
                        color: #e5e5e5 !important;
                    }
                    .form-control, select.form-control, textarea.form-control {
                        background: #3a3a3a !important;
                        border-color: #505050 !important;
                        color: #e5e5e5 !important;
                    }
                    .form-control:focus, select.form-control:focus, textarea.form-control:focus {
                        border-color: #E04545 !important;
                        background: #3a3a3a !important;
                    }
                    .nav-item {
                        color: #e5e5e5 !important;
                    }
                    .nav-item:hover, .nav-item.active {
                        background: rgba(224, 69, 69, 0.2) !important;
                    }
                    .page-title, .welcome-title, .producto-nombre, .encargado-nombre,
                    .categoria-nombre, .proveedor-nombre, .cliente-nombre, h1, h2, h3 {
                        color: #e5e5e5 !important;
                    }
                    .page-subtitle, .welcome-subtitle, .text-muted, small {
                        color: #aaa !important;
                    }
                    .search-box, .search-box input {
                        background: #3a3a3a !important;
                        color: #e5e5e5 !important;
                    }
                    .avatar {
                        background: linear-gradient(135deg, #E04545, #c93a3a) !important;
                    }
                    .badge-code, .badge {
                        background: #3a3a3a !important;
                        color: #e5e5e5 !important;
                    }
                    .pagination-links {
                        background: #2d2d2d !important;
                        border-color: #404040 !important;
                    }
                    .pagination-link {
                        background: #3a3a3a !important;
                        border-color: #505050 !important;
                        color: #e5e5e5 !important;
                    }
                    .pagination-info {
                        background: #3a3a3a !important;
                        color: #e5e5e5 !important;
                        border-color: #505050 !important;
                    }
                    .btn-cancel, .btn-secondary {
                        background: #3a3a3a !important;
                        color: #e5e5e5 !important;
                        border-color: #505050 !important;
                    }
                    .btn-cancel:hover, .btn-secondary:hover {
                        background: #4a4a4a !important;
                    }
                    .alert-success {
                        background: #064e3b !important;
                        color: #a7f3d0 !important;
                    }
                    .alert-error {
                        background: #7f1d1d !important;
                        color: #fecaca !important;
                    }
                    .info-box {
                        background: #064e3b !important;
                        color: #a7f3d0 !important;
                    }
                    .info-box i {
                        color: #34d399 !important;
                    }
                `;
                document.head.appendChild(style);
            }
        } else {
            const style = document.getElementById('dark-theme-style');
            if (style) {
                style.remove();
            }
        }
        localStorage.setItem('bodyfit_theme', theme);
    }

    // Aplicar tema al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        const currentTheme = getInitialTheme();
        applyTheme(currentTheme);
        
        // Sincronizar el radio button en la página de configuración si existe
        const themeRadio = document.querySelector('input[name="theme"][value="' + currentTheme + '"]');
        if (themeRadio) {
            themeRadio.checked = true;
        }
    });
</script>
</body>
</html>