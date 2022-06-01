<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function(Blueprint $table) {
			$table->foreign('cliente_id')->references('id')->on('clientes')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('pedido_producto', function(Blueprint $table) {
			$table->foreign('producto_id')->references('id')->on('productos')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('pedido_producto', function(Blueprint $table) {
			$table->foreign('pedido_id')->references('id')->on('pedidos')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('pagamentos', function(Blueprint $table) {
			$table->foreign('pedido_id')->references('id')->on('pedidos')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_foreign_keys2');
    }
}
