<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegistrosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
			$table->integer('autore_id');
			$table->integer('genero_id');
			$table->boolean('arreglista');
			$table->string('tipo', 10);
			$table->timestamp('fecha');
			$table->text('material');
			$table->integer('centro_id');
			$table->string('fondo', 100);
			$table->string('edicion', 100);
			$table->text('comentarios');
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
        Schema::drop('registros');
    }

}
