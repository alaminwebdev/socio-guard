<?php

namespace App\Model;
use App\Model\Setup\MeetingEvent;

use Illuminate\Database\Eloquent\Model;

class SelpMeetingActivity extends Model
{
    public function event_name()
    {
        return $this->belongsTo(MeetingEvent::class,'event_id','id');
    }
}
