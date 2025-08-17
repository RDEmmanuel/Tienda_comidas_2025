<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Support\Facades\DB;

class Carrito extends Component
{
    public $carrito = [];
    public $direccion_envio = ''; // ✅ Campo para la dirección
    public $metodo_pago = 'efectivo'; // ✅ Campo para el método de pago, por defecto 'efectivo'

    protected $listeners = [
        'agregarProducto'   => 'agregarProducto',
        'eliminarProducto'  => 'eliminarProducto',
        'vaciarCarrito'     => 'vaciar',
        'actualizarCantidad'=> 'actualizarCantidad',
        'confirmarPedido'   => 'confirmar',
    ];

    public function mount()
    {
        $this->carrito = session()->get('carrito', []);
    }

    public function render()
    {
        return view('livewire.carrito', [
            'items' => $this->carrito,
            'total' => $this->calcularTotal(),
        ]);
    }

    public function agregarProducto($productoId)
    {
        $producto = Producto::findOrFail($productoId);

        if (isset($this->carrito[$productoId])) {
            $this->carrito[$productoId]['cantidad']++;
        } else {
            $this->carrito[$productoId] = [
                'id'       => $producto->id,
                'nombre'   => $producto->nombre,
                'precio'   => $producto->precio_venta,
                'cantidad' => 1,
            ];
        }

        session()->put('carrito', $this->carrito);

        $this->dispatch('carrito-actualizado');
    }

    public function eliminarProducto($productoId)
    {
        unset($this->carrito[$productoId]);
        session()->put('carrito', $this->carrito);

        $this->dispatch('carrito-actualizado')->to(\App\Livewire\CarritoBadge::class);
    }

    public function vaciar()
    {
        $this->carrito = [];
        session()->forget('carrito');

        $this->dispatch('carrito-actualizado')->to(\App\Livewire\CarritoBadge::class);
    }

    public function actualizarCantidad($productoId, $cantidad)
    {
        if ($cantidad <= 0) {
            $this->eliminarProducto($productoId);
            return;
        }

        if (isset($this->carrito[$productoId])) {
            $this->carrito[$productoId]['cantidad'] = $cantidad;
            session()->put('carrito', $this->carrito);
        }

        $this->dispatch('carrito-actualizado')->to(\App\Livewire\CarritoBadge::class);
    }

    public function calcularTotal()
    {
        $total = 0;
        foreach ($this->carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return $total;
    }

    public function confirmar()
    {
        // ✅ Validamos dirección antes de guardar
        $this->validate([
            'direccion_envio' => 'required|string|min:5',
            'metodo_pago' => 'required|in:efectivo,transferencia',
        ], [
            'direccion_envio.required' => 'La dirección de envío es obligatoria.',
            'direccion_envio.min' => 'La dirección debe tener al menos 5 caracteres.',
        ]);

        DB::transaction(function () {
            $pedido = Pedido::create([
                'adicional'       => 0,
                'descuento'       => 0,
                'total'           => $this->calcularTotal(),
                'direccion_envio' => $this->direccion_envio, // ✅ Se guarda lo que escribió el cliente
                'estado'          => 'pendiente',
                'metodo_pago'     => $this->metodo_pago,
            ]);

            foreach ($this->carrito as $item) {
                // Bloqueo pesimista para evitar carreras de stock
                $producto = Producto::lockForUpdate()->findOrFail($item['id']);
                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto {$producto->nombre}.");
                }

                PedidoDetalle::create([
                    'pedido_id'          => $pedido->id,
                    'producto_id'        => $item['id'],
                    'cantidad'           => $item['cantidad'],
                    'precio_unitario'    => $item['precio'],
                    'subtotal'           => $item['precio'] * $item['cantidad'],
                ]);

                $producto->decrement('stock', $item['cantidad']);
            }
        });

        $this->vaciar();
        $this->direccion_envio = ''; // ✅ limpiar campo después de confirmar
        session()->flash('success', 'Pedido confirmado con éxito ✅');
    }
}
