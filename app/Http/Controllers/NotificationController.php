<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Obtener notificaciones del usuario autenticado
     */
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $notifications = Notification::where('user_id', Auth::id())
            ->with(['actor.userProfile', 'pin'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => Notification::where('user_id', Auth::id())->where('read', false)->count(),
        ]);
    }

    /**
     * Marcar una notificación como leída
     */
    public function markAsRead(Notification $notification)
    {
        if (Auth::id() !== $notification->user_id) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true, 'message' => 'Notificación marcada como leída']);
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function markAllAsRead()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        Notification::where('user_id', Auth::id())
            ->where('read', false)
            ->update(['read' => true]);

        return response()->json(['success' => true, 'message' => 'Todas las notificaciones marcadas como leídas']);
    }

    /**
     * Eliminar una notificación
     */
    public function destroy(Notification $notification)
    {
        if (Auth::id() !== $notification->user_id) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $notification->delete();

        return response()->json(['success' => true, 'message' => 'Notificación eliminada']);
    }
}
