<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\PinPostgres;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Dar like a un pin
     */
    public function store(PinPostgres $pin)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Debes iniciar sesión para dar like.'], 401);
        }

        try {
            // Verificar si el usuario ya dio like
            $existingLike = Like::where('pin_id', $pin->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingLike) {
                return response()->json(['success' => false, 'message' => 'Ya has dado like a este pin.'], 400);
            }

            // Crear el like
            Like::create([
                'pin_id' => $pin->id,
                'user_id' => Auth::id(),
            ]);

            // Crear notificación si el like es de otro usuario
            if (Auth::id() !== $pin->user_id) {
                try {
                    $username = Auth::user()->userProfile->username ?? Auth::user()->email;
                    Notification::create([
                        'user_id' => $pin->user_id,
                        'actor_id' => Auth::id(),
                        'pin_id' => $pin->id,
                        'type' => 'like',
                        'message' => $username . ' le dio like a tu pin',
                        'read' => false,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Error creating notification: ' . $e->getMessage());
                    // Continuar aunque falle la notificación
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Like agregado.',
                'likes_count' => $pin->likes()->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al dar like.'], 500);
        }
    }

    /**
     * Quitar like de un pin
     */
    public function destroy(PinPostgres $pin)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Debes iniciar sesión.'], 401);
        }

        try {
            Like::where('pin_id', $pin->id)
                ->where('user_id', Auth::id())
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Like removido.',
                'likes_count' => $pin->likes()->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al remover like.'], 500);
        }
    }
}
