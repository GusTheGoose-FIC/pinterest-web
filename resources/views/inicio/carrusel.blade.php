<section class="snap-start h-screen flex items-center justify-center">
    <div 
        x-data="carousel()" 
        x-init="init()" 
        class="w-full h-full flex flex-col justify-center items-center"
    >
        <!-- Títulos -->
        <div class="text-center mb-12">
            <h2 
                class="text-4xl font-bold text-gray-900"
                x-transition.opacity
            >
                Descubre tu próxima
            </h2>

            <h3 
                class="text-4xl font-bold text-green-700 mt-2 transition-all duration-700"
                x-text="slides[currentIndex].titulo"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-4"
            ></h3>
        </div>

        <!-- Imágenes -->
        <div class="flex justify-center gap-4 flex-wrap transition-all duration-700">
            <template x-for="(imagen, i) in slides[currentIndex].imagenes" :key="i">
                <img 
                    :src="imagen" 
                    class="w-48 h-64 object-cover rounded-2xl shadow-md transform hover:scale-105 transition-transform duration-500" 
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                />
            </template>
        </div>

        <!-- Indicadores -->
        <div class="flex justify-center mt-8 space-x-2">
            <template x-for="(slide, i) in slides" :key="i">
                <button 
                    @click="goToSlide(i)"
                    class="w-3 h-3 rounded-full transition-all duration-300"
                    :class="i === currentIndex ? 'bg-green-600 scale-110' : 'bg-gray-300 hover:bg-gray-400'">
                </button>
            </template>
        </div>

    </div>
</section>