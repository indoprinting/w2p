<?php

namespace App\Http\Controllers\PrintERP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PrintERP;
use Illuminate\Support\Facades\Auth;

class QueueOnlineController extends Controller
{
    protected $model_erp;
    public function __construct()
    {
        $this->model_erp = new PrintERP();
    }

    public function index()
    {
        $title      = "Antrian Online";
        $outlets    = DB::table('adm_outlet')->get();
        $queues     = DB::table('idp_queue_online')->where('customer_id', Auth()->id())->latest('id')->take(5)->get();

        return view('print_erp.queue_online.index_queue', compact('title', 'outlets', 'queues'));
    }

    public function getQueue(Request $request)
    {
        $queue  = $this->model_erp->newQueue($request);
        if ($queue) :
            DB::table('idp_queue_online')->insert([
                'customer_id'   => Auth()->id(),
                'no_antrian'    => $queue->token,
                'ets'           => $queue->est_call_date,
                'service'       => $queue->queue_category_name,
                'outlet'        => $queue->warehouse_name,
                'created_at'    => date('Y-m-d H:i:s')
            ]);

            return back()->with('success', 'Nomor antrian berhasil dibuat, silahkan cek whatsapp pelanggan.');
        endif;
        return back()->with('error', 'Gagal mendapatkan nomor antrian, cobalah beberapa saat lagi, terima kasih.');
    }
}
