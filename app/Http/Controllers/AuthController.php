<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Encargado;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $remember = $request->has('remember') ? true : false;

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            switch ($user->codTipoUsuario) {
                case 1: 
                    $cliente = Cliente::where('codUsuario', $user->codUsuario)->first();
                    if ($cliente) {
                        return redirect()->route('cliente.productos');
                    }
                    return redirect()->route('cliente.perfil.completar');
                    
                case 2: 
                    $encargado = Encargado::where('codUsuario', $user->codUsuario)->first();
                    if ($encargado) {
                        return redirect()->route('encargado.dashboard');
                    }
                    return redirect()->route('encargado.perfil.completar');
                    
                case 3: 
                    return redirect()->route('admin.dashboard');
                    
                default:
                    return redirect()->route('login');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }
    public function showRegister()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'carnetIdentidad' => 'required|integer|unique:Cliente,carnetIdentidad',
            'nombre' => 'required|string|max:255',
            'apellidoPaterno' => 'required|string|max:255',
            'apellidoMaterno' => 'required|string|max:255',
            'edad' => 'required|integer|min:18|max:100',
            'sexo' => 'required',
            'celular' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:Usuario,email',
            'password' => 'required|string|min:8',
        ]);

        DB::beginTransaction();
        
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'codTipoUsuario' => 1, // Tipo Cliente
                'bloqueado' => false,
            ]);
            $cliente = Cliente::create([
                'carnetIdentidad' => $validated['carnetIdentidad'],
                'nombre' => $validated['nombre'],
                'apellidoPaterno' => $validated['apellidoPaterno'],
                'apellidoMaterno' => $validated['apellidoMaterno'],
                'edad' => $validated['edad'],
                'sexo' => $validated['sexo'],
                'celular' => $validated['celular'],
                'codUsuario' => $user->codUsuario,
            ]);
            
            DB::commit();
            Auth::login($user);
            
            return redirect()->route('cliente.productos')
                ->with('success', '¡Bienvenido! Tu cuenta ha sido creada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear la cuenta: ' . $e->getMessage()])->withInput();
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Buscar usuario por email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid()),
                    'codTipoUsuario' => 1, // Cliente por defecto
                    'bloqueado' => false,
                ]);
            }
            
            Auth::login($user, true);
            
            return redirect()->route('cliente.productos');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Error al autenticar con Google']);
        }
    }
}