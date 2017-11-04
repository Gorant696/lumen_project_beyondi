<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model {
    
       public function roles(){
        
       return $this->belongstomany(Roles::class, 'roles_permissions', 'permissions_id', 'roles_id');
        
    }
    
}
