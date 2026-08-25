<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'facturas';
    protected $fillable = [
        'proveedor_id',
        'folio_factura',
        'fecha_expedicion',
        'fecha_vencimiento',
        'monto',
        'pagado',
        'complemento_recibido',
        'complemento_folio',
        'complemento_fecha',
        'complemento_monto',
        'comprobante_complemento',
        'tipo',     // <--- Nuevo
        'estatus',  // <--- Nuevo
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}