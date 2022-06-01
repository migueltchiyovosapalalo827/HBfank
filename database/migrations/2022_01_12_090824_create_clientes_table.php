<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('nome');
			$table->string('email')->unique();
			$table->string('phone');
			$table->unsignedBigInteger('bairro_id');
			$table->string('password');
			$table->string('imagens')->nullable();
			$table->string('api_token')->nullable();
            $table->string('pin_code')->nullable();
            $table->boolean('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
