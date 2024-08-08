<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public function employee_info(){
    	return $this->belongsTo(User::class, 'employee_id','id');
    }
}
