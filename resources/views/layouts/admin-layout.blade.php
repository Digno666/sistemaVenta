<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>@yield('title', 'BODY FIT Admin')</title>
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
            max-width: 600px;
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

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E04545, #c93a3a);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
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
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <i class="fas fa-dumbbell"></i>
                <span>BODY FIT</span>
            </a>
        </div>

        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar..." id="globalSearch">
            </div>
        </div>

        <div class="top-right">
            <button class="icon-btn" id="searchMobileBtn" style="display: none;">
                <i class="fas fa-search"></i>
            </button>
            <div class="avatar-dropdown">
                <div class="avatar" id="avatarBtn">
                    <span>{{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}</span>
                </div>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-circle"></i> Mi perfil
                    </a>
                    <a href="#" class="dropdown-item">
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

    <!-- BARRA LATERAL - Solo opciones permitidas para el Administrador -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Inicio</span>
        </a>
        <a href="{{ route('tipos-usuario.index') }}" class="nav-item {{ request()->routeIs('tipos-usuario.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>
            <span>Tipos de Usuario</span>
        </a>
        <a href="{{ route('encargado.index') }}" class="nav-item {{ request()->routeIs('encargado.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Encargados</span>
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
        });

        // Búsqueda global
        if (globalSearch) {
            globalSearch.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    const query = e.target.value.trim();
                    if (query !== '') {
                        // Redirigir a búsqueda global (puedes implementar después)
                        window.location.href = `{{ route('admin.dashboard') }}?search=${encodeURIComponent(query)}`;
                    }
                }
            });
        }

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
                    window.location.href = `{{ route('admin.dashboard') }}?search=${encodeURIComponent(query)}`;
                }
            });
        }

        // Cerrar menú lateral en móvil al hacer clic en un enlace
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.add('closed');
                        mainContent.classList.add('expanded');
                    }
                });
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
            // Mostrar mensaje de éxito
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

            // Mostrar mensaje de error
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#E04545',
                    confirmButtonText: 'Entendido'
                });
            @endif

            // Mostrar mensaje de advertencia
            @if(session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: '¡Atención!',
                    text: '{{ session('warning') }}',
                    confirmButtonColor: '#E04545',
                    confirmButtonText: 'Aceptar'
                });
            @endif

            // Mostrar mensaje informativo
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
</body>
</html>