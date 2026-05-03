<?php

namespace App\Http\Controllers;

use App\Models\TipoUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TipoUsuarioController extends Controller
{
    public function index()
    {
        $tiposUsuario = TipoUsuario::withCount('usuarios')
            ->orderBy('codTipoUsuario', 'desc')
            ->paginate(10);
            
        return view('admin.tipos-usuario.index', compact('tiposUsuario'));
    }

    public function create()
    {
        return view('admin.tipos-usuario.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:TipoUsuario,nombre',
            'descripcion' => 'required|string|max:500',
        ]);

        TipoUsuario::create($validated);

        return redirect()->route('tipos-usuario.index')
            ->with('success', '✨ Tipo de usuario creado exitosamente.');
    }

    public function show($codTipoUsuario)
    {
        $tipoUsuario = TipoUsuario::withCount('usuarios')->findOrFail($codTipoUsuario);
        return view('admin.tipos-usuario.show', compact('tipoUsuario'));
    }

    public function edit($codTipoUsuario)
    {
        $tipoUsuario = TipoUsuario::withCount('usuarios')->findOrFail($codTipoUsuario);
        return view('admin.tipos-usuario.edit', compact('tipoUsuario'));
    }

    public function update(Request $request, $codTipoUsuario)
    {
        $tipoUsuario = TipoUsuario::findOrFail($codTipoUsuario);

        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('TipoUsuario', 'nombre')->ignore($codTipoUsuario, 'codTipoUsuario'),
            ],
            'descripcion' => 'required|string|max:500',
        ]);

        $tipoUsuario->update($validated);

        return redirect()->route('tipos-usuario.index')
            ->with('success', '📝 Tipo de usuario actualizado exitosamente.');
    }

    public function destroy($codTipoUsuario)
    {
        $tipoUsuario = TipoUsuario::findOrFail($codTipoUsuario);
        
        $usuariosCount = User::where('codTipoUsuario', $codTipoUsuario)->count();
        
        if ($usuariosCount > 0) {
            return redirect()->route('admin.tipos-usuario.index')
                ->with('error', '❌ No se puede eliminar porque hay ' . $usuariosCount . ' usuario(s) asociado(s) a este tipo.');
        }

        $tipoUsuario->delete();

        return redirect()->route('tipos-usuario.index')
            ->with('success', '🗑️ Tipo de usuario eliminado exitosamente.');
    }
}