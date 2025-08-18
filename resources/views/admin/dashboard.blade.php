<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <!-- messages -->
    @foreach (['success', 'error', 'warning', 'info'] as $type)
        <x-alert :type="$type" :message="session($type)" />
    @endforeach

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

                <!-- Gráfico + Últimos productos -->
                <div class="flex flex-col gap-3 col-span-1 lg:col-span-2">
                    <div class="flex w-full gap-3">
                        <div class="w-1/2">
                            <!-- Gráfico de productos -->
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 h-64">
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Productos registrados por mes</h3>
                                <div class="relative w-full">
                                    <canvas id="membersChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="w-1/2">
                            <!-- Últimos productos registrados -->
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 h-64">
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Últimos productos registrados</h3>
                                <ul class="divide-y divide-gray-200 text-sm">
                                    @forelse ($ultimosProductos as $producto)
                                        <li class="py-2 flex justify-between">
                                            <span class="text-gray-500 dark:text-white">{{ $producto->nombre }}, {{ $producto->codigo }}</span>
                                            <span class="text-gray-500 dark:text-white">{{ $producto->created_at->format('d/m/Y') }}</span>
                                        </li>
                                    @empty
                                        <li class="py-2 text-gray-500 dark:text-white">No hay productos registrados recientemente.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- fin ultimos productos -->

                    <!-- Gráfico + Últimas ventas -->
                    <div class="flex w-full gap-3">
                        <!-- Gráfico de ventas -->
                        <div class="w-1/2">
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 h-64">
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Pedidos registrados por mes</h3>
                                <div class="relative w-full">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de ultimos ventas -->
                        <div class="w-1/2">
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 h-64">
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Últimas ventas registradas</h3>
                                <ul class="divide-y divide-gray-200 text-sm">
                                    @forelse ($ultimasVentas as $venta)
                                        <li class="py-2 flex justify-between">
                                            <span class="text-gray-500 dark:text-white">
                                                @foreach ($venta->detalles as $detalle)
                                                    x{{$detalle->cantidad}} {{ $detalle->producto->nombre }}
                                                @endforeach
                                            </span>
                                            <span class="text-gray-500 dark:text-green-500">$ {{ $venta->total }}</span>
                                        </li>
                                    @empty
                                        <li class="py-2 text-gray-500 dark:text-white">No hay pedidos recientes.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- fin ultimas ventas -->
                </div>

                <!-- Estadísticas -->
                <div class="grid grid-rows-2 gap-3 h-full">
                    <!-- Fila superior -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-3 flex-1">
                        <div class="flex-1">
                            <a href="{{ route('admin.productos.index') }}" class="block h-full">
                                <div class="h-full flex flex-col justify-center bg-blue-100 dark:bg-cyan-900 rounded-2xl shadow p-6 text-center hover:shadow-lg transition duration-300 dark:hover:drop-shadow-[0_1px_3px_rgba(255,255,255,0.5)]">
                                    <h3 class="text-sm font-medium text-blue-600 dark:text-white">Productos</h3>
                                    <p class="text-3xl font-bold text-blue-700 dark:text-white">{{ $totalProductos }}</p>
                                </div>
                            </a>
                        </div>

                        <div class="flex-1">
                            <a href="{{ route('admin.categorias.index') }}" class="block h-full">
                                <div class="h-full flex flex-col justify-center bg-red-100 dark:bg-emerald-900 rounded-2xl shadow p-6 text-center hover:shadow-lg transition duration-300 dark:hover:drop-shadow-[0_1px_3px_rgba(255,255,255,0.5)]">
                                    <h3 class="text-sm font-medium text-red-500 dark:text-white">Categorías</h3>
                                    <p class="text-3xl font-bold text-red-500 dark:text-white">{{ $totalCategorias }}</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Fila inferior -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-3 flex-1">
                        <div class="flex-1">
                            <a href="{{ route('admin.pedidos.index') }}" class="block h-full">
                                <div class="h-full flex flex-col justify-center bg-yellow-100 dark:bg-teal-900 rounded-2xl shadow p-6 text-center hover:shadow-lg transition duration-300 dark:hover:drop-shadow-[0_1px_3px_rgba(255,255,255,0.5)]">
                                    <h3 class="text-sm font-medium text-yellow-600 dark:text-white">Total Ventas</h3>
                                    <p class="text-3xl font-bold text-yellow-700 dark:text-white">{{ $totalVentas }}</p>
                                </div>
                            </a>
                        </div>

                        <div class="flex-1">
                            <a href="#" class="block h-full">
                                <div class="h-full flex flex-col justify-center bg-green-200 dark:bg-emerald-600 rounded-2xl shadow p-6 text-center hover:shadow-lg transition duration-300 dark:hover:drop-shadow-[0_1px_3px_rgba(255,255,255,0.5)]">
                                    <h3 class="text-sm font-medium text-green-600 dark:text-white">Ventas Mes Actual</h3>
                                    <p class="text-3xl font-bold text-green-700 dark:text-white">{{ $totalVentasMesActual }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- fin de estadísticas -->

            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('membersChart').getContext('2d');
        const membersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Productos registrados',
                    data: {!! json_encode($data) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelsVentas) !!},
                datasets: [{
                    label: 'Ventas registradas',
                    data: {!! json_encode($dataVentas) !!},
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
