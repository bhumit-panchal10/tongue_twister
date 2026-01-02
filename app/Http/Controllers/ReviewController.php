<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $review = Review::select('review.*',DB::raw('(SELECT productname FROM product WHERE  product.productId=review.product_id  LIMIT 1) as productName'))->orderBy('id', 'desc')->get();
        return view('review.index', compact('review'));
    }

    public function editview(Request $request, $id)
    {
        $data = Review::where(['id' => $id])->first();
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        $update = DB::table('review')
            ->where(['id' => $request->id])
            ->update([
                'status' => $request->review_status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Review Status Updated Successfully.');
    }
}
