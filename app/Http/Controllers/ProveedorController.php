<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    // Mostrar listado de proveedores
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('proveedores.create');
    }

    // Guardar proveedor
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'dias_credito' => 'required|integer|min:0',
        ]);

        Proveedor::create([
            'nombre' => $request->nombre,
            'dias_credito' => $request->dias_credito,
        ]);

        // ESTO ES LO QUE FALTABA: Redirigir al listado con un mensaje de éxito
        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado con éxito.');
    }

    // Eliminar proveedor
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        
        if ($proveedor->facturas()->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar este proveedor porque tiene facturas registradas.');
        }

        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}