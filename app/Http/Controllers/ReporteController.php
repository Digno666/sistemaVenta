<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Mostrar dashboard de reportes
     */
    public function index()
    {
        // Resumen general
        $totalVentas = Venta::count();
        $totalCompras = Compra::count();
        $montoTotalVentas = Venta::sum('montoTotal');
        $montoTotalCompras = Compra::sum('montoTotal');
        
        // Usar el modelo en lugar de DB::table
        $productosVendidos = DetalleVenta::sum('cantidad');
        
        // Ventas por mes (últimos 12 meses)
        $ventasPorMes = Venta::select(
                DB::raw('EXTRACT(MONTH FROM "fechaVenta") as mes'),
                DB::raw('EXTRACT(YEAR FROM "fechaVenta") as año'),
                DB::raw('SUM("montoTotal") as total')
            )
            ->where('fechaVenta', '>=', now()->subMonths(12))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM "fechaVenta")'), DB::raw('EXTRACT(MONTH FROM "fechaVenta")'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM "fechaVenta")'), 'asc')
            ->orderBy(DB::raw('EXTRACT(MONTH FROM "fechaVenta")'), 'asc')
            ->get();
        
        // Compras por mes (últimos 12 meses)
        $comprasPorMes = Compra::select(
                DB::raw('EXTRACT(MONTH FROM "fechaCompra") as mes'),
                DB::raw('EXTRACT(YEAR FROM "fechaCompra") as año'),
                DB::raw('SUM("montoTotal") as total')
            )
            ->where('fechaCompra', '>=', now()->subMonths(12))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM "fechaCompra")'), DB::raw('EXTRACT(MONTH FROM "fechaCompra")'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM "fechaCompra")'), 'asc')
            ->orderBy(DB::raw('EXTRACT(MONTH FROM "fechaCompra")'), 'asc')
            ->get();
        
        // Top 5 productos más vendidos usando el modelo con la tabla correcta
        $topProductos = DetalleVenta::select(
                'Producto.codProducto',
                'Producto.nombre',
                DB::raw('SUM("DetalleVenta"."cantidad") as total_vendido')
            )
            ->join('Producto', 'DetalleVenta.codProducto', '=', 'Producto.codProducto')
            ->groupBy('Producto.codProducto', 'Producto.nombre')
            ->orderBy('total_vendido', 'desc')
            ->limit(5)
            ->get();
        
        // Top 5 clientes
        $topClientes = Venta::with('cliente')
            ->select('codCliente', DB::raw('SUM("montoTotal") as total_gastado'))
            ->groupBy('codCliente')
            ->orderBy('total_gastado', 'desc')
            ->limit(5)
            ->get();
        
        return view('Encargado.Reportes.index', compact(
            'totalVentas',
            'totalCompras',
            'montoTotalVentas',
            'montoTotalCompras',
            'productosVendidos',
            'ventasPorMes',
            'comprasPorMes',
            'topProductos',
            'topClientes'
        ));
    }

    /**
     * Reporte de ventas con filtros
     */
    public function ventas(Request $request)
    {
        $query = Venta::with(['cliente', 'encargado', 'detalles.producto']);
        
        // Filtro por fecha desde
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fechaVenta', '>=', $request->fecha_desde);
        }
        
        // Filtro por fecha hasta
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fechaVenta', '<=', $request->fecha_hasta);
        }
        
        // Filtro por cliente
        if ($request->filled('codCliente')) {
            $query->where('codCliente', $request->codCliente);
        }
        
        $ventas = $query->orderBy('fechaVenta', 'desc')->paginate(15);
        
        // Para los filtros
        $clientes = Cliente::orderBy('nombre')->get();
        
        // Resumen del reporte
        $totalVentas = $ventas->total();
        $montoTotal = Venta::query();
        if ($request->filled('fecha_desde')) {
            $montoTotal->whereDate('fechaVenta', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $montoTotal->whereDate('fechaVenta', '<=', $request->fecha_hasta);
        }
        if ($request->filled('codCliente')) {
            $montoTotal->where('codCliente', $request->codCliente);
        }
        $montoTotal = $montoTotal->sum('montoTotal');
        
        return view('Encargado.Reportes.ventas', compact('ventas', 'clientes', 'totalVentas', 'montoTotal'));
    }

    /**
     * Reporte de compras con filtros
     */
    public function compras(Request $request)
    {
        $query = Compra::with(['proveedor', 'encargado', 'detalles.producto']);
        
        // Filtro por fecha desde
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fechaCompra', '>=', $request->fecha_desde);
        }
        
        // Filtro por fecha hasta
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fechaCompra', '<=', $request->fecha_hasta);
        }
        
        // Filtro por proveedor
        if ($request->filled('codProveedor')) {
            $query->where('codProveedor', $request->codProveedor);
        }
        
        $compras = $query->orderBy('fechaCompra', 'desc')->paginate(15);
        
        // Para los filtros
        $proveedores = Proveedor::orderBy('nombre')->get();
        
        // Resumen del reporte
        $totalCompras = $compras->total();
        $montoTotal = Compra::query();
        if ($request->filled('fecha_desde')) {
            $montoTotal->whereDate('fechaCompra', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $montoTotal->whereDate('fechaCompra', '<=', $request->fecha_hasta);
        }
        if ($request->filled('codProveedor')) {
            $montoTotal->where('codProveedor', $request->codProveedor);
        }
        $montoTotal = $montoTotal->sum('montoTotal');
        
        return view('Encargado.Reportes.compras', compact('compras', 'proveedores', 'totalCompras', 'montoTotal'));
    }

    /**
     * Reporte de productos (stock)
     */
    public function productos(Request $request)
    {
        // Top 10 productos más vendidos
        $topProductos = DetalleVenta::select(
                'Producto.codProducto',
                'Producto.nombre as producto_nombre',
                DB::raw('SUM("DetalleVenta"."cantidad") as total_vendido'),
                DB::raw('SUM("DetalleVenta"."cantidad" * "DetalleVenta"."precioVenta") as total_recaudado')
            )
            ->join('Producto', 'DetalleVenta.codProducto', '=', 'Producto.codProducto')
            ->groupBy('Producto.codProducto', 'Producto.nombre')
            ->orderBy('total_vendido', 'desc')
            ->limit(10)
            ->get();
        
        $totalVendido = $topProductos->sum('total_vendido');
        
        return view('Encargado.Reportes.productos', compact('topProductos', 'totalVendido'));
    }

    /**
     * Exportar reporte de ventas a PDF
     */
    public function exportarVentasPDF(Request $request)
    {
        // Aquí implementarías la generación de PDF con una librería como DomPDF
        // return view('reportes.pdf.ventas', compact('ventas'));
    }
}