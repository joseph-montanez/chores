<?php
namespace App\Http\Controllers\Worker;

use App\Http\Requests\StoreWorker;
use App\Repository\WorkerRepository;
use App\User;
use App\Worker;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class AddController extends BaseController
{
    function index()
    {
        $worker = new Worker();
        if (!$worker->user) {
            $worker->user = new User();
        }

        return view('workers/add', [
            'worker' => $worker
        ]);
    }

    /**
     * Store the incoming worker.
     *
     * @param StoreWorker $request
     * @return Response
     */
    function store(StoreWorker $request)
    {
        $data = $request->all();

        $owner = Auth::user();

        $workerRepo = new WorkerRepository();
        $workerRepo->create($owner, $data);

        flash('Worker has been added!');

        return redirect('/workers/list');
    }

}