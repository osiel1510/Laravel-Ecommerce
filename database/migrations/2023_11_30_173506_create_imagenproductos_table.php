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
        Schema::create('imagenproductos', function (Blueprint $table) {
            $table->id();
            $table->string('path'); // Agregamos el campo 'path' para almacenar la ruta de la imagen
            $table->unsignedBigInteger('producto_id'); // Agregamos el campo 'producto_id'
            $table->timestamps();

            // Definimos la relación con la tabla 'productos'
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('imagenproductos', function (Blueprint $table) {
            // Eliminamos la relación con la tabla 'productos'
            $table->dropForeign(['producto_id']);
        });

        Schema::dropIfExists('imagenproductos');
    }
};

