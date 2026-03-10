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
        Schema::table('ventas', function (Blueprint $table) {
            $table->boolean('aplicar_iva')->default(true)->after('total');
            $table->decimal('descuento_global', 10, 2)->default(0)->after('aplicar_iva');
        });

        Schema::table('producto_venta', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->after('producto_id');
            $table->decimal('descuento', 10, 2)->default(0)->after('precio_venta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn(['aplicar_iva', 'descuento_global']);
        });

        Schema::table('producto_venta', function (Blueprint $table) {
            $table->dropColumn(['descripcion', 'descuento']);
        });
    }
};
