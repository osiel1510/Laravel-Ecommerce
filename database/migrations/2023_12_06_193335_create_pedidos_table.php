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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Campo para el nombre
            $table->string('correo'); // Campo para el correo
            $table->string('calle'); // Campo para la calle
            $table->string('cp'); // Campo para el código postal
            $table->string('numero_interior')->nullable(); // Campo para el número interior (opcional)
            $table->string('municipio'); // Campo para el municipio
            $table->string('estado'); // Campo para el estado
            $table->string('numero_telefonico'); // Campo para el número telefónico
            $table->string('status')->default('pendiente'); // Campo para el estado del pedido, con valor predeterminado 'pendiente'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
