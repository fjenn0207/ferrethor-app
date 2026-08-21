<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->string('foto_pago')->nullable(); // Para la foto del comprobante
            $table->string('pdf_complemento')->nullable(); // Para el PDF del complemento
        });
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn(['foto_pago', 'pdf_complemento']);
        });
    }
};
