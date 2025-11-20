<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Panel de Administrador</title>
</head>
<body class="bg-gray-100">

<div class="max-w-7xl mx-auto py-10">
    <!-- Mensajes de estado -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header con navegación -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Panel de Administrador</h1>
            <p class="text-gray-600 mt-2">Gestiona usuarios y contenido de la plataforma</p>
        </div>
        
        <div class="flex gap-4">
            <a href="{{ route('inicio') }}" 
               class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Inicio
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" 
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    {{-- USUARIOS --}}
    <div class="bg-white p-6 rounded-xl shadow mb-10">
        <h2 class="text-2xl font-semibold mb-4">Usuarios Registrados</h2>
        <p class="text-gray-600 mb-4">Total: {{ $users->count() }} usuarios</p>

        @if($users->count() > 0)
        <table class="w-full border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Username</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Fecha Registro</th>
                    <th class="p-3 text-left">Bio</th>
                    <th class="p-3 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 font-medium">{{ $user->id }}</td>
                    <td class="p-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($user->email, 0, 1)) }}
                            </div>
                            {{ $user->profile->username ?? 'Sin username' }}
                        </div>
                    </td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3 text-sm text-gray-600">
                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                    </td>
                    <td class="p-3 max-w-xs">
                        <p class="text-sm text-gray-600 truncate">
                            {{ $user->profile->bio ?? 'Sin biografía' }}
                        </p>
                    </td>
                    <td class="p-3 text-center">
                        <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" 
                              onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-8 text-gray-500">
            <p class="text-lg">No hay usuarios registrados aún.</p>
        </div>
        @endif
    </div>

    {{-- PINES --}}
    <div class="bg-white p-6 rounded-xl shadow mb-10">
        <h2 class="text-2xl font-semibold mb-4">Pines Publicados</h2>
        <p class="text-gray-600 mb-4">Total: {{ $pins->count() }} pines</p>

        @if($pins->count() > 0)
        <table class="w-full border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Imagen</th>
                    <th class="p-3 text-left">Título</th>
                    <th class="p-3 text-left">Descripción</th>
                    <th class="p-3 text-left">Usuario</th>
                    <th class="p-3 text-left">Fecha</th>
                    <th class="p-3 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pins as $pin)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 font-medium">{{ $pin->id }}</td>
                    <td class="p-3">
                        @if($pin->image_url)
                            <img src="{{ $pin->image_url }}" alt="{{ $pin->title }}" 
                                 class="w-16 h-16 object-cover rounded-lg shadow-sm">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400 text-xs">Sin imagen</span>
                            </div>
                        @endif
                    </td>
                    <td class="p-3 max-w-xs">
                        <p class="font-medium truncate">{{ $pin->title ?? 'Sin título' }}</p>
                    </td>
                    <td class="p-3 max-w-xs">
                        <p class="text-sm text-gray-600 truncate">{{ $pin->description ?? 'Sin descripción' }}</p>
                    </td>
                    <td class="p-3">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($pin->user->email, 0, 1)) }}
                            </div>
                            <span class="text-sm">
                                {{ $pin->user->profile->username ?? substr($pin->user->email, 0, strpos($pin->user->email, '@')) }}
                            </span>
                        </div>
                    </td>
                    <td class="p-3 text-sm text-gray-600">
                        {{ $pin->created_at ? $pin->created_at->format('d/m/Y H:i') : 'N/A' }}
                    </td>
                    <td class="p-3 text-center">
                        <div class="flex gap-2 justify-center">
                            @if($pin->image_url)
                            <a href="{{ $pin->image_url }}" target="_blank" 
                               class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600 transition">
                                Ver
                            </a>
                            @endif
                            <form action="{{ route('admin.deletePin', $pin->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Estás seguro de eliminar este pin?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-8 text-gray-500">
            <p class="text-lg">No hay pines publicados aún.</p>
            <p class="text-sm mt-2">Los pines aparecerán aquí cuando los usuarios comiencen a publicar contenido.</p>
        </div>
        @endif
    </div>

    {{-- ESTADÍSTICAS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $users->count() }}</div>
            <div class="text-gray-600 mt-1">Usuarios Totales</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-green-600">{{ $pins->count() }}</div>
            <div class="text-gray-600 mt-1">Pines Publicados</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-purple-600">
                {{ $pins->count() > 0 ? number_format($pins->count() / max($users->count(), 1), 1) : '0' }}
            </div>
            <div class="text-gray-600 mt-1">Pines por Usuario</div>
        </div>
    </div>

</div>

</body>
</html>
