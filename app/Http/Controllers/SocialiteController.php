<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    private $userRepository;

    /**
     * SocialiteController constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function redirect(Request $request, string $driver)
    {
        $request->session()->flash('auth_url', $request->get('auth_url'));
        $request->session()->flash('registration_url', $request->get('registration_url'));
        return Socialite::driver($driver)->redirect();
    }

    public function callback(Request $request, string $driver)
    {
        $user = Socialite::driver($driver)->user();

        //call parse function
        $data = $this->$driver($user);

        if ($user = $this->userRepository->getByEmail($data['email'])){
            $token = $user->createToken('Socialite')->accessToken;
            return redirect($request->session()->get('auth_url')."?token=".$token);
        } else {
            return redirect($request->session()->get('registration_url')."?".http_build_query($data));
        }
    }

    /**
     * parse google user data
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
