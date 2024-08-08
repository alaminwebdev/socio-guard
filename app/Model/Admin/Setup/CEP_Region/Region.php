<?php

namespace App\Model\Admin\Setup\CEP_Region;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\CEP_Region\SetupUser;
use App\Model\Admin\Setup\CEP_Region\RegionArea;
use App\Model\PollisomajDataModel;
use App\Model\PollisomajSetup;

class Region extends Model
{
    public function pollisomaj(){
        return $this->hasMany(PollisomajSetup::class, 'zone_id', 'id');
    }
	public function region_area()
    {
    	return $this->hasMany(RegionArea::class, 'region_id', 'id');
    }

    public function setup_user()
    {
    	return $this->hasMany(SetupUser::class, 'region_id', 'id');
    }

    public function pollisomajdata(){
        return $this->hasMany(PollisomajDataModel::class, 'zone_id', 'id');
    }

    public function region_detail()
    {
        return $this->hasMany(RegionAreaDetail::class, 'region_id', 'id');
    }

}
