<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SurvivorCourtCaseModel extends Model
{
    protected $table='survivor_court_cases';
    
    public function selpincident(){
        return $this->belongsTo(SelpIncidentModel::class,'selp_incident_information_id');
    }

    public function civil_case(){
        return $this->belongsTo(Civilcase::class,'court_case_id', 'id');
    }

    public function police_case(){
        return $this->belongsTo(Policecase::class,'court_case_id', 'id');
    }

    public function  petition_case (){
        return $this->belongsTo(Pititioncase::class,'court_case_id', 'id');
    }

    public function moneyrecover_case(){
        return $this->belongsTo(Moneyrecover::class,'moneyrecover_case_id', 'id');
    }

    public function judgement_status(){
        return $this->belongsTo(Judgementstatus::class,'judjementstatus_id', 'id');
    }
}
