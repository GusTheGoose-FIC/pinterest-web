<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condiciones de servicio - Pinterest Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>document.documentElement.style.scrollBehavior = 'smooth';</script>
</head>
<body class="bg-gray-50 text-gray-800">

   
    <header class="bg-[#fde2c1] py-3 px-6 flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-2">
           <svg style="width: 30px; height: 30px;" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
        <circle cx="16" cy="16" r="14" fill="white"></circle>
        <path d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 21.6801 5.38269 26.5702 10.2435 28.7655C10.25 28.6141 10.2573 28.4752 10.2636 28.3561C10.2722 28.1938 10.2788 28.0682 10.2788 27.9976C10.2788 27.5769 10.5649 25.4904 10.5649 25.4904L12.3149 18.3053C12.0457 17.8678 11.8438 16.9423 11.8438 16.2356C11.8438 12.9711 13.6611 12.2644 14.7716 12.2644C16.1851 12.2644 16.5048 13.7957 16.5048 14.9231C16.5048 15.5194 16.1955 16.4528 15.8772 17.4134C15.5398 18.4314 15.1923 19.4799 15.1923 20.1899C15.1923 21.5697 16.5553 22.2596 17.4976 22.2596C19.988 22.2596 22.2764 19.1298 22.2764 16C22.2764 12.8702 20.8125 9.08412 16.0168 9.08412C11.2212 9.08412 9.06731 12.7356 9.06731 15.5288C9.06731 17.4134 9.77404 18.7933 10.1274 19.0288C10.2284 19.1186 10.4 19.3957 10.2788 19.786C10.1577 20.1764 9.9367 21.0481 9.84135 21.4351C9.83013 21.5248 9.72356 21.6774 9.38702 21.5697C8.96635 21.4351 6.29087 19.7524 6.29087 15.5288C6.29087 11.3053 9.60577 6.39182 16.0168 6.39182C22.4279 6.39182 25.7091 10.6995 25.7091 16C25.7091 21.3005 21.4183 24.6827 18.1538 24.6827C15.5423 24.6827 14.5192 23.516 14.3341 22.9327L13.3413 26.7187C13.1069 27.3468 12.6696 28.4757 12.1304 29.4583C13.3594 29.8111 14.6576 30 16 30Z" fill="#ff0505ff"></path>
      </svg>
            <span class="text-red-700 font-semibold">Políticas</span>
        </div>

        <nav class="flex gap-6 text-sm text-gray-700">
      <div class="flex items-center space-x-6 text-red-700 font-medium relative">
        <div class="relative group">
          <a href="{{ route('Condiciones') }}" 
           class="inline-block px-2 py-1 transition duration-200 ease-in-out 
                  group-hover:text-[#E60023] group-hover:underline">
          Condiciones
        </a>

        <div class="submenucompañia-enter absolute top-full left-0 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-44 z-10 border border-gray-100">
          <a href="{{ route('Condiciones') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Condiciones de servicio</a>
        </div>
      </div>

            <div class="flex items-center space-x-6 text-red-700 font-medium relative">
      <div class="relative group">
        <a href="{{ route('PoliticasPrivacidad') }}" 
           class="inline-block px-2 py-1 transition duration-200 ease-in-out 
                  group-hover:text-[#E60023] group-hover:underline">
          Privacidad
        </a>

        <div class="submenucompañia-enter absolute top-full left-0 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-44 z-10 border border-gray-100">
          <a href="{{ route('PoliticasPrivacidad') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Politicas de privacidad</a>
          <a href="{{ route('AvisosnoUsuario') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Aviso para no usuarios</a>
          <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Grabacion de llamadas</a>
        </div>
      </div>

            <div class="flex items-center space-x-6 text-red-700 font-medium relative">
      <div class="relative group">
        <a href="{{ route('Comunidad') }}" 
           class="inline-block px-2 py-1 transition duration-200 ease-in-out 
                  group-hover:text-[#E60023] group-hover:underline">
          Comunidad
        </a>

        <div class="submenucompañia-enter absolute top-full left-0 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-44 z-10 border border-gray-100">
          <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Directrices para la comunidad</a>
        </div>
      </div>

            <div class="flex items-center space-x-6 text-red-700 font-medium relative">
      <div class="relative group">
        <a href="{{ route('propiedadIntelectual') }}" 
           class="inline-block px-2 py-1 transition duration-200 ease-in-out 
                  group-hover:text-[#E60023] group-hover:underline">
          Propiedad Intelectual
        </a>

        <div class="submenucompañia-enter absolute top-full left-0 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-44 z-10 border border-gray-100">
          <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Derechos de autor</a>
          <a href="{{ route('marcaComercial') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Marca Comercial</a>
        </div>
      </div>

                 <div class="flex items-center space-x-6 text-red-700 font-medium relative">
      <div class="relative group">
        <a href="#" 
           class="inline-block px-2 py-1 transition duration-200 ease-in-out 
                  group-hover:text-[#E60023] group-hover:underline">
          Transparencia
        </a>

        <div class="submenucompañia-enter absolute top-full left-0 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-44 z-10 border border-gray-100">
          <a href="{{ route('transparencia') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Transparencia</a>
        </div>
      </div>

                       <div class="flex items-center space-x-6 text-red-700 font-medium relative">
      <div class="relative group">
        <a href="#" 
           class="inline-block px-2 py-1 transition duration-200 ease-in-out 
                  group-hover:text-[#E60023] group-hover:underline">
          Mas
        </a>

        <div class="submenucompañia-enter absolute top-full left-0 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-44 z-10 border border-gray-100">
          <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Directrices para comerciantes</a>
           <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Directrices de publicidad</a>
            <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Directrices para desarrolladores</a>
             <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Directrices sobre contenidos comerciales y de marca</a>
              <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Aplicacion</a>
        </div>
      </div>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto py-16 px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
        <section class="md:col-span-2">
            <h1 class="text-4xl font-bold text-red-700 mb-8">Condiciones de servicio</h1>

            <article class="space-y-6 leading-relaxed">
                <h2 id="introduccion" class="text-2xl font-semibold text-red-700">¡Gracias por usar Pinterest!</h2>
                <p>
                   Estas Condiciones de servicio (las "Condiciones") rigen tu acceso a y tu uso de cualquier
                    sitio web, aplicación, servicio, tecnología, API, widget, plataforma, canal o cualquier otro producto o función que Pinterest posea,
                    opere u ofrezca o que tenga la marca de Pinterest ("Pinterest" o el "Servicio"), excepto en los casos en los que indiquemos expresamente que se aplican otras condiciones
                    (y no estas). A los efectos de estas Condiciones, "nosotros" o "nos" se refiere a la parte con la que estás firmando este acuerdo,
                    según el artículo 13(e) (Partes). Lee detenidamente estas Condiciones y comunícate con nosotros si tienes alguna pregunta.
                    No puedes usar el Servicio para hacer ni compartir nada que contravenga estas Condiciones. Para mayor claridad, estas Condiciones incluyen
                    e incorporan mediante su referencia las siguientes políticas:
                </p>

                <ul class="list-disc pl-6 space-y-2">
                    <li>Nuestras Directrices para la comunidad, en las que se explica lo que está permitido en Pinterest y lo que no.</li>
                    <li>Directrices de publicidad y Directrices para comerciantes, en las que se explican las 
                      políticas adicionales que se aplican a los anuncios y a los comerciantes en Pinterest;</li>
                    <li>Directrices de contenido comercial y de marca, que explican 
                      las políticas adicionales que se aplican al contenido patrocinado, de marca o comercial;</li>
                    <li>Nuestras prácticas de cumplimiento, 
                        donde se explica cómo ponemos en práctica nuestras políticas, 
                        incluidas las restricciones que podemos establecer en relación con tu contenido en o tu uso de Pinterest.</li>

                </ul>

                <p>
                    Si accedes a Pinterest o lo utilizas, aceptas cumplir con estas Condiciones 
                    y estar sujeto a ellas, y no intentarás eludirlas. Si no aceptas nuestras Condiciones,
                     no debes acceder a Pinterest ni usar el servicio.
                </p>

                <h2 id="Servicio" class="text-2xl font-semibold text-red-700">1.El servicio</h2>
                <p>
                  Pinterest ayuda a inspirar a todas las personas a crear la vida que desean. Para ello, te mostramos cosas que creemos que serán pertinentes, 
                  interesantes y personales para ti en función de tu actividad en el sitio y fuera del sitio. Para prestar el Servicio, necesitamos ser capaces de identificarte a ti y tus intereses, 
                  y usamos tus datos personales para hacer esto. Para obtener más información, lee nuestra Política de privacidad.
                  Algunas de las cosas que te mostramos son promocionadas por anunciantes. Como parte del Servicio, 
                  intentamos garantizar que incluso el contenido promocionado sea pertinente e interesante para ti. 
                  Puedes identificar el contenido promocionado porque estará etiquetado de forma clara.
                </p>
                <h2 id="uso" class="text-2xl font-semibold text-red-700">2. El uso de Pinterest</h2>
                <h2>a. Quien puede usar pinterest</h2>
                <p>
                Solo puedes usar Pinterest si sigues estas Condiciones y todas las leyes aplicables. El uso de Pinterest puede incluir la descarga de software a tu computadora, teléfono, tableta u otro dispositivo. Aceptas que es posible que actualicemos automáticamente ese software y que estas Condiciones se aplicarán a cualquier actualización. Al crear una cuenta de Pinterest, debes proporcionarnos información precisa y completa.
                No está permitido el acceso a Pinterest ni el uso del Servicio por parte de personas menores de 13 años. Puedes usar Pinterest si tienes más de 13 años y superas la edad mínima de consentimiento en tu país. Si tienes entre 13 y 18 años, solo puedes usar el Servicio con la autorización de un progenitor o tutor legal. Asegúrate de que tu progenitor o tutor legal haya revisado estas Condiciones y las haya discutido contigo.
                Si tu cuenta se desactivó anteriormente por infringir estas Condiciones o cualquiera de nuestras políticas, o por razones legales, no podrás crear una nueva cuenta sin nuestro permiso expreso por escrito, que se proporciona a nuestra entera discreción.
                Al usar Pinterest, aceptas no extraer, recopilar, buscar, copiar ni acceder de alguna otra manera a datos o contenido de Pinterest de formas no autorizadas; tales como el uso de medios automatizados (sin nuestro permiso expreso previo), o el acceso o el intento de acceder a datos a los que no tienes permiso para acceder.
                No tienes permitido usar, acceder, descargar ni hacer disponible de otra manera el Servicio (incluido el software relacionado), excepto según lo autoricen las restricciones comerciales aplicables, incluidas las sanciones y los controles de exportación de EE. UU., la UE y el R. U. Aceptas no usar el Servicio para finalidades que se prohíban en las restricciones comerciales aplicables.
                Cualquier uso de Pinterest que no esté permitido expresamente por estas Condiciones constituye un incumplimiento de las mismas y puede infringir derechos de autor, marca comercial y otras leyes.
                </p>
                <h2 id="contenido" class="text-2xl font-semibold text-red-700">3. Tu Contenido de usuario</h2>
                <p> 
                "Contenido de usuario" significa todo el contenido que tú (o las personas que usen tu cuenta) envíes, publiques o muestres en o a través de Pinterest,
                 como pines, tableros, comentarios, mensajes, fotos, videos y cualquier otro material. Eres el único responsable del Contenido de usuario que publiques en o a través de Pinterest y de las consecuencias de hacerlo. Al publicar Contenido de usuario en o a través de Pinterest, declaras y garantizas que tienes todos los derechos, licencias, permisos y autorizaciones necesarios para hacerlo.
                Al publicar Contenido de usuario en o a través de Pinterest, nos otorgas una licencia mundial, no exclusiva, libre de regalías y transferible para usar, reproducir, distribuir, preparar trabajos derivados de, mostrar y ejecutar públicamente dicho Contenido de usuario en conexión con Pinterest y nuestro negocio (incluidos los negocios de nuestros subsidiarios y afiliados), incluyendo para promover y redistribuir parte o la totalidad de Pinterest (y trabajos derivados del mismo) en cualquier formato de medios y a través de cualquier canal de medios. Esta licencia termina cuando eliminas tu Contenido de usuario o tu cuenta, a menos que tu Contenido de usuario haya sido compartido con otros usuarios o haya sido guardado por otros usuarios.
                Al publicar Contenido de usuario en o a través de Pinterest, también nos otorgas el derecho de usar el nombre que proporcionas en tu cuenta de Pinterest en conexión con dicho Contenido de usuario.
                No tienes permitido publicar Contenido de usuario que:
                </p>
            </article> 
        </section>

        <aside class="md:col-span-1 md:sticky md:top-20 self-start border-l-2 border-gray-200 pl-6 text-sm">
            <h3 class="font-semibold mb-4 text-red-700">Tabla de contenidos</h3>
            <ul class="space-y-2">
                <li><a href="#introduccion" class="text-gray-700 hover:text-red-700">¡Gracias por usar Pinterest!</a></li>
                <li><a href="#Servicio" class="text-gray-700 hover:text-red-700">1. El Servicio</a></li>
                <li><a href="#uso" class="text-gray-700 hover:text-red-700">2. El uso de Pinterest</a></li>
                <li><a href="#contenido" class="text-gray-700 hover:text-red-700">3. Tu Contenido de usuario</a></li>
            </ul>
        </aside>

    </main>

    <footer class="bg-white text-gray-700 mt-10 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <svg style="width: 30px; height: 30px;" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
        <circle cx="16" cy="16" r="14" fill="white"></circle>
        <path d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 21.6801 5.38269 26.5702 10.2435 28.7655C10.25 28.6141 10.2573 28.4752 10.2636 28.3561C10.2722 28.1938 10.2788 28.0682 10.2788 27.9976C10.2788 27.5769 10.5649 25.4904 10.5649 25.4904L12.3149 18.3053C12.0457 17.8678 11.8438 16.9423 11.8438 16.2356C11.8438 12.9711 13.6611 12.2644 14.7716 12.2644C16.1851 12.2644 16.5048 13.7957 16.5048 14.9231C16.5048 15.5194 16.1955 16.4528 15.8772 17.4134C15.5398 18.4314 15.1923 19.4799 15.1923 20.1899C15.1923 21.5697 16.5553 22.2596 17.4976 22.2596C19.988 22.2596 22.2764 19.1298 22.2764 16C22.2764 12.8702 20.8125 9.08412 16.0168 9.08412C11.2212 9.08412 9.06731 12.7356 9.06731 15.5288C9.06731 17.4134 9.77404 18.7933 10.1274 19.0288C10.2284 19.1186 10.4 19.3957 10.2788 19.786C10.1577 20.1764 9.9367 21.0481 9.84135 21.4351C9.83013 21.5248 9.72356 21.6774 9.38702 21.5697C8.96635 21.4351 6.29087 19.7524 6.29087 15.5288C6.29087 11.3053 9.60577 6.39182 16.0168 6.39182C22.4279 6.39182 25.7091 10.6995 25.7091 16C25.7091 21.3005 21.4183 24.6827 18.1538 24.6827C15.5423 24.6827 14.5192 23.516 14.3341 22.9327L13.3413 26.7187C13.1069 27.3468 12.6696 28.4757 12.1304 29.4583C13.3594 29.8111 14.6576 30 16 30Z" fill="#ff0505ff"></path>
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
            <a href="{{ route('Condiciones') }}" class="hover:underline">Condiciones de servicio</a>
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