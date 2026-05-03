<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\DetalleCompra;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    /**
     * Mostrar lista de productos
     */
    public function index()
    {
        $productos = Producto::with('categoria')
            ->orderBy('codProducto', 'asc')
            ->paginate(10);
            
        return view('Encargado.producto.index', compact('productos'));
    }

    /**
     * Mostrar formulario para crear nuevo producto
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        return view('Encargado.producto.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codProducto' => 'required|string|max:20|unique:Producto,codProducto',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'codCategoria' => 'required|exists:Categoria,codCategoria',
        ]);

        // Agregar stock por defecto en 0
        $validated['stock'] = 0;

        // Procesar imagen
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = $imagenPath;
        }

        Producto::create($validated);

        return redirect()->route('producto.index')
            ->with('success', '✨ Producto creado exitosamente.');
    }
    public function show($codProducto)
    {
        $producto = Producto::with('categoria')->findOrFail($codProducto);
        
        // Estadísticas de ventas
        $totalVentas = DetalleVenta::where('codProducto', $codProducto)->sum('cantidad');
        
        $totalRecaudado = DetalleVenta::where('codProducto', $codProducto)
            ->select(DB::raw('SUM(cantidad * "precioVenta") as total'))
            ->value('total') ?? 0;
        
        // Estadísticas de compras
        $totalCompras = DetalleCompra::where('codProducto', $codProducto)->sum('cantidad');
        
        return view('encargado.producto.show', compact('producto', 'totalVentas', 'totalRecaudado', 'totalCompras'));
    }
    public function edit($codProducto)
    {
        $producto = Producto::findOrFail($codProducto);
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        return view('Encargado.producto.edit', compact('producto', 'categorias'));
    }
    public function update(Request $request, $codProducto)
    {
        $producto = Producto::findOrFail($codProducto);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',  // Stock opcional en la validación
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'codCategoria' => 'required|exists:Categoria,codCategoria',
        ]);

        // Si no se envía stock, mantener el valor actual
        if (!isset($validated['stock'])) {
            $validated['stock'] = $producto->stock;
        }

        // Procesar imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $imagenPath = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = $imagenPath;
        }

        $producto->update($validated);

        return redirect()->route('producto.index')
            ->with('success', '📝 Producto actualizado exitosamente.');
    }

    /**
     * Eliminar producto
     */
    public function destroy($codProducto)
    {
        $producto = Producto::findOrFail($codProducto);
        
        // Eliminar imagen asociada si existe
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('producto.index')
            ->with('success', '🗑️ Producto eliminado exitosamente.');
    }
}