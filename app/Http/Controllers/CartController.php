<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product\Product;

class CartController extends Controller
{
    protected $model_cart;
    public function __construct()
    {
        $this->model_cart   = new Cart();
    }

    public function index()
    {
        $user_id    = Auth()->id() ?? session('user_id_temp');
        $data_cart  = Cart::where('id_customer', $user_id)->get();
        $category_id    = [];
        $product_id     = [];
        foreach ($data_cart as $data_cart) :
            array_push($category_id, $data_cart->id_category);
            array_push($product_id, $data_cart->id_product);
        endforeach;
        $data    = $this->model_cart->getCart($user_id, $category_id, $product_id);
        return view('cart.index', $data);
    }

    public function destroy($id)
    {
        $user_id = Auth()->id() ?? session('user_id_temp');
        $cart    = Cart::where(['id_customer' => $user_id, 'id' => $id]);
        if ($cart->value('design')) :
            foreach (json_decode($cart->value('design')) as $design) :
                if (file_exists(public_path("assets/images/design-upload/$design"))) :
                    unlink(public_path("assets/images/design-upload/$design"));
                endif;
            endforeach;
        endif;
        $cart->delete();
        return back()->with('success', 'Item berhasil dihapus');
    }


    public function updateNotes(Request $request)
    {
        $product_code = json_decode(Cart::where('id', $request->id)->value('payment_code'), true);
        $product_code[0]['note'] = $request->note;
        $payment_code   = json_encode($product_code);
        // dd($payment_code);
        Cart::where('id', $request->id)->update([
            'payment_code'  => $payment_code,
            'product_note'  => $request->note
        ]);
        // dd($update);
        return back();
    }
}
