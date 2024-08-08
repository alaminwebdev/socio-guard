<?php

namespace App\Observers;

use App\Model\FollowUpInfo;
use App\Model\AuditLog;

class FollowUpInfoObserver
{
    /**
     * Handle the follow up info "created" event.
     *
     * @param  \App\Model\FollowUpInfo  $followUpInfo
     * @return void
     */
    public function created(FollowUpInfo $followUpInfo)
    {
        $data                   = new AuditLog();
        $data->employee_id      = auth()->user()->id;
        $data->employee_pin     = auth()->user()->pin;
        $data->employee_name    = auth()->user()->name;
        $data->complain_id      = $followUpInfo->selp_incident_id;
        $data->ip_address       = request()->ip();
        $data->action_type      = 1;
        $data->changing_page    = url()->current();
        $data->description      = "Followup Data Inserted";
        $data->table_name       = "follow_up_infos";
        $data->save();
    }

    /**
     * Handle the follow up info "updated" event.
     *
     * @param  \App\Model\FollowUpInfo  $followUpInfo
     * @return void
     */
    public function updated(FollowUpInfo $followUpInfo)
    {
        //
    }

    /**
     * Handle the follow up info "deleted" event.
     *
     * @param  \App\Model\FollowUpInfo  $followUpInfo
     * @return void
     */
    public function deleted(FollowUpInfo $followUpInfo)
    {
        //
    }

    /**
     * Handle the follow up info "restored" event.
     *
     * @param  \App\Model\FollowUpInfo  $followUpInfo
     * @return void
     */
    public function restored(FollowUpInfo $followUpInfo)
    {
        //
    }

    /**
     * Handle the follow up info "force deleted" event.
     *
     * @param  \App\Model\FollowUpInfo  $followUpInfo
     * @return void
     */
    public function forceDeleted(FollowUpInfo $followUpInfo)
    {
        //
    }
}
