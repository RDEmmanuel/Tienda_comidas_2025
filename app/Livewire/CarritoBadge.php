<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CarritoBadge extends Component
{
    public $cantidad = 0;

    public function mount()
    {
        $carrito = session()->get('carrito', []);
        $this->cantidad = collect($carrito)->sum('cantidad');
    }

    #[On('carrito-actualizado')]
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
