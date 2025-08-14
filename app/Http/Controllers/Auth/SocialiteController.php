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

            // البحث عن المستخدم في قاعدة بياناتنا باستخدام إيميله
            $user = User::where('email', $socialUser->getEmail())->first();

            // إذا كان المستخدم موجوداً
            if ($user) {
                // نقوم بتحديث الـ google_id الخاص به (فقط في حال لم يكن موجوداً)
                $user->update([
                    'google_id' => $socialUser->getId(),
                ]);
            } 
            // إذا لم يكن المستخدم موجوداً، سنقوم بإنشاء حساب جديد له
            else {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'google_id' => $socialUser->getId(),
                    'password' => null, // لا يوجد كلمة مرور
                ]);
            }

            // 3. تسجيل دخول المستخدم في موقعنا
            Auth::login($user);

            // 4. توجيهه إلى لوحة التحكم
            return redirect('/dashboard');

        } catch (\Exception $e) {
            // في حال حدوث أي خطأ، يتم إعادته إلى صفحة تسجيل الدخول
            return redirect('/login')->with('error', 'Something went wrong or you have cancelled the login');
        }
    }
}
