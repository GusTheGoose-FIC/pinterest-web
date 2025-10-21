<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liderazgo | Mi Empresa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

  <section class="py-16">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-4xl font-bold mb-12">Liderazgo</h2>

      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">
       
        <div class="flex flex-col items-center text-center">
          <img class="w-60 h-60 object-cover rounded-2xl mb-4" src="{{ asset('ImagenesLocales/bill.jpg') }}" alt="Foto de Bill Ready">
          <h3 class="text-lg font-semibold">Bill Ready</h3>
          <p class="text-sm text-gray-500">Director ejecutivo</p>
          <a href="#" class="text-sm text-gray-700 mt-2 inline-flex items-center hover:underline">
            Biografía completa <span class="ml-1">→</span>
          </a>
        </div>

       
        <div class="flex flex-col items-center text-center">
          <img class="w-60 h-60 object-cover rounded-2xl mb-4" src="{{ asset('ImagenesLocales/Julia.jpg') }}" alt="Foto de Julia Brau Donnelly">
          <h3 class="text-lg font-semibold">Julia Brau Donnelly</h3>
          <p class="text-sm text-gray-500">Directora financiera</p>
          <a href="#" class="text-sm text-gray-700 mt-2 inline-flex items-center hover:underline">
            Biografía completa <span class="ml-1">→</span>
          </a>
        </div>

    
        <div class="flex flex-col items-center text-center">
          <img class="w-60 h-60 object-cover rounded-2xl mb-4" src="{{ asset('ImagenesLocales/Malik.jpg') }}" alt="Foto de Malik Ducard">
          <h3 class="text-lg font-semibold">Malik Ducard</h3>
          <p class="text-sm text-gray-500">Responsable de contenido</p>
          <a href="#" class="text-sm text-gray-700 mt-2 inline-flex items-center hover:underline">
            Biografía completa <span class="ml-1">→</span>
          </a>
        </div>

     
        <div class="flex flex-col items-center text-center">
          <img class="w-60 h-60 object-cover rounded-2xl mb-4" src="{{ asset('ImagenesLocales/Matt.jpg') }}" alt="Foto de Matt Madrigal">
          <h3 class="text-lg font-semibold">Matt Madrigal</h3>
          <p class="text-sm text-gray-500">Director de tecnología</p>
          <a href="#" class="text-sm text-gray-700 mt-2 inline-flex items-center hover:underline">
            Biografía completa <span class="ml-1">→</span>
          </a>
        </div>

        <div class="flex flex-col items-center text-center">
          <img class="w-60 h-60 object-cover rounded-2xl mb-4" src="{{ asset('ImagenesLocales/Andrea.jpg') }}" alt="Foto de Andréa Mallard">
          <h3 class="text-lg font-semibold">Andréa Mallard</h3>
          <p class="text-sm text-gray-500">Directora de marketing y comunicaciones</p>
          <a href="#" class="text-sm text-gray-700 mt-2 inline-flex items-center hover:underline">
            Biografía completa <span class="ml-1">→</span>
          </a>
        </div>

        <div class="flex flex-col items-center text-center">
          <img class="w-60 h-60 object-cover rounded-2xl mb-4" src="{{ asset('ImagenesLocales/Doniel.jpg') }}" alt="Foto de Doniel Sutton">
          <h3 class="text-lg font-semibold">Doniel Sutton</h3>
          <p class="text-sm text-gray-500">Directora de personal</p>
          <a href="#" class="text-sm text-gray-700 mt-2 inline-flex items-center hover:underline">
            Biografía completa <span class="ml-1">→</span>
          </a>
        </div>
      </div>
    </div>
  </section>
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