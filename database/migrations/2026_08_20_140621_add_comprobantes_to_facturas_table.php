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
        Schema::table('facturas', function (Blueprint $table) {
            if (!Schema::hasColumn('facturas', 'pagado')) {
                $table->boolean('pagado')->default(false);
            }
            if (!Schema::hasColumn('facturas', 'comprobante')) {
                $table->string('comprobante')->nullable();
            }
            if (!Schema::hasColumn('facturas', 'complemento_recibido')) {
                $table->boolean('complemento_recibido')->default(false);
            }
            if (!Schema::hasColumn('facturas', 'complemento_folio')) {
                $table->string('complemento_folio')->nullable();
            }
            if (!Schema::hasColumn('facturas', 'complemento_fecha')) {
                $table->date('complemento_fecha')->nullable();
            }
            if (!Schema::hasColumn('facturas', 'complemento_monto')) {
                $table->decimal('complemento_monto', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('facturas', 'comprobante_complemento')) {
                $table->string('comprobante_complemento')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn([
                'pagado',
                'comprobante',
                'complemento_recibido',
                'complemento_folio',
                'complemento_fecha',
                'complemento_monto',
                'comprobante_complemento'
            ]);
        });
    }
};