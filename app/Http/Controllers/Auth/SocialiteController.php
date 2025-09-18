<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


 public function callback($provider)
{
    try {
        $socialUser = Socialite::driver($provider)->user();

        // Find or create the user
        $user = User::updateOrCreate(
            [
                'email' => $socialUser->getEmail()
            ],
            [
                'name' => $socialUser->getName(),
                'google_id' => $socialUser->getId(),
                'password' => null, // No password for social logins
                'email_verified_at' => now(), // Assume email is verified
            ]
        );

        // 3. Login the user
        Auth::login($user);

        // 4. Check the user's role and redirect accordingly
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Redirect admin to admin dashboard
        }

        return redirect()->route('home'); // Redirect regular customers to the homepage

    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Something went wrong or you have cancelled the login.');
    }
}
}
