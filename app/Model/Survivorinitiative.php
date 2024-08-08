<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\SelpIncidentModel;
class Survivorinitiative extends Model
{
    protected $table='survivorinitiatives';
    public function selp_iniciative()
    {
        return $this->hasOne(SelpIncidentModel::class, 'earlier_survivor_initiative_place');
    }

}
