@extends('layouts.front')
@section('content')

<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h3>My Orders</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>My Orders</li>
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
                                <li><a href="{{ route('myaccount') }}" class="nav-link">Dashboard</a></li>
                                <li> <a href="{{ route('myorders') }}"  class="nav-link active">Orders</a></li>
                                
                                <li><a href="{{ route('changepassword') }}"  class="nav-link">Change password</a></li>
                                <li><a href="{{route('logout')}}" class="nav-link">logout</a></li>
                            </ul>
                        </div>    
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade show active" id="orders" >
                                <h3>Orders</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">No</th>
                                                <th style="width: 20%;">Order Id</th>
                                                <th style="width: 20%;">Order Date</th>
                                                <th style="width: 20%;">Total</th>
                                                <th style="width: 20%;">Action</th>	 	 	 	
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php $i = 1; ?>
                                            @foreach ($Order as $order)
                                            <tr>
                                                <td>{{ $i + $Order->perPage() * ($Order->currentPage() - 1) }}</td>
                                                
                                                <td>{{ 'Order' . '_' . $order->order_id }}</td>
                                                <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                                <td>₹{{ $order->amount }}</td>
                                                
                                                <td>
                                                    <a href="{{ route('myordersdetails', $order->order_id) }}">view</a>
                                                </td>
                                            </tr>
                                           <?php $i++; ?>
                                                        @endforeach
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