<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pinterest - México</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <script>
document.addEventListener("DOMContentLoaded", () => {

    let currentSection = 0;

    const sections = document.querySelectorAll("section");

    function updateSections() {
        sections.forEach((sec, i) => {
            sec.classList.remove("active", "left");
            if (i === currentSection) {
                sec.classList.add("active");
            } else if (i < currentSection) {
                sec.classList.add("left");
            }
        });
    }

    updateSections();

    document.addEventListener("keydown", (e) => {

        if (e.key === "ArrowDown" || e.key === "ArrowRight") {
            if (currentSection < sections.length - 1) currentSection++;
        } 
        
        if (e.key === "ArrowUp" || e.key === "ArrowLeft") {
            if (currentSection > 0) currentSection--;
        }

        updateSections();
    });

});
</script>

  <script>
function carousel() {
    return {
        currentIndex: 0,
        slides: [
            {
                titulo: 'actividad para niños',
                imagenes: [
                    '{{ asset('ImagenesInicio/niños1.jpg') }}',
                    '{{ asset('ImagenesInicio/niños2.jpg') }}',
                    '{{ asset('ImagenesInicio/niños3.jpg') }}',
                    '{{ asset('ImagenesInicio/niños4.jpg') }}',
                ]
            },
            {
                titulo: 'aventura familiar',
                imagenes: [
                    '{{ asset('ImagenesInicio/familia1.jpeg') }}',
                    '{{ asset('ImagenesInicio/familia2.jpeg') }}',
                    '{{ asset('ImagenesInicio/familia3.jpeg') }}',
                    '{{ asset('ImagenesInicio/familia4.jpg') }}',
                ]
            },
            {
                titulo: 'diversión acuática',
                imagenes: [
                    '{{ asset('ImagenesInicio/piscina1.jpg') }}',
                    '{{ asset('ImagenesInicio/piscina2.jpg') }}',
                    '{{ asset('ImagenesInicio/piscina3.jpg') }}',
                    '{{ asset('ImagenesInicio/piscina4.jpg') }}',
                ]
            },
        ],
        goToSlide(i) {
            this.currentIndex = i;
        },
        init() {
            setInterval(() => {
                this.currentIndex = (this.currentIndex + 1) % this.slides.length;
            }, 6000);
        }
    }
}
</script>
</head>
<body class="bg-white flex flex-col min-h-screen overflow-hidden">
  <nav class="flex items-center justify-between px-6 py-3 shadow-sm">
    <div class="flex items-center space-x-2 overflow-hidden">
      <svg style="width: 30px; height: 30px;" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
        <circle cx="16" cy="16" r="14" fill="white"></circle>
        <path d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 21.6801 5.38269 26.5702 10.2435 28.7655C10.25 28.6141 10.2573 28.4752 10.2636 28.3561C10.2722 28.1938 10.2788 28.0682 10.2788 27.9976C10.2788 27.5769 10.5649 25.4904 10.5649 25.4904L12.3149 18.3053C12.0457 17.8678 11.8438 16.9423 11.8438 16.2356C11.8438 12.9711 13.6611 12.2644 14.7716 12.2644C16.1851 12.2644 16.5048 13.7957 16.5048 14.9231C16.5048 15.5194 16.1955 16.4528 15.8772 17.4134C15.5398 18.4314 15.1923 19.4799 15.1923 20.1899C15.1923 21.5697 16.5553 22.2596 17.4976 22.2596C19.988 22.2596 22.2764 19.1298 22.2764 16C22.2764 12.8702 20.8125 9.08412 16.0168 9.08412C11.2212 9.08412 9.06731 12.7356 9.06731 15.5288C9.06731 17.4134 9.77404 18.7933 10.1274 19.0288C10.2284 19.1186 10.4 19.3957 10.2788 19.786C10.1577 20.1764 9.9367 21.0481 9.84135 21.4351C9.83013 21.5248 9.72356 21.6774 9.38702 21.5697C8.96635 21.4351 6.29087 19.7524 6.29087 15.5288C6.29087 11.3053 9.60577 6.39182 16.0168 6.39182C22.4279 6.39182 25.7091 10.6995 25.7091 16C25.7091 21.3005 21.4183 24.6827 18.1538 24.6827C15.5423 24.6827 14.5192 23.516 14.3341 22.9327L13.3413 26.7187C13.1069 27.3468 12.6696 28.4757 12.1304 29.4583C13.3594 29.8111 14.6576 30 16 30Z" fill="#E60023"></path>
      </svg>
      <h1 class="text-[#E60023] font-bold text-lg">Pinterest</h1>
      <a href="#" class="ml-4 font-semibold text-black hover:underline">Explore</a>
    </div>

    <div class="flex items-center space-x-6 text-blue-700 font-medium">
      <a href="{{ route('Información') }}" class="hover:underline">Informacion</a>
      <a href="{{ route('empresa') }}" class="hover:underline">Empresas</a>
      <a href="{{ route('Create') }}" class="hover:underline">Crear</a>
      <a href="{{ route('News') }}" class="hover:underline">Noticias</a>
    </div>

    <div class="flex items-center space-x-3">
      <button onclick="window.location.href='{{ route('Login') }}'"
        class="bg-[#E60023] text-white font-semibold px-4 py-2 rounded-full hover:bg-[#ad0019] transition">
        Log in
      </button>
      <button onclick="window.location.href='{{ route('registro') }}'"
      class="bg-gray-100 text-black font-semibold px-4 py-2 rounded-full hover:bg-gray-200 transition">
        Sign up
      </button>
    </div>
  </nav>

<main id="scrollContainer"
    class="flex-grow snap-y snap-mandatory h-screen overflow-y-scroll overflow-x-hidden">

    <section class="snap-start h-screen overflow-hidden">
        @include('inicio.carrusel')
    </section>

  
    <section class="snap-start h-screen overflow-hidden">
        @include('inicio.buscaIdea')
    </section>

 
    <section class="snap-start h-screen overflow-hidden">
        @include('inicio.guardaIdeas')
    </section>


    <section class="snap-start h-screen overflow-hidden">
        @include('inicio.crealo')
    </section>

</main>
  <footer class="w-full border-t border-gray-200 bg-white py-4">
    <div class="max-w-6xl mx-auto px-4 flex flex-wrap justify-center text-sm text-gray-600 space-x-4">
      <a href="{{ route('Condiciones') }}" class="text-blue-600 hover:underline">Condiciones de servicio</a>
      <a href="{{ route('PoliticasPrivacidad') }}" class="text-blue-600 hover:underline">Política de privacidad</a>
      <a href="{{ route('Ayuda') }}" class="text-blue-600 hover:underline">Ayuda</a>
      <a href="#" class="text-blue-600 hover:underline">Movil</a>
      <a href="#" class="text-blue-600 hover:underline">Usuarios</a>
      <a href="#" class="text-blue-600 hover:underline">Colecciones</a>
      <a href="#" class="text-blue-600 hover:underline">Compras</a>
      <a href="#" class="text-blue-600 hover:underline">Explorar</a>
      <a href="{{ route('AvisosnoUsuario') }}" class="text-blue-600 hover:underline">Aviso de no usuario</a>
    </div>
  </footer>

</body>
</html>
