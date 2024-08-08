<?php

namespace App\Model\Admin\Setup\CEP_Region;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\SetupUser;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Union;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class SetupUserArea extends Model
{
    use SoftDeletes;
    protected $table='setup_user_areas';
	public function setup_user() 
	{
    	return $this->belongsTo(SetupUser::class, 'setup_user_id', 'id');
    }

    public function users() 
	{
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function setup_user_region() 
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function setup_user_division() 
	{
    	return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function setup_user_district() 
	{
    	return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function setup_user_upazila() 
	{
    	return $this->belongsTo(Upazila::class, 'upazila_id', 'id');
    }

    public function setup_user_union() 
	{
    	return $this->belongsTo(Union::class, 'union_id', 'id');
    }
}
