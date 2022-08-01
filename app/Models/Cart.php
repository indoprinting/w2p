<?php

namespace App\Models;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'idp_carts';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function getCart($user_id, $category_id, $product_id)
    {
        $terkait = Product::whereIn('category', $category_id)->whereNotIn('id_product', $product_id)->withSum('best_seller', 'qty')->withAvg('review', 'rating')->limit(6)->inRandomOrder()->get();
        $data    = Cart::where('id_customer', $user_id)->latest('created_at');
        return [
            'carts'     => $data->get(),
            'total'     => $data->sum('price'),
            'relates'  => $terkait
        ];
    }
}
