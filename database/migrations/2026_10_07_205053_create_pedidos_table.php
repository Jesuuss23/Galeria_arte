<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            // Claves foráneas compatibles con INT de users
            $table->integer('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('users')->cascadeOnDelete();

            $table->integer('artista_id');
            $table->foreign('artista_id')->references('id')->on('users')->cascadeOnDelete();

            // Clave foránea al servicio (servicios.id es BIGINT UNSIGNED por defecto)
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->nullOnDelete();

            $table->text('instrucciones');
            $table->string('archivo_referencia')->nullable(); // Imagen o archivo de referencia

            $table->decimal('precio_acordado', 10, 2)->nullable();
            $table->decimal('comision_plataforma', 10, 2)->default(0.00);
            $table->date('fecha_limite')->nullable();

            $table->string('archivo_entrega_final')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->text('resolucion_admin')->nullable();

            $table->enum('estado', [
                'solicitado',        // Cliente pide cotización
                'cotizado',          // Artista asigna precio y fecha
                'pagado_custodia',   // Cliente pagó, dinero retenido
                'entregado',         // Artista sube el archivo final
                'completado',        // Cliente aprueba y se liberan fondos
                'en_disputa',        // Cliente rechaza entrega
                'reembolsado',       // Admin devuelve el dinero al cliente
                'cancelado'          // Cotización rechazada
            ])->default('solicitado');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};