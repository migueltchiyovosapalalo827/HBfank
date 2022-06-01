<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocoes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('nome');
			$table->string('descricao');
			$table->date('inicio');
			$table->date('fim');
			$table->string('imagens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocoes');
    }
}
