<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;

class ProductosGrid extends Component
{
    public $productos;
    public $showModal = false;
    public $selectedProduct = null;

    public function mount()
    {
        // Trae productos visibles (ajustá la consulta según tu proyecto)
        $this->productos = Producto::where('estado', true)->orderBy('nombre')->get();
    }

    public function render()
    {
        return view('livewire.productos-grid');
    }

    // Abre el modal con el producto seleccionado
    public function openModal(int $productoId)
    {
        $this->selectedProduct = Producto::findOrFail($productoId);
        $this->showModal = true;
    }

    // Cierra el modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedProduct = null;
    }

    // Confirma y agrega el producto al carrito + redirige al carrito
    public function confirmAdd()
    {
        if (! $this->selectedProduct) {
            $this->closeModal();
            return;
        }

        $producto = $this->selectedProduct;
        $carrito = session()->get('carrito', []);

        $id = $producto->id;

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                'id'       => $producto->id,
                'nombre'   => $producto->nombre,
                'precio'   => $producto->precio_venta,
                'cantidad' => 1,
            ];
        }

        session()->put('carrito', $carrito);

        // cerramos modal (opcional) y redirigimos al carrito
        $this->closeModal();

        return redirect()->route('carrito');
    }
}
