<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Función para mostrar la página de HTML
    public function showLogin()
    {
        return view('auth.login');
    }

    // Función para comprobar el email y la contraseña
    public function login(Request $request)
    {
        // Validamos que nos han enviado algo
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentamos iniciar sesión con esos datos
        if (Auth::attempt($credentials)) {
            // Si el login es correcto, regeneramos la sesión (por seguridad) y lo mandamos al inicio
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // Si falla, lo devolvemos a la página de login con un error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Muestra la página de registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // Procesa los datos y guarda al usuario en la Base de Datos
    public function register(Request $request)
    {
        // 1. Validar lo que nos envían (¡Añadimos 'rol' aquí!)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
            'password' => ['required', 'string', 'min:8', 'confirmed'], 
            'rol' => ['required', 'string'], // <--- VALIDACIÓN DEL ROL AÑADIDA
        ]);

        // 2. Crear el usuario en la Base de Datos (¡Y lo guardamos aquí!)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'rol' => $request->rol, // <--- GUARDADO DEL ROL AÑADIDO
        ]);

        // 3. Iniciar sesión automáticamente después de registrarse
        Auth::login($user);

        // 4. Mandarlo a la página principal
        return redirect()->route('home');
    }

    // Cierra la sesión del usuario
    public function logout(Request $request)
    {
        Auth::logout(); // Desconecta al usuario
        $request->session()->invalidate(); // Invalida la sesión actual
        $request->session()->regenerateToken(); // Genera un nuevo token de seguridad

        return redirect()->route('login'); // Lo mandamos de vuelta al login
    }
}