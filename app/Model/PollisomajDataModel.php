<?php

namespace App\Model;

use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Village;
use App\Model\PollisomajSetup;
use Illuminate\Database\Eloquent\Model;

class PollisomajDataModel extends Model
{
    protected $table='pollisomaj_data';


    /**
     * Get the pollisomaj theatre list for the blog post.
     */
    public function theatreList()
    {
        return $this->hasMany(PollisomajTheatreModel::class,'pollisomaj_ref_id','pollisomaj_data_ref');
    }

    public function pollisomaj_info(){
        return $this->belongsTo(PollisomajSetup::class,'pollisomaj_no','pollisomaj_no');
    }

    public function zones(){
        return $this->belongsTo(Region::class,'zone_id','id');
    }

    public function division(){
        return $this->belongsTo(Division::class,'division_id','id');
    }

    public function district(){
        return $this->belongsTo(District::class,'district_id','id');
    }


    public function upazilla(){
        return $this->belongsTo(Upazila::class,'upazilla_id','id');
    }

    public function union(){
        return $this->belongsTo(Union::class,'union_id','id');
    }
}
