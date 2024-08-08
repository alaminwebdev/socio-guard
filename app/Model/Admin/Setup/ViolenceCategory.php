<?php

namespace App\Model\Admin\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Incident\SurvivorIncidentInformation;

class ViolenceCategory extends Model
{
    public function survivor_incident_information()
    {
        return $this->hasMany(SurvivorIncidentInformation::class, 'violence_category_id', 'id');
    }
}
