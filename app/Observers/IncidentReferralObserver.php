<?php

namespace App\Observers;

use App\Model\IncidentReferral;
use App\Model\AuditLog;

class IncidentReferralObserver
{
    /**
     * Handle the incident referral "created" event.
     *
     * @param  \App\Model\IncidentReferral  $incidentReferral
     * @return void
     */
    public function created(IncidentReferral $incidentReferral)
    {
        $data                   = new AuditLog();
        $data->employee_id      = auth()->user()->id;
        $data->employee_pin     = auth()->user()->pin;
        $data->employee_name    = auth()->user()->name;
        $data->complain_id      = $incidentReferral->selp_incident_id;
        $data->ip_address       = request()->ip();
        $data->action_type      = 1;
        $data->changing_page    = url()->current();
        $data->description      = "Incident Referral Data Inserted";
        $data->table_name       = "incident_referrals";
        $data->save();
    }

    /**
     * Handle the incident referral "updated" event.
     *
     * @param  \App\Model\IncidentReferral  $incidentReferral
     * @return void
     */
    public function updated(IncidentReferral $incidentReferral)
    {
        //
    }

    /**
     * Handle the incident referral "deleted" event.
     *
     * @param  \App\Model\IncidentReferral  $incidentReferral
     * @return void
     */
    public function deleted(IncidentReferral $incidentReferral)
    {
        //
    }

    /**
     * Handle the incident referral "restored" event.
     *
     * @param  \App\Model\IncidentReferral  $incidentReferral
     * @return void
     */
    public function restored(IncidentReferral $incidentReferral)
    {
        //
    }

    /**
     * Handle the incident referral "force deleted" event.
     *
     * @param  \App\Model\IncidentReferral  $incidentReferral
     * @return void
     */
    public function forceDeleted(IncidentReferral $incidentReferral)
    {
        //
    }
}
