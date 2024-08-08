<?php

namespace App\Model\Admin\Setup;

use Illuminate\Database\Eloquent\Model;

class CityCorporation extends Model
{
    public function division(){
    	return $this->belongsTo(Division::class, 'division_id','id');
    }
}
