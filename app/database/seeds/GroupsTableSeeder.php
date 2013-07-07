<?php

class GroupsTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('groups')->delete();
      DB::table('users_groups')->delete();

      $groups = [
        'name'=>'administrator',
        'permisssions' => [
          'admin' => 1,
          'supervisor' => 1
        ]
      ];

      Sentry::

      // Uncomment the below to run the seeder
      DB::table('groups')->insert($groups);
    }

}