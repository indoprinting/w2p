<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Product;

class ProductController extends Controller
{
    protected $product_model;
    public function __construct()
    {
        $this->product_model = new Product();
    }

    public function index(Request $request)
    {
        $sort       = $request->sort ?? "name,asc";
        $order      = explode(',', $sort);
        $products   = Product::where('active', 1)->withSum('best_seller', 'qty')->withAvg('review', 'rating')->orderBy($order[0], $order[1])->paginate(15)->withQueryString();

        return view('product.index', compact('products', 'sort'));
    }

    public function productCategory(Request $request, $id)
    {
        $sort       = $request->sort ?? "name,asc";
        $order      = explode(',', $sort);
        $products   = Product::where(['category' => $id, 'active' => 1])->withSum('best_seller', 'qty')->withAvg('review', 'rating')->orderBy($order[0], $order[1])->paginate(15)->withQueryString();

        return view('product.index', compact('products', 'sort'));
    }

    public function productSearch(Request $request)
    {
        if ($request->keyword) session(['keyword' => $request->keyword]);
        $keyword    = session('keyword');
        $sort       = $request->sort ?? "name,asc";
        $order      = explode(',', $sort);
        $products   = Product::where('name', 'like', "%$keyword%")->where('active', 1)->withSum('best_seller', 'qty')->withAvg('review', 'rating')->orderBy($order[0], $order[1])->paginate(15)->withQueryString();

        return view('product.index', compact('products', 'sort', 'keyword'));
    }
}
