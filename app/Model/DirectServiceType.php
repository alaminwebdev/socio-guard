<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DirectServiceType extends Model
{
    protected $table='direct_service_types';

    public function direct_adrs(){
        return $this->hasMany(SurvivorDirectServiceModel::class, 'selp_incident_information_id', 'selp_incident_id');

    }
    
    public function court_case(){
        return $this->hasMany(SurvivorCourtCaseModel::class, 'selp_incident_information_id', 'selp_incident_id');

    }
    

}
