<?php
/**
 *
 * @OAS\Schema(
 *     schema="WorkerCreate",
 *     description="The worker / user model to create a new worker",
 *     title="Worker Create Model",
 *     type="object",
 *     required={"name", "email", "password"},
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
 *         property="password",
 *         title="Password",
 *         description="Password at least 6 characters",
 *         minLength=6,
 *         maxLength=255,
 *         type="string",
 *         format="password"
 *     ),
 *     @OAS\Property(
 *         property="password_confirmation",
 *         title="Password",
 *         description="Same as password field",
 *         minLength=6,
 *         maxLength=255,
 *         type="string",
 *         format="password"
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
 *         type="enum",
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
 * )
 */