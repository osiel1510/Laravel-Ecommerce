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
        Schema::create('pedido_productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Campo para el nombre del producto
            $table->decimal('precio', 10, 2); // Campo para el precio del producto
            $table->integer('cantidad'); // Campo para la cantidad del producto
            $table->unsignedBigInteger('id_pedido'); // Campo para la referencia al pedido
            $table->timestamps();

            // Definir la relación con la tabla 'pedidos'
            $table->foreign('id_pedido')->references('id')->on('pedidos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_productos');
    }
};
