<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Upazila;

class ActivityModel extends Model
{
    protected $table='selp_activities';


    public function meeting_activity()
    {
        return $this->hasMany(SelpMeetingActivity::class,'selp_activities_id','id');
    }

    public function training_activity()
    {
        return $this->hasMany(SelpTrainingActivity::class,'selp_activities_id','id');
    }

    public function community_activity()
    {
        return $this->hasMany(SelpCommunityActivity::class,'selp_activities_id','id');
    }

    public function campaign_activity()
    {
        return $this->hasMany(SelpCampaignActivity::class,'selp_activities_id','id');
    }

    public function pt_show_activity()
    {
        return $this->hasMany(SelpPtShowActivity::class,'selp_activities_id','id');
    }

    public function pt_production_activity()
    {
        return $this->hasMany(SelpPtProductionActivity::class,'selp_activities_id','id');
    }

    public function zones(){
        return $this->belongsTo(Region::class,'employee_zone_id','id');
    }

    public function division(){
        return $this->belongsTo(Division::class,'employee_division_id','id');
    }

    public function district(){
        return $this->belongsTo(District::class,'employee_district_id','id');
    }

    public function upazilla(){
        return $this->belongsTo(Upazila::class,'employee_upazila_id','id');
    }
}
