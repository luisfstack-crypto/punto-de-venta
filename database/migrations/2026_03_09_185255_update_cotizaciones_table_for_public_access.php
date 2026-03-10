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
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->string('token_publico', 64)->nullable()->unique()->after('id');
            $table->boolean('aplicar_iva')->default(true)->after('total');
            $table->decimal('descuento_global', 10, 2)->default(0)->after('aplicar_iva');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->dropColumn(['token_publico', 'aplicar_iva', 'descuento_global']);
        });
    }
};
