<?php

namespace App\Jobs;

use App\Notifications\WorkReminder;
use App\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSMSReminder implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Work
     */
    protected $work;

    /**
     * Create a new job instance.
     * @param Work $work
     */
    public function __construct(Work $work)
    {
        $this->work = $work;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reminder = new WorkReminder($this->work);

        $user = $this->work->worker->user;
        $user->notify($reminder);
    }
}
