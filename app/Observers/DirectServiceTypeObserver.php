<?php

namespace App\Observers;

use App\Model\DirectServiceType;
use App\Model\AuditLog;

class DirectServiceTypeObserver
{
    /**
     * Handle the direct service type "created" event.
     *
     * @param  \App\Model\DirectServiceType  $directServiceType
     * @return void
     */
    public function created(DirectServiceType $directServiceType)
    {
        $data                   = new AuditLog();
        $data->employee_id      = auth()->user()->id;
        $data->employee_pin     = auth()->user()->pin;
        $data->employee_name    = auth()->user()->name;
        $data->complain_id      = $directServiceType->selp_incident_id;
        $data->ip_address       = request()->ip();
        $data->action_type      = 1;
        $data->changing_page    = url()->current();
        $data->description      = "Direct Service Data Inserted";
        $data->table_name       = "direct_service_types";
        $data->save();
    }

    /**
     * Handle the direct service type "updated" event.
     *
     * @param  \App\Model\DirectServiceType  $directServiceType
     * @return void
     */
    public function updated(DirectServiceType $directServiceType)
    {
        //
    }

    /**
     * Handle the direct service type "deleted" event.
     *
     * @param  \App\Model\DirectServiceType  $directServiceType
     * @return void
     */
    public function deleted(DirectServiceType $directServiceType)
    {
        //
    }

    /**
     * Handle the direct service type "restored" event.
     *
     * @param  \App\Model\DirectServiceType  $directServiceType
     * @return void
     */
    public function restored(DirectServiceType $directServiceType)
    {
        //
    }

    /**
     * Handle the direct service type "force deleted" event.
     *
     * @param  \App\Model\DirectServiceType  $directServiceType
     * @return void
     */
    public function forceDeleted(DirectServiceType $directServiceType)
    {
        //
    }
}
