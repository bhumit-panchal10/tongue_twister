@extends('layouts.front')
@section('content')

<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h3>Login</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>Login</li>
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
                 <div class="col-lg-5 d-none d-lg-block">
                    <img src="{{asset('assets/frontassets/img/login-img.png')}}" class="img-fluid" />
                </div>
               <!--login area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form">
                        <h2>login</h2>
                         <form method="POST" id="myForm" action="{{ route('FrontLoginStore') }}">
                                        @csrf
                            <p>   
                                <label>Email <span style="color:red">*</span></label>
                                <input type="email" name="customeremail" placeholder="Email" required>
                                @error('customeremail')
                                     <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                             </p>
                             <p>   
                                <label>Passwords <span style="color:red">*</span></label>
                                <input type="password" name="password" placeholder="Enter your Password" id="password" required>
                                  @error('password')
                                        <strong class="text-danger">{{ $message }}</strong>
                                  @enderror

                             </p>   
                            <div class="login_submit">
                               <a href="{{ route('forgotpassword') }}">Lost your password?</a>
                                <!-- <label for="remember">
                                    <input id="remember" type="checkbox">
                                    Remember me
                                </label> -->
                                <button type="submit">login</button>
                                
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