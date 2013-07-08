<?php

class UsersgroupsTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('users_groups')->delete();

      // Get user admin@amg.com editor@amg.com moderator@amg.com
      // administrator moderador editor
      $user = Sentry::getUserProvider()->findByLogin('admin@amg.com');
      $group = Sentry::getGroupProvider()->findByName('administrator');

      $users_groups[] = [
        'user_id' => $user->id,
        'group_id' => $group->id,
      ]; 

      $user = Sentry::getUserProvider()->findByLogin('editor@amg.com');
      $group = Sentry::getGroupProvider()->findByName('editor');

      $users_groups[] = [
        'user_id' => $user->id,
        'group_id' => $group->id,
      ]; 

      $user = Sentry::getUserProvider()->findByLogin('moderator@amg.com');
      $group = Sentry::getGroupProvider()->findByName('moderador');

      $users_groups[] = [
        'user_id' => $user->id,
        'group_id' => $group->id,
      ]; 

        // Uncomment the below to run the seeder
        DB::table('users_groups')->insert($users_groups);
    }

}