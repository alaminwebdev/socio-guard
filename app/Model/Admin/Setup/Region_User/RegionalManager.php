<?php

namespace App\Model\Admin\Setup\Region_User;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\CEP_Region\Region;

class RegionalManager extends Model
{
	public function region() 
	{
    	return $this->belongsTo(Region::class, 'region_id', 'id');
    }
}
