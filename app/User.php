<?php

namespace App;

use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $phone
 * @property string $pushover_key
 * @property int $notice_by
 * @property int $sms_by
 * @property boolean $sms_email
 *
 *
 * @OAS\Schema(
 *     description="User model",
 *     title="User model",
 *     type="object",
 *     required={"name", "email", "password"},
 *     @OAS\Property(
 *         property="id",
 *         title="User ID",
 *         description="UUID of user",
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
 *         property="email",
 *         title="Email",
 *         description="Email",
 *         maxLength=255,
 *         type="string",
 *         format="email"
 *     ),
 *     @OAS\Property(
 *         property="phone",
 *         title="Phone",
 *         description="Phone number",
 *         maxLength=60,
 *         type="string",
 *         example="(619) 553-2123"
 *     ),
 *     @OAS\Property(
 *         property="pushover_key",
 *         title="Pushover Key",
 *         description="Integration key for Pushover Push Notifications",
 *         maxLength=255,
 *         type="string",
 *         example="vb34tghd34ger34g"
 *     ),
 *     @OAS\Property(
 *         property="notice_by",
 *         title="Notification Setting",
 *         description="How does the user want to receive notifications?
Possible Values:
- 0 - No Notifications
- 1 - Email Notifications
- 2 - Sms Notifications
- 3 - Push Notifications
",
 *         maxLength=16,
 *         type="integer",
 *         example=0
 *     ),
 *     @OAS\Property(
 *         property="sms_by",
 *         title="Text Message (SMS) Setting",
 *         description="If the user's notification is set to 'sms', they have the option to receive via
SMS gateway, or email to sms ?
Possible Values:
- 0 - No Notifications
- 1 - Text To SMS - This just uses your cellphone number and sends a true SMS
- 2 - Email To SMS - This uses your cellphone number and appends it to a SMS Gateway i.e {n}@tomail.net
",
 *         maxLength=16,
 *         type="integer",
 *         example=0
 *     ),
 *     @OAS\Property(
 *         property="sms_email",
 *         title="Text Message (SMS) Email",
 *         description="If the user has selected to be notified by SMS and using their SMS email, then provide the address here",
 *         maxLength=255,
 *         type="email",
 *         example="{n}@tmomail.net"
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
 */
class User extends Authenticatable
{
    use Notifiable;
    use UuidModelTrait;
    use HasApiTokens;

    const NOTICE_BY_EMAIL = 1;
    const NOTICE_BY_SMS = 2;
    const NOTICE_BY_PUSH = 3;
    const NOTICE_BY_NONE = 0;

    const SMS_BY_NONE = 0;
    const SMS_BY_TEXT = 1;
    const SMS_BY_EMAIL = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'pushover_key',
        'sms_email',
        'enable_sms',
        'notice_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'owner',
    ];

    public function workers()
    {
        return $this->hasMany('App\Worker', 'owner_id', 'id');
    }

    public function worker()
    {
        return $this->hasOne('App\Worker', 'user_id', 'id');
    }

    public function work()
    {
        return $this->belongsToMany('App\Work', 'works', 'user_id', 'id');
    }


    /**
     * Route notifications for the Nexmo channel.
     *
     * @return string
     */
    public function routeNotificationForNexmo()
    {
        return $this->phone;
    }

    /**
     * Route notifications for the PushOver channel.
     *
     * @return string
     */
    public function routeNotificationForPushover()
    {
        return $this->pushover_key;
    }
}
