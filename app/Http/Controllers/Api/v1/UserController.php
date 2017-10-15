<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{
    private $userService;
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserService $userService, UserRepositoryInterface $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
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
     *   @SWG\Parameter( name="avatar", description="User avatar in base64 encode", required=false, type="base64", in="query"),
     *   @SWG\Parameter( name="password", description="User password", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="password_confirmation", description="User confirmation password", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="terms", description="check terms of use", required=true, type="boolean", in="query"),
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
     * @SWG\Get(
     *   path="/users/{id}",
     *   summary="User detail",
     *   tags={"Users"},
     *   produces={"application/json"},
     *   @SWG\Parameter( name="id", description="User id", required=true, type="string", in="path"),
     *   @SWG\Response( response=200, description="Success get user detail"),
     * )
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json($user->toArray(), 200);
    }

    /**
     * @SWG\Put(
     *   path="/users/{id}",
     *   summary="Update user",
     *   tags={"Users"},
     *   produces={"application/json"},
     *   @SWG\Parameter( name="id", description="User id", required=true, type="string", in="path"),
     *   @SWG\Parameter( name="name", description="User first name", required=false, type="string", in="query"),
     *   @SWG\Parameter( name="surname", description="User last name", required=false, type="string", in="query"),
     *   @SWG\Parameter( name="email", description="User email", required=false, type="string", in="query"),
     *   @SWG\Parameter( name="avatar", description="User avatar in base64 encode", required=false, type="base64", in="query"),
     *   @SWG\Parameter( name="password", description="New user password", required=false, type="string", in="query"),
     *   @SWG\Parameter( name="password_confirmation", description="Confirmation new user password", required=false, type="string", in="query"),
     *   @SWG\Parameter( name="current_password", description="Current user password", required=true, type="string", in="query"),
     *   @SWG\Response( response=200, description="Success user update"),
     *   @SWG\Response( response=400, description="authorization token is required"),
     *   @SWG\Response( response=401, description="Unauthenticated"),
     *   @SWG\Response( response=403, description="Access denied"),
     *   @SWG\Response( response=422, description="Validation errors"),
     *   security={{"jwt_auth":{}}}
     * )
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if (Auth::id() != $user->id){
            return response()->json(trans('app.accessDenied'), 403);
        }

        $user = $this->userService->update($request->except('current_password'), $user->id);

        return response()->json($user->toArray(), 200);
    }
}