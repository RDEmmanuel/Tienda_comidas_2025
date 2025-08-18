<?php


namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // 🔢 Estadísticas de productos
        $totalProductos = Producto::count();
        $ultimosProductos = Producto::latest()->take(5)->get(); 

        // 🔢 Estadísticas de categorías
        $totalCategorias = Categoria::count();
        $ultimasCategorias = Categoria::latest()->take(5)->get();  
        
        // 🔢 Estadísticas de ventas
        $totalVentas = Pedido::count();
        $ultimasVentas = Pedido::latest()->take(5)->get();

        // 📌 Total ventas del mes actual
        $totalVentasMesActual = Pedido::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // 📊 Estadísticas de productos por mes para el gráfico
        $productosPorMes = Producto::select(
                DB::raw("COUNT(*) as count"),
                DB::raw("YEAR(created_at) as year"),
                DB::raw("MONTH(created_at) as month")
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $totalProductosPorMes = $productosPorMes->sum('count');
        $labels = $productosPorMes->map(function ($item) {
            return Carbon::createFromDate($item->year, $item->month, 1)->translatedFormat('F Y');
        });

        $data = $productosPorMes->pluck('count');
        // fin gráfico productos por mes

        // 📊 Estadísticas de ventas por mes para el gráfico
        $ventasPorMes = Pedido::select(
                DB::raw("COUNT(*) as count"),
                DB::raw("YEAR(created_at) as year"),
                DB::raw("MONTH(created_at) as month")
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $totalVentasPorMes = $ventasPorMes->sum('count');
        $labelsVentas = $ventasPorMes->map(function ($item) {
            return Carbon::createFromDate($item->year, $item->month, 1)->translatedFormat('F Y');
        });

        $dataVentas = $ventasPorMes->pluck('count');
        // fin gráfico ventas por mes

        // Retornar la vista con las estadísticas y los datos necesarios para los gráficos
        return view('admin.dashboard', compact(
            'totalProductos',
            'totalCategorias',
            'ultimasCategorias',
            'labels',
            'data',
            'labelsVentas',
            'dataVentas',
            'ultimosProductos',
            'totalVentas',
            'ultimasVentas',
            'totalVentasMesActual' // 👈 Se pasa a la vista
        ));
    }
}
