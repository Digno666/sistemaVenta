<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProveedorController extends Controller
{
    /**
     * Mostrar lista de proveedores
     */
    public function index()
    {
        $proveedores = Proveedor::orderBy('codProveedor', 'desc')->paginate(10);
        return view('Encargado.Proveedor.index', compact('proveedores'));
    }

    /**
     * Mostrar formulario para crear nuevo proveedor
     */
    public function create()
    {
        return view('Encargado.Proveedor.create');
    }

    /**
     * Guardar nuevo proveedor
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:Proveedor,nombre',
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:20',
        ]);

        Proveedor::create($validated);

        return redirect()->route('proveedor.index')
            ->with('success', '✨ Proveedor creado exitosamente.');
    }

    public function show($codProveedor)
    {
        $proveedor = Proveedor::findOrFail($codProveedor);
        
        // Compras a este proveedor (últimas 5)
        $compras = Compra::with(['encargado', 'detalles'])
            ->where('codProveedor', $codProveedor)
            ->orderBy('fechaCompra', 'desc')
            ->limit(5)
            ->get();
        
        // Productos que provee este proveedor (a través de las compras y detalles)
        $productos = Producto::whereHas('detallesCompra', function($query) use ($codProveedor) {
            $query->whereHas('compra', function($q) use ($codProveedor) {
                $q->where('codProveedor', $codProveedor);
            });
        })
        ->orderBy('nombre', 'asc')
        ->limit(5)
        ->get();
        
        // Estadísticas
        $totalComprasRealizadas = Compra::where('codProveedor', $codProveedor)->count();
        
        $totalGastado = Compra::where('codProveedor', $codProveedor)->sum('montoTotal');
        
        $totalProductos = Producto::whereHas('detallesCompra', function($query) use ($codProveedor) {
            $query->whereHas('compra', function($q) use ($codProveedor) {
                $q->where('codProveedor', $codProveedor);
            });
        })->count();
        
        return view('encargado.proveedor.show', compact('proveedor', 'compras', 'productos', 'totalComprasRealizadas', 'totalGastado', 'totalProductos'));
    }
    /**
     * Mostrar formulario para editar proveedor
     */
    public function edit($codProveedor)
    {
        $proveedor = Proveedor::findOrFail($codProveedor);
        return view('Encargado.Proveedor.edit', compact('proveedor'));
    }

    /**
     * Actualizar proveedor
     */
    public function update(Request $request, $codProveedor)
    {
        $proveedor = Proveedor::findOrFail($codProveedor);

        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('Proveedor', 'nombre')->ignore($codProveedor, 'codProveedor'),
            ],
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:20',
        ]);

        $proveedor->update($validated);

        return redirect()->route('proveedor.index')
            ->with('success', '📝 Proveedor actualizado exitosamente.');
    }

    /**
     * Eliminar proveedor
     */
    public function destroy($codProveedor)
    {
        $proveedor = Proveedor::findOrFail($codProveedor);

        $proveedor->delete();

        return redirect()->route('proveedor.index')
            ->with('success', '🗑️ Proveedor eliminado exitosamente.');
    }
}