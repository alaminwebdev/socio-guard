<?php

namespace App\Model\Admin\Incident;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Incident\SurvivorIncidentInformation;

class SurvivorOtherOrganizationSupport extends Model
{
    protected  $fillable = [
    	'survivor_id',
    	'survivor_incident_info_id',
    	'survivor_final_support_id',
        'other_program',
    	'survivor_other_support_date',
    	'other_organization_support_description',
    	'created_by',
    	'updated_by'
    ];

    public function other_organization_final_support()
    {
        return $this->belongsTo(SurvivorFinalSupport::class, 'survivor_final_support_id', 'id');
    }

    public function survivor_incident_information()
    {
        return $this->belongsTo(SurvivorIncidentInformation::class, 'survivor_incident_info_id', 'id');
    }
}
