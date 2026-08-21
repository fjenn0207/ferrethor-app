<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proveedores';
    protected $fillable = ['nombre', 'dias_credito'];

    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}