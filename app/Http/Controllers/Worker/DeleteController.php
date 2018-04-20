<?php

namespace App\Http\Controllers\Worker;

use App\Worker;

class DeleteController
{
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index($id) {
        $worker = Worker::findOrFail($id);

        $worker->user()->delete();
        $worker->delete();
        flash('Worker has been deleted!');

        return redirect()->route('worker.list');
    }
}