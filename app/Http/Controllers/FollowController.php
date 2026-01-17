<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function store(User $user)
    {
        $authUser = Auth::user();
        if (!$authUser) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        if ($authUser->id === $user->id) {
            return response()->json(['success' => false, 'message' => 'No puedes seguirte a ti mismo.'], 400);
        }

        $authUser->following()->syncWithoutDetaching([$user->id]);

            // Notificar al seguido
            try {
                $username = optional($authUser->userProfile)->username ?? $authUser->email;
                Notification::create([
                    'user_id' => $user->id,
                    'actor_id' => $authUser->id,
                    'pin_id' => null,
                    'type' => 'follow',
                    'message' => $username . ' empezó a seguirte.',
                    'read' => false,
                ]);
            } catch (\Throwable $e) {
                \Log::error('No se pudo crear notificación de follow: ' . $e->getMessage());
            }

        return response()->json([
            'success' => true,
            'message' => 'Siguiendo al usuario.',
            'following' => true,
            'followers_count' => $user->followers()->count(),
        ]);
    }

    public function destroy(User $user)
    {
        $authUser = Auth::user();
        if (!$authUser) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        if ($authUser->id === $user->id) {
            return response()->json(['success' => false, 'message' => 'No puedes dejar de seguirte a ti mismo.'], 400);
        }

        $authUser->following()->detach($user->id);

        return response()->json([
            'success' => true,
            'message' => 'Has dejado de seguir al usuario.',
            'following' => false,
            'followers_count' => $user->followers()->count(),
        ]);
    }

        public function followers()
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
            })->values();

            return response()->json([
                'success' => true,
                'followers' => $followers,
            ]);
        }
}
