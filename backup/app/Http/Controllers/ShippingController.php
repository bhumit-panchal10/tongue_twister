<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function index(Request $request)
    {
        $Shipping = Shipping::orderBy('id', 'desc')->get();
        return view('shipping.index', compact('Shipping'));
    }

    public function editview(Request $request, $id)
    {
        $data = Shipping::where(['id' => $id])->first();
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        $update = DB::table('shipping')
            ->where(['id' => $request->id])
            ->update([
                'rate' => $request->rate,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Shipping Updated Successfully.');
    }
}
