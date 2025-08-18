<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
            {{ __('Detalle de pedido #') . $pedido->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 text-center">

                {{-- Información del pedido --}}
                <div class="">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 border-b pb-6">Información General de la venta</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-gray-700 dark:text-gray-300 pt-4">
                        {{-- Mostrar ID de la venta, fecha, monto adicional y descuento --}}
                        <div>ID Pedido: <strong>{{ $pedido->id }} </strong></div>
                        <div>Fecha: <strong>{{ $pedido->created_at->format('d/m/Y H:i') }}</strong> </div>
                        <div>Monto Adicional: <strong>${{ number_format($pedido->monto_adicional, 2, ',', '.') }}</strong></div>
                        <div>Descuento: 
                            <strong>    
                                {{-- Mostrar descuento si existe, de lo contrario mostrar "Sin descuento" --}}
                                @if ($pedido->descuento)
                                    {{ $pedido->descuento }}%
                                @else
                                    Sin descuento
                                @endif
                            </strong>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-green-600 dark:text-green-500 py-6">${{ number_format($pedido->total, 2, ',', '.') }}</h3>
                </div>

                {{-- Tabla de productos vendidos --}}
                <div>
                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-400 dark:bg-gray-700 text-white dark:text-gray-100 text-sm uppercase text-center">
                                <tr>
                                    <th class="px-4 py-2">Producto</th>
                                    <th class="px-4 py-2">Descripcion</th>
                                    <th class="px-4 py-2">Precio Unitario</th>
                                    <th class="px-4 py-2">Cantidad</th>
                                    <th class="px-4 py-2">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-300 dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700 dark:text-gray-100 text-center">
                                @forelse ($pedido->detalles as $detalle)
                                    <tr>
                                        <td class="px-4 py-2">
                                            {{ $detalle->producto->nombre }} <br>
                                            <small class="text-gray-500">Código: {{ $detalle->producto->id }}</small>
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ $detalle->producto->descripcion }}
                                        </td>
                                        <td class="px-4 py-2">
                                            ${{ number_format($detalle->precio_unitario, 2, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ $detalle->cantidad }}
                                        </td>
                                        <td class="px-4 py-2">
                                            ${{ number_format($detalle->subtotal, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-gray-500 dark:text-gray-300">
                                            No se encontraron productos en este pedido
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Volver atrás --}}
                    <div class="mt-6 flex justify-end">
                        <x-primary-button href="{{ route('admin.pedidos.index') }}" class="ml-2">
                            Volver
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
