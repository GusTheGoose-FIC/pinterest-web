<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                            $adminEmails = ['admin@pinterest.com', 'brandon@admin.com', 'paniagua@gmail.com'];
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
    <main class="flex" x-data="notificationsData()" x-ref="mainPanel">

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
            
            <button @click="setMessagesTab()">💬</button>
            <button>⚙️</button>
        </aside>

        <section class="flex-1 p-4">
            <!-- Pestañas -->
            <div class="flex gap-6 mb-6 border-b">
                <button 
                    @click="activeTab = 'todos'"
                    :class="activeTab === 'todos' ? 'border-b-2 border-red-600 text-gray-900' : 'text-gray-500 hover:text-gray-900'"
                    class="pb-3 font-semibold transition"
                >
                    Todos los pins
                </button>
                <button 
                    @click="activeTab = 'mios'"
                    :class="activeTab === 'mios' ? 'border-b-2 border-red-600 text-gray-900' : 'text-gray-500 hover:text-gray-900'"
                    class="pb-3 font-semibold transition"
                >
                    Mis pins
                </button>
                <button 
                    @click="activeTab = 'estadisticas'; loadStats()"
                    :class="activeTab === 'estadisticas' ? 'border-b-2 border-red-600 text-gray-900' : 'text-gray-500 hover:text-gray-900'"
                    class="pb-3 font-semibold transition"
                >
                    Estadísticas
                </button>
                <button 
                    @click="activeTab = 'mensajes'; loadFollowers()"
                    :class="activeTab === 'mensajes' ? 'border-b-2 border-red-600 text-gray-900' : 'text-gray-500 hover:text-gray-900'"
                    class="pb-3 font-semibold transition"
                >
                    Mensajes
                </button>
                <button 
                    @click="activeTab = 'notificaciones'; loadNotifications()"
                    :class="activeTab === 'notificaciones' ? 'border-b-2 border-red-600 text-gray-900' : 'text-gray-500 hover:text-gray-900'"
                    class="pb-3 font-semibold transition relative"
                >
                    Notificaciones
                    <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute -top-2 -right-3 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center"></span>
                </button>
            </div>

            <!-- Tab: Todos los pins -->
            <div x-show="activeTab === 'todos'" class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
                @forelse(($images ?? []) as $img)
                    <div class="mb-4 break-inside-avoid rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition cursor-pointer group"
                         onclick="openPinModal({{ is_array($img) ? ($img['id'] ?? '') : ($img->id ?? '') }})">
                        <img
                            src="{{ is_array($img) ? ($img['url'] ?? '') : ($img->image_url ?? '') }}"
                            alt="{{ is_array($img) ? ($img['title'] ?? 'Imagen') : ($img->title ?? 'Imagen') }}"
                            class="w-full h-auto object-cover block group-hover:brightness-90 transition"
                            loading="lazy"
                        >
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-20">
                        No hay imágenes aún. Sube algunas para ver tu feed.
                    </div>
                @endforelse
            </div>

            <!-- Tab: Mis pins -->
            <div x-show="activeTab === 'mios'" class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
                @forelse(($userPins ?? []) as $pin)
                    <div class="mb-4 break-inside-avoid rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition group relative">
                        <div class="cursor-pointer" onclick="openPinModal({{ $pin['id'] ?? '' }})">
                            <img
                                src="{{ $pin['image_url'] ?? '' }}"
                                alt="{{ $pin['title'] ?? 'Imagen' }}"
                                class="w-full h-auto object-cover block group-hover:brightness-90 transition"
                                loading="lazy"
                            >
                        </div>
                        
                        <!-- Overlay con acciones -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100">
                            <button 
                                onclick="editPin({{ $pin['id'] }})"
                                class="bg-white hover:bg-gray-100 text-gray-900 rounded-full p-3 transition shadow-lg"
                                title="Editar pin"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button 
                                onclick="deletePin({{ $pin['id'] }}, '{{ $pin['title'] ?? 'Pin' }}')"
                                class="bg-red-600 hover:bg-red-700 text-white rounded-full p-3 transition shadow-lg"
                                title="Eliminar pin"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Info del pin -->
                        <div class="p-3 bg-white">
                            <h3 class="font-semibold text-sm truncate">{{ $pin['title'] ?? 'Sin título' }}</h3>
                            <p class="text-xs text-gray-500 truncate">{{ $pin['created_at'] ?? 'hace poco' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-20">
                        <p class="mb-4">No tienes pins aún.</p>
                        <a href="{{ route('creacionPines') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-full transition">
                            Crear pin
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Tab: Estadísticas -->
            <div x-show="activeTab === 'estadisticas'" class="space-y-4">
                <div x-show="loadingStats" class="text-center py-10">
                    <p class="text-gray-500">Cargando estadísticas...</p>
                </div>

                <template x-if="!loadingStats && pinStats.length > 0">
                    <div>
                        <!-- Resumen total -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="bg-white p-4 rounded-xl shadow border-l-4 border-blue-500">
                                <p class="text-gray-600 text-sm">Total de Pines</p>
                                <p class="text-3xl font-bold text-blue-600" x-text="totalStats.total_pins"></p>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow border-l-4 border-red-500">
                                <p class="text-gray-600 text-sm">Total de Likes</p>
                                <p class="text-3xl font-bold text-red-600" x-text="totalStats.total_likes"></p>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow border-l-4 border-green-500">
                                <p class="text-gray-600 text-sm">Total de Comentarios</p>
                                <p class="text-3xl font-bold text-green-600" x-text="totalStats.total_comments"></p>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow border-l-4 border-orange-500">
                                <p class="text-gray-600 text-sm">Total de Reportes</p>
                                <p class="text-3xl font-bold text-orange-600" x-text="totalStats.total_reports"></p>
                            </div>
                        </div>

                        <!-- Tabla de estadísticas por pin -->
                        <div class="bg-white rounded-xl shadow overflow-hidden">
                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h3 class="font-semibold text-gray-900">Estadísticas de Cada Pin</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 border-b">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Pin</th>
                                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Likes</th>
                                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Comentarios</th>
                                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Reportes</th>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        <template x-for="pin in pinStats" :key="pin.id">
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <img x-show="pin.image_url" :src="pin.image_url" :alt="pin.title" class="w-12 h-12 rounded-lg object-cover">
                                                        <div class="min-w-0">
                                                            <p class="font-semibold text-gray-900 truncate" x-text="pin.title"></p>
                                                            <p class="text-xs text-gray-500 truncate" x-text="pin.description"></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                                        ❤️ <span x-text="pin.likes_count"></span>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                                        💬 <span x-text="pin.comments_count"></span>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span :class="pin.reports_count > 0 ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700'" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold">
                                                        🚩 <span x-text="pin.reports_count"></span>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600" x-text="getTimeAgo(pin.created_at)"></td>
                                                <td class="px-6 py-4 text-center">
                                                    <button @click="openPinModal(pin.id)" class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-full transition">
                                                        Ver
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="!loadingStats && pinStats.length === 0">
                    <div class="text-center py-20 bg-white rounded-xl">
                        <p class="text-gray-600 mb-4">No tienes pins aún.</p>
                        <a href="{{ route('creacionPines') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-full transition">
                            Crear primer pin
                        </a>
                    </div>
                </template>
            </div>

            <!-- Tab: Mensajes -->
            <div x-show="activeTab === 'mensajes'" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-1 bg-white border rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-900">Seguidores</h3>
                        <button @click="loadFollowers()" class="text-xs text-blue-600 hover:text-blue-700">Actualizar</button>
                    </div>
                    <div x-show="loadingFollowers" class="text-sm text-gray-500">Cargando seguidores...</div>
                    <template x-if="!loadingFollowers && followers.length === 0">
                        <p class="text-sm text-gray-500">Aún no tienes seguidores.</p>
                    </template>
                    <div class="space-y-2 max-h-[60vh] overflow-y-auto">
                        <template x-for="f in followers" :key="f.id">
                            <div 
                                :class="selectedUser && selectedUser.id === f.id ? 'border-red-500 bg-red-50' : 'border-transparent'"
                                class="w-full flex items-center gap-3 p-2 rounded-xl border hover:bg-gray-50 text-left">
                                <div class="w-10 h-10 rounded-full bg-red-200 flex items-center justify-center font-bold text-sm text-red-700">
                                    <span x-text="f.initial"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm text-gray-900 truncate" x-text="f.username"></p>
                                    <p class="text-xs" :class="f.is_mutual ? 'text-green-600' : 'text-gray-500'" x-text="f.is_mutual ? 'Seguidor mutuo' : 'Te sigue' "></p>
                                </div>
                                <div class="flex flex-col gap-1 items-end">
                                    <button @click.stop="selectFollower(f)" class="text-xs text-blue-600 hover:text-blue-700">Abrir</button>
                                    <template x-if="!f.is_mutual">
                                        <button @click.stop="followUser(f)" class="text-xs text-red-600 hover:text-red-700 font-semibold">Seguir de vuelta</button>
                                    </template>
                                    <template x-if="f.is_mutual">
                                        <span class="text-[11px] text-green-600">Mutuos</span>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="md:col-span-2 bg-white border rounded-2xl p-4 shadow-sm flex flex-col min-h-[60vh]">
                    <template x-if="!selectedUser">
                        <div class="flex-1 flex items-center justify-center text-gray-500 text-sm">Selecciona un seguidor para chatear.</div>
                    </template>

                    <template x-if="selectedUser">
                        <div class="flex-1 flex flex-col">
                            <div class="border-b pb-3 mb-3 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-red-200 flex items-center justify-center font-bold text-sm text-red-700">
                                        <span x-text="selectedUser.initial"></span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900" x-text="selectedUser.username"></p>
                                        <p class="text-xs text-gray-500" x-text="selectedUser.is_mutual ? 'Seguidor mutuo' : 'Solo te sigue'"></p>
                                    </div>
                                </div>
                                <button @click="loadConversation(selectedUser.id)" class="text-xs text-blue-600 hover:text-blue-700">Actualizar chat</button>
                            </div>

                            <div class="flex-1 space-y-3 overflow-y-auto pr-1" id="messagesContainer">
                                <div x-show="loadingMessages" class="text-sm text-gray-500">Cargando mensajes...</div>
                                <template x-if="!loadingMessages && messages.length === 0">
                                    <p class="text-sm text-gray-500">Sin mensajes aún. ¡Envía el primero!</p>
                                </template>
                                <template x-for="msg in messages" :key="msg.id">
                                    <div class="flex" :class="msg.sender_id === currentUserId ? 'justify-end' : 'justify-start'">
                                        <div :class="msg.sender_id === currentUserId ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800'" class="px-4 py-2 rounded-2xl max-w-[70%] text-sm">
                                            <p x-text="msg.content"></p>
                                            <p class="text-[11px] mt-1 opacity-80" x-text="formatTime(msg.created_at)"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="pt-3 mt-3 border-t">
                                <template x-if="selectedUser && !selectedUser.is_mutual">
                                    <p class="text-xs text-red-600">Solo puedes chatear con seguidores mutuos.</p>
                                </template>
                                <div class="flex gap-2" x-show="selectedUser && selectedUser.is_mutual">
                                    <input type="text" x-model="messageInput" @keyup.enter="sendMessage()" placeholder="Escribe un mensaje" class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <button @click="sendMessage()" :disabled="sendingMessage" class="bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-4 py-2 rounded-full text-sm font-semibold transition">
                                        Enviar
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-2" x-text="messageError" x-show="messageError"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Tab: Notificaciones -->
            <div x-show="activeTab === 'notificaciones'" class="space-y-3">
                <div x-show="loadingNotifications" class="text-center py-10">
                    <p class="text-gray-500">Cargando notificaciones...</p>
                </div>

                <template x-if="!loadingNotifications && notifications.length > 0">
                    <div class="max-w-2xl">
                        <div class="mb-4 flex gap-2">
                            <button 
                                @click="markAllAsRead()"
                                class="text-sm text-blue-600 hover:text-blue-700 font-semibold"
                            >
                                Marcar todas como leídas
                            </button>
                        </div>

                        <template x-for="notification in notifications" :key="notification.id">
                            <div 
                                :class="notification.read ? 'bg-gray-50' : 'bg-blue-50'"
                                class="p-4 rounded-2xl border border-gray-200 flex items-start gap-4 hover:shadow-md transition"
                            >
                                <!-- Avatar del usuario -->
                                <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-pink-400 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-white text-sm">
                                    <span x-text="notification.actor.userProfile?.username?.charAt(0).toUpperCase() || 'U'"></span>
                                </div>

                                <!-- Contenido de la notificación -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">
                                        <span x-text="notification.actor.userProfile?.username || 'Usuario'"></span>
                                        <span x-show="notification.type === 'like'"> le dio like a tu pin</span>
                                        <span x-show="notification.type === 'comment'"> comentó en tu pin</span>
                                        <span x-show="notification.type === 'reply'"> respondió a un comentario</span>
                                        <span x-show="notification.type === 'follow'"> empezó a seguirte</span>
                                        <span x-show="notification.type === 'message'"> te envió un mensaje</span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1" x-text="getTimeAgo(notification.created_at)"></p>
                                    <p class="text-sm text-gray-700 mt-2 truncate" x-text="notification.message"></p>
                                    <template x-if="notification.pin">
                                        <p class="text-xs text-gray-500 truncate">Pin: <span x-text="notification.pin.title"></span></p>
                                    </template>
                                </div>

                                <!-- Acciones -->
                                <div class="flex gap-2 flex-shrink-0">
                                    <template x-if="notification.pin_id">
                                        <button 
                                            @click="openPinModal(notification.pin_id)"
                                            class="px-3 py-1 bg-white hover:bg-gray-100 rounded-full text-sm font-medium transition border border-gray-200"
                                        >
                                            Ver
                                        </button>
                                    </template>
                                    <template x-if="notification.type === 'message'">
                                        <button 
                                            @click="setMessagesTab(); selectFollower({id: notification.actor.id, username: notification.actor.userProfile?.username || 'Usuario', initial: (notification.actor.userProfile?.username || 'U').charAt(0).toUpperCase(), is_mutual: true});"
                                            class="px-3 py-1 bg-white hover:bg-gray-100 rounded-full text-sm font-medium transition border border-gray-200"
                                        >
                                            Abrir chat
                                        </button>
                                    </template>
                                    <button 
                                        @click="deleteNotification(notification.id)"
                                        class="px-3 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded-full text-sm font-medium transition border border-red-200"
                                    >
                                        ✕
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="!loadingNotifications && notifications.length === 0">
                    <div class="text-center text-gray-500 py-20">
                        <p class="mb-4">No tienes notificaciones aún.</p>
                        <p class="text-sm">Aquí verás cuando alguien dé like o comente en tus pins</p>
                    </div>
                </template>
            </div>
        </section>

    </main>

    @include('components.pin-modal')

    <script>
        // Función para obtener tiempo relativo
        function getTimeAgo(date) {
            const createdAt = new Date(date);
            const now = new Date();
            const secondsAgo = Math.floor((now - createdAt) / 1000);

            if (secondsAgo < 60) {
                return 'hace unos segundos';
            } else if (secondsAgo < 3600) {
                const minutes = Math.floor(secondsAgo / 60);
                return 'hace ' + minutes + ' minuto' + (minutes > 1 ? 's' : '');
            } else if (secondsAgo < 86400) {
                const hours = Math.floor(secondsAgo / 3600);
                return 'hace ' + hours + ' hora' + (hours > 1 ? 's' : '');
            } else {
                const days = Math.floor(secondsAgo / 86400);
                return 'hace ' + days + ' día' + (days > 1 ? 's' : '');
            }
        }

        // Componente Alpine para notificaciones
        function notificationsData() {
            return {
                activeTab: 'todos',
                notifications: [],
                unreadCount: 0,
                loadingNotifications: false,
                followers: [],
                loadingFollowers: false,
                selectedUser: null,
                messages: [],
                loadingMessages: false,
                sendingMessage: false,
                messageInput: '',
                messageError: '',
                currentUserId: {{ Auth::id() }},

                async loadNotifications() {
                    this.loadingNotifications = true;
                    try {
                        const response = await fetch('/notifications');
                        const data = await response.json();
                        if (data.success) {
                            this.notifications = data.notifications;
                            this.unreadCount = data.unread_count;
                        }
                    } catch (error) {
                        console.error('Error loading notifications:', error);
                    } finally {
                        this.loadingNotifications = false;
                    }
                },

                async deleteNotification(notificationId) {
                    try {
                        const response = await fetch('/notifications/' + notificationId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.loadNotifications();
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                },

                async markAllAsRead() {
                    try {
                        const response = await fetch('/notifications/mark-all-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.loadNotifications();
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                },

                async loadFollowers() {
                    this.loadingFollowers = true;
                    try {
                        const response = await fetch('/followers');
                        const data = await response.json();
                        if (data.success) {
                            this.followers = data.followers;
                            if (!this.selectedUser && this.followers.length) {
                                const mutual = this.followers.find(f => f.is_mutual);
                                this.selectFollower(mutual || this.followers[0]);
                            }
                        }
                    } catch (error) {
                        console.error('Error al cargar seguidores:', error);
                    } finally {
                        this.loadingFollowers = false;
                    }
                },

                selectFollower(follower) {
                    this.selectedUser = follower;
                    this.messages = [];
                    this.messageInput = '';
                    this.messageError = '';
                    if (follower && follower.is_mutual) {
                        this.loadConversation(follower.id);
                    }
                },

                async followUser(follower) {
                    if (!follower || follower.is_mutual) return;
                    try {
                        const response = await fetch('/users/' + follower.id + '/follow', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            follower.is_mutual = true;
                            // Actualizar selección si es el mismo usuario
                            if (this.selectedUser && this.selectedUser.id === follower.id) {
                                this.selectedUser.is_mutual = true;
                                this.loadConversation(follower.id);
                            }
                        } else {
                            this.messageError = data.message || 'No se pudo seguir al usuario';
                        }
                    } catch (error) {
                        console.error('Error al seguir:', error);
                        this.messageError = 'No se pudo seguir al usuario';
                    }
                },

                async loadConversation(userId) {
                    if (!userId) return;
                    this.loadingMessages = true;
                    this.messageError = '';
                    try {
                        const response = await fetch('/messages/' + userId);
                        const data = await response.json();
                        if (data.success) {
                            this.messages = data.messages;
                            this.$nextTick(() => {
                                const container = document.getElementById('messagesContainer');
                                if (container) container.scrollTop = container.scrollHeight;
                            });
                        } else {
                            this.messageError = data.message || 'No se pudo cargar la conversación';
                        }
                    } catch (error) {
                        console.error('Error cargando mensajes:', error);
                        this.messageError = 'No se pudo cargar la conversación';
                    } finally {
                        this.loadingMessages = false;
                    }
                },

                async sendMessage() {
                    if (!this.selectedUser || !this.selectedUser.is_mutual) {
                        this.messageError = 'Solo puedes chatear con seguidores mutuos.';
                        return;
                    }
                    const text = (this.messageInput || '').trim();
                    if (!text) return;
                    this.sendingMessage = true;
                    this.messageError = '';
                    try {
                        const response = await fetch('/messages/' + this.selectedUser.id, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ content: text })
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.messageInput = '';
                            this.loadConversation(this.selectedUser.id);
                        } else {
                            this.messageError = data.message || 'No se pudo enviar el mensaje';
                        }
                    } catch (error) {
                        console.error('Error enviando mensaje:', error);
                        this.messageError = 'No se pudo enviar el mensaje';
                    } finally {
                        this.sendingMessage = false;
                    }
                },

                setMessagesTab() {
                    this.activeTab = 'mensajes';
                    this.loadFollowers();
                },

                // Estadísticas de Pines
                pinStats: [],
                totalStats: {
                    total_pins: 0,
                    total_likes: 0,
                    total_comments: 0,
                    total_reports: 0
                },
                loadingStats: false,
                statsError: '',

                async loadStats() {
                    this.loadingStats = true;
                    this.statsError = '';
                    try {
                        const response = await fetch('/pin-stats');
                        if (response.status === 401) {
                            window.location.href = '/login';
                            return;
                        }
                        const data = await response.json();
                        if (data.success) {
                            this.pinStats = data.pins;
                            this.totalStats = data.total_stats;
                        } else {
                            this.statsError = data.message || 'No se pudieron cargar las estadísticas';
                        }
                    } catch (error) {
                        console.error('Error cargando estadísticas:', error);
                        this.statsError = 'Error al cargar las estadísticas';
                    } finally {
                        this.loadingStats = false;
                    }
                },

                formatTime(dateStr) {
                    const d = new Date(dateStr);
                    return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                },

                init() {
                    // Cargar notificaciones cuando se inicia el componente
                    this.loadNotifications();
                    this.loadFollowers();
                    // Recargar cada 30 segundos
                    setInterval(() => {
                        if (this.activeTab === 'notificaciones') {
                            this.loadNotifications();
                        } else if (this.activeTab === 'mensajes' && this.selectedUser) {
                            this.loadConversation(this.selectedUser.id);
                        } else if (this.activeTab === 'estadisticas') {
                            this.loadStats();
                        }
                    }, 30000);
                }
            }
        }

        function editPin(pinId) {
            window.location.href = '/pins/' + pinId + '/edit';
        }

        function deletePin(pinId, pinTitle) {
            if (confirm('¿Estás seguro de que deseas eliminar el pin "' + pinTitle + '"?')) {
                fetch('/pins/' + pinId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Pin eliminado correctamente');
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'No se pudo eliminar el pin'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el pin');
                });
            }
        }
    </script>

</body>
</html>