<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public function parent_role() 
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
