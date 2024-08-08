<?php

namespace App\Observers;

use App\Model\SurvivorDirectServiceModel;
use App\Model\AuditLog;

class DirectServiceObserver
{
    /**
     * Handle the survivor direct service model "created" event.
     *
     * @param  \App\Model\SurvivorDirectServiceModel  $survivorDirectServiceModel
     * @return void
     */
    public function created(SurvivorDirectServiceModel $survivorDirectServiceModel)
    {
        $data                   = new AuditLog();
        $data->employee_id      = auth()->user()->id;
        $data->employee_pin     = auth()->user()->pin;
        $data->employee_name    = auth()->user()->name;
        $data->complain_id      = $survivorDirectServiceModel->selp_incident_information_id;
        $data->ip_address       = request()->ip();
        $data->action_type      = 1;
        $data->changing_page    = url()->current();
        $data->description      = "ADR Data Inserted";
        $data->table_name       = "survivor_direct_services";
        $data->save();
    }

    /**
     * Handle the survivor direct service model "updated" event.
     *
     * @param  \App\Model\SurvivorDirectServiceModel  $survivorDirectServiceModel
     * @return void
     */
    public function updated(SurvivorDirectServiceModel $survivorDirectServiceModel)
    {
        //
    }

    /**
     * Handle the survivor direct service model "deleted" event.
     *
     * @param  \App\Model\SurvivorDirectServiceModel  $survivorDirectServiceModel
     * @return void
     */
    public function deleted(SurvivorDirectServiceModel $survivorDirectServiceModel)
    {
        //
    }

    /**
     * Handle the survivor direct service model "restored" event.
     *
     * @param  \App\Model\SurvivorDirectServiceModel  $survivorDirectServiceModel
     * @return void
     */
    public function restored(SurvivorDirectServiceModel $survivorDirectServiceModel)
    {
        //
    }

    /**
     * Handle the survivor direct service model "force deleted" event.
     *
     * @param  \App\Model\SurvivorDirectServiceModel  $survivorDirectServiceModel
     * @return void
     */
    public function forceDeleted(SurvivorDirectServiceModel $survivorDirectServiceModel)
    {
        //
    }
}
