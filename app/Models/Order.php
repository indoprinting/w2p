<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'idp_orders';
    protected $primaryKey = 'id_order';
    protected $guarded  = ['id_order'];

    public function store($req, $payment, $cart, $alamat_pickup, $address)
    {
        $data    = [
            'no_inv'    => $payment->sale->reference,
            'cust_id'   => Auth()->id() ?? 0,
            'cust_name' => Auth()->user()->name ?? $req->name,
            'address'   => $address,
            'total'     => intval($req->total),
            'items'     => json_encode($cart),
            'pickup'    => $alamat_pickup,
            'cust_phone'    => Auth()->user()->phone ?? $req->phone,
            'cust_email'    => Auth()->user()->email ?? null,
            'pickup_method'     => $req->pickup_method,
            'payment_method'    => $req->payment_method,
            'url_track_order'   => $payment->url,
            'sale_status'       => 'Need Payment',
            'cs'                => 'Web2Print Account',
        ];

        $store = $this->create($data);
        return $store->id_order;
    }

    public function storeDelivery($request, $invoice, $order, $name, $phone, $address, $db_address)
    {
        $data_delivery  = explode(",,", $request->ongkos_kirim);
        if ($data_delivery[3] == "Gosend") :
            $data_gosend = [
                "paymentType" => 3,
                "shipment_method" => str_replace(' ', '', $data_delivery[0]),
                "routes" => [
                    [
                        "originName" => "Indoprinting Online",
                        "originContactName" => "Indoprinting Online",
                        "originContactPhone" => "085877992444",
                        "originAddress" => "Jl. Durian Raya No. 100, Banyumanik Semarang",
                        "originLatLong" => "-7.065086600767203,110.42756631026865",
                        "destinationContactName" => Auth()->user()->name ?? $name,
                        "destinationContactPhone" => Auth()->user()->phone ?? $phone,
                        "destinationLatLong" => $db_address->coordinate,
                        "destinationAddress" => $address,
                        "item" => "Paket dari tim online Indoprinting (Lantai 2) dengan No. Invoice : $invoice"
                    ]
                ]
            ];
            $data_gosend = json_encode($data_gosend);
        else :
            $data_gosend = null;
        endif;
        DB::table('idp_delivery')->insert([
            'id_inv'            => $order,
            'no_inv'            => $invoice,
            'courier_service'   => $data_delivery[0],
            'courier_price'     => $data_delivery[1],
            'estimasi'          => $data_delivery[2],
            'courier_name'      => $data_delivery[3],
            'weight'            => $request->berat,
            'data_gosend'       => $data_gosend,
        ]);
    }

    public function getOutlet()
    {
        // return cache()->remember('checkout-outlet', cacheTime(), function () {
        return DB::table('adm_outlet')->where('active', 1)->get();
        // });
    }

    public function getRajaOngkir($data_ongkir)
    {
        $rajaongkir = Http::withHeaders(['key' => 'a8d6b05e4211851c4d307d28263ff8e6'])
            ->post('https://pro.rajaongkir.com/api/cost', $data_ongkir);
        return $rajaongkir->successful() ? $rajaongkir->object()->rajaongkir->results : null;
    }

    public function getGosend($origin, $destination)
    {
        if (env('APP_ENV') == "production") :
            $api_gosend   = Http::baseUrl("https://kilat-api.gojekapi.com/gokilat/v10/")
                ->withHeaders([
                    "Client-ID"    => "indoprinting-engine",
                    "Pass-Key"    => "6e86c4e7da59aefc450a253dbc5bee22bdd5937e06885ff6ef2f61c89e3805c3",
                ])->withOptions(['http_errors' => false]);
        else :
            $api_gosend   = Http::baseUrl("https://integration-kilat-api.gojekapi.com/gokilat/v10/")
                ->withHeaders([
                    "Client-ID"    => "indoprinting-engine",
                    "Pass-Key"    => "635e9496ebf113291f53e6c99ee2805363db7fe46b442db29e29b906a71a40c3",
                ])->withOptions(['http_errors' => false]);
        endif;
        $gosend = $api_gosend->get("calculate/price", [
            'http_errors'   => false,
            "origin"        => $origin,
            "destination"   => $destination,
            "paymentType"   => 3,
        ]);
        return $gosend->successful() ? $gosend->object() : null;
    }

    public function rajaOngkir($carts, $data_outlet, $data_address)
    {
        $berat      = [];
        foreach ($carts as $cart) :
            array_push($berat, json_decode($cart->dimensi)->berat);
        endforeach;
        $wt         = array_sum($berat) * 1000;
        return     [
            'origin'            => $data_outlet->suburb_id,
            'originType'        => "subdistrict",
            'destination'       => $data_address->suburb_id,
            'destinationType'   => "subdistrict",
            "weight"            => $wt,
            'courier'           => "anteraja:jne"
        ];
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class, 'id_inv', 'id_order');
    }
}
