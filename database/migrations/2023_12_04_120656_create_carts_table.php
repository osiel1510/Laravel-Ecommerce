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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id'); // Agrega producto_id como clave foránea
            $table->unsignedBigInteger('user_id'); // Agrega user_id como clave foránea
            $table->unsignedInteger('quantity'); // Agrega la columna de cantidad
            $table->timestamps();
            
            // Definir las relaciones de clave foránea
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

