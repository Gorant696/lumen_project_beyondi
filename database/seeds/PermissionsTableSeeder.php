<?php

use Illuminate\Database\Seeder;
use App\Permissions;

class PermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Permissions $permissions) {
        
        $permissionlist = ['Create', 'Delete', 'Addrole', 'Removerole', 'Update', 'Read'];

        foreach ($permissionlist as $permission) {

            $permissions->insert([
                'name' => $permission,
                'permission_key' => strtolower($permission), 
            ]);
        }
    }

}
