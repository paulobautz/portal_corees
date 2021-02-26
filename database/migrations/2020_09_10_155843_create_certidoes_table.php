<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertidoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certidoes', function (Blueprint $table) {
            $table->string('numero');
            $table->string('nome');
            $table->string('cpf_cnpj');
            $table->string('registro_core');
            $table->string('tipo');
            $table->string('codigo');
            $table->text('declaracao');
            $table->time('hora_emissao');
            $table->date('data_emissao');
            $table->date('data_validade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certidoes');
    }
}
