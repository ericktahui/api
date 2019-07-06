<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        //	Borramos	los	datos	de	la	tabla
        DB::table('users')->delete();
        //	Añadimos	una	entrada	a	esta	tabla
		User::create(array('email'	=>	'foo@bar.com'));

    }
}
