<?php

namespace App;

use Alsofronie\Uuid\UuidModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Work
 * @package App
 *
 * @property int $user_id
 * @property int $task_id
 * @property bool $completed
 * @property \DateTime $start_at
 * @property \DateTime $due_at
 * @property \DateTime $completed_at
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property Task task
 * @property Worker worker
 * @property Worker[] workers
 */
class Work extends Model
{
    use UuidModelTrait, Notifiable;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name', 'due_time'];

    public function task() {
        return $this->belongsTo('App\Task', 'task_id', 'id');
    }

    public function taskWorker() {
        return $this->belongsTo('App\Task\TaskWorker', 'task_worker_id', 'id');
    }

    /**
     * Get the name of the task
     *
     * @return bool
     */
    public function getNameAttribute()
    {
        return $this->task()->select('name')->get()->first()->name;
    }

    /**
     * Get the time of the work when its dye
     *
     * @return string
     */
    public function getDueTimeAttribute()
    {
        return (new Carbon($this->attributes['due_at']))->format('g:i A');
    }

    /**
     * @param $value
     * @return Carbon|null
     */
    public function getDueAtAttribute($value) {
        if ($value instanceof Carbon) {
            return $value;
        }
        else if ($value instanceof \DateTime) {
            return Carbon::instance($value);
        } else {
            return $value ? new Carbon($value) : null;
        }
    }

    /**
     * Route notifications for the Nexmo channel.
     *
     * @return string
     */
    public function routeNotificationForNexmo()
    {
        return $this->worker->user->phone;
    }

    /**
     * Route notifications for the Nexmo channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        $worker    = $this->taskWorker->worker;
        $user      = $worker->user;
        $sms_by    = $user->sms_by;
        $notice_by = $user->notice_by;
        if ($notice_by == User::NOTICE_BY_SMS && $sms_by == User::SMS_BY_EMAIL) {
            return str_replace('{n}', $user->phone, $user->sms_email);
        } else {
            return $user->email;
        }
    }

    /**
     * Route notifications for the PushOver channel.
     *
     * @return string
     */
    public function routeNotificationForPushover()
    {
        return $this->worker->user->pushover_key;
    }
}