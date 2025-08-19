<x-guest-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('cliente.index') }}" 
                class="text-md text-gray-500 hover:text-blue-500 dark:text-gray-200 leading-tight">
                Inicio
            </a>
            <span class="mx-1 text-gray-500 dark:text-gray-400">&gt;</span>
            <a href="{{ route('carrito') }}" 
                class="text-md text-gray-500 hover:text-blue-500 dark:text-gray-200 leading-tight">
                Mi pedido
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    @livewire('carrito')
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
