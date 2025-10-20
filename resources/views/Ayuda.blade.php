<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de asistencia - Pinterest</title>
   <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

    <header class="border-b border-gray-200">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        
            <div class="flex items-center space-x-2">
                <svg style="width: 30px; height: 30px;" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
        <circle cx="16" cy="16" r="14" fill="white"></circle>
        <path d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 21.6801 5.38269 26.5702 10.2435 28.7655C10.25 28.6141 10.2573 28.4752 10.2636 28.3561C10.2722 28.1938 10.2788 28.0682 10.2788 27.9976C10.2788 27.5769 10.5649 25.4904 10.5649 25.4904L12.3149 18.3053C12.0457 17.8678 11.8438 16.9423 11.8438 16.2356C11.8438 12.9711 13.6611 12.2644 14.7716 12.2644C16.1851 12.2644 16.5048 13.7957 16.5048 14.9231C16.5048 15.5194 16.1955 16.4528 15.8772 17.4134C15.5398 18.4314 15.1923 19.4799 15.1923 20.1899C15.1923 21.5697 16.5553 22.2596 17.4976 22.2596C19.988 22.2596 22.2764 19.1298 22.2764 16C22.2764 12.8702 20.8125 9.08412 16.0168 9.08412C11.2212 9.08412 9.06731 12.7356 9.06731 15.5288C9.06731 17.4134 9.77404 18.7933 10.1274 19.0288C10.2284 19.1186 10.4 19.3957 10.2788 19.786C10.1577 20.1764 9.9367 21.0481 9.84135 21.4351C9.83013 21.5248 9.72356 21.6774 9.38702 21.5697C8.96635 21.4351 6.29087 19.7524 6.29087 15.5288C6.29087 11.3053 9.60577 6.39182 16.0168 6.39182C22.4279 6.39182 25.7091 10.6995 25.7091 16C25.7091 21.3005 21.4183 24.6827 18.1538 24.6827C15.5423 24.6827 14.5192 23.516 14.3341 22.9327L13.3413 26.7187C13.1069 27.3468 12.6696 28.4757 12.1304 29.4583C13.3594 29.8111 14.6576 30 16 30Z" fill="#E60023"></path>
      </svg>
                <span class="font-medium text-sm text-gray-600">Centro de asistencia</span>
            </div>

            <nav class="hidden md:flex items-center space-x-6 text-sm font-medium text-gray-700">
                <a href="#" class="hover:underline">General</a>
                <a href="#" class="hover:underline">Empresas</a>
                <a href="#" class="hover:underline">Política de privacidad</a>
                <a href="#" class="hover:underline">Más de Pinterest</a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12">

        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-900 mb-6">Sigue inspirándote</h1>

            <div class="max-w-xl mx-auto">
                <div class="relative">
                    <input
                        type="text"
                        placeholder="¿Cómo podemos ayudarte?"
                        class="w-full border border-gray-300 rounded-full px-5 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
                    >
                    <svg class="w-5 h-5 text-gray-500 absolute right-5 top-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 16.65z" />
                    </svg>
                </div>
            </div>
        </div>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @php
                $sections = [
                    ['icon' => '➡️', 'title' => 'Para empezar', 'links' => ['Crea una cuenta de Pinterest', 'Encuentra tu perfil', 'Actualiza la aplicación']],
                    ['icon' => '⚙️', 'title' => 'Administra tu cuenta y tus preferencias', 'links' => ['Inicia y cierra sesión', 'Edita tu configuración', 'Gestiona notificaciones']],
                    ['icon' => '📌', 'title' => 'Encuentra y guarda ideas', 'links' => ['Descubre contenido nuevo', 'Guarda Pines e ideas', 'Explora tableros']],
                    ['icon' => '✏️', 'title' => 'Crea y edita', 'links' => ['Crea un Pin o tablero', 'Edita tu información', 'Elimina contenido']],
                    ['icon' => '🤝', 'title' => 'Conéctate, colabora y comparte', 'links' => ['Busca amigos y contactos', 'Comparte Pines y tableros', 'Mensajería y colaboración']],
                    ['icon' => '🔒', 'title' => 'Privacidad, seguridad y aspectos legales', 'links' => ['Administra tu privacidad', 'Protege tu cuenta', 'Consulta nuestras políticas']],
                ];
            @endphp

            @foreach($sections as $section)
                <div class="border border-gray-300 rounded-2xl p-6 hover:shadow-md transition">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="text-2xl">{{ $section['icon'] }}</span>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $section['title'] }}</h2>
                    </div>
                    <ul class="text-gray-600 text-sm space-y-1 mb-4">
                        @foreach($section['links'] as $link)
                            <li><a href="#" class="hover:underline">{{ $link }}</a></li>
                        @endforeach
                    </ul>
                    <button class="text-sm border border-gray-400 rounded-full px-4 py-1 hover:bg-gray-100">Ver más</button>
                </div>
            @endforeach
        </section>

        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Artículos destacados</h2>
            <div class="max-w-3xl mx-auto divide-y divide-gray-300">
                @foreach ([
                    'Opciones de seguridad para adolescentes',
                    'Haz que tu perfil sea privado o público',
                    'Compra mediante Pines de productos',
                    'No puedes iniciar sesión en Pinterest'
                ] as $item)
                    <details class="py-3 cursor-pointer">
                        <summary class="flex justify-between items-center font-medium text-gray-800">
                            {{ $item }}
                            <span class="text-xl font-light">+</span>
                        </summary>
                    </details>
                @endforeach
            </div>
        </section>
    </main>

 
    <footer class="bg-white text-gray-700 mt-10 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
          
            <div>
                <svg style="width: 30px; height: 30px;" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
        <circle cx="16" cy="16" r="14" fill="white"></circle>
        <path d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 21.6801 5.38269 26.5702 10.2435 28.7655C10.25 28.6141 10.2573 28.4752 10.2636 28.3561C10.2722 28.1938 10.2788 28.0682 10.2788 27.9976C10.2788 27.5769 10.5649 25.4904 10.5649 25.4904L12.3149 18.3053C12.0457 17.8678 11.8438 16.9423 11.8438 16.2356C11.8438 12.9711 13.6611 12.2644 14.7716 12.2644C16.1851 12.2644 16.5048 13.7957 16.5048 14.9231C16.5048 15.5194 16.1955 16.4528 15.8772 17.4134C15.5398 18.4314 15.1923 19.4799 15.1923 20.1899C15.1923 21.5697 16.5553 22.2596 17.4976 22.2596C19.988 22.2596 22.2764 19.1298 22.2764 16C22.2764 12.8702 20.8125 9.08412 16.0168 9.08412C11.2212 9.08412 9.06731 12.7356 9.06731 15.5288C9.06731 17.4134 9.77404 18.7933 10.1274 19.0288C10.2284 19.1186 10.4 19.3957 10.2788 19.786C10.1577 20.1764 9.9367 21.0481 9.84135 21.4351C9.83013 21.5248 9.72356 21.6774 9.38702 21.5697C8.96635 21.4351 6.29087 19.7524 6.29087 15.5288C6.29087 11.3053 9.60577 6.39182 16.0168 6.39182C22.4279 6.39182 25.7091 10.6995 25.7091 16C25.7091 21.3005 21.4183 24.6827 18.1538 24.6827C15.5423 24.6827 14.5192 23.516 14.3341 22.9327L13.3413 26.7187C13.1069 27.3468 12.6696 28.4757 12.1304 29.4583C13.3594 29.8111 14.6576 30 16 30Z" fill="#E60023"></path>
      </svg>
                <div class="relative inline-block">
                    <select class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300">
                        <option>Español</option>
                        <option>English</option>
                        <option>Français</option>
                    </select>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-gray-800 mb-3">Empresa</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:underline">Acerca de Pinterest</a></li>
                    <li><a href="#" class="hover:underline">Sala de prensa</a></li>
                    <li><a href="#" class="hover:underline">Empleos</a></li>
                    <li><a href="#" class="hover:underline">Inversores</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold text-gray-800 mb-3">Más de Pinterest</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:underline">Centro de asistencia</a></li>
                    <li><a href="#" class="hover:underline">Empresas</a></li>
                    <li><a href="#" class="hover:underline">Creadores</a></li>
                    <li><a href="#" class="hover:underline">Desarrolladores</a></li>
                </ul>
            </div>
        </div>

        <hr class="border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-wrap items-center justify-between text-xs text-gray-600">
            <p>© 2025 Pinterest</p>
            <div class="flex flex-wrap gap-3">
                <a href="#" class="hover:underline">Condiciones de servicio</a>
                <a href="#" class="hover:underline">Derechos de autor & Marca registrada</a>
                <a href="#" class="hover:underline">Política de privacidad</a>
                <a href="#" class="hover:underline">Aviso para no usuarios</a>
                <a href="#" class="hover:underline">Política de cookies</a>
                <a href="#" class="hover:underline">Anuncios personalizados</a>
            </div>
        </div>
    </footer>
</body>
</html>