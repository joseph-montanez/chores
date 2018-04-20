<?php
/**
 * Created by PhpStorm.
 * User: josephmontanez
 * Date: 1/5/2017
 * Time: 10:18 AM
 */

namespace App\Http\Controllers\Chore;


use App\Task;

class ListController
{
    function index() {
        $tasks = Task::orderBy('name')->paginate(15);

        return view('chores.list', ['tasks' => $tasks]);
    }
}