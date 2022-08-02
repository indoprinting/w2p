<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Product\SaveProductRequest;

class ProductDetailController extends ProductController
{
    public function detail($id)
    {
        $data       = $this->product_model->productDetail($id);
        $data       = array_merge($data, [
            "title" => $data['product']->name,
            "term"  => DB::table('adm_settings')->where('setting_name', 'term_id')->value('setting'),
        ]);

        return view('product.detail', $data);
    }

    public function store(SaveProductRequest $req)
    {
        // SaveProductRequest
        $product        = Product::find($req->id);
        if (!session("user_id_temp")) session(['user_id_temp' => random_int(1, 99999999)]);
        if ($req->qty < $product->min_order) return back()->with('error', "Minimal order $product->min_order");
        $material       = explode(',,', $req->atb1);
        $size           = $this->sizePrice($req, $material, $product);
        if (!$size && $product->category == 11) :
            return back()->with('error', 'Minimal order produk banner 1 M<sup>2</sup>');
        elseif (!$size && $product->mmt_fixed == 1) :
            return back()->with('error', 'Minimal order produk banner 0.3 M<sup>2</sup>');
        elseif (!$size && $product->category == 26) :
            return back()->with('error', 'Minimal order produk sticker custom 5x5CM atau 25CM<sup>2</sup>');
        elseif (!$size && $product->category == 21) :
            return back()->with('error', 'Panjang minimal 5 CM, Lebar Minimal 5 CM, Panjang Maksimal 240 CM, Lebar Maksimal 120CM');
        endif;
        $jenis_atb      = [$size['jenis_atb'], $material[0]];
        $nama_atb       = [$size['nama_atb'], $material[1]];
        $harga_atb      = [$size['harga_atb'], 0];
        $kode_bahan     = $this->erpCode($req, $material, $size['nama_atb'], $product);
        $data_atribut   = $this->customAttributes($req, $kode_bahan, $jenis_atb, $nama_atb, $harga_atb);
        $dimensi        = ['berat' => $product->weight * $req->qty];
        $link           = $req->link ?? 0;
        $design         = null;
        if ($req->hasFile('design_img')) :
            $upload_file = $this->designUpload($req);
            if (!$upload_file) :
                return back()->with('error', 'Harap upload 2 design atau kirim via link');
            endif;
            $design = ['design' => json_encode($upload_file)];
        elseif ($req->design_online) :
            $design = ['design_online' => 1];
        else :
            $design = ['link' => $link];
        endif;
        $cart   = array_merge($design, [
            'id_customer'   => Auth()->id() ?? session('user_id_temp'),
            'id_product'    => $req->id,
            'id_category'   => $product->category,
            'name'          => $product->name,
            'qty'           => $req->qty,
            'product_note'  => $req->note,
            'thumbnail'     => $product->thumbnail,
            'price'         => array_sum($data_atribut['harga_atb']),
            'satuan'        => $size['satuan'],
            'attributes'    => json_encode($data_atribut['atb']),
            'payment_code'  => json_encode($data_atribut['atbcode']),
            'dimensi'       => json_encode($dimensi),
        ]);
        $save_cart = Cart::create($cart);
        if ($req->design_online) :
            $size_name   = explode(',,', $req->atb0);
            $ukuran = $req->id . '-' . Str::slug($size_name[1], '-');
            return redirect()->route('design.online', ['product_id' => $req->id, 'ukuran' => $ukuran, 'cart_id' => $save_cart->id]);
        else :
            return redirect()->route('cart');
        endif;
    }

    public function sizePrice($post, $material, $product)
    {
        if ($product->category == 11 && $product->customize == 1) :
            $v_name     = "$post->panjang x $post->lebar";
            $ukuran     = $post->panjang * $post->lebar * $post->qty;
            if ($ukuran < 1) return false;
            return [
                "jenis_atb" => "Ukuran",
                "nama_atb"  => $v_name . " M",
                "harga_atb" => $this->materialPrice($material[5], $material[4], $ukuran)['total'],
                "satuan"    => $this->materialPrice($material[5], $material[4], $ukuran)['satuan'],
            ];
        elseif ($product->category == 26) :
            $v_name     = "$post->panjang x $post->lebar";
            $ukuran     = $post->panjang * $post->lebar * $post->qty;
            if ($ukuran < 25 || $post->panjang < 5 || $post->lebar < 5) return false;
            return [
                "jenis_atb"   => "Ukuran",
                "nama_atb"    => $v_name . " CM",
                "harga_atb"   => $this->materialPrice($material[5], $material[4], $ukuran)['total'],
                "satuan"   => $this->materialPrice($material[5], $material[4], $ukuran)['satuan'],
            ];
        elseif ($product->category == 21 && $product->customize == 1) :
            $v_name     = "$post->panjang x $post->lebar";
            $ukuran     = $post->panjang * $post->lebar * $post->qty;
            if ($post->panjang < 5 || $post->lebar < 5 || $post->panjang > 240 || $post->lebar > 120) return false;
            return [
                "jenis_atb" => "Ukuran",
                "nama_atb"  => $v_name . " CM",
                "harga_atb" => $this->materialPrice($material[5], $material[4], $ukuran)['total'],
                "satuan"    => $this->materialPrice($material[5], $material[4], $ukuran)['satuan'],
            ];
        elseif ($product->category == 11 && $product->customize != 1) :
            $size_name   = explode(',,', $post->atb0);
            $size   = explode('x', $size_name[1]);
            $width  = preg_replace('/[^0-9\/_|+.-]/', '', $size[0]);
            $length = preg_replace("/[^0-9\/_|+.-]/", '', $size[1]);
            $luas   = $width * $length;
            $luas   = $luas < 1 ? 1 : $luas;
            $harga  = $luas * $post->qty;
            return [
                "jenis_atb" => "Ukuran",
                "nama_atb"  => $size_name[1],
                "harga_atb" => $this->materialPrice($material[5], $material[4], $harga)['total'],
                "satuan"    => $this->materialPrice($material[5], $material[4], $harga)['satuan'],
            ];
        elseif ($product->category == 11 && $product->mmt_fixed == 1) :
            $size_name   = explode(',,', $post->atb0);
            if (isset($size_name[1]) && $size_name[1]) {
                $size   = explode('x', $size_name[1]);
                $width  = preg_replace('/[^0-9\/_|+.-]/', '', $size[0]);
                $length = preg_replace("/[^0-9\/_|+.-]/", '', $size[1]);
                $luas   = $width * $length * $post->qty;
            } else {
                $luas = $post->panjang * $post->lebar * $post->qty;
            }
            if ($luas < 0.3) {
                return false;
            }
            return [
                "jenis_atb" => "Ukuran",
                "nama_atb"  => $size_name[1],
                "harga_atb" => $this->materialPrice($material[5], $material[4], $luas)['total'],
                "satuan"    => $this->materialPrice($material[5], $material[4], $luas)['satuan'],
            ];
        else :
            $size       = explode(',,', $post->atb0);
            $v_name     = $size[1];
            $ukuran     = $size[2] * $post->qty;
            return [
                "jenis_atb" => $size[0],
                "nama_atb"  => $v_name,
                "harga_atb" => $this->materialPrice($material[5], $material[4], $ukuran)['total'],
                "satuan"    => $this->materialPrice($material[5], $material[4], $ukuran)['satuan'],
            ];
        endif;
    }

    public function materialPrice($price, $qty, $ukuran)
    {
        $material_range = json_decode($price);
        $material_qty   = json_decode($qty);
        $m_qty          = count($material_qty);
        for ($index = $m_qty; $index > 0; $index--) {
            if ($ukuran >= $material_qty[$index - 1]) :
                $material_price = $material_range[$index];
                break;
            else :
                $material_price = $material_range[0];
            endif;
        }
        return [
            'total'     => $ukuran * $material_price,
            'satuan'    => $material_price
        ];
    }

    public function customAttributes($req, $kode_bahan, $jenis_atb, $nama_atb, $harga_atb)
    {
        $atbcode        = array($kode_bahan);
        for ($x = 2; $x < $req->count; $x++) {
            $atb[$x]        = explode(',,', $req->input('atb' . $x));
            $qty            = $atb[$x][0] == "Isi" ? $req->qty_isi * $req->qty : $req->qty;
            $code           = array('code'  => $atb[$x][3], 'quantity' => $qty);
            $jenis_atb[$x]  = $atb[$x][0];
            $nama_atb[$x]   = $atb[$x][1];
            $atb_range      = json_decode($atb[$x][5]);
            $atb_qty        = json_decode($atb[$x][4]);
            $m_qty          = count($atb_qty);
            for ($index = $m_qty; $index > 0; $index--) {
                if ($qty >= $atb_qty[$index - 1]) :
                    $prices = $atb_range[$index];
                    break;
                else :
                    $prices = $atb_range[0];
                endif;
            }
            $harga_atb[$x]   = $prices * $qty;
            array_push($atbcode, $code);
        }
        $atb = [
            'jenis_atb' => $jenis_atb,
            'nama_atb'  => $nama_atb,
        ];

        return [
            'atb' => $atb,
            'atbcode' => $atbcode,
            'harga_atb' => $harga_atb
        ];
    }

    public function erpCode($post, $material, $v_name, $product)
    {
        $lebar      = $post->lebar;
        $panjang    = $post->panjang;
        $qty        = $post->qty;
        $note       = $post->note;
        if ($product->category == 11 && $product->customize == 1) :
            return array(
                'code'      => $material[3],
                'width'     => $lebar,
                'length'    => $panjang,
                'quantity'  => $qty,
                'note'      => $note,
            );
        elseif (in_array($product->category, [21, 26]) && $product->customize == 1) :
            return array(
                'code'      => $material[3],
                'width'     => 1,
                'length'    => 1,
                'quantity'  => $qty * $panjang * $lebar,
                'note'      => $note,
            );
        elseif ($product->category == 11 && $product->customize != 1) :
            $v_name = explode('x', $v_name);
            $width  = preg_replace('/[^0-9\/_|+.-]/', '', $v_name[0]);
            $length = preg_replace("/[^0-9\/_|+.-]/", '', $v_name[1]);
            $luas   = $width * $length;
            return array(
                'code'      => $material[3],
                'width'     => $luas < 1 ? 1 : $width,
                'length'    => $luas < 1 ? 1 : $length,
                'quantity'  => $qty,
                'note'      => $note,
            );
        elseif ($material[6] == "DPI" && $product->luas != 1) :
            $v_name = explode('x', $v_name);
            if (count($v_name) < 2) {
                echo '<b>app/Http/Controllers/ProductDetailController.php:254: SOMETHING WRONG</b><br>';
                echo('<pre>');
                print_r($v_name);
                echo('</pre>');
                die;
            }
            $width  = preg_replace('/[^0-9\/_|+.-]/', '', $v_name[0]);
            $length = preg_replace("/[^0-9\/_|+.-]/", '', $v_name[1]);
            $luas   = $width * $length;
            return array(
                'code'      => $material[3],
                'width'     => $luas < 1 ? 1 : $width,
                'length'    => $luas < 1 ? 1 : $length,
                'quantity'  => $qty,
                'note'      => $note,
            );
        elseif ($product->luas == 1) :
            return array(
                'code'      => $material[3],
                'width'     => 1,
                'length'    => 1,
                'quantity'  => $qty,
                'note'      => $note,
            );
        else :
            return array(
                'code'      => $material[3],
                'quantity'  => $qty,
                'note'      => $note,
            );
        endif;
    }

    public function designUpload($req)
    {
        $layout = $req->layout;
        if (count($layout) != count($req->design_img)) return false;
        $images = array();
        foreach ($req->design_img as $id => $image) :
            if ($image->isValid()) :
                $filename   = str_replace([" ", "/"], "-", Str::random(8) . "-" . $layout[$id] . "-" . $image->getClientOriginalName());
                $image->move(public_path('assets/images/design-upload'), $filename); // DO NOT CHANGE !!!
                array_push($images, $filename);
            endif;
        endforeach;

        return $images;
    }
}
