<?php

use Illuminate\Database\Seeder;
use App\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(User $user)
    {
       
     
        
        $users_to_seed = [
            [
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => app('hash')->make('secret'),
            ],

            [
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => app('hash')->make('secret'),
            ],
             [
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => app('hash')->make('secret'),
            ]
        ];

        foreach ($users_to_seed as $seeded) {
            $user->create($seeded);
        }
    }
}
