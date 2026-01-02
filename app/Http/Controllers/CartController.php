<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductWeight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Mail;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        // dd($cartItems);
        return view('Front.cart', compact('cartItems'));
    }


    public function addToCart(Request $request)
    {
        // dd($request);
        if ($request->wishlist == 100) {
            \Cart::add([
                'id' => $request->productid,
                'categoryId' => $request->categoryId,
                'name' => $request->productname,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'weight' => $request->weight,
                'attributes' => array(
                    'image' => $request->image,
                )
            ]);

            DB::table('wishlist')->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $request->customerid, 'productid' => $request->productid])->delete();
        } else {
            \Cart::add([
                'id' => $request->productid,
                'categoryId' => $request->categoryId,
                'name' => $request->productname,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'weight' => $request->weight,
                'attributes' => array(
                    'image' => $request->image,
                )
            ]);
        }
        return back()->with('success', 'Product is Added to Cart Successfully !');

    }



    public function removeCart(Request $request)
    {
        // dd($request);
        \Cart::remove($request->id);
        return back()->with('success', 'Item Cart Remove Successfully !');

        // return redirect()->route('cart.list');
        return back();
    }

    public function clearAllCart()
    {
        \Cart::clear();

        return back()->with('success', 'All Item Cart Clear Successfully !');

        return back();
        // return redirect()->route('cart.list');
    }


    public function updateCart(Request $request)
    {
        // dd($request);
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        return back()->with('success', 'Item Cart is Updated Successfully !');

        return back();
        // return redirect()->route('cart.list');
    }
}
