<?php

namespace App\Observers;


use App\Model\Admin\Setup\CEP_Region\SetupUser;
class SetupUserObserver
{
    /**
     * Handle the setup user "created" event.
     *
     * @param  \App\SetupUser  $setupUser
     * @return void
     */
    public function created(SetupUser $setupUser)
    {
        //
    }

    /**
     * Handle the setup user "updated" event.
     *
     * @param  \App\SetupUser  $setupUser
     * @return void
     */
    public function updated(SetupUser $setupUser)
    {
        //
    }

    /**
     * Handle the setup user "deleted" event.
     *
     * @param  \App\SetupUser  $setupUser
     * @return void
     */
    public function deleted(SetupUser $setupUser)
    {
        $setupUser->date_to=$setupUser->deleted_at;
        $setupUser->save();
    }

    /**
     * Handle the setup user "restored" event.
     *
     * @param  \App\SetupUser  $setupUser
     * @return void
     */
    public function restored(SetupUser $setupUser)
    {
        //
    }

    /**
     * Handle the setup user "force deleted" event.
     *
     * @param  \App\SetupUser  $setupUser
     * @return void
     */
    public function forceDeleted(SetupUser $setupUser)
    {
        //
    }
}
