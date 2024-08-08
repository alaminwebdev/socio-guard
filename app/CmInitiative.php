<?php

namespace App;

use App\SwapnosarothiCmPreventionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmInitiative extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'date'  => 'date',
    ];

    public function preventionType()
    {
        return $this->hasOne(SwapnosarothiCmPreventionType::class, 'id', 'prevention_type');
    }

    public function preventionBy()
    {
        return $this->hasOne(SwapnosarothiCmPrevention::class, 'id', 'prevention_by');
    }
    public function profile()
    {
        return $this->hasOne(SwapnosarothiProfile::class, 'id', 'swapnosarothi_profile_id');
    }

    /**
     * Scope to retrieve records with a 1st Initiative.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithFirstInitiative($query)
    {
        return $query->where('initiative', '=', '1st');
    }

    /**
     * Scope to retrieve records with a 2nd Initiative.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithSecondInitiative($query)
    {
        return $query->where('initiative', '2nd');
    }
}
