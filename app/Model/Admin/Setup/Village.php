<?php

namespace App\Model\Admin\Setup;

use App\Model\PollisomajSetup;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $guarded = ['id'];


    public function pollisomaj(){
        return $this->hasMany(PollisomajSetup::class, 'village_id', 'id');
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

    public function union(){
    	return $this->belongsTo(Union::class, 'union_id','id');
    }
}
