<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PinPostgres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Middleware para verificar que el usuario sea admin
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    private function isAdmin()
    {
        $adminEmails = [
            'admin@pinterest.com',
            'brandon@admin.com', 
        ];
        
        return in_array(Auth::user()->email, $adminEmails);
    }

    public function index()
    {
        // Verificar si el usuario actual es admin
        if (!$this->isAdmin()) {
            return redirect()->route('inicioLogueado')->with('error', 'No tienes permisos de administrador.');
        }
        
        // Obtener usuarios con sus perfiles
        $users = User::with('profile')->orderBy('created_at', 'desc')->get();
        
        // Obtener pines con información del usuario
        $pins = PinPostgres::with(['user.profile'])->orderBy('created_at', 'desc')->get();
        
        return view('PantallaAdmin', compact('users', 'pins'));
    }

    /**
     * Eliminar un usuario
     */
    public function deleteUser($id)
    {
        // Verificar permisos de admin
        if (!$this->isAdmin()) {
            return redirect()->route('inicioLogueado')->with('error', 'No tienes permisos de administrador.');
        }

        try {
            $user = User::findOrFail($id);
            
            // Verificar que no se elimine a sí mismo
            if ($user->id === Auth::id()) {
                return redirect()->back()->with('error', 'No puedes eliminarte a ti mismo.');
            }
            
            // Eliminar pines del usuario primero (por la foreign key)
            PinPostgres::where('user_id', $user->id)->delete();
            
            // Eliminar el usuario (esto también eliminará su perfil por cascade)
            $user->delete();
            
            return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un pin
     */
    public function deletePin($id)
    {
        // Verificar permisos de admin
        if (!$this->isAdmin()) {
            return redirect()->route('inicioLogueado')->with('error', 'No tienes permisos de administrador.');
        }

        try {
            $pin = PinPostgres::findOrFail($id);
            
            // También eliminar de MongoDB si existe
            if ($pin->mongo_id) {
                $mongoPin = $pin->mongo();
                if ($mongoPin) {
                    $mongoPin->delete();
                }
            }
            
            // Eliminar de PostgreSQL
            $pin->delete();
            
            return redirect()->back()->with('success', 'Pin eliminado correctamente.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el pin: ' . $e->getMessage());
        }
    }
}