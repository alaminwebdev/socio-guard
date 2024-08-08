<?php

namespace App\Model\Admin\Setup\CEP_Region;

use App\Observers\RegionAreaDetailObserver;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\CEP_Region\RegionArea;
use Illuminate\Database\Eloquent\SoftDeletes;


class RegionAreaDetail extends Model
{
    use SoftDeletes;



    public function region_area()
    {
        return $this->belongsTo(RegionArea::class, 'region_id', 'id');
    }

    public function regional_division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function regional_district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    /**
     * Scope to retrieve previous zone for a division.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPreviousZone($query, $divisionId)
    {
        return $query->where('division_id', $divisionId)
            ->where('status', '1')
            ->whereNotNull('date_to')
            ->withTrashed();
    }
}
