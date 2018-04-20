<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{


    /**
     * Listen to the Task saving event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function saving(Task $task)
    {
        //-- Clear fields if not reoccurring
        if (!$task->reoccurring) {
            $task->reoccurring = 0;
            $task->end_at = null;
            $task->frequency = 0;
            $task->interval = 0;
            $task->count = 0;
        } else {
            $task->reoccurring = 1;
        }
    }


    /**
     * Listen to the Task deleting event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function deleting(Task $task)
    {
        $task->workers()->delete();
        $task->works()->delete();
    }

}