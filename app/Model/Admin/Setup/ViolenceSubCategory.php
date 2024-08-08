<?php

namespace App\Model\Admin\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Incident\SurvivorIncidentInformation;

class ViolenceSubCategory extends Model
{
    public function violencecategory(){
    	return $this->belongsTo(ViolenceCategory::class,'violence_category_id','id');
    }

    public function survivor_incident_information()
    {
        return $this->hasMany(SurvivorIncidentInformation::class, 'violence_sub_category_id', 'id');
    }
}
