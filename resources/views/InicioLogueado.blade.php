<nav class="flex items-center justify-between px-4 py-2 bg-white shadow">
   
    <div class="flex items-center gap-4">
        <a href="/" class="text-red-600 font-bold text-2xl">P</a>
        <input type="text"
            class="w-96 py-2 px-4 rounded-full bg-gray-200 outline-none"
            placeholder="Buscar" />
    </div>

    
    <div class="relative" x-data="{ open:false }">
       
        <button @click="open = !open"
            class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center">
            {{ strtoupper(Auth::user()->name[0] ?? 'U') }}
        </button>

        <!-- Dropdown -->
        <div x-show="open" @click.outside="open=false"
            class="absolute right-0 mt-2 w-64 bg-white shadow-lg border rounded-xl p-3">

            <!-- Usuario -->
            <div class="flex gap-3 items-center p-2 border rounded-xl hover:bg-gray-50 cursor-pointer">
                <div class="w-10 h-10 rounded-full bg-green-600 text-white flex justify-center items-center">
                    {{ strtoupper(Auth::user()->name[0] ?? 'U') }}
                </div>
                <div>
                    <p class="font-bold text-sm">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <hr class="my-2" />

            <ul class="text-sm">
                <li class="py-2 px-3 rounded-lg hover:bg-gray-100 cursor-pointer">
                    Convertir en cuenta empresarial
                </li>
                <li class="py-2 px-3 rounded-lg hover:bg-gray-100 cursor-pointer">
                    Añadir otra cuenta
                </li>
            </ul>

            <hr class="my-2" />

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full py-2 px-3 rounded-lg hover:bg-gray-100 text-left text-red-500">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</nav>