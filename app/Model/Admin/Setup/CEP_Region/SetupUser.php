<?php

namespace App\Model\Admin\Setup\CEP_Region;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Role;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\DistrictManager;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use Illuminate\Database\Eloquent\SoftDeletes;
class SetupUser extends Model
{
    use SoftDeletes;
	public function setup_user_area()
    {
    	return $this->hasMany(SetupUserArea::class, 'setup_user_id', 'id');
    }

    public function region() 
	{
    	return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
