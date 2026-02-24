<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Image;
use App\Models\Pin;
use App\Models\PinPostgres;
use App\Models\SavedPin;
use App\Models\User;
use App\Models\UserProfile;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class MobileFeedController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $limit = max(1, min((int) $request->integer('limit', 120), 200));
        $search = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', ''));
        $userId = trim((string) $request->query('user_id', ''));
        $userEmail = trim((string) $request->query('user_email', ''));

        $query = PinPostgres::query()
            ->with(['user.userProfile'])
            ->withCount(['likes', 'savedPins']);

        if ($userId !== '') {
            $query->where('user_id', $userId);
        }

        if ($userEmail !== '') {
            $normalizedEmail = Str::lower($userEmail);
            $query->whereHas('user', function ($userQuery) use ($normalizedEmail) {
                $userQuery->whereRaw('LOWER(email) = ?', [$normalizedEmail]);
            });
        }

        if ($category !== '') {
            $normalizedCategory = '%' . Str::lower($category) . '%';
            $query->whereRaw('LOWER(COALESCE(board, \'\')) LIKE ?', [$normalizedCategory]);
        }

        if ($search !== '') {
            $tokens = collect(preg_split('/\s+/u', Str::lower($search)) ?: [])
                ->map(fn ($token) => trim((string) $token))
                ->filter(fn ($token) => $token !== '')
                ->values();

            if ($tokens->isNotEmpty()) {
                $query->where(function ($outer) use ($tokens) {
                    foreach ($tokens as $token) {
                        $like = '%' . $token . '%';
                        $outer->where(function ($inner) use ($like) {
                            $inner->whereRaw('LOWER(COALESCE(title, \'\')) LIKE ?', [$like])
                                ->orWhereRaw('LOWER(COALESCE(description, \'\')) LIKE ?', [$like])
                                ->orWhereRaw('LOWER(COALESCE(board, \'\')) LIKE ?', [$like]);
                        });
                    }
                });
            }
        }

        $pins = $query
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();

        return response()->json([
            'data' => $pins->map(fn (PinPostgres $pin) => $this->transformPin($pin))->values(),
            'meta' => [
                'count' => $pins->count(),
                'limit' => $limit,
            ],
        ]);
    }

    public function show(PinPostgres $pin): JsonResponse
    {
        $pin->load(['user.userProfile']);
        $pin->loadCount(['likes', 'savedPins']);

        $relatedQuery = PinPostgres::query()
            ->with(['user.userProfile'])
            ->withCount(['likes', 'savedPins'])
            ->where('id', '!=', $pin->id)
            ->orderByDesc('created_at');

        if (!empty($pin->board)) {
            $relatedQuery->where('board', $pin->board);
        }

        $relatedPins = $relatedQuery->limit(12)->get();

        if ($relatedPins->isEmpty() && !empty($pin->board)) {
            $relatedPins = PinPostgres::query()
                ->with(['user.userProfile'])
                ->withCount(['likes', 'savedPins'])
                ->where('id', '!=', $pin->id)
                ->orderByDesc('created_at')
                ->limit(12)
                ->get();
        }

        return response()->json([
            'data' => $this->transformPin($pin),
            'related' => $relatedPins->map(fn (PinPostgres $related) => $this->transformPin($related))->values(),
        ]);
    }

    public function comments(Request $request, PinPostgres $pin): JsonResponse
    {
        $viewerEmail = trim((string) $request->query('user_email', ''));
        $viewer = $viewerEmail !== '' ? $this->resolveUserByEmail($viewerEmail, false) : null;

        $comments = Comment::query()
            ->where('pin_id', $pin->id)
            ->whereNull('parent_id')
            ->with(['user.userProfile', 'replies.user.userProfile', 'replies.replies.user.userProfile'])
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'data' => $comments->map(
                fn (Comment $comment) => $this->transformComment($comment, $pin, $viewer)
            )->values(),
        ]);
    }

    public function addComment(Request $request, PinPostgres $pin): JsonResponse
    {
        if (!$pin->allow_comments) {
            return response()->json([
                'message' => 'Los comentarios están deshabilitados para este pin.',
            ], 403);
        }

        $validated = $request->validate([
            'user_email' => ['required', 'email', 'max:255'],
            'content' => ['required', 'string', 'max:500'],
            'parent_id' => ['nullable', 'integer', 'exists:comments,id'],
        ]);

        $user = $this->resolveUserByEmail((string) $validated['user_email'], true);
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        $parentId = $validated['parent_id'] ?? null;
        if ($parentId !== null) {
            $parent = Comment::query()->find($parentId);
            if (!$parent || (int) $parent->pin_id !== (int) $pin->id) {
                return response()->json([
                    'message' => 'El comentario padre no pertenece a este pin.',
                ], 422);
            }
        }

        $comment = Comment::create([
            'pin_id' => $pin->id,
            'user_id' => $user->id,
            'parent_id' => $parentId,
            'content' => trim((string) $validated['content']),
        ]);

        $comment->load(['user.userProfile', 'replies.user.userProfile']);

        return response()->json([
            'data' => $this->transformComment($comment, $pin, $user),
        ], 201);
    }

    public function deleteComment(Request $request, PinPostgres $pin, Comment $comment): JsonResponse
    {
        $validated = $request->validate([
            'user_email' => ['required', 'email', 'max:255'],
        ]);

        if ((int) $comment->pin_id !== (int) $pin->id) {
            return response()->json([
                'message' => 'Comentario no encontrado para este pin.',
            ], 404);
        }

        $user = $this->resolveUserByEmail((string) $validated['user_email'], false);
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        $canDelete = (int) $user->id === (int) $comment->user_id || (int) $user->id === (int) $pin->user_id;
        if (!$canDelete) {
            return response()->json([
                'message' => 'No tienes permiso para eliminar este comentario.',
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_email' => ['required', 'email', 'max:255'],
            'image' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:20480'],
        ]);

        $user = $this->resolveUserByEmail((string) $validated['user_email'], true);
        if (!$user) {
            return response()->json([
                'message' => 'No se pudo resolver el usuario.',
            ], 422);
        }

        if (!$request->hasFile('image')) {
            return response()->json([
                'message' => 'La imagen es requerida.',
            ], 422);
        }

        try {
            $imageUrl = $this->storePinImageFile($request->file('image'));
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'No se pudo subir la imagen.',
            ], 500);
        }

        return response()->json([
            'data' => [
                'image_url' => $this->normalizeImageUrlForClient($imageUrl),
            ],
        ], 201);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_email' => ['required', 'email', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:2000'],
            'image_urls' => ['nullable', 'array'],
            'image_urls.*' => ['nullable', 'string', 'max:2000'],
            'allow_comments' => ['nullable', 'boolean'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        $primaryImageUrl = trim((string) ($validated['image_url'] ?? ''));
        $imageUrls = collect($validated['image_urls'] ?? [])
            ->map(fn ($url) => trim((string) $url))
            ->filter(fn ($url) => $url !== '')
            ->values();

        if ($primaryImageUrl === '' && $imageUrls->isNotEmpty()) {
            $primaryImageUrl = (string) $imageUrls->first();
        }

        if ($primaryImageUrl === '') {
            return response()->json([
                'message' => 'Debes enviar image_url o image_urls.',
            ], 422);
        }

        $user = $this->resolveUserByEmail((string) $validated['user_email'], true);
        if (!$user) {
            return response()->json([
                'message' => 'No se pudo resolver el usuario.',
            ], 422);
        }

        $mongoPin = null;
        try {
            $mongoPin = Pin::create([
                'user_id' => $user->id,
                'title' => (string) ($validated['title'] ?? ''),
                'description' => (string) ($validated['description'] ?? ''),
                'image_url' => $primaryImageUrl,
                'link' => null,
                'board' => (string) ($validated['category'] ?? ''),
                'tags' => [],
                'products' => [],
                'allow_comments' => (bool) ($validated['allow_comments'] ?? true),
                'show_similar' => false,
                'alt_text' => (string) ($validated['alt_text'] ?? ''),
            ]);
        } catch (Throwable $e) {
            // Si Mongo falla, mantenemos el pin en Postgres con image_url directo.
        }

        $pin = PinPostgres::create([
            'user_id' => $user->id,
            'title' => (string) ($validated['title'] ?? ''),
            'description' => (string) ($validated['description'] ?? ''),
            // Guardar siempre image_url en Postgres para que el pin sea visible
            // aun cuando Mongo no este disponible desde alguna vista/proceso.
            'image_url' => $primaryImageUrl,
            'link' => null,
            'board' => (string) ($validated['category'] ?? ''),
            'allow_comments' => (bool) ($validated['allow_comments'] ?? true),
            'show_similar' => false,
            'alt_text' => (string) ($validated['alt_text'] ?? ''),
            'mongo_id' => $mongoPin?->id,
        ]);

        // Compatibilidad con pantallas web antiguas que consumen la coleccion "images".
        try {
            Image::create([
                'url' => $primaryImageUrl,
                'title' => (string) ($validated['title'] ?? ''),
                'user_id' => $user->id,
                'tags' => [],
            ]);
        } catch (Throwable $e) {
            // No bloqueamos el flujo principal si falla el espejo en images.
        }

        $pin->load(['user.userProfile']);
        $pin->loadCount(['likes', 'savedPins']);

        return response()->json([
            'data' => $this->transformPin($pin),
        ], 201);
    }

    public function profileByEmail(Request $request): JsonResponse
    {
        $email = trim((string) $request->query('email', ''));
        $viewerEmail = trim((string) $request->query('viewer_email', ''));
        if ($email === '') {
            return response()->json([
                'message' => 'El parámetro email es requerido.',
            ], 422);
        }

        $user = $this->resolveUserByEmail($email, true);

        if (!$user) {
            return response()->json([
                'message' => 'Perfil no encontrado.',
            ], 404);
        }

        $user->load('userProfile');

        return response()->json([
            'data' => $this->transformProfile($user, $viewerEmail),
        ]);
    }

    public function profileById(Request $request, User $user): JsonResponse
    {
        $viewerEmail = trim((string) $request->query('viewer_email', ''));
        $user->load('userProfile');

        return response()->json([
            'data' => $this->transformProfile($user, $viewerEmail),
        ]);
    }

    public function updateProfileByEmail(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'actor_email' => ['required', 'email', 'max:255'],
            'username' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:40'],
            'avatar_url' => ['nullable', 'string', 'max:2000'],
            'cover_url' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = $this->resolveUserByEmail((string) $validated['email'], true);
        if (!$user) {
            return response()->json([
                'message' => 'No se pudo resolver el usuario.',
            ], 422);
        }

        $actor = $this->resolveUserByEmail((string) $validated['actor_email'], false);
        if (!$actor) {
            return response()->json([
                'message' => 'No se pudo resolver el actor.',
            ], 422);
        }

        if ((int) $actor->id !== (int) $user->id) {
            return response()->json([
                'message' => 'Solo el titular del perfil puede modificarlo.',
            ], 403);
        }

        $profile = UserProfile::firstOrNew(['user_id' => $user->id]);

        if (array_key_exists('username', $validated)) {
            $username = trim((string) ($validated['username'] ?? ''));
            if ($username !== '') {
                $usernameExists = UserProfile::query()
                    ->whereRaw('LOWER(username) = ?', [Str::lower($username)])
                    ->where('user_id', '!=', $user->id)
                    ->exists();
                if ($usernameExists) {
                    return response()->json([
                        'message' => 'Ese nombre de usuario ya está en uso.',
                    ], 422);
                }
            }
            $profile->username = $username;
        }
        if (array_key_exists('bio', $validated)) {
            $profile->bio = (string) ($validated['bio'] ?? '');
        }
        if (array_key_exists('phone', $validated)) {
            $profile->phone = trim((string) ($validated['phone'] ?? ''));
        }
        if (array_key_exists('avatar_url', $validated)) {
            $profile->avatar_url = trim((string) ($validated['avatar_url'] ?? ''));
        }
        if (array_key_exists('cover_url', $validated)) {
            $profile->cover_url = trim((string) ($validated['cover_url'] ?? ''));
        }

        $profile->save();
        $user->load('userProfile');

        return response()->json([
            'data' => $this->transformProfile($user, (string) $validated['actor_email']),
        ]);
    }

    public function interactions(Request $request, PinPostgres $pin): JsonResponse
    {
        $email = trim((string) $request->query('user_email', ''));
        if ($email === '') {
            return response()->json([
                'message' => 'El parámetro user_email es requerido.',
            ], 422);
        }

        $user = $this->resolveUserByEmail($email, true);
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        return response()->json([
            'data' => $this->interactionPayload($pin, $user),
        ]);
    }

    public function setLike(Request $request, PinPostgres $pin): JsonResponse
    {
        $validated = $request->validate([
            'user_email' => ['required', 'email', 'max:255'],
            'liked' => ['required', 'boolean'],
        ]);

        $user = $this->resolveUserByEmail((string) $validated['user_email'], true);
        if (!$user) {
            return response()->json([
                'message' => 'No se pudo resolver el usuario.',
            ], 422);
        }

        if ((bool) $validated['liked']) {
            Like::firstOrCreate([
                'pin_id' => $pin->id,
                'user_id' => $user->id,
            ]);
        } else {
            Like::query()
                ->where('pin_id', $pin->id)
                ->where('user_id', $user->id)
                ->delete();
        }

        return response()->json([
            'data' => $this->interactionPayload($pin, $user),
        ]);
    }

    public function setSaved(Request $request, PinPostgres $pin): JsonResponse
    {
        $validated = $request->validate([
            'user_email' => ['required', 'email', 'max:255'],
            'saved' => ['required', 'boolean'],
        ]);

        $user = $this->resolveUserByEmail((string) $validated['user_email'], true);
        if (!$user) {
            return response()->json([
                'message' => 'No se pudo resolver el usuario.',
            ], 422);
        }

        if ((bool) $validated['saved']) {
            SavedPin::firstOrCreate([
                'pin_id' => $pin->id,
                'user_id' => $user->id,
            ]);
        } else {
            SavedPin::query()
                ->where('pin_id', $pin->id)
                ->where('user_id', $user->id)
                ->delete();
        }

        return response()->json([
            'data' => $this->interactionPayload($pin, $user),
        ]);
    }

    public function savedPins(Request $request): JsonResponse
    {
        $email = trim((string) $request->query('user_email', $request->query('email', '')));
        if ($email === '') {
            return response()->json([
                'message' => 'El parámetro user_email es requerido.',
            ], 422);
        }

        $user = $this->resolveUserByEmail($email, true);
        if (!$user) {
            return response()->json(['data' => []]);
        }

        $pins = PinPostgres::query()
            ->with(['user.userProfile'])
            ->withCount(['likes', 'savedPins'])
            ->whereHas('savedPins', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderByDesc('created_at')
            ->limit(200)
            ->get();

        return response()->json([
            'data' => $pins->map(fn (PinPostgres $pin) => $this->transformPin($pin))->values(),
            'meta' => [
                'count' => $pins->count(),
            ],
        ]);
    }

    public function destroy(Request $request, PinPostgres $pin): JsonResponse
    {
        $validated = $request->validate([
            'user_email' => ['required', 'email', 'max:255'],
        ]);

        $user = $this->resolveUserByEmail((string) $validated['user_email'], false);
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        if ((int) $pin->user_id !== (int) $user->id) {
            return response()->json([
                'message' => 'No tienes permisos para eliminar este pin.',
            ], 403);
        }

        try {
            $mongo = $pin->mongo();
            if ($mongo) {
                $mongo->delete();
            }
        } catch (Throwable $e) {
            // Si falla Mongo, igual eliminamos en Postgres para no bloquear la operación.
        }

        $pin->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    private function transformPin(PinPostgres $pin): array
    {
        $imageUrl = $this->normalizeImageUrlForClient((string) ($pin->image_url ?? ''));
        $createdAtMs = $pin->created_at ? $pin->created_at->getTimestampMs() : 0;
        $username = optional($pin->user?->userProfile)->username ?: ($pin->user?->email ?? 'Usuario');
        $imageUrls = $imageUrl !== '' ? [$imageUrl] : [];

        return [
            'id' => (string) $pin->id,
            'image_url' => $imageUrl,
            'image_urls' => $imageUrls,
            'title' => (string) ($pin->title ?? ''),
            'description' => (string) ($pin->description ?? ''),
            'category' => (string) ($pin->board ?? ''),
            'keywords' => $this->buildKeywords($pin),
            'like_count' => (int) ($pin->likes_count ?? 0),
            'save_count' => (int) ($pin->saved_pins_count ?? 0),
            'user_id' => (string) $pin->user_id,
            'user_name' => (string) $username,
            'user_email' => (string) ($pin->user?->email ?? ''),
            'aspect_ratio' => 1.0,
            'timestamp' => $createdAtMs,
            'created_at' => $pin->created_at?->toISOString(),
            'can_edit' => false,
        ];
    }

    private function transformProfile(User $user, string $viewerEmail = ''): array
    {
        $normalizedViewer = Str::lower(trim($viewerEmail));
        $canEdit = $normalizedViewer !== '' && $normalizedViewer === Str::lower((string) $user->email);

        return [
            'id' => (string) $user->id,
            'email' => (string) $user->email,
            'username' => (string) (optional($user->userProfile)->username ?: $user->email),
            'bio' => (string) (optional($user->userProfile)->bio ?? ''),
            'phone' => (string) (optional($user->userProfile)->phone ?? ''),
            'avatar_url' => $this->normalizeImageUrlForClient((string) (optional($user->userProfile)->avatar_url ?? '')),
            'cover_url' => $this->normalizeImageUrlForClient((string) (optional($user->userProfile)->cover_url ?? '')),
            'pins_count' => PinPostgres::query()->where('user_id', $user->id)->count(),
            'likes_count' => Like::query()->where('user_id', $user->id)->count(),
            'saved_count' => SavedPin::query()->where('user_id', $user->id)->count(),
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count(),
            'joined_at' => $user->created_at?->toISOString(),
            'can_edit' => $canEdit,
        ];
    }

    private function transformComment(Comment $comment, PinPostgres $pin, ?User $viewer): array
    {
        $comment->loadMissing(['user.userProfile', 'replies.user.userProfile', 'replies.replies.user.userProfile']);

        $username = optional($comment->user?->userProfile)->username ?: ($comment->user?->email ?? 'Usuario');
        $initialSource = $comment->user?->email ?: $username;
        $initial = Str::upper(Str::substr((string) $initialSource, 0, 1));
        $canDelete = $viewer
            ? ((int) $viewer->id === (int) $comment->user_id || (int) $viewer->id === (int) $pin->user_id)
            : false;

        return [
            'id' => (int) $comment->id,
            'content' => (string) $comment->content,
            'user_id' => (string) $comment->user_id,
            'user_name' => (string) $username,
            'user_initial' => $initial !== '' ? $initial : 'U',
            'created_at' => $comment->created_at?->diffForHumans() ?? '',
            'created_at_iso' => $comment->created_at?->toISOString(),
            'is_owner' => $viewer ? (int) $viewer->id === (int) $comment->user_id : false,
            'can_delete' => $canDelete,
            'replies' => $comment->replies
                ->map(fn (Comment $reply) => $this->transformComment($reply, $pin, $viewer))
                ->values()
                ->all(),
        ];
    }

    private function buildKeywords(PinPostgres $pin): array
    {
        $parts = [
            (string) ($pin->title ?? ''),
            (string) ($pin->description ?? ''),
            (string) ($pin->board ?? ''),
        ];

        $keywords = collect($parts)
            ->flatMap(function (string $text) {
                if ($text === '') {
                    return [];
                }

                $tokens = preg_split('/[^\pL\pN]+/u', Str::lower($text)) ?: [];
                return collect($tokens)
                    ->map(fn ($token) => trim((string) $token))
                    ->filter(fn ($token) => $token !== '')
                    ->values();
            })
            ->unique()
            ->values();

        return $keywords->all();
    }

    private function resolveUserByEmail(string $email, bool $createIfMissing): ?User
    {
        $normalizedEmail = Str::lower(trim($email));
        if ($normalizedEmail === '') {
            return null;
        }
        if (Str::length($normalizedEmail) > 255) {
            return null;
        }

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$normalizedEmail])
            ->first();

        if ($user || !$createIfMissing) {
            return $user;
        }

        $user = User::create([
            'email' => $normalizedEmail,
            'password' => Hash::make(Str::random(40)),
            'date' => now()->toDateString(),
        ]);

        UserProfile::firstOrCreate(
            ['user_id' => $user->id],
            ['username' => Str::before($normalizedEmail, '@')]
        );

        return $user;
    }

    private function storePinImageFile(UploadedFile $file): string
    {
        try {
            return (string) Cloudinary::upload($file->getRealPath(), [
                'folder' => 'pins',
            ])->getSecurePath();
        } catch (Throwable $e) {
            $uploadsPath = public_path('uploads/pins');
            if (!is_dir($uploadsPath)) {
                mkdir($uploadsPath, 0777, true);
            }

            $extension = Str::lower((string) ($file->getClientOriginalExtension() ?: 'jpg'));
            if ($extension === '') {
                $extension = 'jpg';
            }

            $filename = 'pin-' . time() . '-' . Str::uuid() . '.' . $extension;
            $file->move($uploadsPath, $filename);

            return '/uploads/pins/' . $filename;
        }
    }

    private function interactionPayload(PinPostgres $pin, User $user): array
    {
        $liked = Like::query()
            ->where('pin_id', $pin->id)
            ->where('user_id', $user->id)
            ->exists();

        $saved = SavedPin::query()
            ->where('pin_id', $pin->id)
            ->where('user_id', $user->id)
            ->exists();

        return [
            'pin_id' => (string) $pin->id,
            'liked' => $liked,
            'saved' => $saved,
            'like_count' => Like::query()->where('pin_id', $pin->id)->count(),
            'save_count' => SavedPin::query()->where('pin_id', $pin->id)->count(),
            'can_delete' => (int) $pin->user_id === (int) $user->id,
        ];
    }

    private function normalizeImageUrlForClient(string $url): string
    {
        $value = trim($url);
        if ($value === '') {
            return '';
        }

        $base = request()->getSchemeAndHttpHost();

        // Si viene ruta relativa, convertirla a absoluta con el host actual.
        if (Str::startsWith($value, '/')) {
            return rtrim($base, '/') . $value;
        }

        $parsed = parse_url($value);
        $host = strtolower((string) ($parsed['host'] ?? ''));

        // Reescribir localhost/127.0.0.1 para que funcione en emulador/dispositivo.
        if (in_array($host, ['localhost', '127.0.0.1', '10.0.2.2', '0.0.0.0'], true)) {
            $path = (string) ($parsed['path'] ?? '');
            $query = isset($parsed['query']) ? ('?' . $parsed['query']) : '';
            $fragment = isset($parsed['fragment']) ? ('#' . $parsed['fragment']) : '';

            return rtrim($base, '/') . $path . $query . $fragment;
        }

        return $value;
    }
}
