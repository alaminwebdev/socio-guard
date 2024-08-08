<?php

namespace App\Model;

use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PollisomajSetup extends Model
{
    use SoftDeletes;
    protected $table='pollisomaj_setup';


    public function zone(){
        return $this->belongsTo(Region::class,'zone_id');
    }

    public function division(){
        return $this->belongsTo(Division::class,'division_id');
    }

    public function district(){
        return $this->belongsTo(District::class,'district_id');
    }
    public function upazila(){
        return $this->belongsTo(Upazila::class,'upazila_id');
    }

    public function union(){
        return $this->belongsTo(Union::class,'union_id');
    }

    public function village(){
        return $this->belongsTo(Village::class,'village_id');
    }
}
