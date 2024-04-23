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
        Schema::create('compras_detalle_temporals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos');
            $table->foreignId('usuario_id')->constrained('users');
            $table->decimal('cantidad', 10,2);
            $table->decimal('precio_unitario', 10,2);
            $table->decimal('total', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras_detalle_temporals');
    }
};
