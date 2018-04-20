<?php
/**
 * Created by PhpStorm.
 * User: josephmontanez
 * Date: 1/6/2017
 * Time: 12:03 AM
 */

namespace App;

use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Worker
 * @package App
 *
 * @OAS\Schema(
 *     description="User model",
 *     title="User model",
 *     type="object",
 *     @OAS\Property(
 *         property="id",
 *         title="Worker ID",
 *         description="UUID of Worker",
 *         maxLength=255,
 *         type="string",
 *         example="f80cf05a-9ef3-4781-9a05-728079e360ae"
 *     ),
 *     @OAS\Property(
 *         property="owner_id",
 *         title="Worker Owner",
 *         description="UUID of worker's owner id",
 *         maxLength=255,
 *         type="string",
 *         example="f80cf05a-9ef3-4781-9a05-728079e360ae"
 *     ),
 *     @OAS\Property(
 *         property="user_id",
 *         title="Worker User",
 *         description="UUID of worker user id",
 *         maxLength=255,
 *         type="string",
 *         example="f80cf05a-9ef3-4781-9a05-728079e360ae"
 *     ),
 *     @OAS\Property(
 *         property="name",
 *         title="Full Name",
 *         description="Entire name, first, last, middle",
 *         maxLength=255,
 *         type="string",
 *         example="John Doe"
 *     ),
 *     @OAS\Property(
 *         property="user",
 *         title="User",
 *         description="Worker's user data",
 *         type="object",
 *         ref="#/components/schemas/User"
 *     ),
 *     @OAS\Property(
 *         property="created_at",
 *         title="Date Created",
 *         description="When the user was created",
 *         maxLength=16,
 *         type="datetime",
 *         example="01/01/2022 05:00:00"
 *     ),
 *     @OAS\Property(
 *         property="updated_at",
 *         title="Date Updated",
 *         description="When the user was last updated",
 *         maxLength=16,
 *         type="datetime",
 *         example="01/01/2022 05:00:00"
 *     ),
 * )
 *
 * @property int $owner_id
 * @property int $id
 * @property string $name
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property User owner
 * @property User user
 */
class Worker extends Model
{
    use UuidModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function owner() {
        return $this->belongsTo('App\User', 'owner_id', 'id');
    }
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}