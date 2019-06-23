<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\PrivateUserResource;
use App\Models\User;
use Socialite;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $authUser = $this->findOrCreateUser($user, $provider);

        if (!$token = Auth::login($authUser, true)) {
            return response()->json([
              'errors' => [
                'email' => ['Could not login with those det']
                ]
              ], 401);
        }

        return (new PrivateUserResource($authUser))
                ->additional([
                  'meta' => [
                    'token' => $token
                  ]
                ]);
    }


    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::firstOrNew([
          'email'    => $user->email
        ]);

        if (!$authUser->exists) {
            $authUser->name = $user->name;
            $authUser->provider = $provider;
            $authUser->provider_id = $user->id;
            $authUser->save();
        }

        return $authUser;
    }

    public function action(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
              'errors' => [
                'email' => ['Could not login with those det']
                ]
              ], 401);
        }

        return (new PrivateUserResource($request->user()))
                ->additional([
                  'meta' => [
                    'token' => $token
                  ]
                ]);
    }
}
