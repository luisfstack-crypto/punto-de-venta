<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // nombre_contacto, rfc, regimen_fiscal, uso_cfdi, requiere_factura
        // ya existen en la tabla — solo agregamos los campos de dirección fiscal
        Schema::table('personas', function (Blueprint $table) {
            $table->string('pais')->nullable()->after('requiere_factura');
            $table->string('estado_fiscal')->nullable()->after('pais');
            $table->string('ciudad')->nullable()->after('estado_fiscal');
            $table->string('codigo_postal', 10)->nullable()->after('ciudad');
            $table->string('calle')->nullable()->after('codigo_postal');
            $table->string('cruzamientos')->nullable()->after('calle');
            $table->string('numero_exterior', 20)->nullable()->after('cruzamientos');
            $table->string('numero_interior', 20)->nullable()->after('numero_exterior');
        });
    }

    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn([
                'pais',
                'estado_fiscal',
                'ciudad',
                'codigo_postal',
                'calle',
                'cruzamientos',
                'numero_exterior',
                'numero_interior',
            ]);
        });
    }
};
