<?php

namespace App\Model;

use App\Model\Setup\PTshowEvent;

use Illuminate\Database\Eloquent\Model;

class SelpPtShowActivity extends Model
{
    public function event_name()
    {
        return $this->belongsTo(PTshowEvent::class, 'event_id', 'id');
    }

    // Accessor for participant_pwd_total
    public function getParticipantPwdTotalAttribute()
    {
        if ($this->attributes['participant_pwd_total'] == null) {
            return (
                $this->attributes['participant_pwd_boys'] +
                $this->attributes['participant_pwd_girls'] +
                $this->attributes['participant_pwd_men'] +
                $this->attributes['participant_pwd_women'] +
                $this->attributes['participant_pwd_other_gender']
            );
        }

        return $this->attributes['participant_pwd_total'];
    }
}
