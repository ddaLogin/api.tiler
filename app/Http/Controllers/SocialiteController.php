<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialiteController extends Controller
{
    private $userRepository;
    private $userService;

    /**
     * SocialiteController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserService $userService
     */
    public function __construct(UserRepositoryInterface $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function redirect(Request $request, string $driver)
    {
        $request->session()->flash('callback_url', $request->get('callback_url'));
        return Socialite::driver($driver)->redirect();
    }

    public function callback(Request $request, string $driver)
    {
        $user = Socialite::driver($driver)->user();
        $data = $this->$driver($user);

        if ($user = $this->userRepository->getByEmail($data['email'])){
            $token = JWTAuth::fromUser($user);
            return redirect($request->session()->get('callback_url')."?token=".$token);
        } else {
            return redirect($request->session()->get('callback_url')."?".http_build_query($data));
        }
    }

    /**
     * parse google redirect and return user data
     *
     * @param $googleUser
     * @return mixed
     */
    private function google($googleUser)
    {
        return [
            'email' => $googleUser->email,
            'name' => $googleUser->user['name']['givenName'],
            'surname' => $googleUser->user['name']['familyName'],
        ];
    }
}
