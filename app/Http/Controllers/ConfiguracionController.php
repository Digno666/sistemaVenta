<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConfiguracionController extends Controller
{
    /**
     * Mostrar página de configuración
     */
    public function index()
    {
        return view('Encargado.configuracion');
    }

    /**
     * Actualizar contraseña del usuario
     */
    public function seguridad(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Verificar contraseña actual
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('encargado.configuracion')
            ->with('success', 'Contraseña actualizada exitosamente');
    }

    /**
     * Actualizar preferencias de notificaciones
     */
    public function notificaciones(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email_notifications' => 'nullable|boolean',
            'stock_notifications' => 'nullable|boolean',
            'weekly_reports' => 'nullable|boolean',
        ]);

        // Si no existen las columnas en la tabla Usuario, las creamos
        // Esta información se puede guardar en una tabla settings o en JSON
        // Por ahora, lo guardaremos en una sesión o en una tabla aparte
        
        // Guardar en sesión (temporal)
        session([
            'email_notifications' => $validated['email_notifications'] ?? false,
            'stock_notifications' => $validated['stock_notifications'] ?? false,
            'weekly_reports' => $validated['weekly_reports'] ?? false,
        ]);

        // Si quieres persistir en la base de datos, necesitas agregar estas columnas a la tabla Usuario
        // o crear una tabla "configuraciones"

        return redirect()->route('encargado.configuracion')
            ->with('success', 'Preferencias de notificaciones actualizadas');
    }

    /**
     * Actualizar preferencias de apariencia
     */
    public function apariencia(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'nullable|in:light,dark,auto',
            'layout' => 'nullable|in:compact,comfortable',
        ]);

        // Guardar en sesión (temporal)
        session([
            'theme' => $validated['theme'] ?? 'light',
            'layout' => $validated['layout'] ?? 'compact',
        ]);

        return redirect()->route('encargado.configuracion')
            ->with('success', 'Preferencias de apariencia actualizadas');
    }

    /**
     * Actualizar preferencias de notificaciones (versión con base de datos)
     * Si prefieres usar base de datos, descomenta el código y crea la migración
     */
    // public function notificaciones(Request $request)
    // {
    //     $user = Auth::user();
    //
    //     $validated = $request->validate([
    //         'email_notifications' => 'nullable|boolean',
    //         'stock_notifications' => 'nullable|boolean',
    //         'weekly_reports' => 'nullable|boolean',
    //     ]);
    //
    //     // Crear o actualizar configuraciones
    //     $user->configuracion()->updateOrCreate(
    //         ['user_id' => $user->codUsuario],
    //         [
    //             'email_notifications' => $validated['email_notifications'] ?? false,
    //             'stock_notifications' => $validated['stock_notifications'] ?? false,
    //             'weekly_reports' => $validated['weekly_reports'] ?? false,
    //         ]
    //     );
    //
    //     // También puedes usar un campo JSON en la tabla Usuario
    //     // $user->preferencias = json_encode([
    //     //     'email_notifications' => $validated['email_notifications'] ?? false,
    //     //     'stock_notifications' => $validated['stock_notifications'] ?? false,
    //     //     'weekly_reports' => $validated['weekly_reports'] ?? false,
    //     // ]);
    //     // $user->save();
    //
    //     return redirect()->route('encargado.configuracion')
    //         ->with('success', 'Preferencias de notificaciones actualizadas');
    // }
}