<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear Pines - Pinterest</title>
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
            <h1 class="text-xl font-semibold">Crear Pines</h1>
        </div>
        
        <div class="flex items-center gap-3">
            <span id="statusMessage" class="text-sm text-gray-600"></span>
            <button type="submit" form="multiplePinsForm" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-full font-semibold text-sm">
                Publicar Todo
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-8 px-4" x-data="multiPinCreator()">
        
        <!-- Mensajes -->
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

        <!-- Upload Area -->
        <div class="mb-8 border-2 border-dashed border-gray-300 rounded-2xl p-12 text-center hover:bg-gray-50 transition cursor-pointer" 
             @click="$refs.multiFileInput.click()"
             @drop.prevent="handleDrop($event)"
             @dragover.prevent="dragActive = true"
             @dragleave.prevent="dragActive = false"
             :class="dragActive ? 'border-blue-500 bg-blue-50' : ''">
            <div class="flex flex-col items-center gap-4">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <div>
                    <p class="text-lg font-semibold text-gray-900">Sube múltiples imágenes a la vez</p>
                    <p class="text-sm text-gray-500 mt-1">Selecciona o arrastra tus imágenes aquí</p>
                </div>
                <input type="file" 
                       id="multiFileInput" 
                       ref="multiFileInput"
                       accept="image/*" 
                       multiple
                       @change="handleFileSelection($event)"
                       class="hidden">
                <p class="text-xs text-gray-400 mt-4">Soportamos .jpg, .png y otros formatos de imagen (máx 20 MB cada una)</p>
            </div>
        </div>

        <!-- Pines a crear -->
        <div x-show="pins.length > 0">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">
                    Pines a crear (<span x-text="pins.length"></span>)
                </h2>
                <button type="button" @click="pins = []" class="text-red-600 hover:text-red-700 font-semibold text-sm">
                    Limpiar todo
                </button>
            </div>

            <!-- Form con todos los pines -->
            <form id="multiplePinsForm" @submit.prevent="submitAllPins()">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <template x-for="(pin, index) in pins" :key="index">
                        <div class="bg-white border-2 border-gray-200 rounded-2xl overflow-hidden">
                            <!-- Preview -->
                            <div class="relative bg-gray-100" style="height: 300px;">
                                <img :src="pin.preview" class="w-full h-full object-cover">
                                <button type="button" 
                                        @click="removePin(index)"
                                        class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Fields -->
                            <div class="p-4 space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Título</label>
                                    <input 
                                        type="text" 
                                        x-model="pin.title"
                                        placeholder="Título del pin"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                    >
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Descripción</label>
                                    <textarea 
                                        x-model="pin.description"
                                        placeholder="Descripción breve"
                                        rows="2"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm resize-none focus:outline-none focus:ring-2 focus:ring-red-500"
                                    ></textarea>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Tablero</label>
                                    <select 
                                        x-model="pin.board"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                    >
                                        <option value="">Sin tablero</option>
                                        <option value="ideas">Ideas</option>
                                        <option value="favoritos">Favoritos</option>
                                        <option value="proyectos">Proyectos</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-2">
                                    <input 
                                        type="checkbox" 
                                        x-model="pin.allow_comments"
                                        class="w-4 h-4 text-red-600 rounded focus:ring-red-500"
                                    >
                                    <label class="text-xs font-semibold text-gray-700">Permitir comentarios</label>
                                </div>
                            </div>

                            <!-- Hidden inputs para el formulario -->
                            <input type="hidden" :name="'pins[' + index + '][title]'" :value="pin.title">
                            <input type="hidden" :name="'pins[' + index + '][description]'" :value="pin.description">
                            <input type="hidden" :name="'pins[' + index + '][board]'" :value="pin.board">
                            <input type="hidden" :name="'pins[' + index + '][allow_comments]'" :value="pin.allow_comments ? 1 : 0">
                            <input type="hidden" :name="'pins[' + index + '][image_data]'" :value="pin.imageData">
                        </div>
                    </template>
                </div>

                <!-- Botón para agregar más imágenes -->
                <div class="flex justify-center mb-8">
                    <button type="button" 
                            @click="openFileDialog()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-semibold transition">
                        + Agregar más imágenes
                    </button>
                </div>
            </form>
        </div>

        <!-- Mensaje vacío -->
        <div x-show="pins.length === 0" class="text-center py-20">
            <p class="text-gray-500 text-lg">Selecciona imágenes para comenzar</p>
        </div>
    </main>

    <script>
        function multiPinCreator() {
            return {
                pins: [],
                dragActive: false,

                handleFileSelection(event) {
                    const files = event.target.files;
                    if (files.length > 0) {
                        this.processFiles(files);
                        // Limpiar el input para permitir seleccionar los mismos archivos
                        event.target.value = '';
                    }
                },

                handleDrop(event) {
                    const files = event.dataTransfer.files;
                    this.dragActive = false;
                    this.processFiles(files);
                },

                openFileDialog() {
                    this.$refs.multiFileInput.click();
                },

                processFiles(files) {
                    Array.from(files).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.pins.push({
                                    title: file.name.replace(/\.[^/.]+$/, ''),
                                    description: '',
                                    board: '',
                                    allow_comments: true,
                                    preview: e.target.result,
                                    imageData: e.target.result,
                                });
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                },

                removePin(index) {
                    this.pins.splice(index, 1);
                },

                submitAllPins() {
                    if (this.pins.length === 0) {
                        alert('Por favor selecciona al menos una imagen');
                        return;
                    }

                    const statusEl = document.getElementById('statusMessage');
                    statusEl.textContent = 'Publicando ' + this.pins.length + ' pines...';
                    statusEl.className = 'text-sm text-blue-600';

                    // Crear objeto con los datos de los pines
                    const pinsPayload = this.pins.map(pin => ({
                        title: pin.title,
                        description: pin.description,
                        board: pin.board,
                        allow_comments: pin.allow_comments ? 1 : 0,
                        image_data: pin.imageData
                    }));

                    fetch('{{ route("pins.storeMultiple") }}', {
                        method: 'POST',
                        body: JSON.stringify({
                            pins: pinsPayload,
                            _token: document.querySelector('meta[name="csrf-token"]').content
                        }),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            statusEl.textContent = '✓ ' + data.message;
                            statusEl.className = 'text-sm text-green-600';
                            setTimeout(() => {
                                window.location.href = '{{ route("inicioLogueado") }}';
                            }, 2000);
                        } else {
                            statusEl.textContent = '✗ Error: ' + (data.message || 'Error desconocido');
                            statusEl.className = 'text-sm text-red-600';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        statusEl.textContent = '✗ ' + error.message;
                        statusEl.className = 'text-sm text-red-600';
                    });
                }
            };
        }
    </script>

</body>
</html>
