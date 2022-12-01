<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\Auth\LoginPhoneRequest;
use App\Models\Cart;

class LoginController extends Controller
{
    protected $user_model;
    public function __construct()
    {
        $this->user_model   = new User();
    }

    public function index()
    {
        $title      = "Halaman Login";
        $promo      = DB::table('adm_settings')->where('setting_name', 'promo-login')->value('setting');
        $provinces  = DB::table('local_provinces')->get();

        return view('auth.login', compact('title', 'promo', 'provinces'));
    }

    public function loginPhone(LoginPhoneRequest $request)
    {
        $check  = User::where('phone', $request->phone)->first();
        if (!$check) {
            return $this->storeUser($request);
        }

        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return redirect()->route('profile');
        }

        return back()->with('error', 'Password salah');
    }

    public function loginGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function validateGoogleCallback()
    {
        try {
            $user       = Socialite::driver('google')->user();
            $findUser   = User::where('email', $user->email)->first();
            if ($findUser) {
                Auth::login($findUser);
                return redirect()->route('home');
            }
            $newUser    = User::create([
                'name'          => $user->name,
                'email'         => $user->email,
                'password'      => Hash::make($user->email),
                'user_role'     => '2',
                'google'        => '1',
                'active'        => '1',
            ]);
            Auth::login($newUser);
            request()->session()->regenerate();
            return redirect()->route('profile');
        } catch (\Throwable $th) {
            storeError("Login google", "gagal login {$user->email}", $th->getMessage());
            return redirect()->route('loginPage')->with('error', 'Gagal login dengan google');
        }
    }

    public function storeUser($post)
    {
        $store = User::create([
            'phone'         => $post->phone,
            'user_role'     => '2',
            'password'      => Hash::make($post->password),
            'active'        => '1',
        ]);
        Auth::login($store);
        return $this->checkDataERP($store);
    }

    public function checkDataERP($user)
    {
        $response = Http::get('https://printerp.indoprinting.co.id/api/v1/customers', ['phone' => $user->phone])->object();
        if ($response->error == 0) {
            $data = $response;
            User::where('phone', $user->phone)->update([
                'name'  => $data->customer->name
            ]);
        }
        return redirect()->route('edit.profile')->with('success', 'Berhasil registrasi, harap masukkan nama dan nomor telepon yang valid agar bisa checkout');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        setcookie("nsm_session_idp", "");

        return redirect('/');
    }
}
