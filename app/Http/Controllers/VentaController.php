<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Cliente;
use App\Models\Encargado;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    /**
     * Mostrar lista de ventas
     */
    public function index()
    {
        $ventas = Venta::with(['encargado', 'cliente', 'detalles'])
            ->orderBy('codVenta', 'desc')
            ->paginate(10);
            
        return view('Encargado.Venta.index', compact('ventas'));
    }

    /**
     * Mostrar formulario para crear nueva venta
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre', 'asc')->get();
        $productos = Producto::where('stock', '>', 0)->orderBy('nombre', 'asc')->get();
        $encargado = Encargado::where('codUsuario', Auth::user()->codUsuario ?? 0)->first();
        
        return view('Encargado.Venta.create', compact('clientes', 'productos', 'encargado'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'codCliente' => 'required|exists:Cliente,carnetIdentidad',
            'productos' => 'required|array|min:1',
            'productos.*.codProducto' => 'required|exists:Producto,codProducto',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precioVenta' => 'required|numeric|min:0',
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
                $montoTotal += $producto['precioVenta'] * $producto['cantidad'];
            }

            // Crear la venta
            $venta = Venta::create([
                'fechaVenta' => now()->format('Y-m-d'),
                'montoTotal' => $montoTotal,
                'codEncargado' => $encargado->carnetIdentidad,
                'codCliente' => $request->codCliente,
            ]);

            // Crear los detalles de venta y actualizar stock
            foreach ($request->productos as $producto) {
                // Verificar stock disponible
                $productoModel = Producto::find($producto['codProducto']);
                if ($productoModel->stock < $producto['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$productoModel->nombre}");
                }

                DetalleVenta::create([
                    'precioVenta' => $producto['precioVenta'],
                    'cantidad' => $producto['cantidad'],
                    'codVenta' => $venta->codVenta,
                    'codProducto' => $producto['codProducto'],
                ]);

                // Actualizar stock (restar)
                $productoModel->stock -= $producto['cantidad'];
                $productoModel->save();
            }
            
            DB::commit();
            
            return redirect()->route('venta.index')
                ->with('success', '✨ Venta registrada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '❌ Error al registrar la venta: ' . $e->getMessage())->withInput();
        }
    }
    public function show($codVenta)
    {
        $venta = Venta::with(['encargado', 'cliente', 'detalles.producto'])
            ->findOrFail($codVenta);
            
        return view('Encargado.Venta.show', compact('venta'));
    }

    /**
     * Eliminar venta (anular)
     */
    public function destroy($codVenta)
    {
        $venta = Venta::with('detalles')->findOrFail($codVenta);
        
        DB::beginTransaction();
        
        try {
            // Restaurar stock de productos
            foreach ($venta->detalles as $detalle) {
                $producto = Producto::find($detalle->codProducto);
                if ($producto) {
                    $producto->stock += $detalle->cantidad;
                    $producto->save();
                }
            }
            
            // Eliminar detalles de la venta
            DetalleVenta::where('codVenta', $codVenta)->delete();
            
            // Eliminar la venta
            $venta->delete();
            
            DB::commit();
            
            return redirect()->route('venta.index')
                ->with('success', 'Venta anulada exitosamente. Stock restaurado.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('venta.index')
                ->with('error', 'Error al anular la venta: ' . $e->getMessage());
        }
    }
}   