<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveLangFromGenerosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generos', function(Blueprint $table) {
            $table->dropColumn('lang');
        });
        Schema::table('generos', function(Blueprint $table) {
            $table->text('lang');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generos', function(Blueprint $table) {
            $table->string('lang', 5);          
        });
    }

}
