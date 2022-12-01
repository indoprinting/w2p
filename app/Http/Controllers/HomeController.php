<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Product\CategoryProduct;

class HomeController extends Controller
{
    public function index()
    {
        visitor();
        visitorToday();
        $design_online     = DB::table('idp_custom_design_category')->get();
        $banner            = DB::table('adm_carousel')->where('active', 1)->get();
        $our_work          = cache()->remember('our_work', cacheTime(), fn () => DB::table('adm_our_work')->latest('created_at')->get());
        $best_seller       = cache()->remember('best_seller-home', cacheTime(), fn () => Product::withSum('best_seller', 'qty')->withAvg('review', 'rating')->latest('best_seller_sum_qty')->whereNotIn('id_product', [197,344])->take(10)->get());
        $newest            = cache()->remember('newest-home', cacheTime(), fn () => Product::withSum('best_seller', 'qty')->withAvg('review', 'rating')->where('newest', 1)->take(10)->get());
        $categories        = cache()->remember('categories-home', cacheTime(), fn () => CategoryProduct::with('products')->where('id_category', '!=', 27)->orderBy('name', 'asc')->get());

        return view('home.index', compact('categories', 'best_seller', 'newest', 'banner', 'our_work', 'design_online'));
    }

    public function all_product()
    {
        $title = "All Product";
        return view('home.products', compact('title'));
    }

    public function faq()
    {
        $title = "Frequently Asked Questions";
        return view('home.faq', compact('title'));
    }

    public function caraOrder()
    {
        $title = "Cara Order";
        return view('home.cara_order', compact('title'));
    }

    public function priceList()
    {
        $title = "Price List";
        $images = DB::table('idp_price_list')->get();
        return view('home.price_list', compact('title', 'images'));
    }

    public function downloadPriceList($image)
    {
        return response()->download(public_path("assets/images/price-list/$image"));
    }

    public function term()
    {
        $title = "Syarat dan Ketentuan";
        $term = DB::table('adm_settings')->where('setting_name', 'term_id')->value('setting');
        return view('home.term', compact('title', 'term'));
    }

    public function privacy()
    {
        $title = "Privacy and Security";
        $privacy = DB::table('adm_settings')->where('setting_name', 'privacy')->value('setting');
        return view('home.privacy', compact('title', 'privacy'));
    }

    public function tokoKami()
    {
        $title = "Toko Kami";
        $stores = DB::table('adm_outlet')->get();
        return view('home.toko_kami', compact('title', 'stores'));
    }

    public function daftarBank()
    {
        $title = 'Daftar Bank';
        return view('home.daftar_bank', compact('title'));
    }
}
