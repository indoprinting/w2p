<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function index()
    {
        $title  = "Halaman verifikasi akun";
        $promo  = DB::table('adm_settings')->where('setting_name', 'promo-login')->value('setting');

        return view('auth.verifikasi_akun', compact('title', 'promo'));
    }

    public function checkAccount(Request $request)
    {
        $check = User::query()->where('phone', $request->phone)->first();
        if ($check) :
            waReset($check->id_customer, $check->phone, $check->name);
            return redirect()->route('forgotPage', ['phone' => $request->phone]);
        endif;

        return redirect()->route('verifikasi.akun')->with('error', 'Akun tidak ditemukan, mohon masukkan nomor telepon yang sudah terdaftar');
    }

    public function resetPage(Request $request)
    {
        $title  = "Halaman reset password";
        $phone  = $request->phone;
        $promo  = DB::table('adm_settings')->where('setting_name', 'promo-login')->value('setting');

        return view('auth.reset_password', compact('title', 'promo', 'phone'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'password' => 'required|min:4'
            ],
            [
                'password.required' => "Password tidak boleh kosong",
                'password.min' => "Password minimal 4 karakter",
            ]
        );

        $check_pin = User::query()->where(['phone' => $request->phone, 'token' => $request->pin])->first();
        if ($check_pin) :
            User::query()->where(['phone' => $request->phone, 'token' => $request->pin])->update([
                'password'  => Hash::make($request->password),
                'token'     => null
            ]);

            return redirect()->route('loginPage')->with('success', 'Password berhasil diganti, silahkan lanjut login');
        endif;

        return redirect()->back()->with('error', 'PIN tidak sesuai, mohon check pesan whatsapp pelanggan untuk mendapatkan PIN');
    }
}
