<?php

use Illuminate\Database\Seeder;
use App\Roles;
use App\Permissions;

class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Roles $roles, Permissions $permissions) {
        
        $roleslist = [
            'admin' => 
            [
                'name' => 'Admin', 
                'permissions' => ['create', 'delete', 'changestatus', 'update', 'read']
           ], 
            'moderator' => [
                'name' => 'My Moderator', 
                'permissions' => ['create', 'edit']
           ], 
            'employee' => [
                'name' => 'Employee', 
                'permissions' => ['read']
           ], 
         ];

        foreach ($roleslist as $key => $value) {
            $model = $roles->create([
                'name' => $value['name'], 
                'role_key' => $key,
            ]);
            
            $query = [];
            foreach($value['permissions'] as $permission) {
                $query[] = "permission_key = '$permission'";
            }
     
            $ids = $permissions->whereRaw(implode($query, " OR "))->get()->pluck('id')->toArray();
            
            $model->permissions()->attach($ids);
            
            
        }
        
                    //foreach permission
            
        
    }

}
