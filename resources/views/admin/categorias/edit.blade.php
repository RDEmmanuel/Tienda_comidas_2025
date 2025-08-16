<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
            {{ __('Editar categoría') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Formulario -->
                <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div class="p-1">
                        <x-input-label for="nombre" :value="__('Nombre')" class="dark:text-gray-300" />
                        <x-text-input id="nombre"
                                      class="block mt-1 w-full dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200"
                                      type="text"
                                      name="nombre"
                                      :value="old('nombre', $categoria->nombre)"
                                      required autofocus autocomplete="nombre" />
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2 dark:text-red-300" />
                    </div>

                    <!-- Descripción -->
                    <div class="p-1">
                        <x-input-label for="descripcion" :value="__('Descripción')" class="dark:text-gray-300" />
                        <x-text-input id="descripcion"
                                      class="block mt-1 w-full dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200"
                                      type="text"
                                      name="descripcion"
                                      :value="old('descripcion', $categoria->descripcion)"
                                      autofocus autocomplete="descripcion" />
                        <x-input-error :messages="$errors->get('descripcion')" class="mt-2 dark:text-red-300" />
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end">
                        <a href="{{ route('admin.categorias.index') }}"
                           class="inline-flex items-center px-4 py-2 mr-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-2xl hover:bg-gray-300 dark:hover:bg-gray-600">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-2xl hover:bg-indigo-700">
                            Actualizar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
