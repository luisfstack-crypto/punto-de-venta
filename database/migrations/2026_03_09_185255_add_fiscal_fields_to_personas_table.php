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
        Schema::table('personas', function (Blueprint $table) {
            $table->string('nombre_contacto')->nullable()->after('razon_social');
            $table->string('rfc', 20)->nullable()->after('numero_documento');
            $table->string('regimen_fiscal')->nullable()->after('rfc');
            $table->string('uso_cfdi')->nullable()->after('regimen_fiscal');
            $table->boolean('requiere_factura')->default(false)->after('uso_cfdi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn(['nombre_contacto', 'rfc', 'regimen_fiscal', 'uso_cfdi', 'requiere_factura']);
        });
    }
};
