<?php

use Illuminate\Database\Seeder;
//use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        /*
        //	Borramos	los	datos	de	la	tabla
        DB::table('users')->delete();
        //	Añadimos	una	entrada	a	esta	tabla
		User::create(array('email'	=>	'foo@bar.com'));
        */

        /*
        Model::unguard();
            $this->call(UsuariosTableSeeder::class);
        

        Model::reguard();
        */
    }
}
