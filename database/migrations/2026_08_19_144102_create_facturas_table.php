<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->string('folio_factura')->unique(); // Evita duplicados a nivel de base de datos
            $table->date('fecha_expedicion');
            $table->date('fecha_vencimiento');
            $table->decimal('monto', 10, 2);
            $table->boolean('pagado')->default(false);
            $table->string('complemento_recibido')->nullable(); // Visible solo para proveedores con crédito
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
