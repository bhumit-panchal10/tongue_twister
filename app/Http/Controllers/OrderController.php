<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use Barryvdh\DomPDF\Facade\Pdf;
//use Barryvdh\DomPDF\Facade as PDF;


class OrderController extends Controller
{
    public function pending(Request $request)
    {
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

        $Pending = Order::
            select(
            'order.order_id',
            'order.customerid',
            'order.shipping_cutomerName',
            'order.shipping_email',
            'order.shipping_mobile',
            'order.shipping_city',
            'order.shiiping_state',
            'state.stateId',
            'state.stateName',
            'order.shipping_pincode',
            'order.netAmount',
            'order.iRazorpayStatus',
            'order.created_at',
            'order.isPayment',
            )
            ->orderBy('order_id', 'desc')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isPayment' => 0,'iRazorpayStatus'=>1])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
                ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
                ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
            ->join('state', 'order.shiiping_state', '=', 'state.stateId')    
            ->paginate(env('PER_PAGE_COUNT'));

        return view('order.pending', compact('Pending', 'FromDate', 'ToDate', 'Courier'));
    }
    
    public function paymentpendingOrder(Request $request)
    {
        // dd($request);
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;

        $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

        $Pending = Order::
            select(
            'order.order_id',
            'order.customerid',
            'order.shipping_cutomerName',
            'order.shipping_email',
            'order.shipping_mobile',
            'order.shipping_city',
            'order.shiiping_state',
            'state.stateId',
            'state.stateName',
            'order.shipping_pincode',
            'order.netAmount',
            'order.iRazorpayStatus',
            'order.created_at',
            'order.isPayment',
            )
            ->orderBy('order_id', 'desc')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isPayment' => 0,'iRazorpayStatus'=>0])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
                ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
                ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
            ->join('state', 'order.shiiping_state', '=', 'state.stateId')
            ->paginate(env('PER_PAGE_COUNT'));

        return view('order.paymentPendingOrder', compact('Pending', 'FromDate', 'ToDate', 'Courier'));
    }

    public function dispatched(Request $request)
    {
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;

        $Dispatched = Order::select(
            'order.order_id',
            'order.customerid',
            'order.shipping_cutomerName',
            'order.shipping_email',
            'order.shipping_mobile',
            'order.shipping_city',
            'order.shiiping_state',
            'state.stateId',
            'state.stateName',
            'order.shipping_pincode',
            'order.netAmount',
            'order.iRazorpayStatus',
            'order.created_at',
            'order.isPayment',
            'order.courier',
            'courier.name',
            'order.docketNo',
            )
            ->orderBy('order_id', 'desc')
            ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isPayment' => 1,'order.iRazorpayStatus' => 1])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
                ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
                ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
            ->join('courier', 'order.courier', '=', 'courier.id')
            ->join('state', 'order.shiiping_state', '=', 'state.stateId')    
            ->paginate(env('PER_PAGE_COUNT'));
        //dd($Dispatched);

        return view('order.dispatched', compact('Dispatched', 'FromDate', 'ToDate'));
    }

    public function cancel(Request $request)
    {
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;

        $Cancel = Order::orderBy('order_id', 'desc')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isPayment' => 2])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
                ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
                ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->join('state', 'order.shiiping_state', '=', 'state.stateId')    
            ->paginate(env('PER_PAGE_COUNT'));

        return view('order.cancel', compact('Cancel', 'FromDate', 'ToDate'));
    }

    public function statustocancel(Request $request, $id)
    {
        $status = DB::table('order')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
            ->update([
                'isPayment' => 2,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        return redirect()->route('order.cancel')->with('success', 'Status Updated Successfully.');
    }

    public function statustodispatched(Request $request)
    {
        //dd($request);
        $status = DB::table('order')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $request->order_id])
            ->update([
                'courier' => $request->courier,
                'docketNo' => $request->docketNo,
                'isPayment' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
             $courierName=Courier::where(['id'=>$request->courier])->first();
            $Order = Order::select('order.*',DB::raw('(select state.stateName from state where order.shiiping_state=state.stateid limit 1) as state'))->where("order_id",$request->order_id)->first();
            $SendEmailDetails = DB::table('sendemaildetails')
                ->where(['id' => 9])
                ->first();

            $root = $_SERVER['DOCUMENT_ROOT'];
            $file = file_get_contents($root . '/mailers/dispatch.html', 'r');

            $file = str_replace('#name', $Order['shipping_cutomerName'], $file);
            $file = str_replace('#orderid', $Order['order_id'], $file);
            $file = str_replace('#courierName', $courierName->name, $file);
            $file = str_replace('#docketNo', $request->docketNo, $file);
            $file = str_replace('#tracking', $courierName->tracking_url, $file);

                        $html = "";

            $file = str_replace('#tableProductTr', $html, $file);

            // dd($file);
            $setting = DB::table("setting")->select('email')->first();
            $toMail = $setting->email;
            
            $to = $toMail;
            $subject = "Dispatched Order";
            // dd($subject);
            $message = $file;
            // dd($message);
            $header = "From:".$SendEmailDetails->strFromMail."\r\n";
            //$header .= "Cc:afgh@somedomain.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            
            $retval = mail($to,$subject,$message,$header);
            
            
            $to1 = $Order['shipping_email'];
            $subject1 = "Dispatched Order";
            $message1 = $file;
            $header = "From:".$SendEmailDetails->strFromMail."\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            
            $retval = mail($to1,$subject1,$message1,$header);
            
        return redirect()->route('order.dispatched')->with('success', 'Status Updated Successfully.');
    }

    public function statustopending(Request $request, $id)
    {
        $status = DB::table('order')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
            ->update([
                'isPayment' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        return redirect()->route('order.pending')->with('success', 'Status Updated Successfully.');
    }

    public function orderdetail(Request $request, $id)
    {
        $Shipping = Shipping::select('rate as shippingcharge')->orderBy('id', 'desc')->first();
        $data = Order::select('order.*','state.stateName')->orderBy('order_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
            ->join('state', 'state.stateId', '=', 'order.shiiping_state')->first();
        // dd($data);
        $detail = OrderDetail::select(
            'order.cutomerName',
            'order.mobile',
            'order.email',
            'order.address',
            'order.state',
            'order.city',
            'order.shipping_cutomerName',
            'order.shipping_mobile',
            'order.shipping_email',
            'order.shiiping_address1',
            'order.shiiping_address2',
            'order.shiiping_state',
            'order.shipping_city',
            'order.shipping_pincode',
            'order.amount as totalamount',
            'order.pincode',
            'orderdetail.quantity',
            'orderdetail.rate',
            'orderdetail.amount',
            'orderdetail.weight',
            'product.productname',
            // 'product.photo',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
        )
            ->orderBy('orderDetailId', 'DESC')
            ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $data->order_id])
            ->join('order', 'orderdetail.orderID', '=', 'order.order_id')
            ->join('product', 'orderdetail.productId', '=', 'product.productId')
            ->get();
        //dd($detail);

        return  view('order.productdetail', compact('data', 'detail', 'id', 'Shipping'));
    }

    public function DetailPDF(Request $request, $id)
    {
        // dd($id);
        $Shipping = Shipping::select('rate as shippingcharge')->orderBy('id', 'desc')->first();
        //dd($Shipping);
        $data = Order::select('order.*','state.stateName',
            'courier.id',
            'courier.name as couriername',
        )->orderBy('order_id', 'DESC')
            ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.order_id' => $id])
            ->join('state', 'state.stateId', '=', 'order.shiiping_state')
            ->leftjoin('courier', 'order.courier', '=', 'courier.id')
            ->first();
        // dd($data);
        $detail = OrderDetail::select(
            'order.order_id',
            'order.cutomerName',
            'order.shipping_cutomerName',
            'order.mobile',
            'order.shipping_mobile',
            'order.email',
            'order.shipping_email',
            'order.address',
            'order.shiiping_address1',
            'order.shiiping_address2',
            'order.state',
            'order.shiiping_state',
            'order.city',
            'order.shipping_city',
            'order.pincode',
            'order.shipping_pincode',
            'order.docketNo',
            'order.discount',
            'order.netAmount',
            'order.courier',
            'order.amount as totalamount',
            'orderdetail.orderID',
            'orderdetail.quantity',
            'orderdetail.rate',
            'orderdetail.amount',
            'orderdetail.weight',
            'product.productname',
            'courier.id',
            'courier.name as couriername',
            )
            ->orderBy('orderDetailId', 'DESC')
            ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $data->order_id])
            ->join('order', 'orderdetail.orderID', '=', 'order.order_id')
            ->join('product', 'orderdetail.productId', '=', 'product.productId')
            ->leftjoin('courier', 'order.courier', '=', 'courier.id')
            ->get();
        // dd($detail);

        // $pdf = PDF::loadView('order.invoice', ['data' => $data]);
        $pdf = PDF::loadView('order.invoice', ['data' => $data, 'detail' => $detail, 'Shipping' => $Shipping]);
        //dd($pdf);
        // $pdf = PDF::loadView('order.invoice');
        // $pdf(array(
        //     'orientation' => 'landscape'
        // ));
        return $pdf->stream('Report.pdf');
        // return $pdf->download('Report.pdf');

        Route::get(
            "/admin/order/pdf/ .'$id'.",
            function () {
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadHTML('<h1>Test</h1>');
                return $pdf->download('invoice.pdf');
            }
        );
    }
    
     public function DispatchPDF(Request $request, $id)
    {
        try {
            $data = Order::orderBy('order_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
                ->join('state', 'order.shiiping_state', '=', 'state.stateId')
                ->first();
            // dd($data);

            $pdf = PDF::loadView('order.DispatchPDF', ['data' => $data]);
            return $pdf->stream('Dispatch.pdf');

            Route::get(
                "/admin/dispatch/pdf/ .'$id'.",
                function () {
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML('<h1>Test</h1>');
                    return $pdf->download('Dispatch.pdf');
                }
            );
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
     public function validatedocketno(Request $request)
    {
        try{
        $data = Order::where(['iStatus' => 1, 'isDelete' => 0,'courier'=>$request->courier, 'docketNo' => $request->docketno])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
        } catch (\Exception $e) {

        report($e);
 
        return false;
    }
    }
    public function successOrder(Request $request,$id)
    {
        $status = DB::table('order')
                    ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
                    ->update([
                        'iRazorpayStatus' => 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    
        $status = DB::table('card_payment')
                    ->where(['oid' => $id])
                    ->update([
                        'status' => 'Success',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
        return redirect()->back()->with('success', 'Payment status updated to success');

    }

}
