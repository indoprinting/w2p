<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TanpaRegisterRequest;

class OrderTanpaLoginController extends Controller
{
    public function tanpaRegisterPage()
    {
        $title      = "Order tanpa register";
        $provinces  = DB::table('local_provinces')->get();
        $promo      = DB::table('adm_settings')->where('setting_name', 'promo-login')->value('setting');
        return view('auth.tanpa_register', compact('title', 'provinces', 'promo'));
    }

    public function tanpaRegister(TanpaRegisterRequest $request)
    {
        session('form-tanpa-login', [
            'name'      => $request->name,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'rt-rw'     => $request->input('rt-rw'),
            'province'  => $request->province,
            'city'      => $request->city,
            'suburb'    => $request->suburb,
        ]);
    }
}
