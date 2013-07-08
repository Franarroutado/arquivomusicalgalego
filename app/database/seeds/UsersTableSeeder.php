<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('users')->delete();

        $administrator = ['email' => 'admin@amg.com', 'password' => 'admin', 'first_name' => 'admin'];
        $editor = ['email' => 'editor@amg.com', 'password' => 'editor', 'first_name' => 'editor'];
        $moderator = ['email' => 'moderator@amg.com', 'password' => 'moderator', 'first_name' => 'moderator'];

        $newUser[] = Sentry::getUserProvider()->create($administrator);  
        $newUser[] = Sentry::getUserProvider()->create($editor); 
        $newUser[] = Sentry::getUserProvider()->create($moderator);     

        foreach ($newUser as $user) {
            // Get the activation code
            $activationCode = $user->getActivationCode();
            // Attempt activate account
            $user->attemptActivation($activationCode);
        }
        

        // Uncomment the below to run the seeder
        //DB::table('users')->insert($users);
    }

}