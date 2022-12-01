<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\PrintERP;
use App\Models\Address\City;
use Illuminate\Http\Request;
use App\Models\Address\Suburb;
use App\Models\Address\Address;
use App\Models\Address\Province;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
// use Google\Service\ServiceControl\Auth;
use App\Http\Requests\Profile\EditAddressRequest;
use App\Http\Requests\Profile\EditProfileRequest;
use App\Http\Requests\Profile\EditPasswordRequest;

class ProfileController extends Controller
{
    protected $api_erp;
    protected $address_model;
    public function __construct()
    {
        $this->api_erp  = new PrintERP();
        $this->address_model  = new Address();
    }

    public function index()
    {
        $this->moveCart();
        $title      = "My Profile";
        $orders     = Order::where('cust_id', Auth()->id())->with('shipping')->latest()->get();
        $alamat     = Address::where('cust_id', Auth()->id())->with('province', 'city', 'suburb')->first();

        return view('customer.daftar_belanja', compact('title', 'orders', 'alamat'));
    }

    public function editProfile()
    {
        $this->moveCart();
        $title  = "Ubah Profil";
        return view('customer.edit_profile', compact('title'));
    }

    public function saveProfile(EditProfileRequest $request)
    {
        $this->api_erp->ErpCustomer($request->name, $request->phone, $request->email);
        User::where('id_customer', Auth()->id())->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profile berhasil diupdate');
    }

    public function editAddress()
    {
        $title      = "Ubah Alamat";
        $address    = Address::where('cust_id', Auth()->id())->with('province', 'city', 'suburb')->first();
        $provinces  = Cache::rememberForever('provinces', fn () => Province::all());
        return view('customer.edit_address', compact('title', 'address', 'provinces'));
    }

    public function saveAddress(EditAddressRequest $request)
    {
        $save   = $this->address_model->saveAddress($request);
        return $save ? back()->with('success', 'Alamat berhasil diupdate') : back()->with('error', 'Alamat gagal diupdate, pastikan koneksi pelanggan lancar');
    }

    public function ajaxGetCity(Request $request)
    {
        $cities = City::where('province_id', $request->id)->get();
        foreach ($cities as $city) :
            echo "<option value='$city->city_id'>$city->city_name</option>";
        endforeach;
    }

    public function ajaxGetSuburb(Request $request)
    {
        $suburbs    = Suburb::where('city_id', $request->id)->get();
        foreach ($suburbs as $suburb) :
            echo "<option value='$suburb->suburb_id'>$suburb->suburb_name</option>";
        endforeach;
    }

    public function editPassword()
    {
        $title      = "Ubah Password";
        return view('customer.edit_password', compact('title'));
    }

    public function savePassword(EditPasswordRequest $request)
    {
        User::where('id_customer', Auth()->id())->update([
            'password'  => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diupdate');
    }

    public function moveCart()
    {
        return Cart::where('id_customer', session('user_id_temp'))->update(['id_customer' => Auth()->user()->id_customer]);
    }

    public function storeReview(Request $request)
    {
        $id = $request->id;
        dd($request->cart_id[$id[0]]);
    }

    public function designStudio()
    {
        $title      = "Your Design";

        return view('customer.design_studio', compact('title'));
    }
}
