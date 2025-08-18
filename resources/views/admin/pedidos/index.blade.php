<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Pedidos') }}
            </h2>
        </div>
    </x-slot>

    <!-- messages -->
    @foreach (['success', 'error', 'warning', 'info'] as $type)
        <x-alert :type="$type" :message="session($type)" />
    @endforeach

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    
                    <!-- Filtros y botones -->
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-2 items-center">
                        <div class="col-span-1">
                            <!-- 🔍 Búsqueda -->
                            <form method="GET" action="{{ route('admin.pedidos.index') }}" class="relative flex items-center">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar"
                                    class="w-full text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-800 pl-4 pr-10 py-2 h-10 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                                
                                @if(request('search'))
                                    <a href="{{ route('admin.pedidos.index') }}"
                                    class="absolute right-4 text-gray-400 hover:text-red-500 text-xl font-bold"
                                    title="Limpiar búsqueda">
                                    <i class="fa-solid fa-delete-left"></i>
                                    </a>
                                @else
                                    <button type="submit"
                                        class="absolute right-4 text-gray-400 hover:text-blue-500 text-md font-bold"
                                        title="Buscar">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                @endif
                            </form>
                        </div>

                        <div></div>

                    </div>

                    <!-- Tabla -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                        <table class="w-full text-sm text-center text-gray-700 dark:text-gray-500 bg-white dark:bg-gray-900">
                            <thead class="text-xs uppercase bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                                <tr>
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Fecha</th>
                                    <th class="px-6 py-4">Estado</th>
                                    <th class="px-6 py-4">Monto Adicional</th>
                                    <th class="px-6 py-4">Descuento</th>
                                    <th class="px-6 py-4">Total</th>
                                    <th class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pedidos as $pedido)
                                    <tr class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                            {{ $pedido->id }}
                                        </td>
                                        <td class="px-6 py-3">
                                            {{ $pedido->created_at->format('d/m/Y H:i') }}
                                        </td>                                        
                                        <td class="px-6 py-3 capitalize">
                                            {{ ($pedido->estado) }}
                                        </td>
                                        <td class="px-6 py-3">${{ number_format($pedido->monto_adicional, 2, ',', '.') }}</td>
                                        <td class="px-6 py-3">
                                            @if($pedido->descuento)
                                                {{ $pedido->descuento }}%
                                            @else
                                                Sin descuento
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 font-bold text-lg text-gray-700 dark:text-gray-100">
                                            ${{ number_format($pedido->total, 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-3">
                                            <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                                                title="Ver detalles"
                                               class="italic text-blue-500 dark:text-blue-500 dark:hover:text-blue-400 hover:text-blue-600">
                                               Ver Detalles
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-gray-500 dark:text-gray-300">No hay pedidos para mostrar</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <div class="p-2 dark:text-gray-200">
                            {{ $pedidos->appends(['search' => request('search')])->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
