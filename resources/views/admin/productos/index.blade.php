<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ $titulo ?? __('Productos') }}
            </h2>
        </div>
    </x-slot>

    <!-- Mensajes -->
    @foreach (['success', 'error', 'warning', 'info'] as $type)
        <x-alert :type="$type" :message="session($type)" />
    @endforeach

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100">

                    <!-- Filtros -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 items-center">
                        <form method="GET" action="{{ route('admin.productos.index') }}" class="col-span-2 md:col-span-3 grid grid-cols-3 gap-4">
                            {{-- Buscador --}}
                            <div class="relative flex items-center w-full col-span-1">
                                <input type="text" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    placeholder="Buscar"
                                    class="w-full text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-800 pl-4 pr-10 py-2 h-10 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                                @if(request('search'))
                                    <a href="{{ route('admin.productos', ['categoria_id' => request('categoria_id'), 'visible' => request('visible')]) }}"
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
                            </div>

                            {{-- Selector de categoría --}}
                            <div>
                                <select name="categoria_id" 
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 px-2"
                                        onchange="this.form.submit()">
                                    <option value="">Todas las categorías</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filtro Visible/No visible --}}
                            <div>
                                <select name="visible"
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 px-2"
                                        onchange="this.form.submit()">
                                    <option value="true" {{ request('visible') === 'true' ? 'selected' : '' }}>Visibles</option>
                                    <option value="false" {{ request('visible') === 'false' ? 'selected' : '' }}>Ocultos</option>
                                </select>
                            </div>
                        </form>

                        {{-- Botón Añadir Producto --}}
                        <div class="col-span-2 md:col-span-1">
                            <a href="{{ route('admin.productos.create') }}"
                               class="w-full py-3 inline-flex justify-center items-center px-4 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <i class="fa-solid fa-plus mr-1"></i>Añadir
                            </a>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">
                        <table class="w-full text-sm text-center text-gray-700 dark:text-gray-500 bg-white dark:bg-gray-900">
                            <thead class="text-xs uppercase bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                                <tr>
                                    <th class="px-6 py-4">Código</th>
                                    <th class="px-6 py-4">Imagen</th>
                                    <th class="px-6 py-4">Nombre</th>
                                    <th class="px-6 py-4">Descripción</th>
                                    <th class="px-6 py-4">Categoría</th>
                                    <th class="px-6 py-4">Stock</th>
                                    <th class="px-6 py-4">Precio Venta</th>
                                    <th class="px-6 py-4">Visible</th>
                                    <th class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productos as $producto)
                                    <tr class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                            {{ $producto->id }}
                                        </td>
                                        <td class="px-6 py-3 flex justify-center items-center">
                                            @if($producto->imagen)
                                                <img src="{{ asset('storage/' . $producto->imagen) }}"
                                                    alt="{{ $producto->nombre }}" class="w-16 h-16 object-cover rounded-md">
                                            @else
                                                <span class="text-gray-500 italic dark:text-gray-600">Sin imagen</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3">{{ $producto->nombre }}</td>
                                        <td class="px-6 py-3">{{ Str::limit($producto->descripcion, 50) }}</td>
                                        <td class="px-6 py-3">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                                        <td class="px-6 py-3 {{ $producto->stock >= 15 ? 'text-green-500' : ($producto->stock > 5 ? 'text-yellow-500' : 'text-red-500') }}">
                                            {{ $producto->stock }}
                                        </td>
                                        <td class="px-6 py-3">${{ number_format($producto->precio_venta, 2, ',', '.') }}</td>
                                        <td class="px-6 py-3">
                                            <span class="{{ $producto->estado ? 'text-green-600' : 'text-red-500' }}">
                                                {{ $producto->estado ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3">
                                            <div class="flex justify-center items-center gap-x-4">
                                                {{-- Agregar al carrito --}}
                                                <div></div>
                                                {{-- Editar --}}
                                                <a href="{{ route('admin.productos.edit', $producto->id) }}"
                                                   class="text-sm font-medium text-gray-500 dark:text-gray-300 dark:hover:text-blue-500 hover:text-blue-500"
                                                   title="Editar">
                                                    <i class="fa-solid fa-pencil"></i>Editar
                                                </a>
                                                {{-- Ver --}}
                                                <a href="{{ route('admin.productos.show', $producto->id) }}"
                                                   class="text-sm font-medium text-gray-500 dark:text-gray-300 dark:hover:text-blue-500 hover:text-blue-500"
                                                   title="Ver detalles">
                                                    <i class="fa-solid fa-info"></i>Ver
                                                </a>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="py-6 text-gray-500 dark:text-gray-300">No se encontraron productos.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <div class="p-2 dark:text-gray-200">
                            {{ $productos->appends(request()->all())->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
