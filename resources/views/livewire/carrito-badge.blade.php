    <div class="relative">
    <a href="{{ route('carrito') }}" class="text-gray-700 dark:text-gray-200">
        <i class="fa-solid fa-cart-shopping text-white text-2xl"></i>
        @if ($cantidad > 0)
            <span class="absolute -top-2 -right-2 bg-gray-600 text-white text-xs px-2 py-0.5 rounded-full">
                {{ $cantidad }}
            </span>
        @endif
    </a>
</div>
