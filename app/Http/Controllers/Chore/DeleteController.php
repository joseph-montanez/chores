<?php
/**
 * Created by PhpStorm.
 * User: josephmontanez
 * Date: 1/5/2017
 * Time: 9:38 PM
 */

namespace App\Http\Controllers\Chore;

use App\Task;

class DeleteController
{
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index($id) {
        $task = Task::findOrFail($id);

        $task->delete();
        flash('Chore has been deleted!');

        return redirect('/chores/list');

    }
}