<?php

namespace App\Observers;

use App\Model\PollisomajDataModel;
use App\Model\AuditLog;

class PollisomajDataObserver
{
    /**
     * Handle the pollisomaj data model "created" event.
     *
     * @param  \App\Model\PollisomajDataModel  $pollisomajDataModel
     * @return void
     */
    public function created(PollisomajDataModel $pollisomajDataModel)
    {
        $data                       = new AuditLog();
        $data->employee_id          = $pollisomajDataModel->employee_id;
        $data->employee_pin         = $pollisomajDataModel->employee_pin;
        $data->employee_name        = auth()->user()->name;
        $data->pollisomaj_data_id   = $pollisomajDataModel->id;
        $data->ip_address           = request()->ip();
        $data->action_type          = 1;
        $data->changing_page        = url()->current();
        $data->description          = "Pollisomaj Data Inserted";
        $data->table_name           = "pollisomaj_data";
        $data->save();
    }

    /**
     * Handle the pollisomaj data model "updated" event.
     *
     * @param  \App\Model\PollisomajDataModel  $pollisomajDataModel
     * @return void
     */
    public function updated(PollisomajDataModel $pollisomajDataModel)
    {
        $data                       = new AuditLog();
        $data->employee_id          = $pollisomajDataModel->employee_id;
        $data->employee_pin         = $pollisomajDataModel->employee_pin;
        $data->employee_name        = auth()->user()->name;
        $data->pollisomaj_data_id   = $pollisomajDataModel->id;
        $data->ip_address           = request()->ip();
        $data->action_type          = 2;
        $data->changing_page        = url()->current();
        $data->description          = "Pollisomaj Data Updated";
        $data->table_name           = "pollisomaj_data";
        $data->save();
    }

    /**
     * Handle the pollisomaj data model "deleted" event.
     *
     * @param  \App\Model\PollisomajDataModel  $pollisomajDataModel
     * @return void
     */
    public function deleted(PollisomajDataModel $pollisomajDataModel)
    {
        $data                       = new AuditLog();
        $data->employee_id          = $pollisomajDataModel->employee_id;
        $data->employee_pin         = $pollisomajDataModel->employee_pin;
        $data->employee_name        = auth()->user()->name;
        $data->pollisomaj_data_id   = $pollisomajDataModel->id;
        $data->ip_address           = request()->ip();
        $data->action_type          = 3;
        $data->changing_page        = url()->current();
        $data->description          = "Pollisomaj Data Deleted";
        $data->table_name           = "pollisomaj_data";
        $data->save();
    }

    /**
     * Handle the pollisomaj data model "restored" event.
     *
     * @param  \App\Model\PollisomajDataModel  $pollisomajDataModel
     * @return void
     */
    public function restored(PollisomajDataModel $pollisomajDataModel)
    {
        //
    }

    /**
     * Handle the pollisomaj data model "force deleted" event.
     *
     * @param  \App\Model\PollisomajDataModel  $pollisomajDataModel
     * @return void
     */
    public function forceDeleted(PollisomajDataModel $pollisomajDataModel)
    {
        
    }
}
