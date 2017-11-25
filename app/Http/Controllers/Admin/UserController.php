<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * users page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $size = $request->get('size', config('common.defaultUserCount'));

        return view('admin.user.index', [
            'users' => $this->userRepository->getAllOrderByCreatedAtAndPaginate($size),
            'size' => $size,
        ]);
    }
}
