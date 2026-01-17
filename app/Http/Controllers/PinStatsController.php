<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinStatsController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $user = Auth::user();
        $pins = $user->pins()->with(['likes', 'comments', 'reports'])->orderBy('created_at', 'desc')->get();

        $stats = $pins->map(function ($pin) {
            return [
                'id' => $pin->id,
                'title' => $pin->title,
                'description' => $pin->description,
                'image_url' => $pin->image_url,
                'created_at' => $pin->created_at,
                'likes_count' => $pin->likes()->count(),
                'comments_count' => $pin->comments()->count(),
                'reports_count' => $pin->reports()->count(),
                'allow_comments' => $pin->allow_comments,
            ];
        });

        $totalStats = [
            'total_pins' => $pins->count(),
            'total_likes' => $pins->sum(fn($p) => $p->likes()->count()),
            'total_comments' => $pins->sum(fn($p) => $p->comments()->count()),
            'total_reports' => $pins->sum(fn($p) => $p->reports()->count()),
        ];

        return response()->json([
            'success' => true,
            'pins' => $stats,
            'total_stats' => $totalStats,
        ]);
    }
}
