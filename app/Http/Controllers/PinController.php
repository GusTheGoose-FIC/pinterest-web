<?php

namespace App\Http\Controllers;

use App\Models\PinPostgres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinController extends Controller
{
    /**
     * Mostrar formulario de edición de pin
     */
    public function edit(PinPostgres $pin)
    {
        // Verificar que el usuario sea dueño del pin
        if (Auth::id() !== $pin->user_id) {
            return redirect()->route('inicioLogueado')->with('error', 'No tienes permiso para editar este pin.');
        }

        return view('pins.edit', ['pin' => $pin]);
    }

    /**
     * Actualizar un pin
     */
    public function update(Request $request, PinPostgres $pin)
    {
        // Verificar que el usuario sea dueño del pin
        if (Auth::id() !== $pin->user_id) {
            return response()->json(['success' => false, 'message' => 'No tienes permiso para editar este pin.'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:2000',
            'link' => 'sometimes|nullable|url',
            'board' => 'sometimes|string|nullable',
            'allow_comments' => 'sometimes|boolean',
        ]);

        try {
            $pin->update($validated);

            // También actualizar en MongoDB si existe
            if ($pin->mongo_id) {
                $mongoPin = $pin->mongo();
                if ($mongoPin) {
                    $mongoPin->update($validated);
                }
            }

            return response()->json(['success' => true, 'message' => 'Pin actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el pin.'], 500);
        }
    }

    /**
     * Eliminar un pin
     */
    public function destroy(PinPostgres $pin)
    {
        // Verificar que el usuario sea dueño del pin o sea administrador
        if (Auth::id() !== $pin->user_id && !$this->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'No tienes permiso para eliminar este pin.'], 403);
        }

        try {
            // Eliminar de MongoDB si existe
            if ($pin->mongo_id) {
                $mongoPin = $pin->mongo();
                if ($mongoPin) {
                    $mongoPin->delete();
                }
            }

            // Eliminar de PostgreSQL
            $pin->delete();

            return response()->json(['success' => true, 'message' => 'Pin eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el pin.'], 500);
        }
    }

    /**
     * Verificar si el usuario es administrador
     */
    private function isAdmin()
    {
        $adminEmails = ['admin@pinterest.com', 'brandon@admin.com', 'paniagua@gmail.com'];
        return in_array(Auth::user()->email, $adminEmails);
    }
}
