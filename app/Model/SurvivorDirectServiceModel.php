<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SurvivorDirectServiceModel extends Model
{
    protected $table='survivor_direct_services';

    public function selpincident(){
        return $this->belongsTo(SelpIncidentModel::class,'selp_incident_information_id');
    }

    public function incident_district(){
        return $this->belongsTo(SelpIncidentModel::class,'selp_incident_ref', 'selp_incident_ref');
    }
    
    public function alternative_dispute_resolution(){
        return $this->belongsTo(AlternativeDisputeResolution::class,'alternative_dispute_resolution_id', 'id');
    }
    
    public function adr_money_recovered(){
        return $this->belongsTo(Adrmoneyrecover::class,'money_recovered_through_adr', 'id');
    }

    public function getStartDateAttributes($value){
        return date('d-m-Y',strtotime($value));
    }

    public function getClosingDateAttributes($value){
        return date('d-m-Y',strtotime($value));
    }
}
