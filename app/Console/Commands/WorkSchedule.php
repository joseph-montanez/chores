<?php

namespace App\Console\Commands;

use App\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class WorkSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate work based off tasks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = new Carbon(null, config('app.timezone'));
        $start->setTime(0,0,0);

        /** @var Task[] $tasks */
        $tasks = Task::all();
        $work_service = new Task\WorkService();
        /** @var Task $task */
        foreach($tasks as $task) {
            $work_service->generateWork($task);
        }
    }
}
