<?php
/**
 * Created by PhpStorm.
 * User: josephmontanez
 * Date: 1/8/2017
 * Time: 10:42 PM
 */

namespace App\Http\Controllers\Chore;

use App\Http\Controllers\Controller;
use App\User;
use App\Work;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ScheduleController extends Controller
{
    function today() {
        /** @var User $user */
        $user = Auth::user();

        $start = new Carbon();
        $start->setTime(0,0,0);
        $end = new Carbon();
        $end->setTime(23,59,59);

        $works = Work::with('task')
            ->select('works.*')
            ->join('tasks_workers', function ($join) use($user) {
                $join->on('works.task_id', '=', 'tasks_workers.task_id')
                    ->where('tasks_workers.worker_id', '=', $user->worker()->first()->id);
            })
            ->whereBetween('due_at', [$start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s')])
            ->orderBy('due_at', 'ASC')->get();

        if (Request::isJson()) {
            return response()->json(['works' => $works]);
        } else {
            return view('schedule.today', ['works' => $works]);
        }
    }

    function markDone($work_id) {
        $work = Work::findOrFail($work_id);
        $work->completed_at = new Carbon();
        $work->completed = 1;
        $work->saveOrFail();
    }

    function markNotDone($work_id) {
        $work = Work::findOrFail($work_id);
        $work->completed_at = null;
        $work->completed = 0;
        $work->saveOrFail();
    }

}