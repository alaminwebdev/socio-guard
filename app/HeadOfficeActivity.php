<?php

namespace App;

use App\Model\Setup\HeadOfficeActivityEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadOfficeActivity extends Model
{
    use SoftDeletes;
    public function ho_event()
    {
        return  $this->hasOne(HeadOfficeActivityEvent::class, 'id',  'ho_event_id',);
    }
}
