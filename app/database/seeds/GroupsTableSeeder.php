<?php

class GroupsTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('groups')->delete();
      //DB::table('users_groups')->delete();
      //
      $administrator= ['name'=>'administrator',
        'permissions' => [
          'autores.index' => 1,
          'registros.index' => 1,
          'centros.index' => 1,
          'generos.index' => 1,
          'materiales.index' => 1,
        ]];

      $moderador = ['name'=>'moderador',
        'permissions' => [
          'autores.index' => 1,
          'registros.index' => 1,
          'centros.index' => 0,
          'generos.index' => 1,
          'materiales.index' => 0,
        ]];
      $editor = ['name'=>'editor',
        'permissions' => [
          'autores.index' => 1,
          'registros.index' => 1,
          'centros.index' => 0,
          'generos.index' => 1,
          'materiales.index' => 0,
        ]];

      Sentry::getGroupProvider()->create($administrator);
      Sentry::getGroupProvider()->create($moderador);
      Sentry::getGroupProvider()->create($editor);

      // Uncomment the below to run the seeder
      //DB::table('groups')->insert($groups);
    }

}