<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Categorias') }}
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
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 items-center">
                        <div class="col-span-2 md:col-span-2">
                            <!-- 🔍 Formulario de búsqueda -->
                            <form method="GET" action="{{ route('admin.categorias.index') }}" class="relative flex items-center">
                                {{-- Input de búsqueda --}}
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Buscar"
                                    class="w-full text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-800 pl-4 pr-10 py-2 h-10 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                                >

                                {{-- Botón limpiar o buscar --}}
                                @if(request('search'))
                                    <a href="{{ route('admin.categorias.index') }}"
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
                        
                        <div class="col-span-2 md:col-span-1 flex items-end">
                            <!-- Botón para añadir nueva categoria -->
                            <a href="{{ route('admin.categorias.create') }}"
                                class="w-full py-3 inline-flex justify-center items-center px-4 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <i class="fa-solid fa-user-plus mr-1"></i>Añadir
                            </a>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                        <table class="w-full text-sm text-center text-gray-700 dark:text-gray-500 bg-white dark:bg-gray-900">
                            <thead class="text-xs uppercase bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                                <tr>
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Nombre</th>
                                    <th class="px-6 py-4">Descripción</th>
                                    <th class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categorias as $categoria)
                                    <tr class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                            {{ $categoria->id }}
                                        </td>
                                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                            {{ $categoria->nombre }}
                                        </td>
                                        <td class="px-6 py-3 italic text-gray-600 dark:text-gray-400">
                                            @if (!empty($categoria->descripcion))
                                                {{ $categoria->descripcion }}
                                            @else
                                                <span class="italic text-gray-500 dark:text-gray-700">Sin descripción</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3">
                                            <!-- Acciones -->
                                            <div class="flex justify-center items-center gap-x-4">
                                                <!-- editar -->
                                                <a href="{{ route('admin.categorias.edit', $categoria->id) }}" 
                                                    class="text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-500"
                                                    title="Editar">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>

                                                <!-- borrar -->
                                                <form action="{{ route('admin.categorias.destroy', $categoria->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoria?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Eliminar" class="text-red-500 hover:text-red-400">
                                                        <i class="fas fa-trash"></i>
                                                    </button>                                                
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-gray-500 dark:text-gray-300">No se encontraron resultados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <div class="p-2 dark:text-gray-200">
                            {{ $categorias->appends(['search' => request('search')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
