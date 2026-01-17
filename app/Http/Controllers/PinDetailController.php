<?php

namespace App\Http\Controllers;

use App\Models\PinPostgres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinDetailController extends Controller
{
    /**
     * Obtener detalles del pin con comentarios y likes (JSON)
     */
    public function show(PinPostgres $pin)
    {
        // Cargar el pin con usuario, comentarios (sin padres) y likes
        $pin->load('user.userProfile', 'likes');
        
        // Cargar solo comentarios principales (sin parent_id)
        $mainComments = $pin->comments()->whereNull('parent_id')->with('user.userProfile', 'replies.user.userProfile')->orderBy('created_at', 'desc')->get();

        // Verificar si el usuario actual dio like
        $userLiked = false;
        if (Auth::check()) {
            $userLiked = $pin->likes()->where('user_id', Auth::id())->exists();
        }

        // Datos de seguimiento del autor
        $author = $pin->user;
        $followersCount = $author ? $author->followers()->count() : 0;
        $isFollowingAuthor = false;
        $isSelf = false;

        if ($author && Auth::check()) {
            $isSelf = Auth::id() === $author->id;
            if (!$isSelf) {
                $isFollowingAuthor = Auth::user()->following()->where('followed_id', $author->id)->exists();
            }
        }

        return response()->json([
            'pin' => [
                'id' => $pin->id,
                'title' => $pin->title ?? 'Sin título',
                'description' => $pin->description ?? 'Sin descripción',
                'image_url' => $pin->image_url,
                'allow_comments' => (bool) $pin->allow_comments,
                'user_name' => $pin->user && $pin->user->userProfile ? $pin->user->userProfile->username : ($pin->user->email ?? 'Usuario'),
                'user_initial' => $pin->user ? strtoupper(substr($pin->user->email, 0, 1)) : 'U',
                'user_id' => $pin->user_id,
                'created_at' => $pin->created_at->diffForHumans(),
                'likes_count' => $pin->likes()->count(),
                'user_liked' => $userLiked,
                'followers_count' => $followersCount,
                'is_following_author' => $isFollowingAuthor,
                'is_self' => $isSelf,
            ],
            'comments' => $mainComments->map(function ($comment) use ($pin) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_name' => $comment->user && $comment->user->userProfile ? $comment->user->userProfile->username : ($comment->user->email ?? 'Usuario'),
                    'user_initial' => $comment->user ? strtoupper(substr($comment->user->email, 0, 1)) : 'U',
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user_id' => $comment->user_id,
                    'is_owner' => auth()->check() && auth()->id() === $comment->user_id,
                    'is_pin_owner' => auth()->check() && auth()->id() === $pin->user_id,
                    'replies' => $comment->replies->map(function ($reply) use ($pin) {
                        return [
                            'id' => $reply->id,
                            'content' => $reply->content,
                            'user_name' => $reply->user && $reply->user->userProfile ? $reply->user->userProfile->username : ($reply->user->email ?? 'Usuario'),
                            'user_initial' => $reply->user ? strtoupper(substr($reply->user->email, 0, 1)) : 'U',
                            'created_at' => $reply->created_at->diffForHumans(),
                            'user_id' => $reply->user_id,
                            'is_owner' => auth()->check() && auth()->id() === $reply->user_id,
                            'is_pin_owner' => auth()->check() && auth()->id() === $pin->user_id,
                        ];
                    })->toArray(),
                ];
            })->values()->all(),
        ]);
    }
}
