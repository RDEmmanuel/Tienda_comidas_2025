<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Mostrar todas las categorías
    public function index(Request $request)
    {
        $query = Categoria::query();

        // 🔍 Buscar por...
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                ->orWhere('nombre', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // 🔢 Paginación
        $categorias = $query->orderBy('id')->paginate(6);

        // Mantener parámetros en los links de paginación
        $categorias->appends($request->only('search'));

        return view('admin.categorias.index', compact('categorias'));
    }

    // Mostrar formulario para crear categoría
    public function create()
    {
        return view('admin.categorias.create');
    }

    // Guardar nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Categoria::create($request->all());

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    // Mostrar formulario para editar categoría
    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    // Actualizar categoría
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($request->all());

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    // Eliminar categoría
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
