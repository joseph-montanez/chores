<?php

namespace App\Observers;


use App\Worker;

class WorkerObserver
{
    /**
     * Listen to the Worker deleting event.
     *
     * @param  \App\Worker  $worker
     * @return void
     */
    public function deleting(Worker $worker)
    {
        $worker->user()->delete();
    }

}