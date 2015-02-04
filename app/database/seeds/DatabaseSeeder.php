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
                
                
//                Admin::truncate();
//                Client::truncate();
//                User::truncate();
                
                
                $this->call('AdminSeeder');
                $this->call('ClientSeeder');
                $this->call('UserSeeder');
	}

}
