<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buscar Pines | Pinterest Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <header class="sticky top-0 z-20 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-3">
            <a href="{{ route('inicioLogueado') }}" class="text-red-600 font-bold text-2xl">P</a>
            <form method="GET" action="{{ route('buscar.pins') }}" class="flex-1 flex items-center gap-2">
                <input
                    type="text"
                    name="q"
                    value="{{ $searchQuery }}"
                    placeholder="Buscar por título, descripción o categoría"
                    class="w-full border border-gray-300 bg-gray-50 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                >
                <button type="submit" class="px-4 py-2 rounded-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">
                    Buscar
                </button>
            </form>
            <a href="{{ route('inicioLogueado') }}" class="hidden sm:inline text-sm font-semibold text-gray-700 hover:text-red-600">Inicio</a>
            <a href="{{ route('users.profile.show', Auth::id()) }}" class="w-10 h-10 rounded-full bg-green-200 flex items-center justify-center font-semibold text-gray-700 hover:bg-green-300 transition" title="Mi perfil">
                {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6 space-y-5">
        <section class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Explorar</p>
                    <h1 class="text-xl font-bold text-gray-900">Búsqueda de pines</h1>
                    @if($searchQuery !== '')
                        <p class="text-sm text-gray-600 mt-1">
                            Mostrando resultados para: <span class="font-semibold text-gray-900">"{{ $searchQuery }}"</span>
                        </p>
                    @else
                        <p class="text-sm text-gray-600 mt-1">Descubre pines sugeridos, de cuentas que sigues y los tuyos.</p>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                        {{ $suggestedPins->count() }} sugeridos
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                        {{ $followedPins->count() }} seguidos
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                        {{ $myPins->count() }} míos
                    </span>
                </div>
            </div>
        </section>

        <section x-data="{ activeTab: '{{ $searchQuery !== '' ? 'resultados' : 'sugeridos' }}' }" class="space-y-4">
            <div class="flex flex-wrap items-center gap-2 border-b border-gray-200 pb-2">
                <button
                    type="button"
                    @click="activeTab = 'resultados'"
                    :class="activeTab === 'resultados' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition"
                >
                    Resultados ({{ $resultPins->count() }})
                </button>
                <button
                    type="button"
                    @click="activeTab = 'sugeridos'"
                    :class="activeTab === 'sugeridos' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition"
                >
                    Sugeridos ({{ $suggestedPins->count() }})
                </button>
                <button
                    type="button"
                    @click="activeTab = 'seguidos'"
                    :class="activeTab === 'seguidos' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition"
                >
                    Seguidos ({{ $followedPins->count() }})
                </button>
                <button
                    type="button"
                    @click="activeTab = 'mios'"
                    :class="activeTab === 'mios' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition"
                >
                    Mis pines ({{ $myPins->count() }})
                </button>
            </div>

            <div x-show="activeTab === 'resultados'" x-transition.opacity>
                <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
                    @forelse($resultPins as $pin)
                        <article
                            class="mb-4 break-inside-avoid rounded-2xl overflow-hidden bg-white border border-gray-200 shadow-sm hover:shadow-md transition cursor-pointer"
                            onclick="openPinModal({{ $pin->id }})"
                        >
                            @if(!empty($pin->image_url))
                                <img src="{{ $pin->image_url }}" alt="{{ $pin->title ?? 'Pin' }}" class="w-full h-auto object-cover" loading="lazy">
                            @else
                                <div class="w-full h-56 bg-gray-200"></div>
                            @endif
                            <div class="p-3">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $pin->title ?? 'Sin título' }}</p>
                                <p class="text-xs text-gray-500 truncate">
                                    por
                                    <a href="{{ route('users.profile.show', $pin->user_id) }}" class="hover:text-red-600" onclick="event.stopPropagation()">
                                        {{ optional($pin->user?->userProfile)->username ?? ($pin->user?->email ?? 'Usuario') }}
                                    </a>
                                </p>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-gray-500">No hay resultados para esta búsqueda.</p>
                    @endforelse
                </div>
            </div>

            <div x-show="activeTab === 'sugeridos'" x-transition.opacity>
                <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
                    @forelse($suggestedPins as $pin)
                        <article
                            class="mb-4 break-inside-avoid rounded-2xl overflow-hidden bg-white border border-gray-200 shadow-sm hover:shadow-md transition cursor-pointer"
                            onclick="openPinModal({{ $pin->id }})"
                        >
                            @if(!empty($pin->image_url))
                                <img src="{{ $pin->image_url }}" alt="{{ $pin->title ?? 'Pin' }}" class="w-full h-auto object-cover" loading="lazy">
                            @else
                                <div class="w-full h-56 bg-gray-200"></div>
                            @endif
                            <div class="p-3">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $pin->title ?? 'Sin título' }}</p>
                                <p class="text-xs text-gray-500 truncate">
                                    por
                                    <a href="{{ route('users.profile.show', $pin->user_id) }}" class="hover:text-red-600" onclick="event.stopPropagation()">
                                        {{ optional($pin->user?->userProfile)->username ?? ($pin->user?->email ?? 'Usuario') }}
                                    </a>
                                </p>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-gray-500">No hay pines sugeridos por ahora.</p>
                    @endforelse
                </div>
            </div>

            <div x-show="activeTab === 'seguidos'" x-transition.opacity>
                @if($followingCount === 0)
                    <div class="rounded-2xl border border-gray-200 bg-white p-5">
                        <p class="text-sm text-gray-600">Aún no sigues cuentas. Sigue perfiles para ver sus pines aquí.</p>
                    </div>
                @else
                    <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
                        @forelse($followedPins as $pin)
                            <article
                                class="mb-4 break-inside-avoid rounded-2xl overflow-hidden bg-white border border-gray-200 shadow-sm hover:shadow-md transition cursor-pointer"
                                onclick="openPinModal({{ $pin->id }})"
                            >
                                @if(!empty($pin->image_url))
                                    <img src="{{ $pin->image_url }}" alt="{{ $pin->title ?? 'Pin' }}" class="w-full h-auto object-cover" loading="lazy">
                                @else
                                    <div class="w-full h-56 bg-gray-200"></div>
                                @endif
                                <div class="p-3">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $pin->title ?? 'Sin título' }}</p>
                                    <p class="text-xs text-gray-500 truncate">
                                        por
                                        <a href="{{ route('users.profile.show', $pin->user_id) }}" class="hover:text-red-600" onclick="event.stopPropagation()">
                                            {{ optional($pin->user?->userProfile)->username ?? ($pin->user?->email ?? 'Usuario') }}
                                        </a>
                                    </p>
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-gray-500">No hay pines de cuentas seguidas para esta búsqueda.</p>
                        @endforelse
                    </div>
                @endif
            </div>

            <div x-show="activeTab === 'mios'" x-transition.opacity>
                <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
                    @forelse($myPins as $pin)
                        <article
                            class="mb-4 break-inside-avoid rounded-2xl overflow-hidden bg-white border border-gray-200 shadow-sm hover:shadow-md transition cursor-pointer"
                            onclick="openPinModal({{ $pin->id }})"
                        >
                            @if(!empty($pin->image_url))
                                <img src="{{ $pin->image_url }}" alt="{{ $pin->title ?? 'Pin' }}" class="w-full h-auto object-cover" loading="lazy">
                            @else
                                <div class="w-full h-56 bg-gray-200"></div>
                            @endif
                            <div class="p-3">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $pin->title ?? 'Sin título' }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $pin->created_at?->diffForHumans() }}</p>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-gray-500">Aún no tienes pines para mostrar.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    @include('components.pin-modal')
</body>
</html>
