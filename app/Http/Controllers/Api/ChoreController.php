<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChore;
use App\Task;
use App\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeRequest = new StoreChore();
        $storeRequest->request = $request;

        $valid = validator($request->only([
            'name', 'description', 'interval',
            'reoccurring', 'points', 'frequency',
            'count', 'start_at_date', 'start_at_time',
            'end_at_date', 'end_at_time', 'workers',
        ]), $storeRequest->rules(), $storeRequest->messages());

        if ($valid->fails()) {
            return response()->json(['errors' => $valid->errors()], 400);
        }

        $task_id = $request->get('id', 0);
        if ($task_id > 0) {
            $task = Task::findOrFail($task_id);
        } else {
            $task = new Task();
        }

        $data = $request->only([
            'name', 'description', 'interval', 'reoccurring', 'points', 'frequency', 'count'
        ]);
        $task->fill($data);

        $start_at = $task->createDateTime($request->get('start_at_date'), $request->get('start_at_time'));
        $end_at = $task->createDateTime($request->get('end_at_date'), $request->get('end_at_time'));

        $task->start_at = $start_at;
        $task->end_at = $end_at;

        $task->user()->associate(Auth::user());
        $task->timezone = 'America/Los_Angeles';
        $saved = $task->save();

        if ($saved) {
            $request_workers = $request->get('workers', []);

            if (!is_array($request_workers)) {
                $request_workers = [$request_workers];
            }

            foreach ($request_workers as $worker_id) {
                $worker = Worker::find($worker_id);
                $task_worker = new Task\TaskWorker();
                $task_worker->position = 0;
                $task_worker->task()->associate($task);
                $task_worker->worker()->associate($worker);
                $task_worker->save();
            }

            return response()->json(['chore' => $task], 200);
        } else {
            return response()->json(['errors' => ['general' => ['Unable to save chore to database']]], 400);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
