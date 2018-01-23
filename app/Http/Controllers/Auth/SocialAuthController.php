<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $social_user = Socialite::driver($provider)->user();
        # dd($social_user);

        if ($user = User::where('email', $social_user->email)->first()) {
            # return $this->authAndRedirect($user);
        } else {
            $user = User::create([
                'nombres' => $social_user->name,
                'email' => $social_user->email,
                'sexo' => $social_user->user['gender'] == 'male' ? 'masculino' : 'femenino',
                'estatus' => true
            ]);
            # return $this->authAndRedirect($user);
        }

        return $this->authAndRedirect($user);
    }

    public function authAndRedirect($user)
    {
        if (Auth::loginUsingId($user->id, true)) {
            return redirect()->route('index');
        }

        # return Auth::user();
        # Auth::login($user);
    }
}
