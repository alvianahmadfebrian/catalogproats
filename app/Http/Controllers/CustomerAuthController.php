<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('catalog.index');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('catalog.index'))
                             ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('catalog.index');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => Str::slug($validated['name']) . '-' . Str::random(3),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->notify(new \App\Notifications\GeneralNotification(
            "Selamat Datang di Proats E-Catalog!",
            "Halo {$user->name}, terima kasih telah mendaftar. Mulailah menjelajahi instrumen musik favorit Anda!",
            route('catalog.index'),
            'fas fa-hands-clapping text-amber-600'
        ));

        Auth::login($user);

        return redirect()->route('catalog.index')->with('success', 'Pendaftaran akun berhasil! Selamat berbelanja di Proats.');
    }

    // Google Login Redirect & Callback Handler
    public function googleRedirect()
    {
        $clientId = config('services.google.client_id');

        // Real Google OAuth redirect if credentials are configured in .env
        if (!empty($clientId) && class_exists('Laravel\Socialite\Facades\Socialite')) {
            try {
                return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
            } catch (\Exception $e) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Gagal menghubungkan ke Google OAuth: ' . $e->getMessage(),
                ]);
            }
        }

        // Demo / Instant Google Authentication for local testing without Client ID
        $demoGoogleUser = [
            'name' => 'Pengguna Google (Demo)',
            'email' => 'user.google@gmail.com',
            'google_id' => 'google_demo_123456',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80',
        ];

        $user = User::where('email', $demoGoogleUser['email'])
                    ->orWhere('google_id', $demoGoogleUser['google_id'])
                    ->first();

        if ($user) {
            $user->update([
                'google_id' => $demoGoogleUser['google_id'],
                'avatar' => $user->avatar ?? $demoGoogleUser['avatar'],
            ]);
        } else {
            $user = User::create([
                'name' => $demoGoogleUser['name'],
                'username' => 'google-user-' . Str::random(4),
                'email' => $demoGoogleUser['email'],
                'password' => Hash::make(Str::random(16)),
                'google_id' => $demoGoogleUser['google_id'],
                'avatar' => $demoGoogleUser['avatar'],
            ]);

            $user->notify(new \App\Notifications\GeneralNotification(
                "Selamat Datang di Proats E-Catalog!",
                "Halo {$user->name}, terima kasih telah mendaftar dengan Akun Google. Temukan berbagai penawaran menarik!",
                route('catalog.index'),
                'fas fa-hands-clapping text-amber-600'
            ));
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->route('catalog.index')->with('success', 'Berhasil masuk dengan Akun Google! (Untuk OAuth Google asli, isi GOOGLE_CLIENT_ID & GOOGLE_CLIENT_SECRET pada .env)');
    }

    public function googleCallback(Request $request)
    {
        try {
            if (class_exists('Laravel\Socialite\Facades\Socialite')) {
                $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();

                $email = $googleUser->getEmail();
                $googleId = $googleUser->getId();
                $name = $googleUser->getName() ?? 'Pengguna Google';
                $avatar = $googleUser->getAvatar();

                if (empty($email)) {
                    return redirect()->route('login')->withErrors([
                        'email' => 'Akun Google Anda tidak memberikan izin akses email.'
                    ]);
                }

                $user = User::where('email', $email)
                            ->orWhere('google_id', $googleId)
                            ->first();

                if ($user) {
                    $user->update([
                        'google_id' => $googleId,
                        'avatar' => $avatar ?: $user->avatar,
                    ]);
                } else {
                    $username = Str::slug($name) . '-' . Str::random(4);
                    while (User::where('username', $username)->exists()) {
                        $username = Str::slug($name) . '-' . Str::random(4);
                    }

                    $user = User::create([
                        'name' => $name,
                        'username' => $username,
                        'email' => $email,
                        'password' => Hash::make(Str::random(16)),
                        'google_id' => $googleId,
                        'avatar' => $avatar,
                    ]);

                    $user->notify(new \App\Notifications\GeneralNotification(
                        "Selamat Datang di Proats E-Catalog!",
                        "Halo {$user->name}, terima kasih telah mendaftar dengan Google. Selamat berbelanja!",
                        route('catalog.index'),
                        'fas fa-hands-clapping text-amber-600'
                    ));
                }

                Auth::login($user, true);
                $request->session()->regenerate();

                return redirect()->route('catalog.index')->with('success', 'Selamat datang kembali, ' . $user->name . '! Berhasil masuk via Google.');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal login via Google: ' . $e->getMessage()
            ]);
        }

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('catalog.index')->with('success', 'Anda telah keluar.');
    }
}
