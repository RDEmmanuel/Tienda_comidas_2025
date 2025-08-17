<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\Categoria;

class ProductoClienteController extends Controller
{
    public function index()
    {
        $productos = Producto::where('estado', true)->get();
        return view('cliente.index', compact('productos'));
    }
}
