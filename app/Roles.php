<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {
    
     public function users(){
        
       return $this->belongstomany(User::class, 'users_roles', 'roles_id', 'users_id');
        
    }

     public function permissions(){
         
       return $this->belongstomany(Permissions::class, 'roles_permissions', 'roles_id', 'permissions_id');
         
     }
    
}
