<?php

namespace App\Http\Controllers;

use App\Models\PinPostgres;
use Illuminate\Http\Request;

class PublicPinsController extends Controller
{
    /**
     * Mostrar pines para visitantes (solo ver y descargar).
     */
    public function index()
    {
        $pins = PinPostgres::with(['user.profile'])
            ->orderByDesc('created_at')
            ->take(50)
            ->get();

        return view('public-pins', compact('pins'));
    }
}
