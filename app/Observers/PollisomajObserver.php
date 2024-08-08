<?php

namespace App\Observers;

use App\Model\PollisomajSetup ;


class PollisomajObserver
{
    /**
     * Handle the pollisomaj setup "created" event.
     *
     * @param  \App\PollisomajSetup  $pollisomajSetup
     * @return void
     */
    public function created(PollisomajSetup $pollisomajSetup)
    {
        //
    }

    /**
     * Handle the pollisomaj setup "updated" event.
     *
     * @param  \App\PollisomajSetup  $pollisomajSetup
     * @return void
     */
    public function updated(PollisomajSetup $pollisomajSetup)
    {
        //
    }

    /**
     * Handle the pollisomaj setup "deleted" event.
     *
     * @param  \App\PollisomajSetup  $pollisomajSetup
     * @return void
     */
    public function deleted(PollisomajSetup $pollisomajSetup)
    {
        $pollisomajSetup->date_to=$pollisomajSetup->deleted_at;
        $pollisomajSetup->save();
    }

    /**
     * Handle the pollisomaj setup "restored" event.
     *
     * @param  \App\PollisomajSetup  $pollisomajSetup
     * @return void
     */
    public function restored(PollisomajSetup $pollisomajSetup)
    {
        //
    }

    /**
     * Handle the pollisomaj setup "force deleted" event.
     *
     * @param  \App\PollisomajSetup  $pollisomajSetup
     * @return void
     */
    public function forceDeleted(PollisomajSetup $pollisomajSetup)
    {
        //
    }
}
