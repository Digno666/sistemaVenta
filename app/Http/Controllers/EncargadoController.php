<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Encargado;
use App\Models\User;
use App\Models\TipoUsuario;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EncargadoController extends Controller
{
    public function index()
    {
        $encargados = Encargado::with('usuario')
            ->orderBy('carnetIdentidad', 'desc')
            ->paginate(10);
            
        return view('admin.encargados.index', compact('encargados'));
    }

    public function create()
    {
        $tiposUsuario = TipoUsuario::all();
        return view('admin.encargados.create', compact('tiposUsuario'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'carnetIdentidad' => 'required|integer|unique:Encargado,carnetIdentidad',
            'nombre' => 'required|string|max:255',
            'apellidoPaterno' => 'required|string|max:255',
            'apellidoMaterno' => 'required|string|max:255',
            'sexo' => 'required',
            'telefono' => 'required|max:8',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:Usuario,email',
            'password' => 'required|string|min:6|confirmed',
            'codTipoUsuario' => 'required|exists:TipoUsuario,codTipoUsuario',
            'bloqueado' => 'boolean',
        ]);

        DB::beginTransaction();
        
        try {
            $usuario = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'codTipoUsuario' => $validated['codTipoUsuario'],
                'bloqueado' => $validated['bloqueado'] ?? false,
            ]);

            Encargado::create([
                'carnetIdentidad' => $validated['carnetIdentidad'],
                'nombre' => $validated['nombre'],
                'apellidoPaterno' => $validated['apellidoPaterno'],
                'apellidoMaterno' => $validated['apellidoMaterno'],
                'sexo' => $validated['sexo'],
                'telefono' => $validated['telefono'],
                'codUsuario' => $usuario->codUsuario,
            ]);
            
            DB::commit();
            
            return redirect()->route('encargado.index')
                ->with('success', '✨ Encargado y usuario creados exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($carnetIdentidad)
    {
        $encargado = Encargado::with('usuario.tipoUsuario')->findOrFail($carnetIdentidad);
        
        // Compras realizadas por el encargado (últimas 5)
        $compras = Compra::with(['proveedor', 'detalles'])
            ->where('codEncargado', $carnetIdentidad)
            ->orderBy('fechaCompra', 'desc')
            ->limit(5)
            ->get();
        
        // Ventas realizadas por el encargado (últimas 5)
        $ventas = Venta::with(['cliente', 'detalles'])
            ->where('codEncargado', $carnetIdentidad)
            ->orderBy('fechaVenta', 'desc')
            ->limit(5)
            ->get();
        
        // Estadísticas
        $totalCompras = Compra::where('codEncargado', $carnetIdentidad)->count();
        $totalVentas = Venta::where('codEncargado', $carnetIdentidad)->count();
        $totalMontoCompras = Compra::where('codEncargado', $carnetIdentidad)->sum('montoTotal');
        $totalMontoVentas = Venta::where('codEncargado', $carnetIdentidad)->sum('montoTotal');
        
        return view('admin.encargado.show', compact('encargado', 'compras', 'ventas', 'totalCompras', 'totalVentas', 'totalMontoCompras', 'totalMontoVentas'));
    }

    public function edit($carnetIdentidad)
    {
        $encargado = Encargado::with('usuario')->findOrFail($carnetIdentidad);
        $tiposUsuario = TipoUsuario::all();
        return view('admin.encargados.edit', compact('encargado', 'tiposUsuario'));
    }

    public function update(Request $request, $carnetIdentidad)
    {
        $encargado = Encargado::with('usuario')->findOrFail($carnetIdentidad);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoPaterno' => 'required|string|max:255',
            'apellidoMaterno' => 'required|string|max:255',
            'sexo' => 'required|in:M,F',
            'telefono' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('Usuario', 'email')->ignore($encargado->codUsuario, 'codUsuario'),
            ],
            'password' => 'nullable|string|min:6',
            'codTipoUsuario' => 'required|exists:TipoUsuario,codTipoUsuario',
            'bloqueado' => 'boolean',
        ]);

        DB::beginTransaction();
        
        try {
            $usuarioData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'codTipoUsuario' => $validated['codTipoUsuario'],
                'bloqueado' => $validated['bloqueado'] ?? false,
            ];
            
            if (!empty($validated['password'])) {
                $usuarioData['password'] = Hash::make($validated['password']);
            }
            
            $encargado->usuario->update($usuarioData);

            $encargado->update([
                'nombre' => $validated['nombre'],
                'apellidoPaterno' => $validated['apellidoPaterno'],
                'apellidoMaterno' => $validated['apellidoMaterno'],
                'sexo' => $validated['sexo'],
                'telefono' => $validated['telefono'],
            ]);
            
            DB::commit();
            
            return redirect()->route('encargado.index')
                ->with('success', '📝 Encargado y usuario actualizados exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($carnetIdentidad)
    {
        $encargado = Encargado::with('usuario')->findOrFail($carnetIdentidad);
        
        DB::beginTransaction();
        
        try {
            $codUsuario = $encargado->codUsuario;
            $encargado->delete();
            User::where('codUsuario', $codUsuario)->delete();
            
            DB::commit();
            
            return redirect()->route('encargado.index')
                ->with('success', '🗑️ Encargado y usuario eliminados exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('encargado.index')
                ->with('error', '❌ Error al eliminar: ' . $e->getMessage());
        }
    }
}