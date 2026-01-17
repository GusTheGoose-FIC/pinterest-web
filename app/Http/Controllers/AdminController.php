<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PinPostgres;
use App\Models\PinReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'paniagua@gmail.com', 
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
        
        // Obtener reportes de pines con estadísticas
        $pinReports = PinReport::with(['pin', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Agrupar reportes por pin
        $reportsByPin = [];
        foreach ($pinReports as $report) {
            $pinId = $report->pin_id;
            if (!isset($reportsByPin[$pinId])) {
                $reportsByPin[$pinId] = [
                    'pin' => $report->pin,
                    'total' => 0,
                    'by_type' => [],
                    'reports' => []
                ];
            }
            $reportsByPin[$pinId]['total']++;
            $reason = $report->reason;
            if (!isset($reportsByPin[$pinId]['by_type'][$reason])) {
                $reportsByPin[$pinId]['by_type'][$reason] = 0;
            }
            $reportsByPin[$pinId]['by_type'][$reason]++;
            $reportsByPin[$pinId]['reports'][] = $report;
        }
        
        // Ordenar por total de reportes descendente
        uasort($reportsByPin, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });
        
        return view('PantallaAdmin', compact('users', 'pins', 'pinReports', 'reportsByPin'));
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

    /**
     * Restablecer contraseña de un usuario
     */
    public function resetUserPassword(Request $request, $id)
    {
        // Verificar permisos de admin
        if (!$this->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos de administrador.'], 403);
        }

        $request->validate([
            'new_password' => 'required|string|min:8',
        ]);

        try {
            $user = User::findOrFail($id);
            
            // Verificar que no se cambie su propia contraseña por este método
            if ($user->id === Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Usa el perfil para cambiar tu propia contraseña.'], 400);
            }
            
            // Cambiar la contraseña
            $user->password = Hash::make($request->new_password);
            $user->save();
            
            return response()->json([
                'success' => true, 
                'message' => 'Contraseña restablecida correctamente para ' . ($user->email ?? 'el usuario')
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al restablecer contraseña: ' . $e->getMessage()], 500);
        }
    }
}