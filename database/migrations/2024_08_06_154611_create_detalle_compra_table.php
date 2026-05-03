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
        Schema::create('DetalleCompra', function (Blueprint $table) {
            $table->float('precioCompra',8,2);
            $table->integer('cantidad');
            $table->primary(['codCompra', 'codProducto']);
            $table->foreignId('codCompra');
            $table->foreign('codCompra')->references('codCompra')->on('Compra');
            $table->string('codProducto');
            $table->foreign('codProducto')->references('codProducto')->on('Producto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalleCompra');
    }
};
