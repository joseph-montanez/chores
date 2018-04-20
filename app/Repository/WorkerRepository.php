<?php

namespace App\Repository;


use App\User;
use App\Worker;

class WorkerRepository
{

    /**
     * Create a user and worker from data
     *
     * @param User $owner
     * @param array $data
     *
     * @return Worker
     */
    public function create(User $owner, array $data) : Worker
    {
        $request = collect($data);

        $user = User::create([
            'name'         => $request->get('name', ''),
            'email'        => $request->get('email', ''),
            'phone'        => $request->get('phone', ''),
            'pushover_key' => $request->get('pushover_key', ''),
            'sms_email'    => $request->get('sms_email', ''),
            'sms_by'       => $request->get('sms_by', User::SMS_BY_NONE),
            'notice_by'    => $request->get('notice_by', User::NOTICE_BY_NONE),
            'password'     => bcrypt($request->get('password', '')),
        ]);

        $worker = new Worker();
        $worker->owner()->associate($owner);
        $worker->user()->associate($user);
        $worker->name = $user->name;

        $worker->saveOrFail();

        return $worker;
    }

    /**
     * TODO: If a user has workers under them or there are other owners, then no one can update the user account except
     *       for the user themselves.
     *
     * @param Worker $worker
     * @param $data
     *
     * @return Worker
     */
    public function update(Worker $worker, $data)
    {
        $request = collect($data);

        if ($request->has('name')) {
            $worker->name = $request->get('name', '');
            $worker->user->name = $request->get('name', '');
        }
        if ($request->has('email')) {
            $worker->user->email = $request->get('email', '');
        }
        if ($request->has('phone')) {
            $worker->user->phone = $request->get('phone', '');
        }
        if ($request->has('pushover_key')) {
            $worker->user->pushover_key = $request->get('pushover_key', '');
        }
        if ($request->has('notice_by')) {
            $worker->user->notice_by = $request->get('notice_by', 0);
        }
        if ($request->has('sms_by')) {
            $worker->user->sms_by = $request->get('pushover_key', 0);
        }
        if ($request->has('sms_email')) {
            $worker->user->sms_email = $request->get('sms_email', '');
        }
        if ($request->has('password')) {
            $worker->user->password = bcrypt($request->get('password', ''));
        }

        $worker->save();
        $worker->user->save();

        return $worker;
    }

}
