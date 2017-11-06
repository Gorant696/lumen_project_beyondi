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
        
        $permissionlist = ['create', 'delete', 'changestatus', 'update', 'read'];

        foreach ($permissionlist as $permission) {

            $permissions->insert([
                'name' => $permission,
                'key' => $permission, 
            ]);
        }
    }

}
