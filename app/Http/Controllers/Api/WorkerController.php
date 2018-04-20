<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorker;
use App\Repository\WorkerRepository;
use App\User;
use App\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    /**
     * @OAS\Post(
     *     path="/workers",
     *     tags={"worker"},
     *     summary="Create a worker",
     *     @OAS\Response(
     *         response=200,
     *         description="Successful in updating worker",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Worker"
     *             )
     *         )
     *     ),
     *     @OAS\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OAS\RequestBody(
     *         request="User",
     *         required=true,
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/WorkerCreate"
     *             )
     *         )
     *     ),
     *     security={
     *         {"passport": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $store = new StoreWorker();
        $store->request = $request;

        /**
         * Get a validator
         *
         * @var $valid \Illuminate\Contracts\Validation\Validator
         */
        $data  = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation',
            'phone',
            'pushover_key',
            'notice_by',
            'sms_by',
            'sms_email',
        ]);
        $valid = validator($data, $store->rules(), $store->messages());

        if ($valid->fails()) {
            $jsonError = response()->json($valid->errors()->all(), 400);
            return response()->json($jsonError);
        }

        /**
         * @var User $owner
         */
        $owner = Auth::user();

        $workerRepo = new WorkerRepository();
        $worker = $workerRepo->create($owner, $data);

        return response()->json($worker, 201);
    }


    /**
     * @OAS\Get(
     *     path="/workers",
     *     tags={"worker"},
     *     summary="Get list of workers under your account",
     *     @OAS\Response(
     *         response=200,
     *         description="array of your workers",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 type="array",
     *                 @OAS\Items(
     *                     ref="#/components/schemas/Worker"
     *                 )
     *             )
     *         ),
     *     ),
     *     security={
     *         {"passport": {}}
     *     }
     * )
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function list(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        return $user->workers;
    }

    /**
     * @OAS\Get(
     *     path="/workers/{id}",
     *     tags={"worker"},
     *     summary="Get a worker under your account",
     *     @OAS\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of worker to fetch",
     *         required=true,
     *         @OAS\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="object of your account details",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Worker"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=400,
     *         description="Missing ID"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Record not found"
     *     ),
     *     security={
     *         {"passport": {}}
     *     }
     * )
     *
     * @param Request $request
     *
     * @param string $id
     *
     * @return Worker
     */
    public function get(Request $request, string $id)
    {
        /** @var User $user */
        $auth_user = Auth::user();

        $worker = $auth_user->workers()->where('id', $id)->first();

        if ($worker) {
            return $worker;
        } else {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
    }

    /**
     * @OAS\Put(
     *     path="/workers/{id}",
     *     tags={"worker"},
     *     summary="Update a worker",
     *     @OAS\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of worker to fetch",
     *         required=true,
     *         @OAS\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="Successful in updating worker",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Worker"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OAS\RequestBody(
     *         request="User",
     *         required=true,
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/WorkerUpdate"
     *             )
     *         )
     *     ),
     *     security={
     *         {"passport": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        /** @var User $user */
        $auth_user = Auth::user();

        $worker = $auth_user->workers()->where('id', $id)->first();

        if (!$worker) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $rules = [
            'name' => 'max:255',
            'email' => 'email|max:255|unique:users,' . $worker->user->id,
            'phone' => 'max:255',
            'pushover_key' => 'max:255',
            'notice_by' => 'max:255',
            'sms_by' => 'max:255',
            'sms_email' => 'max:255',
        ];

        /**
         * Get a validator
         *
         * @var $valid \Illuminate\Contracts\Validation\Validator
         */
        $data  = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation',
            'phone',
            'pushover_key',
            'notice_by',
            'sms_by',
            'sms_email',
        ]);
        $valid = validator($data, $rules, []);

        if ($valid->fails()) {
            $jsonError = response()->json($valid->errors()->all(), 400);
            return response()->json($jsonError);
        }

        $workerRepo = new WorkerRepository();
        $worker = $workerRepo->update($worker, $data);

        return response()->json($worker, 201);
    }
}