<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Banner;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $Product = Product::orderBy('productId', 'desc')->get();
        $datas = Banner::orderBy('banner.bannerId', 'desc')
            ->where(['banner.iStatus' => 1, 'banner.isDelete' => 0])
            ->leftjoin('product', 'banner.iProductId', '=', 'product.productId')
            ->paginate(env('PER_PAGE_COUNT'));
        // dd($Event);

        return view('banner.index', compact('Product', 'datas'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'strPhoto' => 'required',
        ]);


        $img = "";
        if ($request->hasFile('strPhoto')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('strPhoto');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/Banner/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }

        $update = Banner::create([
            'iProductId' => $request->iProductId ?? 0,
            'strPhoto' => $img,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        ]);

        return back()->with('success', 'Banner Uploaded Successfully.');
    }

    public function delete(Request $request)
    {
        $delete = DB::table('banner')->where(['iStatus' => 1, 'isDelete' => 0, 'bannerId' => $request->bannerId])->first();
        
        $root = $_SERVER['DOCUMENT_ROOT'];
        $destinationpath = $root . '/Banner/';
        if ($delete->strPhoto) {
            unlink($destinationpath  . $delete->strPhoto);
        }
            
        Banner::where(['iStatus' => 1, 'isDelete' => 0, 'bannerId' => $request->bannerId])->delete();

        return back()->with('success', 'Banner Deleted Successfully!.');
    }
}
