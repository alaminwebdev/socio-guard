<?php

namespace App\Model\Admin\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Incident\SurvivorIncidentInformation;

class OrganizationName extends Model
{
    public function survivor_incident_information()
    {
        return $this->hasMany(SurvivorIncidentInformation::class, 'provider_organization_name_id', 'id');
    }

    public function organizationtype(){
    	return $this->belongsTo(SurvivorSupportOrganization::class, 'support_organization_id','id');
    }

}
