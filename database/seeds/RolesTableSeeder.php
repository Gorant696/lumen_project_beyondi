<?php

use Illuminate\Database\Seeder;
use App\Roles;

class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Roles $roles) {
        
        $roleslist = ['admin', 'moderator', 'employee'];

        foreach ($roleslist as $role) {

            $roles->insert([
                'name' => $role, 
                'key' => $role
            ]);
        }
    }

}
