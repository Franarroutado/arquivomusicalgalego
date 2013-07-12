<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCentrosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centros', function(Blueprint $table) {
            $table->increments('id');
            $table->string('abrev');
			$table->string('nombre');
			$table->text('cuerpo');
			$table->integer('user_id');
			$table->text('contacto');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('centros');
    }

}
