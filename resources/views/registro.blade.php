<x-guest-layout>
  <form method="POST" action="{{route('register')}}">
      @csrf

      <script src="https://cdn.tailwindcss.com"></script>
      <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
      <!-- apartado logo -->
      <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-sm text-center">
          <div class="flex justify-center mb-6">
              <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Pinterest-logo.png" alt="Logo" class="w-12">
              <h1 class="text-2xl font-semibold text-gray-800 mb-1">Te damos la bienvenida a</h1>
              <h2 class="text-3xl font-bold text-gray-900 mb-8">Pinterest</h2>
          </div>
      </div>

      {{--
      <div>
        <x-input-label for="name" :value="__('Nombre')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div> --}}
      <!-- CAMPO EMAIL -->
      <div class="mt-4 ">
          <x-input-label  for="email" :value="__('Correo Electronico')" />
          <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>
      <!-- CAMPO PASSWORD -->
      <div class="mt-4 "> 
        <x-input-label for="password" :value="__('Contraseña')"/>
        <x-text-input id="password"
          class="block mt-1 w-full" 
          type="password" 
          name="password" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <div class="mt-4">
        <x-input-label for="date" :value="__('Fecha de nacimiento')"/>
        <x-text-input id="password"
          class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-500 focus:ring-2 focus:ring-red-500 focus:outline-none"
          type="date"
          name="date"/>
      </div>

      {{-- CAMPO PASSWORD CONFIRMATION 
      <div class="mt-4">
              <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

              <x-text-input id="password_confirmation" class="block mt-1 w-full"
                              type="password"
                              name="password_confirmation" required autocomplete="new-password" />
              <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
      </div>--}}
      
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