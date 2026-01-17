<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Pin - Pinterest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white">

    <!-- Header -->
    <header class="flex items-center justify-between px-4 py-3 border-b bg-white sticky top-0 z-10">
        <div class="flex items-center gap-4">
            <a href="{{ route('inicioLogueado') }}" class="text-gray-700 hover:bg-gray-100 p-2 rounded-full">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
            </a>
            <h1 class="text-xl font-semibold">Editar Pin</h1>
        </div>
        
        <div class="flex items-center gap-3">
            <button type="submit" form="editPinForm" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-full font-semibold text-sm">
                Guardar cambios
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto py-8 px-4">
        
        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="editPinForm" onsubmit="updatePin(event, {{ $pin->id }})">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Vista previa de la imagen -->
                <div class="md:col-span-1">
                    <div class="bg-gray-100 rounded-2xl overflow-hidden sticky top-24">
                        <img src="{{ $pin->image_url }}" alt="{{ $pin->title }}" class="w-full h-auto object-cover">
                    </div>
                </div>

                <!-- Detalles del pin -->
                <div class="md:col-span-2 space-y-6">

                    <!-- Título -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Título</label>
                        <input 
                            type="text" 
                            name="title" 
                            value="{{ $pin->title }}"
                            placeholder="Añade un título atractivo"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        >
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Descripción</label>
                        <textarea 
                            name="description" 
                            placeholder="Cuéntale a otros de qué trata este pin"
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 resize-none"
                        >{{ $pin->description }}</textarea>
                    </div>

                    <!-- Enlace -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Enlace (opcional)</label>
                        <input 
                            type="url" 
                            name="link" 
                            value="{{ $pin->link }}"
                            placeholder="https://ejemplo.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        >
                    </div>

                    <!-- Tablero -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Tablero (opcional)</label>
                        <input 
                            type="text" 
                            name="board" 
                            value="{{ $pin->board }}"
                            placeholder="Selecciona o crea un tablero"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        >
                    </div>

                    <!-- Permite comentarios -->
                    <div class="flex items-center gap-3">
                        <input 
                            type="checkbox" 
                            id="allowComments"
                            name="allow_comments" 
                            value="1"
                            {{ $pin->allow_comments ? 'checked' : '' }}
                            class="w-4 h-4 text-red-600 rounded focus:ring-red-500"
                        >
                        <label for="allowComments" class="text-gray-700">
                            Permitir comentarios en este pin
                        </label>
                    </div>

                    <!-- Botón para eliminar -->
                    <div class="pt-6 border-t">
                        <button 
                            type="button" 
                            onclick="deleteCurrentPin()"
                            class="w-full bg-red-100 hover:bg-red-200 text-red-600 font-semibold px-4 py-3 rounded-lg transition"
                        >
                            Eliminar este pin
                        </button>
                    </div>

                </div>

            </div>

        </form>

    </main>

    <script>
        function updatePin(event, pinId) {
            event.preventDefault();

            const formData = new FormData(document.getElementById('editPinForm'));
            const data = {
                title: formData.get('title'),
                description: formData.get('description'),
                link: formData.get('link'),
                board: formData.get('board'),
                allow_comments: formData.has('allow_comments') ? true : false,
            };

            fetch('/pins/' + pinId, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pin actualizado correctamente');
                    window.location.href = '{{ route('inicioLogueado') }}';
                } else {
                    alert(data.message || 'Error al actualizar el pin');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar el pin');
            });
        }

        function deleteCurrentPin() {
            if (!confirm('¿Estás seguro de que quieres eliminar este pin? Esta acción no se puede deshacer.')) return;

            fetch('/pins/{{ $pin->id }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pin eliminado correctamente');
                    window.location.href = '{{ route('inicioLogueado') }}';
                } else {
                    alert(data.message || 'Error al eliminar el pin');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el pin');
            });
        }
    </script>

</body>
</html>
