<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoVentaController extends Controller
{
    public function home()
    {
        $categorias = Categoria::withCount('productos')
            ->orderBy('nombre', 'asc')
            ->get();
        
        $productosDestacados = Producto::with('categoria')
            ->where('stock', '>', 0)
            ->orderBy('codProducto', 'desc')
            ->limit(8)
            ->get();
        
        return view('cliente.home', compact('categorias', 'productosDestacados'));
    }
    public function index()
    {
        $productos = Producto::with('categoria')
            ->orderBy('nombre', 'asc')
            ->get();
        
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        
        return view('cliente.productos', compact('productos', 'categorias'));
    }
    public function checkoutForm()
    {
        $cliente = Cliente::where('codUsuario', Auth::user()->codUsuario)->first();
        
        if (!$cliente) {
            return redirect()->route('cliente.perfil.completar')->with('error', 'Complete su perfil primero');
        }
        
        return view('cliente.checkout', compact('cliente'));
    }
    public function checkoutProcess(Request $request)
    {
        $cart = json_decode($request->input('cart', '[]'), true);
        if (empty($cart)) {
            return redirect()->route('cliente.productos')->with('error', 'Carrito vacío');
        }
        
        $request->validate([
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:500',
            'ciudad' => 'required|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
            'metodo_pago' => 'required|string',
        ]);
        
        DB::beginTransaction();
        
        try {
            $cliente = Cliente::where('codUsuario', Auth::user()->codUsuario)->first();
            
            if (!$cliente) {
                return redirect()->route('cliente.perfil.completar')->with('error', 'Complete su perfil primero');
            }
            
            $montoTotal = 0;
            foreach ($cart as $item) {
                $montoTotal += $item['precio'] * $item['cantidad'];
            }
            
            // Calcular envío (puedes hacerlo dinámico después)
            $costoEnvio = 15.00;
            $totalConEnvio = $montoTotal + $costoEnvio;
            
            $venta = Venta::create([
                'fechaVenta' => now()->format('Y-m-d'),
                'montoTotal' => $totalConEnvio,
                'codEncargado' => null,
                'codCliente' => $cliente->carnetIdentidad,
            ]);
            
            foreach ($cart as $item) {
                DetalleVenta::create([
                    'precioVenta' => $item['precio'],
                    'cantidad' => $item['cantidad'],
                    'codVenta' => $venta->codVenta,
                    'codProducto' => $item['codProducto'],
                ]);
                
                $producto = Producto::find($item['codProducto']);
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }
            
            // Aquí puedes guardar los datos de envío en una tabla de pedidos si la tienes
            
            DB::commit();
            
            // Limpiar carrito después de la compra exitosa
            // Esto se manejará con JavaScript al redirigir
            
            return redirect()->route('cliente.compra-exitosa', ['codVenta' => $venta->codVenta])
                ->with('success', 'Compra realizada exitosamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }
    
    /**
     * Página de compra exitosa
     */
    public function compraExitosa($codVenta)
    {
        $venta = Venta::with(['detalles.producto'])->findOrFail($codVenta);
        return view('cliente.compra-exitosa', compact('venta'));
    }
    public function misCompras()
    {
        $cliente = Cliente::where('codUsuario', Auth::user()->codUsuario)->first();
        
        if (!$cliente) {
            return redirect()->route('cliente.perfil.completar')->with('error', 'Complete su perfil primero');
        }
        
        $ventas = Venta::with(['detalles.producto'])
            ->where('codCliente', $cliente->carnetIdentidad)
            ->orderBy('fechaVenta', 'desc')
            ->paginate(10);
        
        return view('cliente.mis-compras', compact('ventas'));
    }
    public function perfil()
    {
        $cliente = Cliente::where('codUsuario', Auth::user()->codUsuario)->first();
        return view('cliente.perfil', compact('cliente'));
    }

    public function updatePerfil(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sesión no encontrada');
        }
        
        $cliente = Cliente::where('codUsuario', $user->codUsuario)->first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:Usuario,email,' . $user->codUsuario . ',codUsuario',
            'celular' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        DB::beginTransaction();

        try {
            // Actualizar usuario
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Actualizar cliente (solo celular)
            if ($cliente) {
                $cliente->update([
                    'celular' => $validated['celular'] ?? $cliente->celular,
                ]);
            }
            if ($request->hasFile('foto')) {
                // Eliminar foto anterior si existe
                if ($cliente && $cliente->foto && Storage::disk('public')->exists($cliente->foto)) {
                    Storage::disk('public')->delete($cliente->foto);
                }
                
                $fotoPath = $request->file('foto')->store('clientes/fotos', 'public');
                $clienteData['foto'] = $fotoPath;
            }

            DB::commit();

            return redirect()->route('cliente.perfil')
                ->with('success', 'Perfil actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el perfil: ' . $e->getMessage())->withInput();
        }
    }

    public function storePerfil(Request $request)
    {
        $validated = $request->validate([
            'carnetIdentidad' => 'required|integer|unique:Cliente,carnetIdentidad',
            'nombre' => 'required|string|max:255',
            'apellidoPaterno' => 'required|string|max:255',
            'apellidoMaterno' => 'required|string|max:255',
            'edad' => 'required|integer|min:18|max:100',
            'sexo' => 'required|in:M,F',
            'celular' => 'required|string|max:20',
             'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('clientes/fotos', 'public');
        }

        $cliente = Cliente::create([
            'carnetIdentidad' => $validated['carnetIdentidad'],
            'nombre' => $validated['nombre'],
            'apellidoPaterno' => $validated['apellidoPaterno'],
            'apellidoMaterno' => $validated['apellidoMaterno'],
            'edad' => $validated['edad'],
            'sexo' => $validated['sexo'],
            'celular' => $validated['celular'],
            'codUsuario' => Auth::user()->codUsuario,
        ]);

        return redirect()->route('cliente.perfil')
            ->with('success', 'Perfil completado exitosamente');
    }
    /**
     * Mostrar página de detalle de compra
     */
    public function detalleCompra($codVenta)
    {
        $cliente = Cliente::where('codUsuario', Auth::user()->codUsuario)->first();
        
        if (!$cliente) {
            return redirect()->route('cliente.perfil.completar')->with('error', 'Complete su perfil primero');
        }
        
        $venta = Venta::with(['detalles.producto'])
            ->where('codCliente', $cliente->carnetIdentidad)
            ->where('codVenta', $codVenta)
            ->firstOrFail();
        
        return view('cliente.detalle-compra', compact('venta'));
    }
    /**
     * Subir foto de perfil vía AJAX
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $cliente = Cliente::where('codUsuario', Auth::user()->codUsuario)->first();
        
        if (!$cliente) {
            return response()->json(['success' => false, 'message' => 'Cliente no encontrado'], 404);
        }
        
        // Eliminar foto anterior
        if ($cliente->foto && Storage::disk('public')->exists($cliente->foto)) {
            Storage::disk('public')->delete($cliente->foto);
        }
        
        $path = $request->file('foto')->store('clientes/fotos', 'public');
        $cliente->update(['foto' => $path]);
        
        return response()->json(['success' => true, 'url' => Storage::url($path)]);
    }
}