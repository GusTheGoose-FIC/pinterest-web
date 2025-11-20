<x-guest-layout>
  <form method="POST" action="{{route('register')}}">
      @csrf
      <script src="https://cdn.tailwindcss.com"></script>
      <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

      <!-- apartado logo -->
      <div class="p-4 w-full flex flex-col items-center justify-center gap-4">
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Pinterest-logo.png" alt="Logotipo pinterest" class="w-8">
          <div class="flex flex-col text-center justify-center">
              <div>
                <h1 class="text-2xl font-semibold text-gray-800 mb-1">Bienvenido a Pinterest</h1>
                <h4>Encuentra nuevas ideas para probar</h4>
              </div>
          </div>
      </div>

      <!-- CAMPO EMAIL -->
      <div class="mt-4 flex flex-col">
        <div class="flex-row">
          <x-input-label  for="email" :value="__('Correo')" />
          <x-text-input id="email" class="block mt-1 w-3xs rounded-4xl" type="email" name="email" :value="old('email')" required autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
      </div>
      <!-- CAMPO PASSWORD -->
      <div class="mt-4 "> 
        <x-input-label for="password" :value="__('Contraseña')"/>
        <x-text-input id="password"
          class="block mt-1 w-3xs rounded-lg" 
          type="password" 
          name="password" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!--Campo fecha nacimiento-->
      <div class="mt-4">
        <x-input-label for="date" :value="__('Fecha de nacimiento')"/>
        <x-text-input id="date"
          class="w-3xs border border-gray-300 rounded-xl px-4 py-3 text-gray-500 focus:ring-2 focus:ring-red-500 focus:outline-none"
          type="date"
          name="date" required />
        <x-input-error :messages="$errors->get('date')" class="mt-2" />
      </div> 
      <div class="flex items-center justify-end mt-4">
          <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('Login') }}">
              {{ __('Ya tienes una cuenta?') }}
          </a>

          <x-primary-button class="ms-4">
              {{ __('Registrarse') }}
          </x-primary-button>
      </div>
  </form>
</x-guest-layout>