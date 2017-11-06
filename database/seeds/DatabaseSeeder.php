<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // $this->call('UsersTableSeeder');
     //   $this->call('Users_rolesTableSeeder');
        
         DB::table('users')->insert([
            'name' => 'goran',
            'email' => 'goran@gmail.com',
            'password' => app('hash')->make('password'),
        ]);
        
        
       
    }
}
