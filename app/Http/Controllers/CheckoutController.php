<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\CheckoutRequest;
use App\Models\Address\Address;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    protected $model_checkout;
    protected $set_payment;
    public function __construct()
    {
        $this->set_payment = DB::table('adm_settings')->where('setting_name', 'set_payment')->value('setting');
        $this->model_checkout = new Order();
    }

    public function index()
    {
        if ($this->set_payment == 0) return back()->with('error', 'mohon maaf toko sedang libur silahkan order kembali pada tanggal 9 mei 2022 terimakasih');
        $cart = Cart::where('id_customer', Auth()->id())->get();
        if (count($cart) == 0) return redirect()->route('cart')->with('error', 'Keranjang kosong, tidak bisa melanjutkan checkout');
        if (!Auth()->user()->name || !Auth()->user()->phone) return redirect()->route('edit.profile')->with('error', 'Nama dan nomor telepon harus diisi untuk melanjutkan checkout');

        $total = Cart::where('id_customer', Auth()->id())->sum('price');
        if ($total < 10000) return redirect()->route('cart')->with('error', 'Maaf, tidak bisa melanjutkan checkout, minimal belanja Rp 10.000,-');
        $outlet = $this->model_checkout->getOutlet();
        $alamat = optional(DB::table('idp_address')->where('cust_id', Auth()->id())->first());
        if ($alamat->suburb_id) :
            $data_ongkir = $this->model_checkout->rajaOngkir($cart, $outlet[0], $alamat);
            $ongkir = $this->model_checkout->getRajaOngkir($data_ongkir);
        endif;
        $gosend = $alamat->coordinate ? $this->model_checkout->getGosend($outlet[0]->coordinate, $alamat->coordinate) : null;
        $data   = [
            'total'     => $total,
            'carts'     => $cart,
            'alamat'    => $alamat,
            'outlets'    => $outlet,
            'gosend'    => $gosend,
            'berat'     => $data_ongkir['weight'] ?? 0,
            'raja_ongkir' => $ongkir ?? null,
        ];
        return view('checkout.index', $data);
    }

    public function checkoutTanpaLogin()
    {
        if ($this->set_payment == 0) return back()->with('error', 'mohon maaf toko sedang libur silahkan order kembali pada tanggal 9 mei 2022 terimakasih');
        $cart = Cart::where('id_customer', session('user_id_temp'))->get();
        if (count($cart) == 0) return redirect()->route('cart')->with('error', 'Keranjang kosong, tidak bisa melanjutkan checkout');

        $total = Cart::where('id_customer', session('user_id_temp'))->sum('price');
        if ($total < 10000) return redirect()->route('cart')->with('error', 'Maaf, tidak bisa melanjutkan checkout, minimal belanja Rp 10.000,-');
        $outlet = $this->model_checkout->getOutlet();
        $data   = [
            'total'     => $total,
            'carts'     => $cart,
            'outlets'   => $outlet,
            'berat'     => $data_ongkir['weight'] ?? 0,
            'alamat'    => $alamat ?? [],
            'gosend'    => $gosend ?? [],
            'raja_ongkir' => $ongkir ?? [],
        ];

        return view('checkout.index', $data);
    }

    public function payment(CheckoutRequest $request)
    {
        $user_id    = Auth()->id() ?? session('user_id_temp');
        $name       = Auth()->user()->name ?? $request->name;
        $phone      = Auth()->user()->phone ?? $request->phone;
        if (!$name || !$phone) :
            return redirect()->route('edit.profile')->with('error', 'Nama atau nomor telepon tidak boleh kosong');
        endif;
        $data_cart  = Cart::where('id_customer', $user_id)->get();
        $alamat_pickup = $request->pickup_method == "Delivery" ? DB::table('adm_outlet')->where('id', 1)->value('name') : $request->alamat_outlet;
        $payment    = $this->saleErp($request, $alamat_pickup, $data_cart);
        if (!isset($payment->error) || $payment->error > 0) return back()->with('error', 'Pembayaran gagal, koneksi ke server gagal');

        $db_address     = Auth()->id() ? Address::where('cust_id', Auth()->id())->with('province', 'city', 'suburb')->first() : null;
        $address        = ($db_address ? "{$db_address->address}, {$db_address?->city?->city_name} {$db_address?->suburb?->suburb_name}, {$db_address?->province?->province_name}" : null);
        $store_order    = $this->model_checkout->store($request, $payment, $data_cart, $alamat_pickup, $address);
        $invoice        = $payment->sale->reference;

        // waBeforePaid($invoice, $phone, $name);

        if ($request->pickup_method == "Delivery") :
            $this->model_checkout->storeDelivery($request, $invoice, $store_order, $name, $phone, $address, $db_address);
        endif;

        foreach ($data_cart as $cart) :
            Cart::destroy($cart->id);
        endforeach;

        return redirect()->route('paymentPage', ['invoice' => $invoice, 'phone' => $phone]);
    }


    public function saleErp($req, $alamat_pickup, $data_cart)
    {
        $kode       = array();
        foreach ($data_cart as $data_product) :
            foreach (json_decode($data_product->payment_code, true) as $code) :
                array_push($kode, $code);
            endforeach;
        endforeach;
        $printerp           = Http::withOptions(['http_errors' => false])->baseUrl("https://printerp.indoprinting.co.id/api/v1/");
        $pickup_method      = $req->pickup_method;
        $payment_method     = $req->payment_method;
        if ($pickup_method == "Delivery") :
            $data_delivery  = explode(",,", $req->ongkos_kirim);
            $ongkir         = [
                'code'      => 'JSONG',
                'quantity'  => 1,
                'price'     => $data_delivery[1],
            ];
            array_push($kode, $ongkir);
        endif;
        $metode = $payment_method == "Transfer" ? 1 : 0;
        $sales_erp          = [
            'phone'         => Auth()->user()->phone ?? $req->phone,
            'use_transfer'  => $metode,
            'items'         => $kode,
        ];
        if ($req->tanpa_login) :
            $cust_erp       = [
                'name'      => Auth()->user()->name ?? $req->name,
                'phone'     => Auth()->user()->phone ?? $req->phone,
                'email'     => Auth()->user()->email ?? $req->email,
                'company'   => '',
            ];
            $add_cust       = $printerp->asForm()->post("customers", $cust_erp);
            if ($add_cust->object()->error > 0) :
                $printerp->asForm()->post("customers/edit", ['phone' => $req->phone, 'name' => $req->name]);
            endif;
        endif;
        $payment        = $printerp->asJson()->post("sales", $sales_erp);
        // dd($payment->body());
        if ($alamat_pickup != "Indoprinting Durian" && $payment->object()->error == 0) :
            $warehouse = DB::table('adm_outlet')->where('name', $alamat_pickup)->value('warehouse');
            $printerp->asForm()->post("sales/edit", ['invoice' => $payment->object()->sale->reference, 'warehouse' => $warehouse]);
        endif;
        return $payment->object();
    }
}
