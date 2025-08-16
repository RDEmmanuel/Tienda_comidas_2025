<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
            {{ __('Agregar nuevo producto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Formulario -->
                <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- nombre y categoria -->
                    <div class="flex flex-wrap">
                        <!-- categoria -->
                        <div class="w-1/2 p-1">
                            <x-input-label for="categoria_id" :value="__('Categoría')" class="dark:text-gray-300" />
                            <select name="categoria_id" id="categoria_id"
                                class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione una categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('categoria_id')" class="mt-2 dark:text-red-300" />
                        </div>
                        <!-- Nombre -->
                        <div class="w-1/2 p-1">
                            <x-input-label for="nombre" :value="__('Nombre')" class="dark:text-gray-300" />
                            <x-text-input id="nombre" class="block mt-1 w-full dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200" type="text" name="nombre"
                                :value="old('nombre')" required autofocus autocomplete="nombre" />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2 dark:text-red-300" />
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="p-1">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Descripción
                        </label>
                        <textarea name="descripcion" id="descripcion" rows="4"
                            class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion') }}</textarea>
                    </div>

                    <!-- Precio de costo y precio venta-->
                    <div class="flex flex-wrap">
                        <!-- Stock -->
                        <div class="w-1/3 p-1">
                            <x-input-label for="stock" :value="__('Stock')" class="dark:text-gray-300" />
                            <x-text-input id="stock" class="block mt-1 w-full dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200" type="text" name="stock"
                                :value="old('stock')" required autofocus autocomplete="stock" />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2 dark:text-red-300" />
                        </div>
                        <div class="w-1/3 p-1">
                            <x-input-label for="precio_costo" :value="__('Precio costo')" class="dark:text-gray-300" />
                            <x-text-input id="precio_costo" class="block mt-1 w-full dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200" type="text" name="precio_costo"
                                :value="old('precio_costo')" required autofocus autocomplete="precio_costo" />
                            <x-input-error :messages="$errors->get('precio_costo')" class="mt-2 dark:text-red-300" />
                        </div>
                        <div class="w-1/3 p-1">
                            <x-input-label for="precio_venta" :value="__('Precio venta')" class="dark:text-gray-300" />
                            <x-text-input id="precio_venta" class="block mt-1 w-full dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200" type="text" name="precio_venta"
                                :value="old('precio_venta')" required autofocus autocomplete="precio_venta" />
                            <x-input-error :messages="$errors->get('precio_venta')" class="mt-2 dark:text-red-300" />
                        </div>
                    </div>

                    <!-- Imagen -->
                    <div class="p-1">
                        <label for="imagen" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Imagen del producto
                        </label>
                        <input type="file" name="imagen" id="imagen"
                            class="block w-full mt-1 text-sm text-gray-900 dark:text-gray-300 file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0 file:text-sm file:font-semibold
                            file:bg-indigo-50 dark:file:bg-gray-700 file:text-indigo-700 dark:file:text-gray-200
                            hover:file:bg-indigo-100 dark:hover:file:bg-gray-600">
                        <x-input-error :messages="$errors->get('imagen')" class="mt-2 dark:text-red-300" />
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end">
                        <a href="{{ route('admin.productos.index') }}"
                           class="inline-flex items-center px-4 py-2 mr-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-2xl hover:bg-gray-300 dark:hover:bg-gray-600">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-2xl hover:bg-indigo-700">
                            Guardar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
