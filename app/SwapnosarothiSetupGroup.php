<?php

namespace App;

use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SwapnosarothiSetupGroup extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'date'
    ];

    public function villages()
    {
        return $this->belongsToMany(Village::class, 'swapnosarothi_group_village', 'group_id', 'village_id');
    }
    public function employee_zone()
    {
        return $this->belongsTo(Region::class, 'zone_id', 'id');
    }
}
