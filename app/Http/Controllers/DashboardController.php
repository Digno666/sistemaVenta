<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Encargado;
use App\Models\TipoUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas
        $totalTiposUsuario = TipoUsuario::count();
        $totalEncargados = Encargado::count();
        $totalUsuariosSistema = User::count();
        
        // Último encargado registrado
        $ultimoEncargado = Encargado::with('usuario')
            ->latest('carnetIdentidad')
            ->first();
        
        $ultimoRegistro = $ultimoEncargado 
            ? $ultimoEncargado->nombre . ' ' . $ultimoEncargado->apellidoPaterno 
            : 'Sin registros';
        
        // Últimos 5 encargados
        $ultimosEncargados = Encargado::with('usuario')
            ->latest('carnetIdentidad')
            ->limit(5)
            ->get();
        
        // Tipos de usuario recientes
        $tiposUsuarioRecientes = TipoUsuario::withCount('usuarios')
            ->latest('codTipoUsuario')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalTiposUsuario',
            'totalEncargados',
            'totalUsuariosSistema',
            'ultimoRegistro',
            'ultimosEncargados',
            'tiposUsuarioRecientes'
        ));
    }
     public function index1()
    {
        // Obtener el encargado actual
        $encargado = Encargado::where('codUsuario', Auth::user()->codUsuario)->first();
        
        // Estadísticas
        $totalCompras = Compra::count();
        $totalVentas = Venta::count();
        $totalClientes = Cliente::count();
        $totalProductos = Producto::count();
        
        // Montos totales
        $montoTotalCompras = Compra::sum('montoTotal');
        $montoTotalVentas = Venta::sum('montoTotal');
        
        // Últimas 5 compras
        $ultimasCompras = Compra::with(['proveedor', 'detalles'])
            ->latest('codCompra')
            ->limit(5)
            ->get();
        
        // Últimas 5 ventas
        $ultimasVentas = Venta::with(['cliente', 'detalles'])
            ->latest('codVenta')
            ->limit(5)
            ->get();
        
        // Productos con stock bajo (menos de 10 unidades)
        $productosStockBajo = Producto::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();
        
        // Clientes recientes
        $clientesRecientes = Cliente::with('usuario')
            ->latest('carnetIdentidad')
            ->limit(5)
            ->get();
        
        return view('encargado.dashboard', compact(
            'encargado',
            'totalCompras',
            'totalVentas',
            'totalClientes',
            'totalProductos',
            'montoTotalCompras',
            'montoTotalVentas',
            'ultimasCompras',
            'ultimasVentas',
            'productosStockBajo',
            'clientesRecientes'
        ));
    }
}