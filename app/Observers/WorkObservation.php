<?php

namespace App\Observers;

use App\Work;

class WorkObservation
{
    /**
     * Listen to the Work deleting event.
     *
     * @param  \App\Work  $work
     * @return void
     */
    public function deleting(Work $work)
    {
        $work->notifications->delete();
    }
}