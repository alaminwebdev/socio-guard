<?php

namespace App;

use App\Model\Admin\Setup\Occupation;
use App\Model\Education;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SwapnosarothiMarriageInfo extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    
    protected $casts = [
        'marriage_date'  => 'date',
    ];

    public function whoRegistered(){
        return $this->hasOne(SwapnosarothiCmMarriageRegister::class, 'id', 'who_registered');
    }
    public function marriagePlace(){
        return $this->hasOne(SwapnosarothiCmMarriagePlace::class, 'id', 'marriage_place');
    }
    public function marriageReason(){
        return $this->hasOne(SwapnosarothiCmMarriagReason::class, 'id', 'marriage_reason');
    }
    public function marriagInitiatedPerson(){
        return $this->hasOne(SwapnosarothiCmWhoInitiatedMarriag::class, 'id', 'marriag_initiated_person');
    }
    public function girlEducational(){
        return $this->hasOne(Education::class, 'id', 'girl_educational');
    }
    public function educatinalInstitution(){
        return $this->hasOne(SwapnosarothiCmGirlInstituteonType::class, 'id', 'educatinal_institution');
    }

    public function groomProfession(){
        return $this->hasOne(Occupation::class, 'id', 'groom_profession');
    }
    public function groomEducation(){
        return $this->hasOne(Education::class, 'id', 'groom_education');
    }

}
