@extends('layouts.front')
@section('content')

<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h3>FORGOT PASSWORD</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>FORGOT PASSWORD</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
                                       @include('common.frontalert')

<!-- customer login start -->
<div class="customer_login">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <img src="{{asset('assets/frontassets/img/forgotpassword.png')}}" class="img-fluid" />
                </div>
               <!--login area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form">
                        <h2>FORGOT PASSWORD</h2>
                            <form action="{{ route('forgotpasswordsubmit') }}" method="post">
                                @csrf
                            <p>   
                                <label>Email <span style="color:red">*</span></label>
                                <input type="email" name="customeremail" placeholder="Enter Your Email" required>
                             </p>
                            <div class="login_submit">
                                <button type="submit">submit</button>
                                
                            </div>

                        </form>
                     </div>    
                </div>
                <!--login area start-->

               
            </div>
        </div>    
    </div>
    <!-- customer login end -->
@endsection