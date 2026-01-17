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
                        <div class="flex gap-2 justify-center">
                            <button onclick="openResetPasswordModal({{ $user->id }}, '{{ $user->email }}')" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition text-sm">
                                Cambiar Contraseña
                            </button>
                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
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

    {{-- REPORTES DE PINES --}}
    <div class="bg-white p-6 rounded-xl shadow mb-10">
        <h2 class="text-2xl font-semibold mb-4">Reportes de Pines</h2>
        <p class="text-gray-600 mb-4">Total: {{ $pinReports->count() }} reportes</p>

        @if($reportsByPin && count($reportsByPin) > 0)
        <div class="space-y-4">
            @foreach($reportsByPin as $pinId => $data)
            <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                <div class="flex items-start gap-4">
                    <!-- Imagen del pin -->
                    <div class="flex-shrink-0">
                        @if($data['pin'] && $data['pin']->image_url)
                            <img src="{{ $data['pin']->image_url }}" alt="{{ $data['pin']->title }}" 
                                 class="w-20 h-20 object-cover rounded-lg shadow-sm">
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400 text-xs">Sin imagen</span>
                            </div>
                        @endif
                    </div>

                    <!-- Información del pin -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                @if($data['pin'])
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $data['pin']->title ?? 'Sin título' }}</h3>
                                    <p class="text-sm text-gray-600">{{ $data['pin']->description ?? 'Sin descripción' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Usuario: <span class="font-medium">{{ $data['pin']->user->profile->username ?? $data['pin']->user->email }}</span>
                                    </p>
                                @else
                                    <p class="text-gray-600">Pin eliminado</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-red-600 mb-1">{{ $data['total'] }}</div>
                                <span class="text-xs text-gray-500">reportes totales</span>
                            </div>
                        </div>

                        <!-- Desglose por tipo -->
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs font-semibold text-gray-700 mb-2">Desglose por tipo:</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                                @forelse($data['by_type'] as $reason => $count)
                                    <div class="bg-white p-2 rounded border border-gray-200">
                                        <p class="text-xs font-medium text-gray-700 truncate" title="{{ $reason }}">{{ substr($reason, 0, 20) }}</p>
                                        <p class="text-sm font-bold text-gray-900">{{ $count }}</p>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-500">Sin desglose disponible</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="mt-3 flex gap-2">
                            @if($data['pin'])
                                <a href="{{ $data['pin']->image_url }}" target="_blank" 
                                   class="text-xs bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                    Ver Pin
                                </a>
                                <form action="{{ route('admin.deletePin', $data['pin']->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este pin reportado?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                        Eliminar Pin
                                    </button>
                                </form>
                            @endif
                            <button onclick="toggleReportDetails({{ $pinId }})" class="text-xs bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
                                Ver Reportes
                            </button>
                        </div>

                        <!-- Detalles de reportes (ocultos por defecto) -->
                        <div id="reports-{{ $pinId }}" class="hidden mt-3 pl-3 border-l-2 border-red-300 space-y-2 max-h-64 overflow-y-auto">
                            @foreach($data['reports'] as $report)
                                <div class="bg-red-50 p-2 rounded text-xs">
                                    <p class="font-medium text-gray-900">{{ $report->reason }}</p>
                                    <p class="text-gray-600">Reportado por: <span class="font-semibold">{{ $report->user->profile->username ?? $report->user->email }}</span></p>
                                    <p class="text-gray-500">{{ $report->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <p class="text-lg">No hay reportes aún.</p>
            <p class="text-sm mt-2">Los reportes de pines aparecerán aquí cuando los usuarios reporten contenido.</p>
        </div>
        @endif
    </div>

    {{-- ESTADÍSTICAS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $users->count() }}</div>
            <div class="text-gray-600 mt-1">Usuarios Totales</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-green-600">{{ $pins->count() }}</div>
            <div class="text-gray-600 mt-1">Pines Publicados</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-red-600">{{ $pinReports->count() }}</div>
            <div class="text-gray-600 mt-1">Reportes Totales</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-purple-600">
                {{ $pins->count() > 0 ? number_format($pins->count() / max($users->count(), 1), 1) : '0' }}
            </div>
            <div class="text-gray-600 mt-1">Pines por Usuario</div>
        </div>
    </div>
</div>

<!-- Modal para cambiar contraseña -->
<div id="resetPasswordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Restablecer Contraseña</h3>
            <button onclick="closeResetPasswordModal()" class="text-gray-500 hover:bg-gray-100 p-2 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <p class="text-sm text-gray-600 mb-4">Cambiando contraseña para: <span id="userEmailDisplay" class="font-semibold"></span></p>
        
        <form id="resetPasswordForm" class="space-y-4">
            <input type="hidden" id="userId" />
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                <input 
                    type="password" 
                    id="newPassword"
                    required
                    minlength="8"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Mínimo 8 caracteres"
                >
                <p class="text-xs text-gray-500 mt-1">La contraseña debe tener al menos 8 caracteres</p>
            </div>
            
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeResetPasswordModal()" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    Cambiar Contraseña
                </button>
            </div>
        </form>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    let currentUserId = null;

    function openResetPasswordModal(userId, userEmail) {
        currentUserId = userId;
        document.getElementById('userId').value = userId;
        document.getElementById('userEmailDisplay').textContent = userEmail;
        document.getElementById('newPassword').value = '';
        document.getElementById('resetPasswordModal').classList.remove('hidden');
    }

    function closeResetPasswordModal() {
        document.getElementById('resetPasswordModal').classList.add('hidden');
        currentUserId = null;
    }

    function toggleReportDetails(pinId) {
        const detailsDiv = document.getElementById('reports-' + pinId);
        if (detailsDiv) {
            detailsDiv.classList.toggle('hidden');
        }
    }

    document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const userId = document.getElementById('userId').value;
        const newPassword = document.getElementById('newPassword').value;
        
        if (newPassword.length < 8) {
            alert('La contraseña debe tener al menos 8 caracteres');
            return;
        }

        fetch(`/admin/users/${userId}/reset-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                new_password: newPassword
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeResetPasswordModal();
            } else {
                alert(data.message || 'Error al cambiar la contraseña');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar la contraseña');
        });
    });

    // Cerrar modal al hacer clic fuera
    document.getElementById('resetPasswordModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeResetPasswordModal();
        }
    });
</script>

</div>

</body>
</html>
