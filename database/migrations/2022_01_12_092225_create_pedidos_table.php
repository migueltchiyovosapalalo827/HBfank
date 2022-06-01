<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('pedido_especial')->nullable();
			$table->integer('quantidade')->default(1);
			$table->enum('forma_de_pagamento', array('cash', 'transferencia','deposito'));
            $table->string('referencia_de_pagamento')->nullable();
			$table->enum('estado', array('pendente', 'aceito', 'rejeitado', 'entregue', 'recusado'))->default('pendente');
			$table->double('total')->default(0);
			$table->double('iva')->default(0);
			$table->unsignedBigInteger('cliente_id');
			$table->string('nota');
            $table->string('endereco');
            $table->double('taxa_de_entrega')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
