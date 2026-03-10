<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->boolean('facturable')->default(false)->after('descripcion');
            $table->string('clave_producto_sat')->nullable()->after('facturable');   // Catálogo SAT c_ClaveProdServ
            $table->string('codigo_interno')->nullable()->after('clave_producto_sat');
            $table->string('unidad_medida')->nullable()->after('codigo_interno');    // Ej: Pieza, Kilogramo
            $table->string('clave_unidad_sat')->nullable()->after('unidad_medida'); // Catálogo SAT c_ClaveUnidad (ej: H87, KGM)
            $table->string('tasa_cuota')->nullable()->after('clave_unidad_sat');    // Ej: 0.160000, Exento, Tasa 0
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn([
                'facturable',
                'clave_producto_sat',
                'codigo_interno',
                'unidad_medida',
                'clave_unidad_sat',
                'tasa_cuota',
            ]);
        });
    }
};
