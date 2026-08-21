<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FacturaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $hoy = \Carbon\Carbon::now();

        $facturas = Factura::with('proveedor')
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('folio_factura', 'like', "%{$search}%")
                    ->orWhere('fecha_expedicion', 'like', "%{$search}%")
                    ->orWhere('fecha_vencimiento', 'like', "%{$search}%")
                    ->orWhereHas('proveedor', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('facturas.index', compact('facturas', 'hoy'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        return view('facturas.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'folio_factura' => 'required|string|unique:facturas,folio_factura',
            'fecha_expedicion' => 'required|date',
            'monto' => 'required|numeric|min:0',
        ]);

        $proveedor = Proveedor::findOrFail($request->proveedor_id);
        $diasCredito = $request->input('dias_credito', $proveedor->dias_credito);
        $fechaVencimiento = Carbon::parse($request->fecha_expedicion)->addDays($diasCredito);

        Factura::create([
            'proveedor_id' => $request->proveedor_id,
            'folio_factura' => $request->folio_factura,
            'fecha_expedicion' => $request->fecha_expedicion,
            'fecha_vencimiento' => $fechaVencimiento,
            'monto' => $request->monto,
            'pagado' => false,
            'complemento_recibido' => false,
        ]);

        return redirect()->route('facturas.index')->with('success', 'Factura registrada con éxito.');
    }

    public function destroy($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete(); 

        return redirect()->route('facturas.index')->with('success', 'Factura enviada al historial correctamente.');
    }

    public function pagar(Request $request, $id)
    {
        $factura = Factura::findOrFail($id);

        $request->validate([
            'comprobante' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('comprobante')) {
            $imagen = $request->file('comprobante');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $ruta = $imagen->storeAs('comprobantes', $nombreImagen, 'public');
            
            $factura->comprobante = $ruta; 
        }

        $factura->pagado = true;
        $factura->save();

        return redirect()->route('facturas.index')->with('success', 'Factura marcada como pagada y comprobante guardado.');
    }

    public function marcarComplemento(Request $request, $id)
    {
        $request->validate([
            'complemento_folio' => 'required|string|max:255',
            'complemento_fecha' => 'required|date',
            'complemento_monto' => 'required|numeric|min:0',
            'comprobante_complemento' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'complemento_folio.required' => 'El folio del complemento es obligatorio.',
            'complemento_fecha.required' => 'La fecha del complemento es obligatoria.',
            'complemento_monto.required' => 'El monto del complemento es obligatorio.',
            'comprobante_complemento.required' => 'El comprobante en imagen es obligatorio.',
            'comprobante_complemento.image' => 'El archivo debe ser una imagen válida.',
        ]);

        $factura = Factura::findOrFail($id);
        
        $datosActualizar = [
            'complemento_recibido' => true,
            'complemento_folio' => $request->complemento_folio,
            'complemento_fecha' => $request->complemento_fecha,
            'complemento_monto' => $request->complemento_monto,
        ];

        if ($request->hasFile('comprobante_complemento')) {
            $imagen = $request->file('comprobante_complemento');
            $nombreImagen = 'comp_' . time() . '_' . $imagen->getClientOriginalName();
            $path = $imagen->storeAs('comprobantes', $nombreImagen, 'public');
            $datosActualizar['comprobante_complemento'] = $path;
        }

        $factura->update($datosActualizar);

        return redirect()->route('facturas.index')->with('success', 'Complemento de pago y comprobante registrados correctamente.');
    }

    public function historial(Request $request)
    {
        $search = $request->input('search');

        $facturas = Factura::onlyTrashed() 
            ->with('proveedor')
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('folio_factura', 'like', "%{$search}%")
                    ->orWhere('fecha_expedicion', 'like', "%{$search}%")
                    ->orWhere('fecha_vencimiento', 'like', "%{$search}%")
                    ->orWhere('deleted_at', 'like', "%{$search}%") 
                    ->orWhereHas('proveedor', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('facturas.historial', compact('facturas'));
    }

    public function restaurar($id)
    {
        $factura = Factura::withTrashed()->findOrFail($id);
        $factura->restore();

        return redirect()->route('facturas.historial')->with('success', 'Factura restaurada con éxito.');
    }

    public function forceDelete($id)
    {
        $factura = Factura::withTrashed()->findOrFail($id);
        $factura->forceDelete(); 

        return redirect()->route('facturas.historial')->with('success', 'Factura eliminada permanentemente.');
    }

    public function guardarComplemento(Request $request, $id)
    {
        $factura = Factura::findOrFail($id);

        $request->validate([
            'foto_pago' => 'nullable|image|max:2048',
            'complemento_folio' => 'nullable|string',
            'complemento_fecha' => 'nullable|date',
            'complemento_monto' => 'nullable|numeric',
            'pdf_complemento' => 'nullable|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('foto_pago')) {
            $path = $request->file('foto_pago')->store('comprobantes', 'public');
            $factura->foto_pago = $path;
            $factura->pagado = true;
        }

        if ($request->filled('complemento_folio')) {
            $factura->complemento_folio = $request->complemento_folio;
            $factura->complemento_fecha = $request->complemento_fecha;
            $factura->complemento_monto = $request->complemento_monto;
            $factura->complemento_recibido = true;
        }

        if ($request->hasFile('pdf_complemento')) {
            $pdfPath = $request->file('pdf_complemento')->store('complementos_pdf', 'public');
            $factura->pdf_complemento = $pdfPath;
            $factura->complemento_recibido = true;
        }

        $factura->save();

        return redirect()->route('facturas.index')->with('success', 'Registro guardado correctamente.');
    }
}