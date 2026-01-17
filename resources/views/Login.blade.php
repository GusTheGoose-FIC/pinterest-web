<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pinterest - México</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const pwd = document.getElementById('password');
    const btn = document.getElementById('togglePassword');

    btn.addEventListener('click', () => {
      const isHidden = pwd.type === 'password';
      pwd.type = isHidden ? 'text' : 'password';
      btn.textContent = isHidden ? '🙈' : '👁️';
    });
  });
</script>
</head>
<body class="bg-gray-50 flex justify-center items-center h-screen">
    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-sm text-center">
        <div class="flex justify-center mb-6">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Pinterest-logo.png" alt="Logo" class="w-12">
        </div>

        <h1 class="text-2xl font-semibold text-gray-800 mb-1">Te damos la bienvenida a</h1>
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Pinterest</h2>
        <form action="{{ route('login') }}" method="POST" class="space-y-4">

            @csrf
            <div class="mt-4">
              <x-input-label  for="email" :value="__('Correo Electronico')" />
              <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4 "> 
              <x-input-label for="password" :value="__('Contraseña')"/>
              <x-text-input id="password"
                class="block mt-1 w-full" 
                type="password" 
                name="password" required autocomplete="new-password" />
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
              <button id="togglePassword" type="button" aria-label="Mostrar contraseña" 
              class="absolute right-4 top-3 text-gray-400 hover:text-gray-700 focus:outline-none">👁️</button>
            </div>

            <div class="text-right">
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
            </div>

            <x-primary-button class="ms-3 w-full bg-red-600 text-white rounded-xl py-3 font-semibold hover:bg-red-700 transition">
                {{ __('Log in') }}
            </x-primary-button>
        </form>

        <div class="my-4 text-gray-400">o</div>

        <button class="w-full border border-gray-300 rounded-xl py-3 flex items-center justify-center gap-2 hover:bg-gray-50">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
            Continuar con Google
        </button>

        <div class="text-center Login mt-4">
          <a href="{{ route('registro') }}" class="text-sm text-blue-600 hover:underline">¿No tienes cuenta registrate aqui?</a>
        </div>
    </div>
</body>
</html>