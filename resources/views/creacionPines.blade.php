<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pin - Pinterest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white" x-data="{ imagePreview: null }">

    <!-- Header -->
    <header class="sticky top-0 z-10 flex items-center justify-between border-b bg-white px-4 py-3">
        <div class="flex items-center gap-4">
            <a href="{{ route('inicioLogueado') }}" class="rounded-full p-2 text-gray-700 hover:bg-gray-100">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
            </a>
            <h1 class="text-xl font-semibold">Crear Pin</h1>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" class="rounded-full px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100">
                ¡Cambios guardados!
            </button>
            <button type="submit" form="pinForm"
                class="rounded-full bg-red-600 px-5 py-2 text-sm font-semibold text-white hover:bg-red-700">
                Publicar
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mx-auto max-w-5xl px-4 py-8">

        <!-- Mensajes de éxito/error -->
        @if (session('success'))
            <div class="mb-4 rounded-2xl border border-green-400 bg-green-100 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-2xl border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="pinForm" method="POST" action="{{ route('pins.store') }}" enctype="multipart/form-data"
            class="flex gap-8">
            @csrf

            <!-- Left Side - Image Upload -->
            <div class="w-96">
                <div class="overflow-hidden rounded-2xl bg-gray-100" style="height: 550px;">
                    <!-- Preview Image -->
                    <div x-show="imagePreview" class="relative h-full">
                        <img :src="imagePreview" class="h-full w-full object-cover">
                        <button type="button" @click="imagePreview = null; $refs.fileInput.value = ''"
                            class="absolute right-4 top-4 rounded-full bg-white p-2 shadow-lg hover:bg-gray-100">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Upload Area -->
                    <label x-show="!imagePreview" for="fileInput"
                        class="flex h-full cursor-pointer flex-col items-center justify-center transition hover:bg-gray-200">
                        <div class="flex flex-col items-center gap-4 p-8 text-center">
                            <div class="flex h-12 w-12 items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-700">Elige un archivo o arrástralo aquí</p>
                            <p class="text-xs text-gray-500">Te recomendamos usar archivos .jpg de alta calidad de menos
                                de 20 MB o archivos .mp4 de menos de 200 MB.</p>
                            <input type="file" id="fileInput" name="image" accept="image/*" x-ref="fileInput"
                                @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }"
                                class="hidden">
                        </div>
                    </label>
                </div>
            </div>

            <!-- Right Side - Form Fields -->
            <div class="flex-1 space-y-6">

                <!-- Título -->
                <div>
                    <label for="title" class="mb-2 block text-xs font-semibold text-gray-700">Título</label>
                    <input type="text" id="title" name="title" placeholder="Añade un título"
                        class="w-full rounded-2xl border-2 border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none">
                </div>

                <!-- Descripción -->
                <div>
                    <label for="description" class="mb-2 block text-xs font-semibold text-gray-700">Descripción</label>
                    <textarea id="description" name="description" rows="4" placeholder="Añade una descripción detallada"
                        class="w-full resize-none rounded-2xl border-2 border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none"></textarea>
                </div>

                <!-- Enlace -->
                <div>
                    <label for="link" class="mb-2 block text-xs font-semibold text-gray-700">Enlace</label>
                    <input type="url" id="link" name="link" placeholder="Añade un enlace"
                        class="w-full rounded-2xl border-2 border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none">
                </div>

                <!-- Tablero -->
                <div>
                    <label for="board" class="mb-2 block text-xs font-semibold text-gray-700">Tablero</label>
                    <select id="board" name="board"
                        class="w-full appearance-none rounded-2xl border-2 border-gray-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none"
                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25em;">
                        <option value="">Selecciona un tablero</option>
                        <option value="ideas">Ideas</option>
                        <option value="favoritos">Favoritos</option>
                        <option value="proyectos">Proyectos</option>
                    </select>
                </div>

                <!-- Temas etiquetados -->
                <div x-data="{ open: false }">
                    <label class="mb-2 block text-xs font-semibold text-gray-700">Temas etiquetados (0)</label>
                    <div class="relative">
                        <input type="text" @click="open = !open" placeholder="Busca una etiqueta"
                            class="w-full rounded-2xl border-2 border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25em;">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">No te preocupes, nadie verá tus etiquetas</p>
                </div>

                <!-- Etiquetar productos -->
                <div>
                    <label class="mb-3 block text-xs font-semibold text-gray-700">Etiquetar productos</label>
                    <button type="button"
                        class="rounded-full bg-gray-200 px-4 py-2 text-sm font-semibold hover:bg-gray-300">
                        Añadir productos
                    </button>
                </div>

                <!-- Más opciones -->
                <div x-data="{ expanded: false }" class="border-t pt-4">
                    <button type="button" @click="expanded = !expanded"
                        class="mb-4 flex items-center gap-2 text-sm font-semibold">
                        <span>Más opciones</span>
                        <svg class="h-4 w-4 transition-transform" :class="expanded ? 'rotate-180' : ''"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>

                    <div x-show="expanded" x-collapse class="space-y-4">
                        <!-- Permitir comentarios -->
                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="allowComments" name="allow_comments" checked
                                class="relative h-6 w-10 cursor-pointer appearance-none rounded-full bg-blue-600 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all after:content-[''] checked:after:left-5">
                            <div class="flex-1">
                                <label for="allowComments" class="cursor-pointer text-sm font-semibold">Permite a las
                                    personas comentar</label>
                            </div>
                        </div>

                        <!-- Mostrar productos parecidos -->
                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="showSimilar" name="show_similar" checked
                                class="relative h-6 w-10 cursor-pointer appearance-none rounded-full bg-blue-600 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all after:content-[''] checked:after:left-5">
                            <div class="flex-1">
                                <label for="showSimilar" class="cursor-pointer text-sm font-semibold">Mostrar
                                    productos parecidos</label>
                                <p class="mt-1 text-xs text-gray-600">Las personas pueden comprar productos parecidos a
                                    lo que se muestra en este Pin a través de la búsqueda visual</p>
                                <p class="mt-2 text-xs text-gray-600">Las recomendaciones de compras no están
                                    disponibles para los Idea Ads y para los Pines con productos etiquetados o una
                                    etiqueta de asociación pagada</p>
                            </div>
                        </div>

                        <!-- Texto alternativo -->
                        <div>
                            <label for="altText" class="mb-2 block text-xs font-semibold text-gray-700">Texto
                                alternativo</label>
                            <textarea id="altText" name="alt_text" rows="3" placeholder="Describe los detalles visuales de tu Pin"
                                class="w-full resize-none rounded-2xl border-2 border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none"></textarea>
                            <p class="mt-2 text-xs text-gray-500">Esto ayuda a las personas que usan lectores de
                                pantalla a entender de qué trata tu Pin</p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </main>

</body>

</html>
