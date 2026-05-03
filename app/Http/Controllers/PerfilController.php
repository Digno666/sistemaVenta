<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Encargado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $encargado = Encargado::where('codUsuario', $user->codUsuario)->first();
        
        return view('Encargado.perfil', compact('encargado'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        $encargado = Encargado::where('codUsuario', $user->codUsuario)->first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('Usuario', 'email')->ignore($user->codUsuario, 'codUsuario'),
            ],
            'telefono' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la foto
        ]);

        DB::beginTransaction();

        try {
            // Actualizar usuario
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Datos del encargado a actualizar
            $encargadoData = [];
            
            if (isset($validated['telefono'])) {
                $encargadoData['telefono'] = $validated['telefono'];
            }

            // Procesar foto
            if ($request->hasFile('foto')) {
                // Eliminar foto anterior si existe
                if ($encargado && $encargado->foto && Storage::disk('public')->exists($encargado->foto)) {
                    Storage::disk('public')->delete($encargado->foto);
                }
                
                $fotoPath = $request->file('foto')->store('encargados/fotos', 'public');
                $encargadoData['foto'] = $fotoPath;
            }

            // Actualizar encargado
            if ($encargado && !empty($encargadoData)) {
                $encargado->update($encargadoData);
            }

            DB::commit();

            return redirect()->route('encargado.perfil.index')
                ->with('success', 'Perfil actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el perfil: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mostrar formulario para completar perfil
     */
    public function completar()
    {
        return view('Encargado.perfil-completar');
    }

    /**
     * Guardar perfil completo del encargado
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'carnetIdentidad' => 'required|integer|unique:Encargado,carnetIdentidad',
            'nombre' => 'required|string|max:255',
            'apellidoPaterno' => 'required|string|max:255',
            'apellidoMaterno' => 'required|string|max:255',
            'sexo' => 'required|in:M,F',
            'telefono' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Procesar foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('encargados/fotos', 'public');
        }

        $encargado = Encargado::create([
            'carnetIdentidad' => $validated['carnetIdentidad'],
            'nombre' => $validated['nombre'],
            'apellidoPaterno' => $validated['apellidoPaterno'],
            'apellidoMaterno' => $validated['apellidoMaterno'],
            'sexo' => $validated['sexo'],
            'telefono' => $validated['telefono'],
            'foto' => $fotoPath,
            'codUsuario' => Auth::user()->codUsuario,
        ]);

        return redirect()->route('encargado.perfil.index')
            ->with('success', 'Perfil completado exitosamente');
    }

    /**
     * Subir foto de perfil vía AJAX
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $encargado = Encargado::where('codUsuario', Auth::user()->codUsuario)->first();
        
        if (!$encargado) {
            return response()->json(['success' => false, 'message' => 'Encargado no encontrado'], 404);
        }
        
        // Eliminar foto anterior
        if ($encargado->foto && Storage::disk('public')->exists($encargado->foto)) {
            Storage::disk('public')->delete($encargado->foto);
        }
        
        $path = $request->file('foto')->store('encargados/fotos', 'public');
        $encargado->update(['foto' => $path]);
        
        return response()->json(['success' => true, 'url' => Storage::url($path)]);
    }
}