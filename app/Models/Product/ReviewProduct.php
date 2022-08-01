<?php

namespace App\Models\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProduct extends Model
{
    use HasFactory;

    protected $table = 'idp_review';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_customer');
    }
}
