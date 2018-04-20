<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Worker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class UserController extends Controller
{

    /**
     * @OAS\Post(
     *     path="/users",
     *     tags={"user"},
     *     summary="Create a user",
     *     @OAS\Response(
     *         response=200,
     *         description="Successful in updating user"
     *     ),
     *     @OAS\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OAS\RequestBody(
     *         request="User",
     *         required=true,
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        /**
         * Get a validator for an incoming registration request.
         *
         * @param  array  $request
         * @return \Illuminate\Contracts\Validation\Validator
         */
        $valid = validator($request->only('email', 'name', 'password', 'mobile'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'string',
        ]);

        if ($valid->fails()) {
            $jsonError=response()->json($valid->errors()->all(), 400);
            return Response::json($jsonError);
        }

        $data = request()->only('email','name','password');

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        // And created user until here.

//        $client = Client::where('password_client', 1)->first();

        // Is this $request the same request? I mean Request $request? Then wouldn't it mess the other $request stuff? Also how did you pass it on the $request in $proxy? Wouldn't Request::create() just create a new thing?

//        $request->request->add([
//            'grant_type'    => 'password',
//            'client_id'     => $client->id,
//            'client_secret' => $client->secret,
//            'username'      => $data['email'],
//            'password'      => $data['password'],
//            'scope'         => null,
//        ]);
//
//        // Fire off the internal request.
//        $token = Request::create(
//            'oauth/token',
//            'POST'
//        );
        $token = $user->createToken($user->id, ['*'])->accessToken;

        return response()->json(['token' => $token], 201);
    }

    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request|Request $request
     * @param  mixed $user
     * @return mixed
     */
    public function registered(Request $request, $user)
    {
        if ($request->wantsJson()) {

            $token = $user->createToken('Token Name', ['Scopes'])->accessToken;

            return response()->json(['token' => $token], 201);
        }

        return false;
    }

    /**
     * @OAS\Get(
     *     path="/users/me",
     *     tags={"user"},
     *     summary="Get your account details",
     *     @OAS\Response(
     *         response=200,
     *         description="object of your account details",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/User"
     *             ),
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
    public function me(Request $request)
    {
        return Auth::user();
    }

    /**
     * @OAS\Get(
     *     path="/users",
     *     tags={"user"},
     *     summary="Get list of users under your account",
     *     @OAS\Response(
     *         response=200,
     *         description="object of your account details",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/User"
     *             ),
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

        return $user->workers->map(function (Worker $worker) {
            return $worker->user;
        });
    }

    /**
     * @OAS\Get(
     *     path="/users/{id}",
     *     tags={"user"},
     *     summary="Get a user under your account",
     *     @OAS\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of user to fetch",
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
     *                 ref="#/components/schemas/User"
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
     * @return User
     */
    public function get(Request $request, string $id)
    {
        /** @var User $user */
        $auth_user = Auth::user();

        $user = $auth_user->workers()->where('user_id', $id)->get()->map(function (Worker $worker) {
            return $worker->user;
        })->first();

        if ($user) {
            return $user;
        } else {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        };
    }

    /**
     * @OAS\Put(
     *     path="/users",
     *     tags={"user"},
     *     summary="Update a user",
     *     @OAS\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of user to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="Successful in updating user"
     *     ),
     *     @OAS\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OAS\RequestBody(
     *         request="User",
     *         required=true,
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     security={
     *         {"passport": {}}
     *     }
     * )
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function update(Request $request, string $id)
    {
        /** @var User $user */
        $auth_user = Auth::user();
    }
}