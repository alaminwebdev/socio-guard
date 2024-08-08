<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SwapnosarothiProfileSkill extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'skill_date'  => 'date',
    ];

    public function profile(){
        return $this->hasOne(SwapnosarothiProfile::class, 'id', 'profile_table_id');
    }
    public function group(){
        return $this->hasOne(SwapnosarothiSetupGroup::class, 'id', 'group_table_id');
    }
    public function skill(){
        return $this->hasOne(SwapnosarothiSkill::class, 'id', 'skill_table_id');
    }
    
}
