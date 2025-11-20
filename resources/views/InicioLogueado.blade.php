<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinterest Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white">

    <nav class="flex items-center justify-between px-4 py-2 border-b bg-white sticky top-0 z-10">
        <div class="flex items-center gap-2">
            <a href="/" class="text-red-600 font-bold text-2xl">P</a>
        </div>

        <div class="w-1/2">
            <input
                type="text"
                placeholder="Buscar"
                class="w-full p-2 bg-gray-100 rounded-full outline-none"
            >
        </div>

        <div class="flex items-center gap-4">
            <!-- Dropdown del usuario -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-10 h-10 bg-green-200 rounded-full flex justify-center items-center font-semibold text-gray-700 hover:bg-green-300 transition">
                    {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                </button>

               
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-200 py-2 z-50">
                    
                    <!-- Usuario actual -->
                    <div class="px-4 py-3 border-b flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-200 rounded-full flex justify-center items-center font-bold text-lg">
                            {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-sm">{{ Auth::user()->userProfile->username ?? 'Usuario' }}</p>
                            <p class="text-xs text-gray-500">Personal</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-8-8a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                        </svg>
                    </div>

                    <!-- Opciones del menú -->
                    <div class="py-2">
                        <a href="#" class="block px-4 py-3 hover:bg-gray-100 text-sm font-medium">
                            Convertir en cuenta para empresas
                        </a>
                        
                        <div class="border-t my-2"></div>
                        
                        <p class="px-4 py-2 text-xs text-gray-500 font-semibold">Tus cuentas</p>
                        
                        <a href="#" class="block px-4 py-3 hover:bg-gray-100 text-sm">
                            Añadir cuenta de Pinterest
                        </a>
                        
                        <div class="border-t my-2"></div>
                        
                        {{-- Solo mostrar enlace de admin a usuarios autorizados --}}
                        @php
                            $adminEmails = ['admin@pinterest.com', 'brandon@admin.com'];
                        @endphp
                        @if(in_array(Auth::user()->email, $adminEmails))
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 hover:bg-gray-100 text-sm font-medium text-red-600">
                             Panel de Administrador
                        </a>
                        
                        <div class="border-t my-2"></div>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-100 text-sm font-medium">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- LAYOUT GENERAL -->
    <main class="flex">

        <!-- SIDEBAR -->
        <aside class="w-14 flex flex-col gap-6 items-center py-6 border-r">
            <button>🏠</button>
            <button>🔍</button>
            
            <!-- Botón Crear con Dropdown -->
            <div x-data="{ openCreate: false }" class="relative">
                <button @click="openCreate = !openCreate" class="text-2xl hover:bg-gray-100 w-10 h-10 rounded-full flex items-center justify-center transition">
                    ➕
                </button>

                <!-- Menú desplegable -->
                <div x-show="openCreate" 
                     @click.away="openCreate = false"
                     x-transition
                     class="absolute left-14 top-0 ml-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-200 py-2 z-50">
                    
                    <h3 class="px-4 py-3 font-bold text-lg text-center">Crear</h3>
                    
                    <div class="border-t"></div>
                    
                    <!-- Opción: Crear Pin -->
                    <a href="{{ route('creacionPines') }}" class="flex items-center gap-4 px-4 py-4 hover:bg-gray-100 transition">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Pin</p>
                            <p class="text-xs text-gray-500">Publica tus fotos o videos y añade enlaces, pegatinas, efectos y más</p>
                        </div>
                    </a>

                    <!-- Opción: Crear Collage -->
                    <a href="#" class="flex items-center gap-4 px-4 py-4 hover:bg-gray-100 transition">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Collage</p>
                            <p class="text-xs text-gray-500">Combina y mezcla ideas para construir tu visión y crear algo nuevo</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <button>💬</button>
            <button>⚙️</button>
        </aside>
        
        <section class="flex-1 p-4">
            <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
                @forelse(($images ?? []) as $img)
                    <div class="mb-4 break-inside-avoid rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                        <img
                            src="{{ is_array($img) ? ($img['url'] ?? '') : ($img->url ?? '') }}"
                            alt="{{ is_array($img) ? ($img['title'] ?? 'Imagen') : ($img->title ?? 'Imagen') }}"
                            class="w-full h-auto object-cover block"
                            loading="lazy"
                        >
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-20">
                        No hay imágenes aún. Sube algunas para ver tu feed.
                    </div>
                @endforelse
            </div>
        </section>

    </main>

</body>
</html>