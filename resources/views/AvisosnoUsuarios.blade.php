<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Políticas </title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="font-sans text-gray-800">
    <nav class="fixed top-0 left-0 w-full bg-green-200 shadow z-50">
      <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-3">
        <div class="flex items-center space-x-2">
          <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Pinterest-logo.png" alt="Logo" class="w-6 h-6">
          <span class="font-semibold text-lg">Políticas</span>
        </div>
        <ul class="hidden md:flex space-x-6 text-sm font-medium">
          <li><a href="{{ route('Condiciones') }}" class="hover:underline">Condiciones</a></li>
          <li><a href="{{ route('PoliticasPrivacidad') }}" class="hover:underline">Privacidad</a></li>
          <li><a href="{{ route('Comunidad') }}" class="hover:underline">Comunidad</a></li>
          <li><a href="{{ route('propiedadIntelectual') }}" class="hover:underline">Propiedad intelectual</a></li>
          <li><a href="{{ route('Transparencia') }}" class="hover:underline">Transparencia</a></li>
          <li><a href="{{ route('Mas') }}" class="hover:underline">Más</a></li>
        </ul>
      </div>
    </nav>
  <main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">
    <div class="md:col-span-2">
        <h1 class="text-4xl font-bold text-rose-700 mb-6">Avisos para no usuarios</h1>

        <p class="text-gray-700 mb-4">
            Actualizaremos la Política de privacidad, que entrará en vigor el 30 de abril de 2025.
            Puedes ver <a href="#" class="text-rose-700 font-semibold hover:underline">aquí</a> la versión actualizada.
        </p>

        <h2 class="text-2xl font-semibold text-rose-700 mt-8 mb-3">Declaración de Privacidad de California</h2>
        <p class="text-gray-700 mb-4">
            <strong>Residentes de California:</strong> véase la Declaración de Privacidad de California y el
            <a href="#" class="text-rose-700 font-semibold hover:underline">Aviso de recopilación de información aquí.</a>
        </p>

        <h2 class="text-2xl font-semibold text-rose-700 mt-8 mb-3">Resumen de cambios</h2>
        <p class="text-gray-700 mb-4">
            Trabajamos arduamente para que el uso de los datos personales sea transparente y
            para que tus derechos y opciones sean fáciles de entender. Agregamos más detalles
            sobre los datos personales que recopilamos y cómo podemos compartirlos.
        </p>

        <h2 class="text-2xl font-semibold text-rose-700 mt-8 mb-3">¡Gracias por usar Pinterest!</h2>
        <p class="text-gray-700 mb-4">
            Nuestra misión es inspirar a las personas para que creen la vida que desean.
            Para ello, te mostramos contenido personalizado y anuncios que pensamos que te
            interesarán según la información que recopilamos de ti y de otras partes.
        </p>
    </div>
    <aside class="hidden md:block border-l border-gray-300 pl-6">
        <h3 class="text-lg font-semibold text-rose-700 mb-4">Tabla de contenidos</h3>
        <ul class="space-y-3 text-sm">
            <li><a href="#" class="hover:underline text-gray-700">Declaración de Privacidad de California</a></li>
            <li><a href="#" class="hover:underline text-gray-700">Resumen de cambios</a></li>
            <li><a href="#" class="hover:underline text-gray-700">¡Gracias por usar Pinterest!</a></li>
            <li><a href="#" class="hover:underline text-gray-700">Alcance de la Política de privacidad</a></li>
            <li><a href="#" class="hover:underline text-gray-700">Recopilamos información de varias maneras</a></li>
            <li><a href="#" class="hover:underline text-gray-700">Cómo usamos la información</a></li>
            <li><a href="#" class="hover:underline text-gray-700">Tus derechos y opciones</a></li>
        </ul>
    </aside>
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