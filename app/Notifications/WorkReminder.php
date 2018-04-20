<?php

namespace App\Notifications;

use App\User;
use App\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use NotificationChannels\Pushover\PushoverChannel;
use NotificationChannels\Pushover\PushoverMessage;

class WorkReminder extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var Work
     */
    protected $work;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Create a new notification instance.
     *
     * @param $work
     */
    public function __construct(Work $work)
    {
        $this->work = $work;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $task_worker = $this->work->taskWorker;

        Log::info($this->work);
        Log::info($this->work->taskWorker);

        $worker      = $task_worker->worker;
        $user        = $worker->user;
        $notice_by   = $user->notice_by;

        if ($notice_by == User::NOTICE_BY_SMS) {
            $sms_by = $user->sms_by;

            if ($sms_by == User::SMS_BY_TEXT) {
                return ['database', 'nexmo'];
            } else {
                return ['database', 'mail'];
            }
        }
        else if ($notice_by == User::NOTICE_BY_EMAIL) {
            return ['database', 'mail'];
        }
        else if ($notice_by == User::NOTICE_BY_PUSH) {
            return ['database', PushoverChannel::class];
        }

        return ['database', 'nexmo', PushoverChannel::class]; //['mail']
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'name' => $this->work->task->name
        ];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('Reminder: ' . $this->work->task->name);
    }

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toPushover($notifiable)
    {
        return PushoverMessage::create('Reminder: ' . $this->work->task->name)
                              ->title('Chores')
                              ->sound('incoming')
                              ->lowPriority()
                              ->url(URL::to('/'), 'Go to your chores');
    }
}
