<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {
    
    public $timestamps = false;
     public function users(){
        
       return $this->belongstomany(User::class, 'user_roles', 'role_id', 'user_id');
        
    }

     public function permissions(){
         
       return $this->belongstomany(Permissions::class, 'role_permissions', 'role_id', 'permission_id');
         
     }
    
}
