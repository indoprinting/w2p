<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'idp_address';
    protected $fillable = ['cust_id', 'address', 'rt_rw', 'province_id', 'city_id', 'suburb_id', 'coordinate'];
    public $timestamps = false;

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function suburb()
    {
        return $this->belongsTo(Suburb::class, 'suburb_id', 'id');
    }

    public function saveAddress($request)
    {
        $coordinate = ($request->lat && $request->lng) ? $request->lat . ',' . $request->lng : null;
        return Address::updateOrCreate(
            [
                'id'   => $request->id
            ],
            [
                'cust_id'   => Auth()->id(),
                'address'   => $request->address,
                'rt_rw'     => $request->rt_rw,
                'province_id'   => $request->province,
                'city_id'       => $request->city,
                'suburb_id'     => $request->suburb,
                'coordinate'    => $coordinate,
            ]
        );
    }
}
