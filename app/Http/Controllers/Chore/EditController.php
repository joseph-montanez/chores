<?php
namespace App\Http\Controllers\Chore;

use App\Task;
use App\Worker;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\StoreChore;
use Illuminate\Support\Facades\Auth;

class EditController extends BaseController
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index($id)
    {
        $task = Task::findOrFail($id);
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
     * @param $id
     * @return Response
     */
    function store(StoreChore $request, $id)
    {
        $data = $request->all();
        $data['reoccurring'] = $request->get('reoccurring', 0);

        /** @var \App\Task $task */
        $task = Task::findOrFail($id);
        $task->fill($data);
        $task->timezone = 'America/Los_Angeles';
        $task->saveOrFail();

        $task->workers()->delete();
        foreach ($data['workers'] as $worker_id) {
            /** @var \App\Worker $worker */
            $worker = Worker::find($worker_id);
            $task_worker = new Task\TaskWorker();
            $task_worker->position = 0;
            $task_worker->task()->associate($task);
            $task_worker->worker()->associate($worker);
            $task_worker->save();
        }

        flash('Chore has been saved!');
        return redirect('/chores/list');
    }

}