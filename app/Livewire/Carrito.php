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

    protected $listeners = ['agregarProducto'];

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
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio_venta,
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
        $this->dispatch('carrito-actualizado');
    }

    public function vaciar()
    {
        $this->carrito = [];
        session()->forget('carrito');
        $this->dispatch('carrito-actualizado');
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
        $this->dispatch('carrito-actualizado');
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
        DB::transaction(function () {
            $pedido = Pedido::create([
                'adicional' => 0,
                'descuento' => 0,
                'total' => $this->calcularTotal(),
                'direccion_envio' => 'Sin dirección', // Ajustar según formulario
                'estado' => 'pendiente',
                'metodo_pago' => 'efectivo',
            ]);

            foreach ($this->carrito as $item) {
                PedidoDetalle::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['precio'] * $item['cantidad'],
                ]);
            }
        });

        $this->vaciar();
        session()->flash('success', 'Pedido confirmado con éxito ✅');
    }
}
