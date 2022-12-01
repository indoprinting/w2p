<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;

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

    public function allProducts()
    {
        $sort       = $request->sort ?? "name,asc";
        $order      = explode(',', $sort);
        $products   = Product::where('active', 1)->withSum('best_seller', 'qty')->withAvg('review', 'rating')->orderBy($order[0], $order[1])->paginate(500)->withQueryString();

        return view('product.products', compact('products', 'sort'));
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

    public function designCategory(Request $request, $id)
    {
        $sort       = $request->sort ?? "template_name,asc";
        $order      = explode(',', $sort);
        $templates  = DB::table('idp_custom_design_template')
            ->join('idp_custom_design_category', 'idp_custom_design_template.template_category', '=', 'idp_custom_design_category.id_category')
            ->select('idp_custom_design_template.*', 'idp_custom_design_category.category_name')
            ->where('idp_custom_design_category.category_slug', $id)
            ->orderBy($order[0], $order[1])
            ->paginate(15)
            ->withQueryString();

        return view('template.index', compact('templates', 'sort'));
    }
}
