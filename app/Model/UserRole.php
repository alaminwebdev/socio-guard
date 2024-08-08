<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
	protected $fillable = ['user_id','role_id'];
	
    public function role_details() 
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
