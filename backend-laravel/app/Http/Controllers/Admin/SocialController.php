<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function sociallogin($provider)
    {
        // Socialite will pick response data automatic
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            dd($e);
        }

        return response()->json($user);
    }

    public function index()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('email', $user->email)->first();

            if ($finduser) {

                if (!$token = JWTAuth::fromUser($finduser)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->email,
                    // 'gauth_id' => $user->id,
                    // 'gauth_type' => 'google',
                    'password' => encrypt('123123123')
                ]);

                if (!$token = JWTAuth::fromUser($newUser)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            }

            $authenticatedUser = JWTAuth::setToken($token)->toUser();

            return redirect("http://localhost:5173/callback/login?hash=$token");
            // return response()->json([
            //     'access_token' => $token,
            //     'token_type' => 'bearer',
            //     'expires_in' => auth()->factory()->getTTL() * 60,
            //     'user' => $authenticatedUser->load(['roles'])
            // ]);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
