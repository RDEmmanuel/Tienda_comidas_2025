<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($productos as $producto)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col">
                <!-- Imagen -->
                @if ($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                         alt="{{ $producto->nombre }}"
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-500 italic">
                        Sin imagen
                    </div>
                @endif

                <!-- Contenido -->
                <div class="p-4 flex-1 flex flex-col text-center">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                        {{ $producto->nombre }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm flex-1 italic">
                        {{ \Illuminate\Support\Str::limit($producto->descripcion, 100) }}
                    </p>
                    <span class="text-4xl font-bold text-gray-900 dark:text-gray-200 mt-2">
                        ${{ number_format($producto->precio_venta, 0, ',', '.') }}
                    </span>
                    <div class="mt-2 flex justify-center items-center">
                        <!-- Abrir modal con las opciones -->
                        <button wire:click="openModal({{ $producto->id }})"
                                class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-full shadow">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    @if ($showModal && $selectedProduct)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-50" wire:click="closeModal"></div>

            <!-- Modal box -->
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-md w-full mx-4 z-10">
                <!-- Botón X en la esquina superior derecha -->
                <button wire:click="closeModal"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 dark:hover:text-white text-2xl font-bold focus:outline-none">
                    &times;
                </button>
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 border-b pb-4">Nuestras opciones</h3>

                    <div class="mt-4 flex justify-between">
                        <p class="font-medium text-gray-700 dark:text-gray-200">{{ $selectedProduct->nombre }}</p>
                        <p class="text-gray-600 dark:text-gray-400">
                            <span class="font-bold">${{ number_format($selectedProduct->precio_venta, 2, ',', '.') }}</span>
                        </p>
                    </div>

                    <div class="flex justify-center gap-2 mt-4">
                        <!-- Elimina el botón Cancelar -->
                        <button wire:click="confirmAdd"
                                class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-full">
                            <i class="fa-solid fa-cart-plus"></i> Agregar al carrito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
