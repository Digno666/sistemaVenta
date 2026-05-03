<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    /**
     * Mostrar lista de categorías
     */
    public function index()
    {
        $categorias = Categoria::orderBy('codCategoria', 'asc')->paginate(5);
        return view('Encargado.categoria.index', compact('categorias'));
    }

    /**
     * Mostrar formulario para crear nueva categoría
     */
    public function create()
    {
        return view('Encargado.categoria.create');
    }

    /**
     * Guardar nueva categoría
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codCategoria' => 'required|string|max:10|unique:Categoria,codCategoria',
            'nombre' => 'required|string|max:255|unique:Categoria,nombre',
            'descripcion' => 'required|string|max:500',
        ]);

        Categoria::create($validated);

        return redirect()->route('categoria.index')
            ->with('success', '✨ Categoría creada exitosamente.');
    }

    /**
     * Mostrar detalles de una categoría específica
     */
    public function show($codCategoria)
    {
        $categoria = Categoria::findOrFail($codCategoria);
        
        // Productos de esta categoría
        $productos = Producto::where('codCategoria', $codCategoria)
            ->orderBy('nombre', 'asc')
            ->limit(6)
            ->get();
        
        // Estadísticas
        $totalProductos = Producto::where('codCategoria', $codCategoria)->count();
        
        $totalVentas = DetalleVenta::whereHas('producto', function($query) use ($codCategoria) {
            $query->where('codCategoria', $codCategoria);
        })->sum('cantidad');
        
        $totalRecaudado = DetalleVenta::whereHas('producto', function($query) use ($codCategoria) {
            $query->where('codCategoria', $codCategoria);
        })->select(DB::raw('SUM(cantidad * "precioVenta") as total'))
        ->value('total') ?? 0;
        
        return view('Encargado.categoria.show', compact('categoria', 'productos', 'totalProductos', 'totalVentas', 'totalRecaudado'));
    }
    public function edit($codCategoria)
    {
        $categoria = Categoria::findOrFail($codCategoria);
        return view('Encargado.categoria.edit', compact('categoria'));
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, $codCategoria)
    {
        $categoria = Categoria::findOrFail($codCategoria);

        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('Categoria', 'nombre')->ignore($codCategoria, 'codCategoria'),
            ],
            'descripcion' => 'required|string|max:500',
        ]);

        $categoria->update($validated);

        return redirect()->route('categoria.index')
            ->with('success', '📝 Categoría actualizada exitosamente.');
    }

    /**
     * Eliminar categoría
     */
    public function destroy($codCategoria)
    {
        $categoria = Categoria::findOrFail($codCategoria);
        
        // Verificar si tiene productos asociados (si tienes tabla Producto)
        // if ($categoria->productos()->count() > 0) {
        //     return redirect()->route('categoria.index')
        //         ->with('error', 'No se puede eliminar porque hay productos asociados a esta categoría.');
        // }

        $categoria->delete();

        return redirect()->route('categoria.index')
            ->with('success', '🗑️ Categoría eliminada exitosamente.');
    }
}