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
            $table->string('tipo')->default('factura'); // 'factura', 'remision', 'nota_credito'
            $table->string('estatus')->default('activo'); // 'activo', 'convertida'
        });
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn(['tipo', 'estatus']);
        });
    }
};
