<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Payment\RequestUploadBuktiTF;
use App\Models\Qris;
use App\Models\Shipping;

class PaymentController extends CheckoutController
{
    protected $qris_model;
    public function __construct()
    {
        $this->qris_model = new Qris();
    }

    public function paymentPage(Request $request)
    {
        $order      = Order::where(['no_inv' => $request->invoice, 'cust_phone' => $request->phone])->first();
        if (!$order) return abort(404);
        $api_erp    = Http::get("https://printerp.indoprinting.co.id/api/v1/sales", ["invoice" => $request->invoice]);
        $sale_erp   = $api_erp->object()->data;
        if ($order->payment_method == "Transfer") :
            $harga_kurir = DB::table('idp_delivery')->where('no_inv', $request->invoice)->value('courier_price');
            return view('payment.index', compact('order', 'harga_kurir', 'sale_erp'));
        elseif ($order->payment_method == "Cash") :
            return view('payment.cash', compact('order', 'sale_erp'));
        else :
            if (DB::table('idp_qris')->where('invoice', $order->no_inv)->doesntExist()) :
                $ongkir = Shipping::where('id_inv', $order->id_order)->value('courier_price');
                $total = $ongkir ? $order->total + $ongkir : $order->total;
                $api_qris   = $this->qris_model->getQris(invoice: $order->no_inv, price: $total);
            endif;
            $qris = DB::table('idp_qris')->where('invoice', $order->no_inv)->first();
            $harga_kurir = DB::table('idp_delivery')->where('no_inv', $request->invoice)->value('courier_price');
            return view('payment.qris', compact('order', 'harga_kurir', 'sale_erp', 'qris'));
        endif;
    }

    public function changePaymentMethod(Request $request)
    {
        $id         = $request->id;
        $current    = $request->current;
        $data       = [
            'invoice'   => $request->invoice,
            'phone'     => $request->phone,
        ];

        if ($current == 'Transfer') :
            Http::asForm()->post('https://printerp.indoprinting.co.id/api/v1/sales/cancel_transfer', $data);
            Order::where('id_order', $id)->update([
                'id_order'          => $id,
                'payment_method'    => 'Cash',
            ]);
        elseif ($current == 'Cash') :
            Http::asForm()->post('https://printerp.indoprinting.co.id/api/v1/sales/add_transfer', $data);
            Order::where('id_order', $id)->update([
                'id_order'          => $id,
                'payment_method'    => 'Transfer',
            ]);
        endif;

        return back();
    }

    public function uploadTF(RequestUploadBuktiTF $request)
    {
        $image      = $request->bukti_tf;
        $filename   = str_replace(" ", "-", Str::random(21) . "-" . $image->getClientOriginalName());
        $update     = Order::where(['id_order' => $request->id, 'cust_phone' => $request->phone])->update(['payment_proof' => $filename]);
        if (!$update) return back()->with('error', 'Upload gagal');
        $image->move(public_path('assets/images/bukti-transfer'), $filename);
        return back()->with('success', 'Upload berhasil');
    }

    public function downloadInvoice(Request $request)
    {
        $order      = Order::where(['no_inv' => $request->invoice, 'cust_phone' => $request->phone])->first();
        if (!$order) return back()->with('error', 'Invoice tidak bisa disimpan');
        $api_erp    = Http::get("https://printerp.indoprinting.co.id/api/v1/sales", ["invoice" => $request->invoice]);
        $data_erp   = $api_erp->object()->data;
        $harga_kurir = DB::table('idp_delivery')->where('no_inv', $request->invoice)->value('courier_price');
        $pdf        = App::make('dompdf.wrapper');
        $pdf->loadview("payment.invoice", compact('order', 'data_erp', 'harga_kurir'))->setPaper('a4', 'potrait')->setWarnings(false);
        return $pdf->stream(str_replace('/', '-', $order->no_inv) . ".pdf");
    }

    public function checkStatusQris(Request $request)
    {
        $check_status = $this->qris_model->checkQris($request->invoice);
        if ($check_status) :
            return back()->with('success', 'Pembayaran Berhasil diterima, silahkan tunggu admin kami memproses orderan pelanggan, terimas kasih.');
        else :
            return back()->with('error', 'Pembayaran belum tervalidasi, silahkan unggah bukti pembayaran atau tunggu sekitar 15 detik untuk melakukan pengecekan ulang, terima kasih.');
        endif;
    }

    public function downloadQrCode(Request $request)
    {
        $invoice    = str_replace('/', '+', $request->invoice);
        $content    = $request->content;
        $filename   = "Qrcode-invoice-{$invoice}.jpg";
        $tempImage  = tempnam(sys_get_temp_dir(), $filename);
        copy("https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl={$content}", $tempImage);

        return response()->download($tempImage, $filename);
    }
}
