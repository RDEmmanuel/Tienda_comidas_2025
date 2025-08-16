<div>
    @props(['type' => 'success', 'message' => ''])

    @php
        $colors = [
            'success' => 'green',
            'error' => 'red',
            'warning' => 'yellow',
            'info' => 'blue',
        ];

        $color = $colors[$type] ?? 'gray';
    @endphp

    @if ($message)
        <div class="p-4 text-sm text-{{ $color }}-700 bg-{{ $color }}-100 dark:bg-{{ $color }}-800 dark:text-{{ $color }}-100 rounded-lg shadow">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{ $message }}
            </div>
        </div>
    @endif
</div>