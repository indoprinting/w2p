<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TrackingOrderController extends Controller
{
    public function index(Request $request)
    {
        $invoice        = $request->invoice ?? $request->inv;
        $data_kurir     = [];
        if ($invoice) :
            $api_get_sales  = Http::get('https://printerp.indoprinting.co.id/api/v1/sales', ['invoice' => $invoice]);
            $order          = Order::query()->where('no_inv', $invoice)->first();
            $data_erp       = $api_get_sales->object();
            if ($data_erp->error == 0) :
                $data_erp   = $data_erp->data;
            else :
                return back()->with('error', 'Data tidak ditemukan, harap masukkan no invoice yang valid');
            endif;
            $kurir  = DB::table('idp_delivery')->where('no_inv', $invoice)->first();
            if (isset($kurir->resi)) :
                if ($kurir->courier_name == "Gosend") :
                    $data_kurir = $kurir;
                else :
                    $nama_kurir     = $kurir->courier_name == 'AnterAja' ? 'anteraja' : 'jne';
                    $api_kurir      = Http::withHeaders(['key' => 'a8d6b05e4211851c4d307d28263ff8e6'])->asForm()->post("https://pro.rajaongkir.com/api/waybill", ['waybill' => $kurir->resi, 'courier' => $nama_kurir])->object();
                    $data_kurir     = (object)[
                        'summary'   => $api_kurir->rajaongkir->result->summary,
                        'detail'    => $api_kurir->rajaongkir->result->details,
                        'status'    => $api_kurir->rajaongkir->result->delivery_status,
                        'manifest'  => $api_kurir->rajaongkir->result->manifest,
                    ];
                endif;
            endif;
        endif;
        $data   = [
            'title'     => "Tracking order",
            'data'      => $data_erp ?? null,
            'kurir'     => $data_kurir,
            'invoice'   => $invoice,
            'order'     => $order ?? null,
        ];
        return view('tracking_order.index', $data);
    }
}
