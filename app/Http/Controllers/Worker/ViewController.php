<?php
/**
 * Created by PhpStorm.
 * User: josephmontanez
 * Date: 1/5/2017
 * Time: 9:39 PM
 */

namespace App\Http\Controllers\Worker;

use App\Worker;

class ViewController
{
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index($id) {
        $worker = Worker::find($id);

        return view('workers.view', ['worker' => $worker]);
    }
}