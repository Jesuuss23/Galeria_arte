<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('es_publico')->default(true)->after('email');
            $table->decimal('saldo_disponible', 10, 2)->default(0.00)->after('es_publico');
            $table->decimal('saldo_retenido', 10, 2)->default(0.00)->after('saldo_disponible');
            $table->boolean('es_admin')->default(false)->after('saldo_retenido');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['es_publico', 'saldo_disponible', 'saldo_retenido', 'es_admin']);
        });
    }
};
