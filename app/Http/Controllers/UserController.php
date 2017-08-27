<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends ApiController
{
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @SWG\Post(
     *   path="/users",
     *   summary="Registration new user",
     *   tags={"Users"},
     *   produces={"application/json"},
     *   @SWG\Parameter( name="name", description="User first name", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="surname", description="User last name", required=false, type="string", in="query"),
     *   @SWG\Parameter( name="email", description="User email", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="password", description="User password", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="password_confirmation", description="User confirmation password", required=true, type="string", in="query"),
     *   @SWG\Response( response=201, description="Success create new user"),
     *   @SWG\Response( response=422, description="Validation errors"),
     * )
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateUserRequest $request)
    {
        $user = $this->userService->registration($request->all());

        return response()->json($user->toArray(), 201);
    }

    /**
     * @SWG\Post(
     *   path="/auth",
     *   summary="Auth",
     *   tags={"Users"},
     *   produces={"application/json"},
     *   @SWG\Parameter( name="email", description="User email", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="password", description="User password", required=true, type="string", in="query"),
     *   @SWG\Response( response=200, description="Success authorization"),
     *   @SWG\Response( response=401, description="Invalid credentials"),
     * )
     * @param AuthUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(AuthUserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => trans('auth.failed')], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => "Couldn't generate token"], 500);
        }

        $user = User::where('email', $credentials['email'])->first();
        $user->token = $token;
        return response()->json($user->toArray(), 200);
    }
}
