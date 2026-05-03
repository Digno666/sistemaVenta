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
        Schema::create('DetalleVenta', function (Blueprint $table) {
            $table->float('precioVenta',8,2);
            $table->integer('cantidad');
            $table->primary(['codVenta', 'codProducto']);
            $table->foreignId('codVenta');
            $table->foreign('codVenta')->references('codVenta')->on('Venta');
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
        Schema::dropIfExists('detalleVenta');
    }
};
