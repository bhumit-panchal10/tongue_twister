<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function paymentReport(Request $request)
    {
        // dd($request);
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;

        $Dispatched = Order::select(
            'order.created_at',
            'order.shipping_cutomerName',
            'order.shipping_email',
            'order.shipping_mobile',
            'order.shipping_city',
            'order.shipping_pincode',
            'order.netAmount',
            'order.isPayment',
            'courier.name',
            'state.stateName',
            'order.docketNo',
            'order.isPayment'
            
            )
            ->orderBy('order_id', 'desc')
            ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isPayment' => 1])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
                ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
                ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
            ->leftjoin('courier', 'order.courier', '=', 'courier.id')
            ->join('state', 'order.shiiping_state', '=', 'state.stateId')    
            ->paginate(15);
        //dd($Dispatched);

        return view('report.paymentReport', compact('Dispatched', 'FromDate', 'ToDate'));
    }

    public function orderTracking(Request $request)
    {
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $Mobile = $request->mobile;

        $Dispatched = Order::orderBy('order_id', 'desc')
            ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isPayment' => 1])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
                ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
                ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
            ->when($request->mobile, fn ($query, $Mobile) => $query
                ->where('order.shipping_mobile', '=', $Mobile))
            ->join('courier', 'order.courier', '=', 'courier.id')
            ->join('state', 'order.shiiping_state', '=', 'state.stateId')    
            ->paginate(15);
        //dd($Dispatched);

        return view('report.orderTracking', compact('Dispatched', 'FromDate', 'ToDate'));
        
    }
    
}
