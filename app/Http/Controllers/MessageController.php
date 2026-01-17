<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    private function ensuresMutualFollow(User $other): bool
    {
        $auth = Auth::user();
        if (!$auth) {
            return false;
        }

        $authFollowsOther = $auth->following()->where('users.id', $other->id)->exists();
        $otherFollowsAuth = $auth->followers()->where('users.id', $other->id)->exists();

        return $authFollowsOther && $otherFollowsAuth;
    }

    public function threads()
    {
        $auth = Auth::user();
        if (!$auth) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $followingIds = $auth->following()->pluck('users.id')->toArray();
        $followers = $auth->followers()->with('userProfile')->get()->map(function ($follower) use ($followingIds) {
            return [
                'id' => $follower->id,
                'username' => optional($follower->userProfile)->username ?? $follower->email,
                'initial' => strtoupper(substr($follower->email, 0, 1)),
                'is_mutual' => in_array($follower->id, $followingIds),
            ];
        });

        return response()->json([
            'success' => true,
            'followers' => $followers,
        ]);
    }

    public function index(User $user)
    {
        $auth = Auth::user();
        if (!$auth) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        if (!$this->ensuresMutualFollow($user)) {
            return response()->json(['success' => false, 'message' => 'Solo puedes chatear con seguidores mutuos.'], 403);
        }

        // Marcar mensajes como leídos
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $auth->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::where(function ($q) use ($auth, $user) {
                $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
            })
            ->orWhere(function ($q) use ($auth, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
            })
            ->orderBy('created_at', 'asc')
            ->take(100)
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, User $user)
    {
        $auth = Auth::user();
        if (!$auth) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        if (!$this->ensuresMutualFollow($user)) {
            return response()->json(['success' => false, 'message' => 'Solo puedes chatear con seguidores mutuos.'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => $auth->id,
            'receiver_id' => $user->id,
            'content' => $validated['content'],
        ]);

        // Notificación al receptor
        try {
            $username = optional($auth->userProfile)->username ?? $auth->email;
            Notification::create([
                'user_id' => $user->id,
                'actor_id' => $auth->id,
                'pin_id' => null,
                'type' => 'message',
                'message' => $username . ' te envió un mensaje: "' . substr($validated['content'], 0, 80) . '"',
                'read' => false,
            ]);
        } catch (\Throwable $e) {
            \Log::error('No se pudo crear notificación de mensaje: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado',
            'data' => $message,
        ]);
    }
}
