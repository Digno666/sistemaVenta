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
        Schema::create('Compra', function (Blueprint $table) {
            $table->bigIncrements('codCompra')->primary();
            $table->date('fechaCompra');
            $table->float('montoTotal',8,2);
            $table->integer('codEncargado');
            $table->foreign('codEncargado')->references('carnetIdentidad')->on('Encargado');
            $table->foreignId('codProveedor');
            $table->foreign('codProveedor')->references('codProveedor')->on('Proveedor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compra');
    }
};
