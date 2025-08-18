<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Mostrar todos los pedidos.
     */
    public function index(Request $request)
    {
        $query = Pedido::query()
            ->with('detalles.producto')
            ->latest();
        // 🔍 Buscar por...
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%");
            // Puedes agregar más campos para buscar si es necesario
            })->orWhereHas('detalles.producto', function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            })->orWhereHas('detalles.producto', function($q) use ($search) {
                $q->where('descripcion', 'like', "%{$search}%");
            });
        }

        // 🔢 Paginación
        $pedidos = $query->orderBy('id')->paginate(6);

        // Mantener parámetros en los links de paginación
        $pedidos->appends($request->only('search'));

        // ✅ Solo pasamos 'ventas' porque las relaciones ya vienen incluidas
        return view('admin.pedidos.index', compact('pedidos'));
    }

    /**
     * Mostrar el detalle de un pedido específico.
     */
    public function show($id)
    {
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }

    /**
     * Eliminar un pedido (opcional).
     */
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);

        foreach ($pedido->detalles as $detalle) {
            // Devolver stock al producto
            $detalle->producto->increment('stock', $detalle->cantidad);
            $detalle->delete();
        }

        $pedido->delete();

        return redirect()->route('admin.pedidos.index')->with('success', 'Venta eliminada correctamente.');
    }

}
