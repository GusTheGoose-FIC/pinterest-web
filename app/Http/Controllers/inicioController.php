<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class inicioController extends Controller
{
public function login(Request $request)
    {
        // 1. Validar los datos
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Intentar el login
        if (Auth::attempt($credentials)) {
            // 3. ¡Éxito!
            $request->session()->regenerate();
            
            // 4. Redirige al homefeed (o a donde sea)
            // (Borra el 'return response()->json()' que tenías aquí)
            return redirect()->intended('/homefeed'); 
        }

        // 5. ¡Fallo! Devuélvelo al formulario con un error
        return back()->withErrors([
            'email' => 'Los datos son incorrectos.',
        ])->onlyInput('email'); // Y re-llena solo el email
    }

    /**
     * MUESTRA la vista del formulario de login (GET).
     */
    public function showLoginForm()
    {
        // ¡Aquí va la vista del LOGIN, no la de WELCOME!
        return view('Login'); 
    }

    public function inicio()
    {
        return view('inicio');
    }

    public function Información()
    {
        return view('Información');
    }
     public function empresa()
    {
        return view('empresa');
    }
     public function Create()
    {
        return view('Create');
    }
     public function News()
    {
        return view('News');
    }
    public function Registro()
    {
        return view('Registro');
    }
}
