<div class="flex flex-col">

    @if (count($items) > 0)

        <div class="flex-1 overflow-y-auto space-y-4">

            {{-- Grid de productos --}}
            @foreach ($items as $item)
                <div class="grid grid-cols-2 gap-4 items-center px-2 py-8 border-b">

                    {{-- Nombre del producto --}}
                    <div class="text-gray-800 dark:text-gray-100 font-semibold text-2xl">
                        {{ $item['nombre'] }} <span class="text-lg font-normal text-gray-600 dark:text-gray-300 italic">x{{ $item['cantidad'] }}</span>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-normal">
                            ${{ number_format($item['precio'], 2) }}
                        </div>
                    </div>

                    {{-- Cantidad --}}
                    <!-- <div class="flex justify-center">
                        <x-text-input 
                            id="cantidad-{{ $item['id'] }}"
                            type="number" 
                            min="1"
                            class="w-20 text-center"
                            value="{{ $item['cantidad'] }}"
                            wire:change="actualizarCantidad({{ $item['id'] }}, $event.target.value)" 
                        />
                    </div> -->

                    {{-- Precio total y eliminar --}}
                    <div class="flex justify-end items-center space-x-4">
                        <span class="font-semibold text-green-500 dark:text-green-500 text-xl">
                            ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                        </span>
                        <button wire:click="eliminarProducto({{ $item['id'] }})" class="text-red-600 hover:text-red-800 text-xl font-bold">✖</button>
                    </div>

                </div>
            @endforeach

            {{-- Dirección de envío --}}
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3">
                <div class="col-span-1 lg:col-start-2">
                    <x-input-label for="direccion_envio" :value="__('Dirección de envío')" class="dark:text-gray-300" />
                    <x-text-input 
                        id="direccion_envio" 
                        type="text" 
                        class="block mt-2 w-full"
                        wire:model.defer="direccion_envio"
                        placeholder="Ej: Calle 1234"
                    />
                    <x-input-error :messages="$errors->get('direccion_envio')" class="mt-2 dark:text-red-400" />
                </div>
            </div> 

            {{-- Total --}}
            <div class="mt-6 text-center text-2xl font-bold text-gray-800 dark:text-gray-100">
                Total: ${{ number_format($total, 2) }}
            </div>
        </div>

        {{-- Botón confirmar fijo al fondo --}}
        <div class=" flex justify-center sticky bottom-0 py-4">
            <button wire:click="confirmar" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                Confirmar pedido
            </button>
        </div>

    @else
        <p class="text-gray-500 dark:text-gray-400 text-xl">El carrito está vacío.</p>
    @endif

</div>
