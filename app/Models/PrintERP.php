<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrintERP extends Model
{
    use HasFactory;
    protected $api_erp;
    public function __construct()
    {
        $this->api_erp  = Http::withOptions(['http_errors' => false])->baseUrl("https://printerp.indoprinting.co.id/api/v1/");
    }

    public function ErpCustomer($name, $phone, $email)
    {
        $add_cust   = $this->api_erp->asForm()->post("customers", ['phone' => $phone, 'name' => $name, 'company' => '', 'email' => $email]);
        if ($add_cust->object()->error > 0) {
            $edit       = $this->api_erp->asForm()->post("customers/edit", ['phone' => $phone, 'name' => $name, 'email' => $email]);
            return $edit->object();
        }
        return $add_cust->object();
    }

    public function newQueue($request)
    {
        $queue  = $this->api_erp->asForm()->post('qms', [
            'name'   => Auth()->user()->name,
            'phone'  => Auth()->user()->phone,
            'warehouse' => $request->outlet,
            'category'  => $request->service,
        ])->object();
        
        if ($queue) {
            return $queue->error == 0 ? $queue->data : false;
        }
        
        return false;
    }
}
