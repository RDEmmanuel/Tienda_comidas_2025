<div class="flex flex-col">

    @if (count($items) > 0)

        <div class="flex-1 overflow-y-auto space-y-4 p-1">

            {{-- Grid de productos --}}
            @foreach ($items as $item)
                <div class="grid grid-cols-2 gap-4 items-center px-2 py-8 border-b">

                    {{-- Nombre del producto --}}
                    <div class="text-gray-800 font-semibold text-2xl">
                        {{ $item['nombre'] }} <span class="text-lg font-normal text-gray-600 italic">x{{ $item['cantidad'] }}</span>
                        <div class="text-sm text-gray-500 font-normal">
                            ${{ number_format($item['precio'], 2) }}
                        </div>
                    </div>

                    {{-- Precio total y eliminar --}}
                    <div class="flex justify-end items-center space-x-4">
                        <span class="font-semibold text-green-500 text-xl">
                            ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                        </span>
                        <button wire:click="eliminarProducto({{ $item['id'] }})" class="text-red-600 hover:text-red-800 text-xl font-bold">✖</button>
                    </div>

                </div>
            @endforeach

            {{-- Dirección de envío --}}
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-1">
                    <x-input-label for="direccion_envio" :value="__('Dirección de envío')" class="dark:text-gray-500" />
                    <x-text-input 
                        id="direccion_envio" 
                        type="text" 
                        class="block mt-2 w-full dark:bg-gray-100 dark:border-gray-400 dark:text-gray-600"
                        wire:model.defer="direccion_envio"
                        placeholder="Ej: Calle 1234"
                    />
                    <x-input-error :messages="$errors->get('direccion_envio')" class="mt-2 dark:text-red-400" />
                </div>
                <div class="col-span-1">
                    <x-input-label for="metodo_pago" :value="__('Método de pago')" class="dark:text-gray-500" />
                    <select id="metodo_pago" class="block mt-2 w-full rounded-lg border-gray-300 dark:border-gray-400 dark:bg-gray-100 dark:text-gray-600" wire:model.defer="metodo_pago">
                        <option value="">Seleccione un método</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                    <x-input-error :messages="$errors->get('metodo_pago')" class="mt-2 dark:text-red-400" />
                </div>
            </div> 
        </div>
        
        {{-- Total --}}
        <div class="flex justify-center sticky bottom-0 pt-4">
            <div class="text-center text-xl font-bold text-gray-800">
                Total: <span class="text-2xl">${{ number_format($total, 2) }}</span> 
            </div>
        </div>

        {{-- Botón confirmar fijo al fondo --}}
        <div class="flex justify-center sticky bottom-0 py-4">
            <button wire:click="confirmar" class="px-6 py-3 bg-red-500 hover:bg-red-700 text-white rounded-full">
                Confirmar pedido
            </button>
        </div>

    @else
        <p class="text-gray-500 text-xl">El carrito está vacío.</p>
    @endif

</div>
