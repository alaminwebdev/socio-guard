<?php

namespace App\Observers;


use App\Model\Admin\Setup\CEP_Region\SetupUserArea;

class SetupUserAreaObserver
{
    /**
     * Handle the setup user area "created" event.
     *
     * @param  \App\SetupUserArea  $setupUserArea
     * @return void
     */
    public function created(SetupUserArea $setupUserArea)
    {
        //
    }

    /**
     * Handle the setup user area "updated" event.
     *
     * @param  \App\SetupUserArea  $setupUserArea
     * @return void
     */
    public function updated(SetupUserArea $setupUserArea)
    {
        //
    }

    /**
     * Handle the setup user area "deleted" event.
     *
     * @param  \App\SetupUserArea  $setupUserArea
     * @return void
     */
    public function deleted(SetupUserArea $setupUserArea)
    {
        $setupUserArea->date_to=$setupUserArea->deleted_at;
        $setupUserArea->save();
    }

    /**
     * Handle the setup user area "restored" event.
     *
     * @param  \App\SetupUserArea  $setupUserArea
     * @return void
     */
    public function restored(SetupUserArea $setupUserArea)
    {
        //
    }

    /**
     * Handle the setup user area "force deleted" event.
     *
     * @param  \App\SetupUserArea  $setupUserArea
     * @return void
     */
    public function forceDeleted(SetupUserArea $setupUserArea)
    {
        //
    }
}
