<?php

namespace Tests\Unit;

use App\Task;
use App\User;
use App\Work;
use App\Worker;
use App\Task\TaskWorker as Task_Worker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTaskCreation()
    {
        $worker = factory(\App\Worker::class)->create();
        $user = $worker->user;

        $task = new Task();
        $task->name = 'UNIT TEST';
        $task->description = '';
        $task->start_at = now()->addMinutes(3);
        $task->user_id = $user->id;
        $task->timezone = 'America/Los_Angeles';
        $task_saved = $task->save();

        $task_worker = new Task_Worker();
        $task_worker->position = 0;
        $task_worker->task()->associate($task);
        $task_worker->worker()->associate($worker);
        $task_worker_saved = $task_worker->save();

        $this->assertTrue($task_saved);
        $this->assertTrue($task_worker_saved);

    }

    public function testWorkAssignment()
    {
        $worker = factory(\App\Worker::class)->create();
        $user = $worker->user;

        $task = new Task();
        $task->name = 'UNIT TEST';
        $task->description = '';
        $task->start_at = now()->addMinutes(3);
        $task->user_id = $user->id;
        $task->timezone = 'America/Los_Angeles';
        $task->save();

        $task->user()->associate($user);

        $task_worker = new Task_Worker();
        $task_worker->position = 0;
        $task_worker->task()->associate($task);
        $task_worker->worker()->associate($worker);
        $task_worker->save();

        $work = new Work();
        $work->due_at = $task->start_at;
        $work->task_id = $task->id;
        $work->task_worker_id = $worker->id;
        $work_saved = $work->save();

        $this->assertTrue($work_saved);
        $this->assertEquals($work->taskWorker->id, $worker->id);
    }
}
