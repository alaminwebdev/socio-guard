<?php

namespace App\Model\Admin\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\SurvivorFinalSupport;

class SurvivorSupportOrganization extends Model
{
    public function brac_final_support()
    {
        return $this->belongsTo(SurvivorFinalSupport::class, 'survivor_final_support_id', 'id');
    }

    public function final_support()
    {
        return $this->hasMany(SurvivorFinalSupport::class, 'survivor_support_organization_id', 'id');
    }
}
