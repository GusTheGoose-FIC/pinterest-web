<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinterest</title>

    @vite(['resources/css/app.css'])
</head>
<body>
        <nav class="relative p-2 bg-amber-800 ">
            <div class="grid grid-cols-3 m-2 p-2 ">
                <div class="flex flex-row p-2 bg-blue-700">
                    <svg class="icono-pequeno " viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>Pinterest-color</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Color-" transform="translate(-300.000000, -260.000000)" fill="#CC2127"> <path d="M324.001411,260 C310.747575,260 300,270.744752 300,284.001411 C300,293.826072 305.910037,302.270594 314.368672,305.982007 C314.300935,304.308344 314.357382,302.293173 314.78356,300.469924 C315.246428,298.522491 317.871229,287.393897 317.871229,287.393897 C317.871229,287.393897 317.106368,285.861351 317.106368,283.59499 C317.106368,280.038808 319.169518,277.38296 321.73505,277.38296 C323.91674,277.38296 324.972306,279.022755 324.972306,280.987123 C324.972306,283.180102 323.572411,286.462515 322.852708,289.502205 C322.251543,292.050803 324.128418,294.125243 326.640325,294.125243 C331.187158,294.125243 334.249427,288.285765 334.249427,281.36532 C334.249427,276.10725 330.707356,272.170048 324.263891,272.170048 C316.985006,272.170048 312.449462,277.59746 312.449462,283.659905 C312.449462,285.754101 313.064738,287.227377 314.029988,288.367613 C314.475922,288.895396 314.535191,289.104251 314.374316,289.708238 C314.261422,290.145705 313.996119,291.21256 313.886047,291.633092 C313.725172,292.239901 313.23408,292.460046 312.686541,292.234256 C309.330746,290.865408 307.769977,287.193509 307.769977,283.064385 C307.769977,276.248368 313.519139,268.069148 324.921503,268.069148 C334.085729,268.069148 340.117128,274.704533 340.117128,281.819721 C340.117128,291.235138 334.884459,298.268478 327.165285,298.268478 C324.577174,298.268478 322.138649,296.868584 321.303228,295.279591 C321.303228,295.279591 319.908979,300.808608 319.615452,301.875463 C319.107426,303.724114 318.111131,305.575587 317.199506,307.014994 C319.358617,307.652849 321.63909,308 324.001411,308 C337.255248,308 348,297.255248 348,284.001411 C348,270.744752 337.255248,260 324.001411,260" id="Pinterest"> </path> </g> </g> </g></svg>
                    <button type="button" class=" ">Feed de inicio</button>
                    <svg class="icono-pequeno" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M96 160C96 142.3 110.3 128 128 128L512 128C529.7 128 544 142.3 544 160C544 177.7 529.7 192 512 192L128 192C110.3 192 96 177.7 96 160zM96 320C96 302.3 110.3 288 128 288L512 288C529.7 288 544 302.3 544 320C544 337.7 529.7 352 512 352L128 352C110.3 352 96 337.7 96 320zM544 480C544 497.7 529.7 512 512 512L128 512C110.3 512 96 497.7 96 480C96 462.3 110.3 448 128 448L512 448C529.7 448 544 462.3 544 480z"/></svg>
                </div>

                <div >
                    
                </div>
                <div  class="flex items-center justify-end gap-4">
                    <div id="perfil-empresa" >
                        <svg class="icono-pequeno" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 248a120 120 0 1 0 0-240 120 120 0 1 0 0 240zm-29.7 56C95.8 304 16 383.8 16 482.3 16 498.7 29.3 512 45.7 512l356.6 0c16.4 0 29.7-13.3 29.7-29.7 0-98.5-79.8-178.3-178.3-178.3l-59.4 0z"/></svg>
                    </div>
                    <div id="buscador" >
                        <svg class="icono-pequeno" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z"/></svg>
                    </div>
                    <div id="notificacion">
                        <svg class="icono-pequeno" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 0c-17.7 0-32 14.3-32 32l0 3.2C119 50 64 114.6 64 192l0 21.7c0 48.1-16.4 94.8-46.4 132.4L7.8 358.3C2.7 364.6 0 372.4 0 380.5 0 400.1 15.9 416 35.5 416l376.9 0c19.6 0 35.5-15.9 35.5-35.5 0-8.1-2.7-15.9-7.8-22.2l-9.8-12.2C400.4 308.5 384 261.8 384 213.7l0-21.7c0-77.4-55-142-128-156.8l0-3.2c0-17.7-14.3-32-32-32zM162 464c7.1 27.6 32.2 48 62 48s54.9-20.4 62-48l-124 0z"/></svg>
                    </div>

                    <div id="mensajes">
                        <svg class="icono-pequeno" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 352L0 128C0 75 43 32 96 32l320 0c53 0 96 43 96 96l0 224c0 53-43 96-96 96l-120 0c-5.2 0-10.2 1.7-14.4 4.8L166.4 539.2c-4.2 3.1-9.2 4.8-14.4 4.8-13.3 0-24-10.7-24-24l0-72-32 0c-53 0-96-43-96-96z"/></svg>
                    </div>
                    <div id="tu-perfil">
                        
                        <svg class="icono-pequeno" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 248a120 120 0 1 0 0-240 120 120 0 1 0 0 240zm-29.7 56C95.8 304 16 383.8 16 482.3 16 498.7 29.3 512 45.7 512l356.6 0c16.4 0 29.7-13.3 29.7-29.7 0-98.5-79.8-178.3-178.3-178.3l-59.4 0z"/></svg>
                    </div>
                    <div id="mas-opciones">
                        <svg class="icono-pequeno" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 10L12 15L17 10" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    <div>
                </div>
            </div>
        </nav>
    
</body>
</html>