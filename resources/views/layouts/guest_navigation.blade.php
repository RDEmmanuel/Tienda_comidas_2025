<nav x-data="{ open: false }" class="bg-red-500 dark:bg-red-500 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-40">

            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ url('/') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-4">
                <livewire:carrito-badge />
            </div>
        </div>
    </div>
</nav>
