<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pinterest - México</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .submenu-enter {
      opacity: 0;
      transform: translateY(-8px);
      transition: all 0.25s ease;
    }
    .group:hover .submenu-enter {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>

<body class="bg-white">
  <nav class="flex items-center justify-between px-6 py-3 shadow-sm">

    <div class="flex items-center space-x-2">
      <svg style="width: 30px; height: 30px;" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
        <circle cx="16" cy="16" r="14" fill="white"></circle>
        <path d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 21.6801 5.38269 26.5702 10.2435 28.7655C10.25 28.6141 10.2573 28.4752 10.2636 28.3561C10.2722 28.1938 10.2788 28.0682 10.2788 27.9976C10.2788 27.5769 10.5649 25.4904 10.5649 25.4904L12.3149 18.3053C12.0457 17.8678 11.8438 16.9423 11.8438 16.2356C11.8438 12.9711 13.6611 12.2644 14.7716 12.2644C16.1851 12.2644 16.5048 13.7957 16.5048 14.9231C16.5048 15.5194 16.1955 16.4528 15.8772 17.4134C15.5398 18.4314 15.1923 19.4799 15.1923 20.1899C15.1923 21.5697 16.5553 22.2596 17.4976 22.2596C19.988 22.2596 22.2764 19.1298 22.2764 16C22.2764 12.8702 20.8125 9.08412 16.0168 9.08412C11.2212 9.08412 9.06731 12.7356 9.06731 15.5288C9.06731 17.4134 9.77404 18.7933 10.1274 19.0288C10.2284 19.1186 10.4 19.3957 10.2788 19.786C10.1577 20.1764 9.9367 21.0481 9.84135 21.4351C9.83013 21.5248 9.72356 21.6774 9.38702 21.5697C8.96635 21.4351 6.29087 19.7524 6.29087 15.5288C6.29087 11.3053 9.60577 6.39182 16.0168 6.39182C22.4279 6.39182 25.7091 10.6995 25.7091 16C25.7091 21.3005 21.4183 24.6827 18.1538 24.6827C15.5423 24.6827 14.5192 23.516 14.3341 22.9327L13.3413 26.7187C13.1069 27.3468 12.6696 28.4757 12.1304 29.4583C13.3594 29.8111 14.6576 30 16 30Z" fill="#000000ff"></path>
      </svg>
      <h1 class="text-[#000000ff] font-bold text-lg">Newsroom</h1>
    </div>

    <div class="flex items-center space-x-6 text-blue-700 font-medium relative">

      <div class="relative group">
        <a href="#" 
           class="inline-block px-2 py-1 transition duration-200 ease-in-out 
                  group-hover:text-[#E60023] group-hover:underline">
          Compañía
        </a>

        <div class="submenucompañia-enter absolute top-full left-0 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-44 z-10 border border-gray-100">
          <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">About</a>
          <a href="{{ route('Liderazgo') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Leaders</a>
        </div>
      </div>

 <div class="flex items-center space-x-6 text-blue-700 font-medium relative">
      <div class="relative group">
        <a href="#" 
           class="inline-block px-2 py-1 transition duration-200 ease-in-out 
                  group-hover:text-[#E60023] group-hover:underline">
          Impacto
        </a>
          <div class="submenuImpacto-enter absolute top-full left-0 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-44 z-10 border border-gray-100">
          <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Resumen de impacto</a>
          <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Construyendo una plataforma Positiva</a>
                    <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Priorizar alas personas</a>
          <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Protegiendo nuestro planeta</a>
          <a href="#" class="px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#E60023] transition-colors duration-150">Progreso con</a>
        </div>
      </div>
      <a href="#" class="hover:underline hover:text-[#E60023] transition-colors duration-150">Recursos</a>
      <a href="#" class="hover:underline hover:text-[#E60023] transition-colors duration-150">Contacto</a>

    </div>

  </nav>
   <main class="flex-grow">
    <section class="text-center py-20 bg-white">

    <h1 class="text-4xl md:text-5xl font-bold mb-4">
        Inspírate <span class="inline-block">📸</span><br>
        Luego, da los primeros pasos ✅<br>
        Todo en <span class="text-red-600 font-extrabold inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0C5.37 0 0 5.37 0 12c0 4.93 3.02 9.15 7.35 10.95-.1-.93-.2-2.35.04-3.37.22-.93 1.45-5.92 1.45-5.92s-.37-.74-.37-1.83c0-1.72 1-3.01 2.25-3.01 1.06 0 1.58.8 1.58 1.76 0 1.07-.68 2.67-1.03 4.15-.29 1.24.6 2.26 1.77 2.26 2.12 0 3.75-2.23 3.75-5.44 0-2.84-2.04-4.83-4.96-4.83-3.38 0-5.36 2.53-5.36 5.14 0 1.02.4 2.12.9 2.71.1.12.12.22.09.34-.1.37-.33 1.17-.38 1.34-.06.2-.19.24-.44.14-1.63-.63-2.65-2.58-2.65-4.65 0-3.38 2.47-6.5 7.13-6.5 3.73 0 6.63 2.66 6.63 6.22 0 3.7-2.33 6.68-5.56 6.68-1.09 0-2.12-.57-2.47-1.24l-.67 2.56c-.24.92-.9 2.08-1.33 2.79.99.31 2.04.47 3.14.47 6.63 0 12-5.37 12-12S18.63 0 12 0z"/>
            </svg> Pinterest
        </span>
    </h1>

   
    <div class="max-w-2xl mx-auto mt-10 text-gray-800 text-lg leading-relaxed">
        <h2 class="text-sm font-semibold uppercase text-gray-600 mb-2">Acerca de Pinterest</h2>
        <p>
            Pinterest es una plataforma de búsqueda y descubrimiento visual donde las personas encuentran inspiración,
            seleccionan ideas y compran productos, todo en un lugar positivo en línea. Pinterest, con sede en San Francisco,
            se lanzó en 2010 y tiene más de <strong>500 millones de usuarios mensuales activos</strong> en todo el mundo.
        </p>

        <a href="{{ route('inicio') }}" class="mt-6 inline-block bg-black text-white px-6 py-2 rounded-full font-semibold hover:bg-gray-800 transition">
            Visitar Pinterest
        </a>
    </div>

    
    <div class="mt-20 flex flex-col md:flex-row justify-center gap-6 px-4">
        <div class="bg-gray-100 rounded-2xl p-6 w-full md:w-1/4">
            <h3 class="font-bold text-lg">578 millones</h3>
            <p class="text-sm text-gray-600">de usuarios activos cada mes</p>
        </div>

        <div class="bg-gray-100 rounded-2xl p-6 w-full md:w-1/4">
            <h3 class="font-bold text-lg">1,500 millones</h3>
            <p class="text-sm text-gray-600">de Pines guardados cada semana</p>
        </div>

        <div class="bg-gray-100 rounded-2xl p-6 w-full md:w-1/4">
            <h3 class="font-bold text-lg">Más del 50%</h3>
            <p class="text-sm text-gray-600">
                de los usuarios piensan en Pinterest como un lugar para comprar
            </p>
        </div>
    </div>
</section>
  </main>
<footer class="bg-white border-t mt-20 py-10">
      <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-start md:items-center space-y-6 md:space-y-0">

        <div class="flex flex-col space-y-3">
          <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Pinterest-logo.png" alt="Pinterest logo" class="w-20">
          <select class="border rounded px-3 py-1 text-sm">
            <option>Español</option>
            <option>English</option>
          </select>
        </div>

        <div class="flex flex-wrap gap-10 text-sm">
          <div>
            <h4 class="font-semibold mb-2">Empresa</h4>
            <ul class="space-y-1">
              <li><a href="#" class="hover:underline">Acerca de pinterest</a></li>
              <li><a href="#" class="hover:underline">Sala de prensa</a></li>
              <li><a href="#" class="hover:underline">Empleos</a></li>
              <li><a href="#" class="hover:underline">Inversores</a></li>
            </ul>
          </div>
          <div>
            <h4 class="font-semibold mb-2">Más de Nosotros</h4>
            <ul class="space-y-1">
              <li><a href="#" class="hover:underline">Centro de asistencia</a></li>
              <li><a href="#" class="hover:underline">Empresas</a></li>
              <li><a href="#" class="hover:underline">Creadores</a></li>
              <li><a href="#" class="hover:underline">Desarrolladores</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="mt-10 text-center text-xs text-gray-500 border-t pt-4">
        © 2025 Ejemplo | Condiciones de servicio · Política de privacidad · Política de cookies
      </div>
    </footer>

</body>
</html>