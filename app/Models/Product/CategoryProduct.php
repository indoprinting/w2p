<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryProduct extends Model
{

    use HasEagerLimit;
    use HasFactory;
    protected $table = 'adm_product_categories';
    protected $primaryKey = 'id_category';
    protected $guarded = ['id_category'];


    public function products()
    {
        return $this->hasMany(Product::class, 'category', 'id_category')->withSum('best_seller', 'qty')->withAvg('review', 'rating')->where('active', 1)->limit(5);
    }
}
