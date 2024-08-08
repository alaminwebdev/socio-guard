<?php

namespace App\Model;
use App\Model\Setup\PTproductionEvent;

use Illuminate\Database\Eloquent\Model;

class SelpPtProductionActivity extends Model
{
    public function event_name()
    {
        return $this->belongsTo(PTproductionEvent::class,'event_id','id');
    }
}
