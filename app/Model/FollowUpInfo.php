<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FollowUpInfo extends Model
{
    public function findings_followup(){
        return $this->belongsTo(Followup::class,'followup_findings', 'id');
    }
}
