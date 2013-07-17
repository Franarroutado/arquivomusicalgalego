<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateFechaFromRegistrosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registros', function(Blueprint $table) {
            $table->dropColumn('fecha');
        });
        Schema::table('registros', function(Blueprint $table) {
            $table->string('fecha', 4);   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registros', function(Blueprint $table) {
            $table->dropColumn('fecha');
        });
        Schema::table('registros', function(Blueprint $table) {
            $table->timestamp('fecha', 4);   
        });
    }

}
