<?php

namespace App\Livewire;

use Livewire\Component;

class CarritoBadge extends Component
{
    public $cantidad = 0;

    protected $listeners = ['carrito-actualizado' => 'actualizarCantidad'];

    public function mount()
    {
        $carrito = session()->get('carrito', []);
        $this->cantidad = collect($carrito)->sum('cantidad');
    }

    public function actualizarCantidad()
    {
        $carrito = session()->get('carrito', []);
        $this->cantidad = collect($carrito)->sum('cantidad');
    }

    public function render()
    {
        return view('livewire.carrito-badge');
    }
}

