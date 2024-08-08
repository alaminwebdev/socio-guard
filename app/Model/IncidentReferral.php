<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Setup\SecondaryRefferal;

class IncidentReferral extends Model
{
    public function complain_received_refferal()
    {
        return $this->belongsTo(SecondaryRefferal::class, 'referral_id','id');
    }
}
