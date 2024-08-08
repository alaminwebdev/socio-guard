<?php

namespace App\Model\Admin\Incident;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\Program;
use App\Model\Admin\Setup\SurvivorSupportOrganization;
use App\Model\Admin\Incident\SurvivorIncidentInformation;

class SurvivorBracSupport extends Model
{
    protected  $fillable = [
    	'survivor_id',
    	'survivor_incident_info_id',
    	'survivor_support_date',
    	'survivor_final_support_id',
    	'brac_program_id',
    	'brac_support_description',
    	'created_by',
    	'updated_by'
    ];

    public function brac_final_support()
    {
        return $this->belongsTo(SurvivorFinalSupport::class, 'survivor_final_support_id', 'id');
    }

    public function brac_program()
    {
        return $this->belongsTo(Program::class, 'brac_program_id', 'id');
    }

    // public function survivor_support_organization()
    // {
    //     return $this->belongsTo(SurvivorSupportOrganization::class, 'brac_program_id', 'id');
    // }

    public function survivor_incident_information()
    {
        return $this->belongsTo(SurvivorIncidentInformation::class, 'survivor_incident_info_id', 'id');
    }

    public function scopeFemale($query)
    {
        return $query->whereHas('survivor_incident_information', function($q){
            $q->where('survivor_gender_id',2);
        });
    }

    public function scopeMale($query)
    {
        return $query->whereHas('survivor_incident_information', function($q){
            $q->where('survivor_gender_id',1);
        });
    }

}
