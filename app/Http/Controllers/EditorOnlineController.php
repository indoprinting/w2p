<?php

namespace App\Http\Controllers;

use App\Models\EditorOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EditorOnlineController extends Controller
{
    public function index(Request $request)
    {
        $title      = "Design Online Indoprinting";
        $design     = EditorOnline::where('id', $request->id_design)->first();
        return view('editor.index_editor', compact('title', 'design'));
    }

    public function getDesign(Request $request)
    {
        $product_id = $request->product_id;
        $get        = DB::table('idp_design')->where('product_id', $product_id)->get();
        $design     = [];
        if ($get) :
            foreach ($get as $get) :
                array_push($design, [
                    'product'   => json_decode($get->design, true),
                    'thumbnail' => $get->thumbnail,
                    'title'     => $get->title,
                    'id'        => $get->id
                ]);
            endforeach;
            echo json_encode($design);
        else :
            echo false;
        endif;
    }

    public function destroy(Request $request)
    {
        $id         = $request->id_design;
        $destroy    = DB::table('idp_design')->where('id', $id)->delete();
        echo $destroy ? true : false;
    }
}
