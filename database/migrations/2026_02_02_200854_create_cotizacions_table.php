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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_hora');
            $table->date('fecha_validez');
            $table->decimal('impuesto', 10, 2);
            $table->decimal('total', 10, 2);
            $table->tinyInteger('estado')->default(1)->comment('0:Rechazada, 1:Pendiente, 2:Aprobada');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('comprobante_id')->nullable()->constrained('comprobantes')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
