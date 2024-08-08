<?php

namespace App\Model;
use App\Model\Setup\CampaignEvent;

use Illuminate\Database\Eloquent\Model;

class SelpCampaignActivity extends Model
{
    public function event_name()
    {
        return $this->belongsTo(CampaignEvent::class,'event_id','id');
    }
}
