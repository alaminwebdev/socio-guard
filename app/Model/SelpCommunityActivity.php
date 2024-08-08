<?php

namespace App\Model;
use App\Model\Setup\CommunityEvent;

use Illuminate\Database\Eloquent\Model;

class SelpCommunityActivity extends Model
{
    public function event_name()
    {
        return $this->belongsTo(CommunityEvent::class,'event_id','id');
    }
}
