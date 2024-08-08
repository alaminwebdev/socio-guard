<?php

namespace App\Model\Admin\Setup\CEP_Region;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;

class RegionArea extends Model
{
	public function region() 
	{
    	return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function region_area_detail()
    {
        return $this->hasMany(RegionAreaDetail::class, 'region_area_id', 'id');
    }
}
