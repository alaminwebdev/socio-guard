<?php

namespace App\Model\Admin\Setup;

use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\SelpIncidentModel;
use Illuminate\Database\Eloquent\Model;

class InformationProviderSource extends Model {
    public function survivor_incident_information() {
        return $this->hasMany(SurvivorIncidentInformation::class, 'provider_source_id', 'id');
    }
    public function incident_informations() {
        return $this->hasMany(SelpIncidentModel::class, 'information_provider_source_id', 'id');
    }
}
