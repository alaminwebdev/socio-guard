<?php

namespace App\Observers;

use App\Model\SurvivorCourtCaseModel;
use App\Model\AuditLog;

class CourtCaseObserver
{
    /**
     * Handle the survivor court case model "created" event.
     *
     * @param  \App\Model\SurvivorCourtCaseModel  $survivorCourtCaseModel
     * @return void
     */
    public function created(SurvivorCourtCaseModel $survivorCourtCaseModel)
    {
        $data                   = new AuditLog();
        $data->employee_id      = auth()->user()->id;
        $data->employee_pin     = auth()->user()->pin;
        $data->employee_name    = auth()->user()->name;
        $data->complain_id      = $survivorCourtCaseModel->selp_incident_information_id;
        $data->ip_address       = request()->ip();
        $data->action_type      = 1;
        $data->changing_page    = url()->current();
        $data->description      = "Court Case Data Inserted";
        $data->table_name       = "survivor_court_cases";
        $data->save();
    }

    /**
     * Handle the survivor court case model "updated" event.
     *
     * @param  \App\Model\SurvivorCourtCaseModel  $survivorCourtCaseModel
     * @return void
     */
    public function updated(SurvivorCourtCaseModel $survivorCourtCaseModel)
    {
        //
    }

    /**
     * Handle the survivor court case model "deleted" event.
     *
     * @param  \App\Model\SurvivorCourtCaseModel  $survivorCourtCaseModel
     * @return void
     */
    public function deleted(SurvivorCourtCaseModel $survivorCourtCaseModel)
    {
        //
    }

    /**
     * Handle the survivor court case model "restored" event.
     *
     * @param  \App\Model\SurvivorCourtCaseModel  $survivorCourtCaseModel
     * @return void
     */
    public function restored(SurvivorCourtCaseModel $survivorCourtCaseModel)
    {
        //
    }

    /**
     * Handle the survivor court case model "force deleted" event.
     *
     * @param  \App\Model\SurvivorCourtCaseModel  $survivorCourtCaseModel
     * @return void
     */
    public function forceDeleted(SurvivorCourtCaseModel $survivorCourtCaseModel)
    {
        //
    }
}
