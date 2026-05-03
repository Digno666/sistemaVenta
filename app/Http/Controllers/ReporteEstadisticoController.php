<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Categoria;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteEstadisticoController extends Controller
{
    /**
     * Reporte de facturación de ventas
     */
    public function facturacionVentas(Request $request)
    {
        // Obtener productos más vendidos
        $productosVendidos = DetalleVenta::select(
                'Producto.codProducto',
                'Producto.nombre as producto_nombre',
                'Producto.descripcion',
                DB::raw('SUM(DetalleVenta.cantidad) as total_cantidad'),
                DB::raw('AVG(DetalleVenta.precioVenta) as promedio_precio'),
                DB::raw('SUM(DetalleVenta.cantidad * DetalleVenta.precioVenta) as total_facturado')
            )
            ->join('Producto', 'DetalleVenta.codProducto', '=', 'Producto.codProducto')
            ->groupBy('Producto.codProducto', 'Producto.nombre', 'Producto.descripcion')
            ->orderBy('total_facturado', 'desc')
            ->get();
        
        // Totales generales
        $totalGeneralFacturado = $productosVendidos->sum('total_facturado');
        $totalCantidadProductos = $productosVendidos->sum('total_cantidad');
        
        // Para el gráfico de composición
        $topProductos = $productosVendidos->take(5);
        $otrosProductos = $productosVendidos->slice(5);
        $otrosTotal = $otrosProductos->sum('total_facturado');
        
        $labels = [];
        $data = [];
        foreach ($topProductos as $producto) {
            $labels[] = $producto->producto_nombre;
            $data[] = $producto->total_facturado;
        }
        if ($otrosTotal > 0) {
            $labels[] = 'Otros Productos';
            $data[] = $otrosTotal;
        }
        
        return view('admin.reportes.estadisticos.facturacion-ventas', compact(
            'productosVendidos',
            'totalGeneralFacturado',
            'totalCantidadProductos',
            'labels',
            'data'
        ));
    }

    /**
     * Reporte de productos más vendidos
     */
    public function productosMasVendidos(Request $request)
    {
        $topProductos = DetalleVenta::select(
                'Producto.codProducto',
                'Producto.nombre as producto_nombre',
                DB::raw('SUM(DetalleVenta.cantidad) as total_vendido'),
                DB::raw('SUM(DetalleVenta.cantidad * DetalleVenta.precioVenta) as total_recaudado')
            )
            ->join('Producto', 'DetalleVenta.codProducto', '=', 'Producto.codProducto')
            ->groupBy('Producto.codProducto', 'Producto.nombre')
            ->orderBy('total_vendido', 'desc')
            ->limit(10)
            ->get();
        
        $totalVendido = $topProductos->sum('total_vendido');
        
        return view('admin.reportes.estadisticos.productos-mas-vendidos', compact('topProductos', 'totalVendido'));
    }

    /**
     * Reporte de ventas por categoría
     */
    public function ventasPorCategoria(Request $request)
    {
        $categorias = Categoria::withCount(['productos' => function($query) {
                $query->whereHas('detallesVenta');
            }])
            ->withSum('productos.detallesVenta', 'cantidad')
            ->get();
        
        // Datos para gráficos
        $labels = [];
        $data = [];
        $totales = [];
        
        foreach ($categorias as $categoria) {
            $totalVentas = $categoria->productos->sum(function($producto) {
                return $producto->detallesVenta->sum('cantidad');
            });
            if ($totalVentas > 0) {
                $labels[] = $categoria->nombre;
                $data[] = $totalVentas;
                $totales[] = $categoria->productos->sum(function($producto) {
                    return $producto->detallesVenta->sum(DB::raw('cantidad * precioVenta'));
                });
            }
        }
        
        return view('admin.reportes.estadisticos.ventas-por-categoria', compact('categorias', 'labels', 'data', 'totales'));
    }

    /**
     * Reporte comparativo anual
     */
    public function comparativoAnual(Request $request)
    {
        $anio = $request->get('anio', date('Y'));
        
        $ventasPorMes = Venta::select(
                DB::raw('EXTRACT(MONTH FROM "fechaVenta") as mes'),
                DB::raw('SUM("montoTotal") as total')
            )
            ->whereYear('fechaVenta', $anio)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM "fechaVenta")'))
            ->orderBy('mes')
            ->get();
        
        $comprasPorMes = Compra::select(
                DB::raw('EXTRACT(MONTH FROM "fechaCompra") as mes'),
                DB::raw('SUM("montoTotal") as total')
            )
            ->whereYear('fechaCompra', $anio)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM "fechaCompra")'))
            ->orderBy('mes')
            ->get();
        
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $ventasData = array_fill(0, 12, 0);
        $comprasData = array_fill(0, 12, 0);
        
        foreach ($ventasPorMes as $venta) {
            $ventasData[$venta->mes - 1] = $venta->total;
        }
        foreach ($comprasPorMes as $compra) {
            $comprasData[$compra->mes - 1] = $compra->total;
        }
        
        return view('admin.reportes.estadisticos.comparativo-anual', compact('meses', 'ventasData', 'comprasData', 'anio'));
    }
}