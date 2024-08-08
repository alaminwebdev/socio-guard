<?php

namespace App\Model\Admin\Setup;

use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\Division;
use App\Model\PollisomajSetup;
use Illuminate\Database\Eloquent\Model;

class District extends Model {
    public function pollisomaj() {
        return $this->hasMany(PollisomajSetup::class, 'district_id', 'id');
    }
    public function division() {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function region_area() {
        return $this->hasMany(RegionAreaDetail::class, 'district_id', 'id');
    }
    public function upazilas() {
        return $this->hasMany(Upazila::class, 'district_id', 'id');
    }
}
