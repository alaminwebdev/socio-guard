<?php

namespace App\Model\Admin\Setup;

use Illuminate\Database\Eloquent\Model;

class Pourosova extends Model
{
    public function division(){
    	return $this->belongsTo(Division::class, 'division_id','id');
    }

    public function district(){
    	return $this->belongsTo(District::class, 'district_id','id');
    }
}
