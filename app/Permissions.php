<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model {
    
       public function roles(){
        
       return $this->belongstomany(Roles::class, 'role_permissions', 'permission_id', 'role_id');
        
    }
    
}
