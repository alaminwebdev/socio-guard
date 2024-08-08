<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildMarriageAssistanceTaken extends Model {
    use SoftDeletes;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function assistanceTakens() {
        return $this->belongsToMany(ChildMarriageInformation::class, 'child_marriage_assistance_information')->withTimestamps();
    }
}
