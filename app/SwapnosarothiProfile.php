<?php

namespace App;

use Carbon\Carbon;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Setup\DropoutReason;
use App\Model\Setup\MigratedReason;
use Illuminate\Database\Eloquent\SoftDeletes;

class SwapnosarothiProfile extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'date_of_birth'  => 'date',
        'start_date' => 'date',
        'age_completion_date' => 'date',
    ];


    public function cmInitiatives()
    {
        return $this->hasMany(CmInitiative::class, 'swapnosarothi_profile_id', 'id');
    }

    public function marriageInfo()
    {
        return $this->hasOne(SwapnosarothiMarriageInfo::class, 'swapnosarothi_profile_id', 'id');
    }

    public function groupName()
    {
        return  $this->hasOne(SwapnosarothiSetupGroup::class, 'id',  'group_id',);
    }
    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = (new Carbon($value))->format('Y-m-d');
    }

    public function profile_division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function profile_district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function profile_upazila()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id', 'id');
    }

    public function profile_union()
    {
        return $this->belongsTo(Union::class, 'union_id', 'id');
    }
    public function profile_village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }
    public function profile_skills()
    {
        return $this->hasMany(SwapnosarothiProfileSkill::class, 'profile_table_id', 'id');
    }

    public function employee_union()
    {
        return $this->belongsTo(Union::class, 'employee_union_id', 'id');
    }

    public function employee_upazila()
    {
        return $this->belongsTo(Upazila::class, 'employee_upazila_id', 'id');
    }

    public function employee_district()
    {
        return $this->belongsTo(District::class, 'employee_district_id', 'id');
    }

    public function employee_division()
    {
        return $this->belongsTo(Division::class, 'employee_division_id', 'id');
    }

    public function employee_zone()
    {
        return $this->belongsTo(Region::class, 'employee_zone_id', 'id');
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'craeted_by', 'id');
    }
    public function pwd()
    {
        return $this->hasOne(SurvivorAutisticInformation::class, 'id', 'disability_type');
    }
    public function f_occupation()
    {
        return $this->hasOne(Occupation::class, 'id', 'father_occupation');
    }
    public function m_occupation()
    {
        return $this->hasOne(Occupation::class, 'id', 'mother_occupation');
    }
    public function o_occupation()
    {
        return $this->hasOne(Occupation::class, 'id', 'other_occupation');
    }

    public function dropout_reason()
    {
        return  $this->hasOne(DropoutReason::class, 'id',  'reason_id');
    }

    public function migrated_reason()
    {
        return  $this->hasOne(MigratedReason::class, 'id',  'reason_id');
    }

    // Accessor for the dynamic relationship
    public function getReasonAttribute()
    {
        if ($this->group_status === 'droupout') {
            return $this->dropout_reason;
        } elseif ($this->group_status === 'migrated') {
            return $this->migrated_reason;
        }

        return null;
    }

    /**
     * Scope a query to only include Approve girls.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 2);
    }

    /**
     * Scope to retrieve records with a non-null and non-zero disability_type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithDisability($query)
    {
        return $query->whereNotNull('disability_type')
            ->where('disability_type', '<>', 0);
    }

    /**
     * Scope to retrieve records with a non-null and non-zero amount_money.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCashSupport($query)
    {
        return $query->whereNotNull('amount_money')
            ->where('amount_money', '<>', 0);
        // ->whereNotNull('cash_support_type');
    }

    /**
     * Scope a query to only include Married girls.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMarried($query)
    {
        return $query->where('group_status', '=', 'married');
    }

    public function money_supports()
    {
        return $this->hasMany(SwapnosarothiProfileMoneySupport::class, 'swapnosarothi_profile_id', 'id');
    }
}
