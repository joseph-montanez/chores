<?php

namespace App\Task;

use App\Notifications\WorkReminder;
use App\Task;
use App\User;
use App\Work;
use App\Worker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WorkService
{
    /**
     * @param Task $task
     */
    public function generateWork(Task $task) {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);

        if ($task->reoccurring) {
            if (!$task->end_at) {
                //-- This is a never ending task, lets just generate a month's worth of work
                $current = new Carbon();
                $current->addWeek(2);
                $task->end_at = $current;
            }

            /** @var \Recurr\Recurrence $recurrence */
            $recurr = $task->recurr();
            $schedule = $recurr->schedule();
            foreach ($schedule as $recurrence) {
                $start = $recurrence->getStart();
                $end = $recurrence->getEnd();

                $existing_work = Work::where('task_id', '=', $task->id)->where('due_at', '=', $start)->get()->first();

                if (!$existing_work) {
                    $work_item = $this->createWork($task, $start);
                }
            }
        } else {
            $work_item = $task->works()->get()->first();

            if ($work_item !== null && !$work_item->completed) {
                $work_item->due_at = $task->start_at;
                $worker = $task->workers->first();
                $work_item->task_worker_id = $worker->id;
                $work_item->save();

                //TODO: a job might be dispatched, need to remove job and reschedule
//                $this->createNotice($work_item->worker, $task, $work_item);
            } else if ($work_item === null) {
                $work_item = $this->createWork($task, $task->start_at);
            }
        }
    }

    /**
     * @param $task
     * @param $due_at
     * @return Work
     */
    public function createWork($task, $due_at) {
        $work = new Work();
        $work->due_at = $due_at;
        $work->task_id = $task->id;
        //TODO: Implement Round Robin assignment
        $worker = $task->workers->random();
        Log::info('Grabbed a worker');
        Log::info($worker);
        $work->task_worker_id = $worker->id;
        $work->save();

        $this->createNotice($worker->worker, $work);

        return $work;
    }

    /**
     * @param TaskWorker $worker
     * @param Work $work
     * @return bool
     */
    public function createNotice(Worker $worker, Work $work)
    {
        if (!empty($worker->user) && $worker->user->notice_by != User::NOTICE_BY_NONE) {
            //-- Remind the worker at the time of when the work is due
            $reminder = new WorkReminder($work);

            $when = new Carbon($work->due_at);

            //-- Setup delayed notice
            $work->notify($reminder->delay($when));
        }
        return false;
    }
}