<?php

namespace App\Model\Admin\Setup;

use App\Model\PollisomajSetup;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    public function pollisomaj(){
        return $this->hasMany(PollisomajSetup::class, 'upazila_id', 'id');
    }
    public function division(){
    	return $this->belongsTo(Division::class, 'division_id','id');
    }

    public function district(){
    	return $this->belongsTo(District::class, 'district_id','id');
    }
}
