<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Perfil | Pinterest Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ auth()->check() ? route('inicioLogueado') : route('inicio') }}" class="text-red-600 font-bold text-2xl">P</a>
            @if(auth()->check())
                <a href="{{ route('users.profile.show', auth()->id()) }}" class="text-sm font-semibold text-gray-700 hover:text-red-600">
                    Mi perfil
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-red-600">
                    Iniciar sesión
                </a>
            @endif
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-6 space-y-6">
        @php
            $profileData = optional($profileUser->userProfile);
            $avatarUrl = $displayAvatarUrl ?? ($profileData->avatar_url ?? '');
            $coverUrl = $displayCoverUrl ?? ($profileData->cover_url ?? '');
        @endphp
        <section class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="h-44 bg-gray-200 relative z-0">
                @if(!empty($coverUrl))
                    <img src="{{ $coverUrl }}" alt="Fondo del perfil" class="absolute inset-0 w-full h-full object-cover z-0">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-red-200 via-amber-200 to-blue-200"></div>
                @endif
            </div>

            <div class="relative z-10 px-6 pb-6">
                <div class="-mt-10 flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                    <div class="flex items-start gap-4">
                        <div class="relative z-20 w-20 h-20 rounded-full bg-white p-1 shadow-md border border-gray-200">
                            @if(!empty($avatarUrl))
                                <img src="{{ $avatarUrl }}" alt="Foto de perfil" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full rounded-full bg-red-100 text-red-700 flex items-center justify-center text-2xl font-bold">
                                    {{ strtoupper(substr($profileUser->email ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="pt-10 md:pt-8">
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $profileData->username ?? $profileUser->email }}
                            </h1>
                            <p class="text-sm text-gray-500">{{ $profileUser->email }}</p>
                            @if(!empty($profileData->phone))
                                <p class="text-xs text-gray-500 mt-1">Tel: {{ $profileData->phone }}</p>
                            @endif
                            <p class="text-sm text-gray-700 mt-2">
                                {{ $profileData->bio ?? 'Sin bio por ahora.' }}
                            </p>
                            <div class="grid grid-cols-3 gap-3 mt-4 max-w-md">
                                <div class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-center">
                                    <p class="text-lg font-bold text-gray-900">{{ $pinsCount ?? $pins->count() }}</p>
                                    <p class="text-[11px] text-gray-500">Pins</p>
                                </div>
                                <div class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-center">
                                    <p class="text-lg font-bold text-gray-900">{{ $savedCount ?? 0 }}</p>
                                    <p class="text-[11px] text-gray-500">Guardados</p>
                                </div>
                                <div class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-center">
                                    <p class="text-lg font-bold text-gray-900">{{ $likesCount ?? 0 }}</p>
                                    <p class="text-[11px] text-gray-500">Me gusta</p>
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 mt-3 flex items-center gap-4">
                                <span>{{ $followersCount }} seguidores</span>
                                <span>{{ $followingCount }} seguidos</span>
                            </div>
                        </div>
                    </div>

                    @if($isOwner)
                        <div class="w-full md:w-[380px] pt-4 md:pt-6">
                            <h2 class="text-sm font-semibold text-gray-700 mb-3">Editar mi perfil</h2>
                            @if(session('status'))
                                <p class="mb-3 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl px-3 py-2">
                                    {{ session('status') }}
                                </p>
                            @endif
                            <form method="POST" action="{{ route('users.profile.update', $profileUser) }}" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="username" class="text-xs text-gray-600 font-semibold">Usuario</label>
                                    <input
                                        id="username"
                                        name="username"
                                        type="text"
                                        value="{{ old('username', $profileData->username ?? $profileUser->email) }}"
                                        class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                    >
                                    @error('username')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="bio" class="text-xs text-gray-600 font-semibold">Bio</label>
                                    <textarea
                                        id="bio"
                                        name="bio"
                                        rows="3"
                                        class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                    >{{ old('bio', $profileData->bio ?? '') }}</textarea>
                                    @error('bio')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="phone" class="text-xs text-gray-600 font-semibold">Teléfono</label>
                                    <input
                                        id="phone"
                                        name="phone"
                                        type="text"
                                        value="{{ old('phone', $profileData->phone ?? '') }}"
                                        class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                    >
                                    @error('phone')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="avatar_image" class="text-xs text-gray-600 font-semibold">Subir foto de perfil</label>
                                    <input
                                        id="avatar_image"
                                        name="avatar_image"
                                        type="file"
                                        accept="image/*"
                                        class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm file:mr-3 file:px-3 file:py-1.5 file:border-0 file:bg-gray-100 file:rounded-lg file:text-xs"
                                    >
                                    @error('avatar_image')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="avatar_url" class="text-xs text-gray-600 font-semibold">URL foto de perfil</label>
                                    <input
                                        id="avatar_url"
                                        name="avatar_url"
                                        type="text"
                                        value="{{ old('avatar_url', $profileData->avatar_url ?? '') }}"
                                        class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                    >
                                    @error('avatar_url')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="cover_image" class="text-xs text-gray-600 font-semibold">Subir fondo del perfil</label>
                                    <input
                                        id="cover_image"
                                        name="cover_image"
                                        type="file"
                                        accept="image/*"
                                        class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm file:mr-3 file:px-3 file:py-1.5 file:border-0 file:bg-gray-100 file:rounded-lg file:text-xs"
                                    >
                                    @error('cover_image')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="cover_url" class="text-xs text-gray-600 font-semibold">URL fondo del perfil</label>
                                    <input
                                        id="cover_url"
                                        name="cover_url"
                                        type="text"
                                        value="{{ old('cover_url', $profileData->cover_url ?? '') }}"
                                        class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                    >
                                    @error('cover_url')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button
                                    type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-full py-2.5 transition"
                                >
                                    Guardar cambios
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Pines publicados</h2>
            <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
                @forelse($pins as $pin)
                    <div
                        class="mb-4 break-inside-avoid rounded-2xl overflow-hidden bg-white border border-gray-200 shadow-sm hover:shadow-md transition cursor-pointer"
                        onclick="openPinModal({{ $pin->id }})"
                    >
                        <img
                            src="{{ $pin->image_url }}"
                            alt="{{ $pin->title ?? 'Pin' }}"
                            class="w-full h-auto object-cover"
                            loading="lazy"
                        >
                        <div class="p-3">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $pin->title ?? 'Sin título' }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $pin->created_at?->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Este perfil aún no tiene pines.</p>
                @endforelse
            </div>
        </section>
    </main>

    @include('components.pin-modal')
</body>
</html>
