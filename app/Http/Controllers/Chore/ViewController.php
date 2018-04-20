<?php
/**
 * Created by PhpStorm.
 * User: josephmontanez
 * Date: 1/5/2017
 * Time: 9:39 PM
 */

namespace App\Http\Controllers\Chore;

use App\Task;
use App\Work;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use FetchLeo\LaravelXml\Facades\Xml;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessBuilder;

class ViewController
{
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index($id) {
        $task = Task::find($id);
        $workers = $task->workers()->get();

        return view('chores.view', ['task' => $task, 'workers' => $workers]);
    }

    function print() {
        $user = Auth::user();
        $worker = $user->worker()->first();

        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);

        $start = (new Carbon())->startOfWeek();
        $start->setTime(0,0,0);

        $end = (new Carbon())->endOfWeek();
        $end->setTime(23,59,59);

        $works = Work::whereBetween('works.due_at', [$start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s')])
            ->join('tasks_workers', 'tasks_workers.task_id', '=', 'works.task_id')
            ->where('tasks_workers.worker_id', '=', $worker->id)
            ->orderBy('works.due_at', 'ASC')->get();

        $days = [];

        //-- Generate Days of Week
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start, $interval, $end);
        foreach ($period as $i => $day) {
            $days[$i] = [
                "weekday" => strtoupper($day->format('D')),
                "day" => (int) $day->format('j')
            ];
        }

        $chores = [];
        foreach ($works as $work) {
            $task = $work->task;
            if (!isset($chores[$task->id])) {
                $chores[$task->id] = [
                    'task' => $task,
                    'days' => [[], [], [], [], [], [], []],
                ];
            }

            $day_of_week = (int) $work->due_at->format('w');
            $chores[$task->id]['days'][$day_of_week] = $work->worker;
        }

        $days = array_values($days);

        $data = [
            'date' => $start->format('M jS'),
            'days' => $days,
            'chores' => array_values($chores)
        ];

        /**
         * @var \SimpleXMLElement
         */
        $xml = Xml::convert($data);

        $java = config('fop.java');
        $jar = config('fop.jar');
        $jar_dir = config('fop.jar_dir');
        $classpath = config('fop.classpath');

        $cfg = resource_path('fops' . DIRECTORY_SEPARATOR . 'cfg.xml');

        $xsl = resource_path('fops' . DIRECTORY_SEPARATOR . 'chores.week.xsl');

        $builder = new ProcessBuilder([$java,
            '-cp', $classpath,
            '-jar', $jar,
            //-- Config
            '-c', $cfg,
            //-- Stream
            '-xml',
            '-',
            '-xsl',
            $xsl,
            '-pdf',
            '-'
        ]);

        $process = $builder->getProcess();
        $process->setWorkingDirectory($jar_dir);
        $process->setInput($xml->asXML());
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        //$process->getExitCodeText(),


        return response($process->getOutput(), 200)->header('Content-Type', 'application/pdf');
    }
}