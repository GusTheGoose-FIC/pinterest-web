<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explora pines - Pinterest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('ImagenesInicio/pinterest-logo-icon.png') }}">
</head>
<body class="bg-white min-h-screen">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-9 h-9 text-red-600" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/>
                </svg>
                <div>
                    <p class="text-sm text-red-700 font-semibold">Pinterest Explore</p>
                    <p class="text-xs text-gray-500">Inspiración para todos. Descarga y descubre.</p>
                </div>
            </div>
            <div class="flex items-center gap-3 text-sm font-semibold">
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-600">Iniciar sesión</a>
                <a href="{{ route('registro') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full">Regístrate</a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-3 sm:px-4 py-6">
        <h1 class="text-xl font-bold text-gray-900 mb-4">Mira las novedades de Pinterest</h1>
        <div class="columns-2 md:columns-3 lg:columns-4 gap-4 [column-fill:_balance]"><!-- Masonry-style columns -->
            @forelse($pins as $pin)
                <div class="mb-4 break-inside-avoid rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition border border-gray-100 bg-white">
                    @if($pin->image_url)
                        <a href="{{ $pin->image_url }}" download>
                            <img src="{{ $pin->image_url }}" alt="{{ $pin->title ?? 'Pin' }}" class="w-full h-auto object-cover">
                        </a>
                    @else
                        <div class="w-full h-52 bg-gray-200 flex items-center justify-center text-gray-400">Sin imagen</div>
                    @endif
                    <div class="p-3 space-y-2">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-gray-900 text-sm leading-tight line-clamp-2">{{ $pin->title ?? 'Sin título' }}</h3>
                                <p class="text-xs text-gray-600 line-clamp-2">{{ $pin->description ?? 'Sin descripción' }}</p>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <div class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($pin->user->email ?? 'U', 0, 1)) }}
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">{{ $pin->user->profile->username ?? ($pin->user->email ?? 'Usuario') }}</div>
                        <div class="flex items-center gap-2 pt-1">
                            @if($pin->image_url)
                                <a href="{{ $pin->image_url }}" download class="flex-1 inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-semibold py-2 rounded-full transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Descargar
                                </a>
                            @endif
                            <button onclick="requireAuth()" class="flex-1 inline-flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold py-2 rounded-full transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path></svg>
                                Guardar / Like
                            </button>
                        </div>
                        <button onclick="requireAuth()" class="w-full mt-2 inline-flex items-center justify-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold py-2 rounded-full transition">
                            Más acciones (comentar, seguir...)
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500">No hay pines disponibles.</div>
            @endforelse
        </div>
    </main>

    <!-- Modal de registro requerido -->
    <div id="authModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl text-center">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Regístrate para hacer más</h3>
            <p class="text-sm text-gray-600 mb-6">Inicia sesión o crea una cuenta para guardar pines, dar like, comentar o seguir usuarios.</p>
            <div class="flex flex-col gap-3">
                <a href="{{ route('login') }}" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-full transition">Iniciar sesión</a>
                <a href="{{ route('registro') }}" class="w-full border border-gray-300 hover:bg-gray-50 text-gray-800 font-semibold py-3 rounded-full transition">Crear cuenta</a>
            </div>
            <button onclick="closeAuthModal()" class="mt-4 text-sm text-gray-500 hover:text-gray-700">Cerrar</button>
        </div>
    </div>

    <script>
        function requireAuth() {
            document.getElementById('authModal').classList.remove('hidden');
            document.getElementById('authModal').classList.add('flex');
        }
        function closeAuthModal() {
            document.getElementById('authModal').classList.add('hidden');
            document.getElementById('authModal').classList.remove('flex');
        }
        // Cerrar al hacer clic fuera
        document.getElementById('authModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeAuthModal();
        });
    </script>
</body>
</html>
