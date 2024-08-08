<?php

namespace App\Model\Admin\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\SurvivorSupportOrganization;
use App\Model\Admin\Incident\SurvivorBracSupport;

class SurvivorFinalSupport extends Model
{
    public function organizationtype()
    {
    	return $this->belongsTo(SurvivorSupportOrganization::class, 'survivor_support_organization_id', 'id');
    }

    public function survivor_brac_support()
    {
    	return $this->hasMany(SurvivorBracSupport::class, 'survivor_final_support_id', 'id');
    }
}
