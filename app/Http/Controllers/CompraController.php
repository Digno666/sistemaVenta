<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Encargado;
use App\Models\Proveedor;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    /**
     * Mostrar lista de compras
     */
    public function index()
    {
        $compras = Compra::with(['encargado', 'proveedor', 'detalles'])
            ->orderBy('codCompra', 'desc')
            ->paginate(10);
            
        return view('Encargado.Compra.index', compact('compras'));
    }

    /**
     * Mostrar formulario para crear nueva compra
     */
    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre', 'asc')->get();
        $productos = Producto::orderBy('nombre', 'asc')->get();
        $encargado = Encargado::where('codUsuario', Auth::user()->codUsuario ?? 0)->first();
        
        return view('Encargado.Compra.create', compact('proveedores', 'productos', 'encargado'));
    }

    /**
     * Guardar nueva compra
     */
    public function store(Request $request)
    {
        $request->validate([
            'codProveedor' => 'required|exists:Proveedor,codProveedor',
            'productos' => 'required|array|min:1',
            'productos.*.codProducto' => 'required|exists:Producto,codProducto',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precioCompra' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            // Obtener el encargado logueado
            $encargado = Encargado::where('codUsuario', Auth::user()->codUsuario)->first();
            
            if (!$encargado) {
                throw new \Exception('No se encontró un encargado asociado al usuario actual.');
            }

            // Calcular monto total
            $montoTotal = 0;
            foreach ($request->productos as $producto) {
                $montoTotal += $producto['precioCompra'] * $producto['cantidad'];
            }

            // Crear la compra
            $compra = Compra::create([
                'fechaCompra' => now()->format('Y-m-d'),
                'montoTotal' => $montoTotal,
                'codEncargado' => $encargado->carnetIdentidad,
                'codProveedor' => $request->codProveedor,
            ]);

            // Crear los detalles de compra y actualizar stock de productos
            foreach ($request->productos as $producto) {
                DetalleCompra::create([
                    'precioCompra' => $producto['precioCompra'],
                    'cantidad' => $producto['cantidad'],
                    'codCompra' => $compra->codCompra,
                    'codProducto' => $producto['codProducto'],
                ]);

                // Actualizar stock del producto
                $productoModel = Producto::find($producto['codProducto']);
                $productoModel->stock += $producto['cantidad'];
                $productoModel->save();
            }
            
            DB::commit();
            
            return redirect()->route('compra.index')
                ->with('success', '✨ Compra registrada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '❌ Error al registrar la compra: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mostrar detalles de una compra específica
     */
    public function show($codCompra)
    {
        $compra = Compra::with(['encargado', 'proveedor', 'detalles.producto'])
            ->findOrFail($codCompra);
            
        return view('Encargado.Compra.show', compact('compra'));
    }

    /**
     * Eliminar compra (solo si es necesario)
     */
    public function destroy($codCompra)
    {
        $compra = Compra::with('detalles')->findOrFail($codCompra);
        
        DB::beginTransaction();
        
        try {
            // Restaurar stock de productos
            foreach ($compra->detalles as $detalle) {
                $producto = Producto::find($detalle->codProducto);
                $producto->stock -= $detalle->cantidad;
                $producto->save();
            }
            
            // Eliminar detalles y compra
            DetalleCompra::where('codCompra', $codCompra)->delete();
            $compra->delete();
            
            DB::commit();
            
            return redirect()->route('compra.index')
                ->with('success', '🗑️ Compra eliminada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('compra.index')
                ->with('error', '❌ Error al eliminar la compra: ' . $e->getMessage());
        }
    }
}