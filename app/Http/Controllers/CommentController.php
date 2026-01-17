<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\PinPostgres;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Almacenar un nuevo comentario o respuesta
     */
    public function store(Request $request, PinPostgres $pin)
    {
        // Validar que el usuario esté autenticado
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Debes iniciar sesión para comentar.'], 401);
        }

        // Validar que el pin permita comentarios
        if (!$pin->allow_comments) {
            return response()->json(['success' => false, 'message' => 'Los comentarios están deshabilitados para este pin.'], 403);
        }

        // Validar el contenido del comentario
        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:comments,id|integer',
        ], [
            'content.required' => 'El comentario no puede estar vacío.',
            'content.max' => 'El comentario no puede exceder 500 caracteres.',
            'parent_id.exists' => 'El comentario padre no existe.',
        ]);

        // Si es una respuesta, validar que el comentario padre pertenezca a este pin
        if ($validated['parent_id'] ?? null) {
            $parentComment = Comment::find($validated['parent_id']);
            if ($parentComment->pin_id !== $pin->id) {
                return response()->json(['success' => false, 'message' => 'El comentario padre no pertenece a este pin.'], 403);
            }
        }

        // Crear el comentario
        $comment = Comment::create([
            'pin_id' => $pin->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        // Crear notificación si el comentario es de otro usuario
        if (Auth::id() !== $pin->user_id && !($validated['parent_id'] ?? null)) {
            try {
                $username = optional(Auth::user()->userProfile)->username ?? Auth::user()->email;
                Notification::create([
                    'user_id' => $pin->user_id,
                    'actor_id' => Auth::id(),
                    'pin_id' => $pin->id,
                    'type' => 'comment',
                    'message' => $username . ' comentó en tu pin: "' . substr($validated['content'], 0, 50) . '..."',
                    'read' => false,
                ]);
            } catch (\Exception $e) {
                \Log::error('Error creating notification: ' . $e->getMessage());
                // Continuar aunque falle la notificación
            }
        }

        // Crear notificación para respuesta (avisar al autor del comentario padre si no es el mismo)
        if ($validated['parent_id'] ?? null) {
            try {
                $parentComment = Comment::find($validated['parent_id']);
                $pinOwnerName = optional(Auth::user()->userProfile)->username ?? Auth::user()->email;
                if ($parentComment->user_id !== Auth::id()) {
                Notification::create([
                    'user_id' => $parentComment->user_id,
                    'actor_id' => Auth::id(),
                    'pin_id' => $pin->id,
                    'type' => 'reply',
                    'message' => $pinOwnerName . ' respondió a tu comentario: "' . substr($validated['content'], 0, 50) . '..."',
                    'read' => false,
                ]);
                }
            } catch (\Exception $e) {
                \Log::error('Error creating reply notification: ' . $e->getMessage());
                // Continuar aunque falle la notificación
            }
        }

        return response()->json(['success' => true, 'message' => 'Comentario publicado.']);
    }

    /**
     * Eliminar un comentario
     */
    public function destroy(Comment $comment)
    {
        // Verificar que el usuario sea dueño del comentario o administrador
        if (Auth::id() !== $comment->user_id && !$this->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'No tienes permiso para eliminar este comentario.'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true, 'message' => 'Comentario eliminado.']);
    }

    /**
     * Verificar si el usuario es administrador
     */
    private function isAdmin()
    {
        $adminEmails = ['admin@pinterest.com', 'brandon@admin.com','paniagua@gmail.com'];
        return in_array(Auth::user()->email, $adminEmails);
    }

     /**
     * contraseñas de  admin 
     * adminpinterest:
     * brandonadmin:
     * paniagua:
     */
}
