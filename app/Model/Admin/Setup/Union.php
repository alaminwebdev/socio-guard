<?php

namespace App\Model\Admin\Setup;

use App\Model\PollisomajSetup;
use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    public function pollisomaj(){
        return $this->hasMany(PollisomajSetup::class, 'union_id', 'id');
    }
    public function division(){
    	return $this->belongsTo(Division::class, 'division_id','id');
    }

    public function district(){
    	return $this->belongsTo(District::class, 'district_id','id');
    }

    public function upazila(){
    	return $this->belongsTo(Upazila::class, 'upazila_id','id');
    }
}
