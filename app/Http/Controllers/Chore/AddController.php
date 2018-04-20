<?php
namespace App\Http\Controllers\Chore;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\StoreChore;
use Illuminate\Support\Facades\Auth;

class AddController extends BaseController
{
    function index()
    {
        $task = new Task();
        $task->start_at = now()->minute(0);
        $task->end_at = now()->addDay()->minute(0);
        $task->with('workers')->get();
        $workers = Auth::user()->workers()->get();
        return view('chores/add', [
            'task' => $task,
            'workers' => $workers,
            'frequencies' => Task::FREQUENCIES,
        ]);
    }

    /**
     * Store the incoming chore.
     *
     * @param StoreChore $request
     *
     * @return Task|Response
     */
    function store(StoreChore $request)
    {
        $data = $request->all();
        $task = new Task();
        $task->fill($data);

        $start_at = new Carbon($request->get('start_at_date'));
        $start_at_hour = $request->get('start_at_time')['hh'];
        $start_at_minute = $request->get('start_at_time')['mm'];

        if ($request->get('start_at_time')['A'] === 'PM') {
            $start_at_hour += 12;
        }

        $start_at->hour($start_at_hour);
        $start_at->minute($start_at_minute);

        $task->user()->associate(Auth::user());
        $task->timezone = 'America/Los_Angeles';
        $task->save();

        foreach ($data['workers'] as $worker_id) {
            $worker = Worker::find($worker_id);
            $task_worker = new Task\TaskWorker();
            $task_worker->position = 0;
            $task_worker->task()->associate($task);
            $task_worker->worker()->associate($worker);
            $task_worker->save();
        }

        flash('Chore has been added!');

        if ($request->ajax()) {
            return $task;
        } else {
            return redirect('/chores/add');
        }

    }

}