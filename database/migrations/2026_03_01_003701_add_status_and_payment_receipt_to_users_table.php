<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status', 20)->default('pending');
            }
            if (!Schema::hasColumn('users', 'payment_receipt')) {
                $table->string('payment_receipt')->nullable();
            }
        });

        // Agrega restricción CHECK solo si no existe (PostgreSQL compatible)
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            $constraints = DB::select("
                SELECT constraint_name FROM information_schema.table_constraints
                WHERE table_name = 'users' AND constraint_name = 'users_status_check'
            ");
            if (empty($constraints)) {
                DB::statement("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'active', 'rejected'))");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check");
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('users', 'payment_receipt')) {
                $table->dropColumn('payment_receipt');
            }
        });
    }
};
