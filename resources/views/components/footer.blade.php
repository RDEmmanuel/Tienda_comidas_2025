<footer class="w-full bg-red-500 text-gray-700 flex flex-col justify-between">
    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto w-full grid grid-cols-1 gap-8 px-6 py-10 text-center">
        
        <!-- row 1: Logo -->
        <div>
            <img src="{{ asset('storage/logos/bg-king-logo.png') }}" alt="BurgerKing Logo" class="mx-auto h-20 mb-3">
            <p class="mt-3 text-sm text-white font-semibold">
                Tu mejor opción para pedir comida rápida, deliciosa y al mejor precio.
            </p>
        </div>

        <!-- row 2: Redes -->
        <div>
            <h3 class="text-lg font-semibold text-white">Nuestras redes</h3>
            <div class="flex space-x-4 mt-3 justify-center text-white">
                <a href="#" class="hover:text-blue-500 text-3xl"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-blue-500 text-4xl"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        
        <!-- row 3: tel -->
        <div>
            <div class="flex space-x-4 mt-3 justify-center text-white">
                <p class="mt-1 text-sm text-white font-semibold">
                    Corrientes, 3400, Argentina
                </p>
                <span class="mx-2 text-white font-semibold">|</span>
                <p class="mt-1 text-sm text-white font-semibold">
                    Teléfono: 3794111222
                </p>
            </div>
        </div>
        
    </div>

    <!-- Línea inferior -->
    <div class="w-full bg-gray-200 py-4 text-center text-sm text-gray-600">
        © {{ date('Y') }} BurgerKing. Todos los derechos reservados.
    </div>
</footer>
