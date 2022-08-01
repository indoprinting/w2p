<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestSellerProduct extends Model
{
    use HasFactory;
    protected $table = 'idp_best_seller';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
