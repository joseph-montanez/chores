<?php

namespace App;


use Alsofronie\Uuid\UuidModelTrait;
use BrianFaust\Recurring\Traits\Recurring;
use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Recurr\Frequency;

/**
 * @property string $id
 * @property int $user_id
 * @property string $name
 * @property int $user_ud
 * @property string $description
 * @property int $reoccurring
 * @property \DateTime start_at
 * @property \DateTime end_at
 * @property string $timezone
 * @property int $frequency
 * @property int $interval
 * @property int $count
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property Collection workers
 */
class Task extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'reoccurring',
        'distribution',
        'points',
        'start_at',
        'end_at',
        'frequency',
        'interval',
        'count',
        'timezone',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'reoccurring' => 'bool',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['reoccurring', 'start_at_date', 'start_at_time', 'end_at_date', 'end_at_time'];


    use FormAccessible;
    use Recurring;
    use UuidModelTrait;

    const FREQUENCIES = [
//        'YEARLY' => 0,
        'DAILY' => Frequency::DAILY,
        'WEEKLY' => Frequency::WEEKLY,
        'MONTHLY' => Frequency::MONTHLY,
        'HOURLY' => Frequency::HOURLY,
//        'MINUTELY' => 5,
//        'SECONDLY' => 6,
    ];


    /** @var array */
    private $frequencies = [
        Frequency::YEARLY   => 'YEARLY',
        Frequency::MONTHLY  => 'MONTHLY',
        Frequency::WEEKLY   => 'WEEKLY',
        Frequency::DAILY    => 'DAILY',
        Frequency::HOURLY   => 'HOURLY',
        Frequency::MINUTELY => 'MINUTELY',
        Frequency::SECONDLY => 'SECONDLY',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function works()
    {
        return $this->hasMany('App\Work', 'task_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workers()
    {
        return $this->hasMany('App\Task\TaskWorker', 'task_id', 'id');
    }

    /**
     * Owner of this task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function getStartAtAttribute($value) {
        return $value ? new Carbon($value) : null;
    }

    public function getEndAtAttribute($value) {
        return $value ? new Carbon($value) : null;
    }

    /**
     * @param $value
     * @return int
     */
    public function getReoccurringAttribute($value) {
        if (isset($this->attributes['reoccurring'])) {
            $value = $this->attributes['reoccurring'];
        }
        return ((int) $value === 1) || $value === true || $value === 'on' ? 1 : 0;
    }

    /**
     * @param $value
     * @return int
     */
    public function setReoccurringAttribute($value) {
        $this->attributes['reoccurring'] = ((int) $value === 1) || $value === true || $value === 'on' ? 1 : 0;
    }

    /**
     * @param $value
     * @return int
     */
    public function getCountAttribute($value) {
        return (int) $value;
    }

    /**
     * @param $value
     * @return int
     */
    public function getIntervalAttribute($value) {
        return (int) $value;
    }

    /**
     * @param $value
     * @return int
     */
    public function getFrequencyAttribute($value) {
        return (int) $value;
    }

    /**
     * @param $value
     * @return int
     */
    public function getPointsAttribute($value) {
        return (int) $value;
    }

    /**
     * Configuration for the Recurring Trait.
     * @return array
     */
    public function getRecurringConfig()
    {
        return [
            'start_date' => $this->start_at->format('c'),
            'end_date'   => $this->end_at->format('c'),
            'timezone'   => $this->timezone,
            'frequency'  => $this->frequencies[$this->frequency],
            'interval'   => $this->interval,
            'count'      => $this->count,
        ];
    }

    /**
     * Get start_at_date as a string formatted date
     *
     * @return string
     */
    public function getStartAtDateAttribute()
    {
        return $this->start_at->format('m/d/Y');
    }

    /**
     * Get start_at_time as a formatted time array
     *
     * @return array
     */
    public function getStartAtTimeAttribute()
    {
        return [
            'hh' => $this->start_at->format('h'),
            'mm' => $this->start_at->format('i'),
            'ss' => $this->start_at->format('s'),
            'A' => $this->start_at->format('A'),
        ];
    }

    /**
     * Get start_at_date as a string formatted date
     *
     * @return string
     */
    public function getEndAtDateAttribute()
    {
        return $this->end_at ? $this->end_at->format('m/d/Y') : null;
    }

    /**
     * Get start_at_time as a formatted time array
     *
     * @return array
     */
    public function getEndAtTimeAttribute()
    {
        if (!$this->end_at) {
            return [
                'hh' => '00',
                'mm' => '00',
                'ss' => '00',
                'A' => 'AM',
            ];
        }

        return [
            'hh' => $this->end_at->format('h'),
            'mm' => $this->end_at->format('i'),
            'ss' => $this->end_at->format('s'),
            'A' => $this->end_at->format('A'),
        ];
    }

    /**
     * Create a DateTime object from an app request
     * 
     * @param string $date
     * @param array $time
     * 
     * @return Carbon|null
     */
    public function createDateTime($date, $time)
    {
        if (in_array($date, [false, 0, '0', 'false'], true)) {
            return null;
        }

        $datetime = new Carbon($date);
        $datetime_hour = $time['hh'];
        $datetime_minute = $time['mm'];

        if ($time['A'] === 'PM') {
            $datetime_hour += 12;
        }

        $datetime->hour($datetime_hour);
        $datetime->minute($datetime_minute);
        
        return $datetime;
    }
}