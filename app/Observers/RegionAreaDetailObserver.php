<?php

namespace App\Observers;

use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;

class RegionAreaDetailObserver
{
    /**
     * Handle the region area detail "created" event.
     *
     * @param  \App\RegionAreaDetail  $regionAreaDetail
     * @return void
     */
    public function created(RegionAreaDetail $regionAreaDetail)
    {
        $regionAreaDetail->deleted_at=$regionAreaDetail->date_to;
        $regionAreaDetail->save();
    }

    /**
     * Handle the region area detail "updated" event.
     *
     * @param  \App\RegionAreaDetail  $regionAreaDetail
     * @return void
     */
    public function updated(RegionAreaDetail $regionAreaDetail)
    {
        
    }

    /**
     * Handle the region area detail "deleted" event.
     *
     * @param  \App\RegionAreaDetail  $regionAreaDetail
     * @return void
     */
    public function deleted(RegionAreaDetail $regionAreaDetail)
    {
       
        $regionAreaDetail->date_to=$regionAreaDetail->deleted_at;
        $regionAreaDetail->save();
    }

    /**
     * Handle the region area detail "restored" event.
     *
     * @param  \App\RegionAreaDetail  $regionAreaDetail
     * @return void
     */
    public function restored(RegionAreaDetail $regionAreaDetail)
    {
        //
    }

    /**
     * Handle the region area detail "force deleted" event.
     *
     * @param  \App\RegionAreaDetail  $regionAreaDetail
     * @return void
     */
    public function forceDeleted(RegionAreaDetail $regionAreaDetail)
    {
        //
    }
}
