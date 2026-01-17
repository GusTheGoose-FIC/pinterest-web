<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\PinPostgres;
use App\Models\PinReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinReportController extends Controller
{
    /**
     * Reportar un pin
     */
    public function store(Request $request, PinPostgres $pin)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Debes iniciar sesión para reportar.'], 401);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ], [
            'reason.required' => 'Indica el motivo del reporte.',
            'reason.max' => 'El motivo no puede exceder 500 caracteres.',
        ]);

        $existing = PinReport::where('pin_id', $pin->id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Ya enviaste un reporte pendiente para este pin.',
            ], 409);
        }

        $report = PinReport::create([
            'pin_id' => $pin->id,
            'user_id' => Auth::id(),
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        $reporterName = optional(Auth::user()->userProfile)->username ?? Auth::user()->email;
        $admins = User::whereIn('email', $this->adminEmails())->get();

        foreach ($admins as $admin) {
            try {
                Notification::create([
                    'user_id' => $admin->id,
                    'actor_id' => Auth::id(),
                    'pin_id' => $pin->id,
                    'type' => 'report',
                    'message' => $reporterName . ' reportó el pin "' . ($pin->title ?? 'Sin título') . '" por: "' . substr($validated['reason'], 0, 80) . '"',
                    'read' => false,
                ]);
            } catch (\Exception $e) {
                \Log::error('Error creating report notification: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Reporte enviado. Un administrador lo revisará.',
            'report_id' => $report->id,
        ]);
    }

    private function adminEmails(): array
    {
        return ['admin@pinterest.com', 'brandon@admin.com', 'paniagua@gmail.com'];
    }
}
