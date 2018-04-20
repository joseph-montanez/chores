<?php
namespace App\Http\Controllers\Worker;

use App\Http\Requests\StoreWorker;
use App\User;
use App\Worker;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class EditController extends BaseController
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index($id)
    {
        $worker = Worker::findOrFail($id);
        if (!$worker->user) {
            $worker->user = new User();
        }


        return view('workers/add', [
            'worker' => $worker,
        ]);
    }

    /**
     * Store the incoming worker.
     *
     * @param StoreWorker $request
     * @param $id
     * @return Response
     */
    function store(StoreWorker $request, $id)
    {
        $worker = Worker::findOrFail($id);
        $worker->fill($request->only([
            'name'
        ]));
        $worker->user->name         = $request->get('name', '');
        $worker->user->email        = $request->get('email', '');
        $worker->user->phone        = $request->get('phone', '');
        $worker->user->pushover_key = $request->get('pushover_key', '');
        $worker->user->sms_email    = $request->get('sms_email', '');
        $worker->user->sms_by       = $request->get('sms_by', User::SMS_BY_NONE);
        $worker->user->notice_by    = $request->get('notice_by', User::NOTICE_BY_NONE);

        if ($worker->save() && $worker->user->save()) {
            flash('Worker has been saved!');

            return redirect('/workers/list');
        }
    }

}