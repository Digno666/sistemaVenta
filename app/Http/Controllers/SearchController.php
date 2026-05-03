<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Compra;
use App\Models\Venta;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }
        
        $results = [];
        
        // Buscar clientes
        $clientes = Cliente::where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('apellidoPaterno', 'LIKE', "%{$query}%")
            ->orWhere('carnetIdentidad', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();
        
        foreach ($clientes as $cliente) {
            $results[] = [
                'type' => 'cliente',
                'title' => $cliente->nombre . ' ' . $cliente->apellidoPaterno,
                'subtitle' => 'CI: ' . $cliente->carnetIdentidad . ' | Tel: ' . $cliente->celular,
                'url' => route('cliente.show', $cliente->carnetIdentidad),
                'icon' => 'fas fa-user'
            ];
        }
        
        // Buscar productos
        $productos = Producto::where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('codProducto', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();
        
        foreach ($productos as $producto) {
            $results[] = [
                'type' => 'producto',
                'title' => $producto->nombre,
                'subtitle' => 'Código: ' . $producto->codProducto . ' | Stock: ' . $producto->stock,
                'url' => route('producto.show', $producto->codProducto),
                'icon' => 'fas fa-box'
            ];
        }
        
        // Buscar proveedores
        $proveedores = Proveedor::where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('telefono', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();
        
        foreach ($proveedores as $proveedor) {
            $results[] = [
                'type' => 'proveedor',
                'title' => $proveedor->nombre,
                'subtitle' => 'Tel: ' . $proveedor->telefono,
                'url' => route('proveedor.show', $proveedor->codProveedor),
                'icon' => 'fas fa-truck'
            ];
        }
        
        // Buscar compras
        $compras = Compra::with('proveedor')
            ->where('codCompra', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();
        
        foreach ($compras as $compra) {
            $results[] = [
                'type' => 'compra',
                'title' => 'Compra #' . $compra->codCompra,
                'subtitle' => 'Proveedor: ' . ($compra->proveedor->nombre ?? 'N/A') . ' | Total: ' . number_format($compra->montoTotal, 2) . ' Bs',
                'url' => route('compra.show', $compra->codCompra),
                'icon' => 'fas fa-shopping-cart'
            ];
        }
        
        // Buscar ventas
        $ventas = Venta::with('cliente')
            ->where('codVenta', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();
        
        foreach ($ventas as $venta) {
            $results[] = [
                'type' => 'venta',
                'title' => 'Venta #' . $venta->codVenta,
                'subtitle' => 'Cliente: ' . ($venta->cliente->nombre ?? 'N/A') . ' | Total: ' . number_format($venta->montoTotal, 2) . ' Bs',
                'url' => route('venta.show', $venta->codVenta),
                'icon' => 'fas fa-chart-line'
            ];
        }
        
        // Ordenar resultados
        usort($results, function($a, $b) {
            return strlen($a['title']) <=> strlen($b['title']);
        });
        
        // Limitar a 10 resultados
        $results = array_slice($results, 0, 10);
        
        if ($request->wantsJson()) {
            return response()->json(['results' => $results]);
        }
        
        return view('Encargado.results', compact('results', 'query'));
    }
}