<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\User;
use App\Models\TipoUsuario;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('usuario')
            ->orderBy('carnetIdentidad', 'desc')
            ->paginate(10);
            
        return view('Encargado.cliente.index', compact('clientes'));
    }

    public function create()
    {
        return view('Encargado.cliente.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'carnetIdentidad' => 'required|integer|unique:Cliente,carnetIdentidad',
            'nombre' => 'required|string|max:255',
            'apellidoPaterno' => 'required|string|max:255',
            'apellidoMaterno' => 'required|string|max:255',
            'edad' => 'required|integer|min:18|max:80',
            'sexo' => 'required',
            'celular' => 'required|string|max:20',

            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:Usuario,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::beginTransaction();
        
        try {
            $usuario = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'codTipoUsuario' => 1, 
                'bloqueado' => false,
            ]);

            // 2. Crear el Cliente vinculado al usuario
            Cliente::create([
                'carnetIdentidad' => $validated['carnetIdentidad'],
                'nombre' => $validated['nombre'],
                'apellidoPaterno' => $validated['apellidoPaterno'],
                'apellidoMaterno' => $validated['apellidoMaterno'],
                'edad' => $validated['edad'],
                'sexo' => $validated['sexo'],
                'celular' => $validated['celular'],
                'codUsuario' => $usuario->codUsuario,
            ]);
            
            DB::commit();
            
            return redirect()->route('cliente.index')
                ->with('success', '✨ Cliente y usuario creados exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($carnetIdentidad)
    {
        $cliente = Cliente::with('usuario')->findOrFail($carnetIdentidad);
        
        // Compras del cliente (últimas 5)
        $compras = Venta::with('detalles')
            ->where('codCliente', $carnetIdentidad)
            ->orderBy('fechaVenta', 'desc')
            ->limit(5)
            ->get();
        
        // Estadísticas
        $totalComprasRealizadas = Venta::where('codCliente', $carnetIdentidad)->count();
        
        $totalGastado = Venta::where('codCliente', $carnetIdentidad)->sum('montoTotal');
        
        $totalProductosComprados = DetalleVenta::whereHas('venta', function($query) use ($carnetIdentidad) {
            $query->where('codCliente', $carnetIdentidad);
        })->sum('cantidad');
        
        return view('encargado.cliente.show', compact('cliente', 'compras', 'totalComprasRealizadas', 'totalGastado', 'totalProductosComprados'));
    }

    public function edit($carnetIdentidad)
    {
        $cliente = Cliente::with('usuario')->findOrFail($carnetIdentidad);
        return view('Encargado.cliente.edit', compact('cliente'));
    }

    public function update(Request $request, $carnetIdentidad)
    {
        $cliente = Cliente::with('usuario')->findOrFail($carnetIdentidad);

        $validated = $request->validate([
            // Datos del Cliente
            'nombre' => 'required|string|max:255',
            'apellidoPaterno' => 'required|string|max:255',
            'apellidoMaterno' => 'required|string|max:255',
            'edad' => 'required|integer|min:18|max:120',
            'sexo' => 'required|in:M,F',
            'celular' => 'required|string|max:20',
            
            // Datos del Usuario
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('Usuario', 'email')->ignore($cliente->codUsuario, 'codUsuario'),
            ],
            'password' => 'nullable|string|min:6',
        ]);

        DB::beginTransaction();
        
        try {
            $usuarioData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];
            
            if (!empty($validated['password'])) {
                $usuarioData['password'] = Hash::make($validated['password']);
            }
            
            $cliente->usuario->update($usuarioData);

            $cliente->update([
                'nombre' => $validated['nombre'],
                'apellidoPaterno' => $validated['apellidoPaterno'],
                'apellidoMaterno' => $validated['apellidoMaterno'],
                'edad' => $validated['edad'],
                'sexo' => $validated['sexo'],
                'celular' => $validated['celular'],
            ]);
            
            DB::commit();
            
            return redirect()->route('cliente.index')
                ->with('success', '📝 Cliente y usuario actualizados exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($carnetIdentidad)
    {
        $cliente = Cliente::with('usuario')->findOrFail($carnetIdentidad);
        
        DB::beginTransaction();
        
        try {
            $codUsuario = $cliente->codUsuario;
            $cliente->delete();
            User::where('codUsuario', $codUsuario)->delete();
            
            DB::commit();
            
            return redirect()->route('cliente.index')
                ->with('success', '🗑️ Cliente y usuario eliminados exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cliente.index')
                ->with('error', '❌ Error al eliminar: ' . $e->getMessage());
        }
    }
}