@extends('layouts.front')
@section('content')
<?php 

     $id=session()->get('customerid');
     $name=session()->get('customername');
?>

<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h3>My Order</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>My Order</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
                                       @include('common.frontalert')


    <!-- my account start  -->
    <section class="main_content_area">
        <div class="container">   
            <div class="account_dashboard">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <!-- Nav tabs -->
                        <div class="dashboard_tab_button">
                            <ul class="nav flex-column dashboard-list">
                                <li><a href="{{ route('myaccount') }}" class="nav-link ">Dashboard</a></li>
                                <li> <a href="{{ route('myorders') }}"  class="nav-link active">Orders</a></li>
                                
                                <li><a href="{{ route('changepassword') }}"  class="nav-link">Change password</a></li>
                                <li><a href="{{route('logout')}}" class="nav-link">logout</a></li>
                            </ul>
                        </div>    
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            
                            <div class=" " id="orders-detail">
                                <h3>Orders</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Order Date</th>
                                                <th>Product Name</th>
                                                <th>Product Image</th>
                                                <th>QTY</th>
                                                <th>Amount</th>	 	 	 	
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php $i = 1; $total=0; ?>
                                            @foreach ($Order as $order)
                                            
                                                <tr class="table_row">
                                                    <td style="min-width:100px">{{ $i }}</td>
                                                    <td>Ordered on {{ date('d-M-Y', strtotime($order->created_at)) }}</td>
                                                    <td><span class="success">{{ $order->productname }}</span>
                                                        <p>
                                                    @if($order->rcustomerId != $id)
                                                        <a href="" class="review-btn" data-bs-toggle="modal" data-bs-target="#review_{{ $order->productId }}">
                                                            Review  
                                                        </a>
                                                    @endif
                                                </p>
                                                    </td>
                                                    <td><img width="80" src="{{ asset('Product') . '/' . $order->photo }}" alt=""></td>
                                                    <td>{{ $order->quantity }}</td>
                                                    <td>Rs: {{ $order->amount }}</td>
                                                </tr>
                                                <?php $i++; 
                                                $total +=$order->amount;
                                                ?>

                                                      <div id="review_{{ $order->productId }}" class="modal fade" role="dialog">
                                                            <div class="modal-dialog">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                                                        <h4 class="modal-title" style="text-align-last: center">Add a review</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                   <form action="{{route('productreview')}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="productId" value="{{ $order->productId }}">
                                                                            <div class="product_ratting mb-10">
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                               <h3>Your rating</h3>
                                                                                <select name="iRate" id="iRate" class="nice-select">
                                                                                    <option value="">Select Star</option>
                                                                                    <option value="1">1 Star</option>
                                                                                    <option value="2">2 Star</option>
                                                                                    <option value="3">3 Star</option>
                                                                                    <option value="4">4 Star</option>
                                                                                    <option value="5">5 Star</option>
                                                                                   </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                            <div class="product_review_form">
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <label for="review_comment">Your review </label>
                                                                                        <textarea name="comment" id="review_comment" ></textarea>
                                                                                    </div> 
                                                                                      
                                                                                </div>
                                                                                <button type="submit">Submit</button>
                                                                            </div> 
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                            @endforeach
                                            <tr>
                                                <td colspan="5" class="text-right">Sub Total</td><td>₹ {{ $total }}</td></tr>
                                                <td colspan="5" class="text-right">Shipping</td><td>₹ {{ $Orderdata->shipping_Charges }}</td></tr>
                                                <td colspan="5" class="text-right">Discount (-)</td><td>₹ {{ $Orderdata->discount }}</td></tr>
                                                <td colspan="5" class="text-right">Total Amount</td><td>₹ {{ $Orderdata->netAmount }}</td></tr>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>  
        </div>        	
    </section>
      
			
    <!-- my account end   --> 
@endsection