<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		Schema::table('bairros', function(Blueprint $table) {
			$table->foreign('cidade_id')->references('id')->on('cidades')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('clientes', function(Blueprint $table) {
			$table->foreign('bairro_id')->references('id')->on('bairros')
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
        Schema::dropIfExists('_foreign_keys');
    }
}
