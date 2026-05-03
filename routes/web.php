<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoVentaController;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\EncargadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\VentaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// ==================== RUTAS PARA ADMINISTRADORES ====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tipos de Usuario
    Route::prefix('tipos-usuario')->name('tipos-usuario.')->group(function () {
        Route::get('/index', [TipoUsuarioController::class, 'index'])->name('index');
        Route::get('/create', [TipoUsuarioController::class, 'create'])->name('create');
        Route::post('/store', [TipoUsuarioController::class, 'store'])->name('store');
        Route::get('/{codTipoUsuario}', [TipoUsuarioController::class, 'show'])->name('show');
        Route::get('/{codTipoUsuario}/edit', [TipoUsuarioController::class, 'edit'])->name('edit');
        Route::put('/{codTipoUsuario}', [TipoUsuarioController::class, 'update'])->name('update');
        Route::delete('/{codTipoUsuario}', [TipoUsuarioController::class, 'destroy'])->name('destroy');
    });
    
    // Encargados
    Route::prefix('encargados')->name('encargado.')->group(function () {
        Route::get('/index', [EncargadoController::class, 'index'])->name('index');
        Route::get('/create', [EncargadoController::class, 'create'])->name('create');
        Route::post('/store', [EncargadoController::class, 'store'])->name('store');
        Route::get('/{carnetIdentidad}', [EncargadoController::class, 'show'])->name('show');
        Route::get('/{carnetIdentidad}/edit', [EncargadoController::class, 'edit'])->name('edit');
        Route::put('/{carnetIdentidad}', [EncargadoController::class, 'update'])->name('update');
        Route::delete('/{carnetIdentidad}', [EncargadoController::class, 'destroy'])->name('destroy');
    });
});

// ==================== RUTAS PARA ENCARGADOS ====================
Route::middleware(['auth', 'role:encargado'])->prefix('encargado')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index1'])->name('encargado.dashboard');
    
    // Perfil
    Route::prefix('perfil')->group(function () {
        Route::get('/', [PerfilController::class, 'index'])->name('encargado.perfil.index');
        Route::put('/update', [PerfilController::class, 'update'])->name('encargado.perfil.update');
        Route::get('/completar', [PerfilController::class, 'completar'])->name('encargado.perfil.completar');
        Route::post('/store', [PerfilController::class, 'store'])->name('encargado.perfil.store');
    });
    
    // Configuración
    Route::prefix('configuracion')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'index'])->name('encargado.configuracion.index');
        Route::put('/seguridad', [ConfiguracionController::class, 'seguridad'])->name('encargado.configuracion.seguridad');
        Route::put('/notificaciones', [ConfiguracionController::class, 'notificaciones'])->name('encargado.configuracion.notificaciones');
        Route::put('/apariencia', [ConfiguracionController::class, 'apariencia'])->name('encargado.configuracion.apariencia');
    });
    Route::get('/search', [SearchController::class, 'search'])->name('encargado.search');
    Route::post('/perfil/upload-photo', [PerfilController::class, 'uploadPhoto'])->name('encargado.perfil.upload-photo');
    
    // Clientes
    Route::prefix('clientes')->name('cliente.')->group(function () {
        Route::get('/index', [ClienteController::class, 'index'])->name('index');
        Route::get('/create', [ClienteController::class, 'create'])->name('create');
        Route::post('/store', [ClienteController::class, 'store'])->name('store');
        Route::get('/{carnetIdentidad}', [ClienteController::class, 'show'])->name('show');
        Route::get('/{carnetIdentidad}/edit', [ClienteController::class, 'edit'])->name('edit');
        Route::put('/{carnetIdentidad}', [ClienteController::class, 'update'])->name('update');
        Route::delete('/{carnetIdentidad}', [ClienteController::class, 'destroy'])->name('destroy');
    });
    
    // Categorías
    Route::prefix('categorias')->name('categoria.')->group(function () {
        Route::get('/index', [CategoriaController::class, 'index'])->name('index');
        Route::get('/create', [CategoriaController::class, 'create'])->name('create');
        Route::post('/store', [CategoriaController::class, 'store'])->name('store');
        Route::get('/{codCategoria}', [CategoriaController::class, 'show'])->name('show');
        Route::get('/{codCategoria}/edit', [CategoriaController::class, 'edit'])->name('edit');
        Route::put('/{codCategoria}', [CategoriaController::class, 'update'])->name('update');
        Route::delete('/{codCategoria}', [CategoriaController::class, 'destroy'])->name('destroy');
    });
    
    // Productos
    Route::prefix('productos')->name('producto.')->group(function () {
        Route::get('/index', [ProductoController::class, 'index'])->name('index');
        Route::get('/create', [ProductoController::class, 'create'])->name('create');
        Route::post('/store', [ProductoController::class, 'store'])->name('store');
        Route::get('/{codProducto}', [ProductoController::class, 'show'])->name('show');
        Route::get('/{codProducto}/edit', [ProductoController::class, 'edit'])->name('edit');
        Route::put('/{codProducto}', [ProductoController::class, 'update'])->name('update');
        Route::delete('/{codProducto}', [ProductoController::class, 'destroy'])->name('destroy');
    });
    
    // Proveedores
    Route::prefix('proveedores')->name('proveedor.')->group(function () {
        Route::get('/index', [ProveedorController::class, 'index'])->name('index');
        Route::get('/create', [ProveedorController::class, 'create'])->name('create');
        Route::post('/store', [ProveedorController::class, 'store'])->name('store');
        Route::get('/{codProveedor}', [ProveedorController::class, 'show'])->name('show');
        Route::get('/{codProveedor}/edit', [ProveedorController::class, 'edit'])->name('edit');
        Route::put('/{codProveedor}', [ProveedorController::class, 'update'])->name('update');
        Route::delete('/{codProveedor}', [ProveedorController::class, 'destroy'])->name('destroy');
    });
    
    // Compras
    Route::prefix('compras')->name('compra.')->group(function () {
        Route::get('/index', [CompraController::class, 'index'])->name('index');
        Route::get('/create', [CompraController::class, 'create'])->name('create');
        Route::post('/store', [CompraController::class, 'store'])->name('store');
        Route::get('/{codCompra}', [CompraController::class, 'show'])->name('show');
        Route::delete('/{codCompra}', [CompraController::class, 'destroy'])->name('destroy');
    });
    
    // Ventas
    Route::prefix('ventas')->name('venta.')->group(function () {
        Route::get('/index', [VentaController::class, 'index'])->name('index');
        Route::get('/create', [VentaController::class, 'create'])->name('create');
        Route::post('/store', [VentaController::class, 'store'])->name('store');
        Route::get('/{codVenta}', [VentaController::class, 'show'])->name('show');
        Route::delete('/{codVenta}', [VentaController::class, 'destroy'])->name('destroy');
    });
    
    // Reportes
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::get('/ventas', [ReporteController::class, 'ventas'])->name('ventas');
        Route::get('/compras', [ReporteController::class, 'compras'])->name('compras');
        Route::get('/productos', [ReporteController::class, 'productos'])->name('productos');
        Route::get('/ventas/pdf', [ReporteController::class, 'exportarVentasPDF'])->name('ventas.pdf');
    });
});

// ==================== RUTAS PARA CLIENTES ====================
Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/home', [ProductoVentaController::class, 'home'])->name('home');
    Route::get('/productos', [ProductoVentaController::class, 'index'])->name('productos');
    Route::get('/checkout', [ProductoVentaController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [ProductoVentaController::class, 'checkoutProcess'])->name('checkout');
    Route::get('/compra-exitosa/{codVenta}', [ProductoVentaController::class, 'compraExitosa'])->name('compra-exitosa');
    Route::get('/mis-compras', [ProductoVentaController::class, 'misCompras'])->name('mis-compras');
    Route::get('/mis-compras/{codVenta}', [ProductoVentaController::class, 'detalleCompra'])->name('mis-compras.detalle');
    Route::get('/perfil', [ProductoVentaController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [ProductoVentaController::class, 'updatePerfil'])->name('perfil.update');
    Route::get('/perfil/completar', [ProductoVentaController::class, 'completarPerfil'])->name('perfil.completar');
    Route::post('/perfil/store', [ProductoVentaController::class, 'storePerfil'])->name('perfil.store');

    Route::post('/cliente/perfil/upload-photo', [ProductoVentaController::class, 'uploadPhoto'])->name('perfil.upload-photo');
});