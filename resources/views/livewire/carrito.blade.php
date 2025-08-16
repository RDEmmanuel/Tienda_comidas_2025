<div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow">
    @if (count($items) > 0)
        <table class="w-full text-sm">
            <thead>
                <tr>
                    <th class="text-left">Producto</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Precio</th>
                    <th class="text-right">Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="border-t">
                        <td>{{ $item['nombre'] }}</td>
                        <td class="text-center">
                            <input type="number" min="1" value="{{ $item['cantidad'] }}"
                                wire:change="actualizarCantidad({{ $item['id'] }}, $event.target.value)"
                                class="w-16 text-center border rounded">
                        </td>
                        <td class="text-right">${{ number_format($item['precio'], 2) }}</td>
                        <td class="text-right">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                        <td>
                            <button wire:click="eliminarProducto({{ $item['id'] }})" class="text-red-600">✖</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-between items-center mt-4">
            <strong>Total: ${{ number_format($total, 2) }}</strong>
            <div class="space-x-2">
                <button wire:click="vaciar" class="px-3 py-1 bg-red-600 text-white rounded">Vaciar</button>
                <button wire:click="confirmar" class="px-3 py-1 bg-green-600 text-white rounded">Confirmar</button>
            </div>
        </div>
    @else
        <p class="text-gray-500">El carrito está vacío.</p>
    @endif
</div>
