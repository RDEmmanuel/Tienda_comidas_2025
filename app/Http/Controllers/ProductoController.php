<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Mostrar todos los productos
    public function index(Request $request)
    {
        $query = Producto::query()
            ->with('categoria');

        // 📌 Filtrar por visible / no visible
        if ($request->has('estado')) {
            // Convierte "true"/"false" a boolean real
            $query->where('estado', filter_var($request->input('estado'), FILTER_VALIDATE_BOOLEAN));
        } else {
            // Por defecto mostrar visibles
            $query->where('estado', true);
        }

        // 📋 Cargar categorías para el filtro
        $categorias = Categoria::all();

        // 🔍 Buscar por texto
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // 🗂️ Filtrar por categoría
        $categoriaSeleccionada = null;
        if ($request->filled('categoria_id')) {
            $categoriaSeleccionada = Categoria::find($request->input('categoria_id'));
            $query->where('categoria_id', $request->input('categoria_id'));
        }

        // 🔢 Paginación
        $productos = $query->orderBy('id')->paginate(3);

        // Mantener parámetros en paginación
        $productos->appends($request->only('search', 'categoria_id', 'estado'));

        // 📌 Título dinámico
        $titulo = match($request->input('visible')) {
            '0', 'false' => 'Productos Ocultos',
            '1', 'true'  => 'Productos Visibles',
            default      => 'Productos Visibles'
        };

        // 🔹 Agregar categoría al título si está seleccionada
        if ($categoriaSeleccionada) {
            $titulo .= " en la categoría: " . $categoriaSeleccionada->nombre;
        }

        return view('admin.productos.index', compact('productos', 'categorias', 'titulo'));
    }

    // Mostrar formulario para crear producto
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.productos.create', compact('categorias'));
    }

    // Guardar nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'precio_costo' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Guardar imagen si existe
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    // Mostrar formulario para editar producto
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    // Actualizar producto
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'precio_costo' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Guardar nueva imagen si se subió
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar producto
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
