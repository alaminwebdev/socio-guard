<?php

namespace App;

use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Upazila;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildMarriageInformation extends Model {
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $table = "child_marriage_informations";

    public function employee_upazila() {
        return $this->belongsTo(Upazila::class, 'employee_upazila_id', 'id');
    }

    public function employee_district() {
        return $this->belongsTo(District::class, 'employee_district_id', 'id');
    }

    public function employee_division() {
        return $this->belongsTo(Division::class, 'employee_division_id', 'id');
    }

    public function employee_zone() {
        return $this->belongsTo(Region::class, 'employee_zone_id', 'id');
    }

    public function child_union() {
        return $this->belongsTo(Union::class, 'child_union_id', 'id');
    }

    public function child_upazila() {
        return $this->belongsTo(Upazila::class, 'child_upazila_id', 'id');
    }

    public function child_district() {
        return $this->belongsTo(District::class, 'child_district_id', 'id');
    }

    public function child_division() {
        return $this->belongsTo(Division::class, 'child_division_id', 'id');
    }
    public function gender() {
        return $this->belongsTo(Gender::class, 'child_gender_id', 'id');
    }
    public function disability() {
        return $this->belongsTo(SurvivorAutisticInformation::class, 'survivor_autistic_information_id', 'id');
    }
    public function child_marriage_initiative() {
        return $this->belongsTo(ChildMarriageInitiative::class, 'child_marriage_initiative_id', 'id');
    }

    public function person_union() {
        return $this->belongsTo(Union::class, 'person_union_id', 'id');
    }

    public function person_upazila() {
        return $this->belongsTo(Upazila::class, 'person_upazila_id', 'id');
    }

    public function person_district() {
        return $this->belongsTo(District::class, 'person_district_id', 'id');
    }

    public function person_division() {
        return $this->belongsTo(Division::class, 'person_division_id', 'id');
    }

    public function assistanceTakens() {
        return $this->belongsToMany(ChildMarriageAssistanceTaken::class, 'child_marriage_assistance_information')->withTimestamps();
    }

}
