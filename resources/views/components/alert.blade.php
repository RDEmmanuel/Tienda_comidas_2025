<div>
    @props(['type' => 'success', 'message' => ''])

    @php
        $classes = [
            'success' => 'text-green-700 bg-green-100 dark:bg-green-800 dark:text-green-100',
            'error'   => 'text-red-700 bg-red-100 dark:bg-red-800 dark:text-red-100',
            'warning' => 'text-yellow-700 bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-100',
            'info'    => 'text-blue-700 bg-blue-100 dark:bg-blue-800 dark:text-blue-100',
        ];

        $class = $classes[$type] ?? 'text-gray-700 bg-gray-100 dark:bg-gray-800 dark:text-gray-100';
    @endphp

    @if ($message)
        <div class="p-4 rounded-lg shadow {{ $class }}">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{ $message }}
            </div>
        </div>
    @endif
</div>
