<?php

namespace App\Model;
use App\Model\Setup\TrainingEvent;

use Illuminate\Database\Eloquent\Model;

class SelpTrainingActivity extends Model
{
    public function event_name()
    {
        return $this->belongsTo(TrainingEvent::class,'event_id','id');
    }
}
