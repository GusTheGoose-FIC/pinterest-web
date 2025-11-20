<section class="parallax min-h-screen flex items-center bg-[#FAF48B]">
  <div class="w-full grid grid-cols-1 md:grid-cols-2 px-10">

    <!-- TEXTO -->
    <div class="flex flex-col justify-center text-left mb-10 md:mb-0">
      <h1 class="text-5xl font-bold text-[#00665E] mb-4">
        Guarda las ideas que te gusten
      </h1>
      <p class="text-lg text-gray-900 mb-6">
        Recopila tus favoritos para volver a verlos después.
      </p>
      <button class="bg-[#C00] text-white px-6 py-2 rounded-full hover:bg-red-900 transition">
        Explorar
      </button>
    </div>

    <!-- IMÁGENES -->
    <div class="flex flex-wrap gap-4 justify-center">
      <img src="{{ asset('ImagenesInicio/home1.jpg') }}" class="w-64 h-64 rounded-3xl object-cover shadow-xl">
      <img src="{{ asset('ImagenesInicio/home2.jpg') }}" class="w-40 h-40 rounded-3xl object-cover shadow-xl">
      <img src="{{ asset('ImagenesInicio/home3.jpg') }}" class="w-40 h-40 rounded-3xl object-cover shadow-xl">
      <img src="{{ asset('ImagenesInicio/home4.jpg') }}" class="w-40 h-40 rounded-3xl object-cover shadow-xl">
    </div>

  </div>
</section>
