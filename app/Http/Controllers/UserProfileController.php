<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\PinPostgres;
use App\Models\SavedPin;
use App\Models\User;
use App\Models\UserProfile;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class UserProfileController extends Controller
{
    public function show(User $user): View
    {
        $user->load('userProfile');

        $pins = PinPostgres::query()
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(120)
            ->get();

        $isOwner = Auth::check() && (int) Auth::id() === (int) $user->id;
        $profile = optional($user->userProfile);
        $displayAvatarUrl = $this->normalizeImageUrlForWeb((string) ($profile->avatar_url ?? ''));
        $displayCoverUrl = $this->normalizeImageUrlForWeb((string) ($profile->cover_url ?? ''));

        return view('users.show', [
            'profileUser' => $user,
            'pins' => $pins,
            'isOwner' => $isOwner,
            'displayAvatarUrl' => $displayAvatarUrl,
            'displayCoverUrl' => $displayCoverUrl,
            'pinsCount' => PinPostgres::query()->where('user_id', $user->id)->count(),
            'likesCount' => Like::query()->where('user_id', $user->id)->count(),
            'savedCount' => SavedPin::query()->where('user_id', $user->id)->count(),
            'followersCount' => $user->followers()->count(),
            'followingCount' => $user->following()->count(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if (!Auth::check() || (int) Auth::id() !== (int) $user->id) {
            abort(403, 'No tienes permiso para editar este perfil.');
        }

        $profileId = optional($user->userProfile)->id;

        $validated = $request->validate([
            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('user_profiles', 'username')->ignore($profileId),
            ],
            'bio' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:40'],
            'avatar_url' => ['nullable', 'string', 'max:2000'],
            'cover_url' => ['nullable', 'string', 'max:2000'],
            'avatar_image' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:20480'],
            'cover_image' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:20480'],
        ]);

        $profile = UserProfile::firstOrNew(['user_id' => $user->id]);

        $username = trim((string) ($validated['username'] ?? ''));
        $profile->username = $username !== '' ? $username : $user->email;
        $profile->bio = trim((string) ($validated['bio'] ?? ''));
        $profile->phone = trim((string) ($validated['phone'] ?? ''));

        $avatarUrl = trim((string) ($validated['avatar_url'] ?? ''));
        $coverUrl = trim((string) ($validated['cover_url'] ?? ''));

        if ($request->hasFile('avatar_image')) {
            $avatarUrl = $this->storeProfileImageFile($request->file('avatar_image'));
        }
        if ($request->hasFile('cover_image')) {
            $coverUrl = $this->storeProfileImageFile($request->file('cover_image'));
        }

        $profile->avatar_url = $avatarUrl;
        $profile->cover_url = $coverUrl;
        $profile->save();

        return redirect()
            ->route('users.profile.show', $user)
            ->with('status', 'Perfil actualizado correctamente.');
    }

    private function storeProfileImageFile(UploadedFile $file): string
    {
        try {
            return (string) Cloudinary::upload($file->getRealPath(), [
                'folder' => 'profiles',
            ])->getSecurePath();
        } catch (Throwable $e) {
            $uploadsPath = public_path('uploads/profiles');
            if (!is_dir($uploadsPath)) {
                mkdir($uploadsPath, 0777, true);
            }

            $extension = Str::lower((string) ($file->getClientOriginalExtension() ?: 'jpg'));
            if ($extension === '') {
                $extension = 'jpg';
            }

            $filename = 'profile-' . time() . '-' . Str::uuid() . '.' . $extension;
            $file->move($uploadsPath, $filename);

            return '/uploads/profiles/' . $filename;
        }
    }

    private function normalizeImageUrlForWeb(string $url): string
    {
        $value = trim($url);
        if ($value === '') {
            return '';
        }

        $base = request()->getSchemeAndHttpHost();

        if (Str::startsWith($value, '/')) {
            return rtrim($base, '/') . $value;
        }

        $parsed = parse_url($value);
        $host = strtolower((string) ($parsed['host'] ?? ''));

        if (in_array($host, ['localhost', '127.0.0.1', '10.0.2.2', '0.0.0.0'], true)) {
            $path = (string) ($parsed['path'] ?? '');
            $query = isset($parsed['query']) ? ('?' . $parsed['query']) : '';
            $fragment = isset($parsed['fragment']) ? ('#' . $parsed['fragment']) : '';

            return rtrim($base, '/') . $path . $query . $fragment;
        }

        return $value;
    }
}
