<?php

namespace App\Model\Admin\Setup;

use Illuminate\Database\Eloquent\Model;

class SurvivorSupportName extends Model
{
    public function survivorsupporttype(){
    	return $this->belongsTo(SurvivorSupportType::class, 'survivor_support_type_id','id');
    }
}
