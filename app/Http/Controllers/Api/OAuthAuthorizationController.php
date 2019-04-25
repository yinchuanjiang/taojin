<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class OAuthAuthorizationController extends Controller
{
    public function redirectToProvider($driver) {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback($driver) {
        $user =  Socialite::driver($driver)->user();
        // dd($user)
    }
}
