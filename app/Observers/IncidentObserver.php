<?php

namespace App\Observers;

use App\Model\SelpIncidentModel;
use App\Model\AuditLog;

class IncidentObserver
{
    /**
     * Handle the selp incident model "created" event.
     *
     * @param  \App\Model\SelpIncidentModel  $selpIncidentModel
     * @return void
     */
    public function created(SelpIncidentModel $selpIncidentModel)
    {
        // dd($selpIncidentModel);
        $data                   = new AuditLog();
        $data->employee_id      = auth()->user()->id;
        $data->employee_pin     = $selpIncidentModel->employee_pin;
        $data->employee_name    = $selpIncidentModel->employee_name;
        $data->complain_id      = $selpIncidentModel->id;
        $data->ip_address       = request()->ip();
        $data->action_type      = 1;
        $data->changing_page    = url()->current();
        $data->description      = "Incident Data Inserted";
        $data->table_name       = "selp_incident_informations";
        $data->save();
    }

    /**
     * Handle the selp incident model "updated" event.
     *
     * @param  \App\Model\SelpIncidentModel  $selpIncidentModel
     * @return void
     */
    public function updated(SelpIncidentModel $selpIncidentModel)
    {
        $data                   = new AuditLog();
        $data->employee_id      = auth()->user()->id;
        $data->employee_pin     = $selpIncidentModel->employee_pin;
        $data->employee_name    = $selpIncidentModel->employee_name;
        $data->complain_id      = $selpIncidentModel->id;
        $data->ip_address       = request()->ip();
        $data->action_type      = 2;
        $data->changing_page    = url()->current();
        $data->description      = "Incident Data Updated";
        $data->table_name       = "selp_incident_informations";
        $data->save();
    }

    /**
     * Handle the selp incident model "deleted" event.
     *
     * @param  \App\Model\SelpIncidentModel  $selpIncidentModel
     * @return void
     */
    public function deleted(SelpIncidentModel $selpIncidentModel)
    {
        $data                   = new AuditLog();
        $data->employee_id      = auth()->user()->id;
        $data->employee_pin     = $selpIncidentModel->employee_pin;
        $data->employee_name    = $selpIncidentModel->employee_name;
        $data->complain_id      = $selpIncidentModel->id;
        $data->ip_address       = request()->ip();
        $data->action_type      = 3;
        $data->changing_page    = url()->current();
        $data->description      = "Incident Data Deleted";
        $data->table_name       = "selp_incident_informations";
        $data->save();
    }

    /**
     * Handle the selp incident model "restored" event.
     *
     * @param  \App\Model\SelpIncidentModel  $selpIncidentModel
     * @return void
     */
    public function restored(SelpIncidentModel $selpIncidentModel)
    {
        //
    }

    /**
     * Handle the selp incident model "force deleted" event.
     *
     * @param  \App\Model\SelpIncidentModel  $selpIncidentModel
     * @return void
     */
    public function forceDeleted(SelpIncidentModel $selpIncidentModel)
    {
        //
    }
}
