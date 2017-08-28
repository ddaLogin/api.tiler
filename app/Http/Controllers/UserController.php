<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
     *   summary="Authorization",
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

    /**
     * @SWG\Get(
     *   path="/users/{id}",
     *   summary="User detail",
     *   tags={"Users"},
     *   produces={"application/json"},
     *   @SWG\Parameter( name="id", description="User id", required=true, type="string", in="path"),
     *   @SWG\Response( response=200, description="User detail"),
     *   @SWG\Response( response=401, description="Unauthenticated"),
     *   security={{"jwt_auth":{}}}
     * )
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        if (JWTAuth::parseToken()->authenticate()->id != $user->id){
            throw new AccessDeniedHttpException();
        }

        return response()->json($user->toArray(), 200);
    }
}
