<?php

namespace App\Models\Product;

use App\Models\EditorOnline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    use HasFactory;
    protected $table = 'idp_products';
    protected $primaryKey = 'id_product';
    protected $guarded = ['id_product'];

    public function best_seller()
    {
        return $this->hasMany(BestSellerProduct::class, 'id_product', 'id_product');
    }

    public function review()
    {
        return $this->hasMany(ReviewProduct::class, 'id_product', 'id_product');
    }

    public function kategori()
    {
        return $this->belongsTo(CategoryProduct::class, 'category', 'id_category');
    }

    public function design()
    {
        return $this->hasOne(EditorOnline::class, 'product_id', 'id_product');
    }

    public function productDetail($id)
    {
        $product    = Product::where('id_product', $id)
            ->with('design')
            ->with('review', fn ($query) => $query->with('user'))
            ->withCount('review')
            ->withAvg('review', 'rating')
            ->first();
        return [
            "product"    => $product,
            "layouts"    => json_decode($product->stages)->design_layout->layout[0],
            "thumbnails" => json_decode($product->thumbnail2),
            "materials"  => json_decode($product->material),
            "sizes"      => json_decode($product->size),
            "attributes" => json_decode($product->attributes['attributes']),
        ];
    }
}
