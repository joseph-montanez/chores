<?php
/**
 * Created by PhpStorm.
 * User: josephmontanez
 * Date: 1/7/2017
 * Time: 4:26 PM
 */

namespace App\Task;

use \Alsofronie\Uuid\UuidModelTrait;
use \Illuminate\Database\Eloquent\Model;

/**
 * Class Worker
 * @package App\Task
 *
 * @property string $id
 * @property string $task_id
 * @property string $worker_id
 * @property int $position
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class TaskWorker extends Model
{
    use UuidModelTrait;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks_workers';

    public function task() {
        return $this->belongsTo('App\Task', 'task_id', 'id');
    }

    public function worker() {
        return $this->belongsTo('App\Worker', 'worker_id', 'id');
    }

    public function user() {
        return $this->worker->user();
    }

}