<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('GroupsTableSeeder');
		$this->call('UsersgroupsTableSeeder');
		$this->call('AutoresTableSeeder');
		$this->call('GenerosTableSeeder');
		$this->call('MaterialesTableSeeder');
		$this->call('CentrosTableSeeder');
		$this->call('RegistrosTableSeeder');
	}

}