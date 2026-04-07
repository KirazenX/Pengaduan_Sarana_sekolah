<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // Mendaftarkan layanan untuk tampilan login dan register, serta mengatur logika autentikasi menggunakan email atau NIS
    public function register(): void
    {
        $this->app->bind(\Laravel\Fortify\Contracts\LoginViewResponse::class, function () {
            return new \Laravel\Fortify\Http\Responses\SimpleViewResponse('auth.login');
        });

        $this->app->bind(\Laravel\Fortify\Contracts\RegisterViewResponse::class, function () {
            return new \Laravel\Fortify\Http\Responses\SimpleViewResponse('auth.register');
        });
    }

    /**
     * Bootstrap any application services.
     */
    // Mengatur logika autentikasi menggunakan email atau NIS, serta mengonfigurasi pembatasan kecepatan untuk login dan autentikasi dua faktor
    public function boot(): void
    {
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $login = $request->input('login');

            $user = User::where('email', $login)
                ->orWhere('nis', $login)
                ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::redirects('login', '/dashboard');
        Fortify::redirects('register', '/dashboard');

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
