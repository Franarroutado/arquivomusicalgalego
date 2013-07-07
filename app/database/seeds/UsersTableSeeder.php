<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('users')->delete();

        $users = ['email' => 'amg@amg.com', 'password' => 'test', 'first_name' => 'superadmin'];

        $newUser = Sentry::getUserProvider()->create($users);      

        // Get the activation code
        $activationCode = $newUser->getActivationCode();
        // Attempt activate account
        $newUser->attemptActivation($activationCode);

        // Uncomment the below to run the seeder
        //DB::table('users')->insert($users);
    }

}