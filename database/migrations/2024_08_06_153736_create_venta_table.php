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
        Schema::create('Venta', function (Blueprint $table) {
            $table->bigIncrements('codVenta')->primary();
            $table->date('fechaVenta');
            $table->float('montoTotal',8,2);
            $table->integer('codEncargado');
            $table->foreign('codEncargado')->references('carnetIdentidad')->on('Encargado');
            $table->integer('codCliente');
            $table->foreign('codCliente')->references('carnetIdentidad')->on('Cliente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venta');
    }
};
