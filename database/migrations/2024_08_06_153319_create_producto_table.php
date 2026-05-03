<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Producto', function (Blueprint $table) {
            $table->string('codProducto')->primary();
            $table->string('nombre');
            $table->string('descripcion');
            $table->float('precio');
            $table->integer('stock')->default(0);
            $table->string('imagen')->nullable();
            $table->string('codCategoria');
            $table->foreign('codCategoria')->references('codCategoria')->on('Categoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
};
