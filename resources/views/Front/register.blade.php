@extends('layouts.front')
@section('content')

<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h3>Register</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>Register</li>
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
            <div class="row  justify-content-between">
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="{{asset('assets/frontassets/img/log.png')}}" class="img-fluid" />
                </div>

               <!--register area start-->
               <div class="col-lg-6 col-md-6">
                <div class="account_form register">
                    <h2>Register</h2>
                    <form id="myForm" action="{{ route('registerstore') }}" method="post">
                         @csrf
                        <p>   
                            <label>Name <span style="color:red;">*</span></label>
                             <input type="text" name="customername" placeholder="Enter Your Name"  value="{{ old('customername') }}" required>
                            @error('customername')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                         </p>
                         <p>   
                            <label>Email <span style="color:red;">*</span></label>
                            <input type="email" name="customeremail" placeholder="Enter Your Email" value="{{ old('customeremail') }}" required>
                            @error('customeremail')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                         </p>
                         <p>   
                            <label>Phone <span style="color:red;">*</span></label>
                                <input type="text" name="customermobile" maxlength="10" minlength="10"  onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="{{ old('customermobile') }}" placeholder="Enter Your Mobile Number" required>
                                @error('customermobile')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                        </p>
                         <p>   
                            <label>Passwords <span style="color:red;">*</span></label>
                            <input type="password" name="password" placeholder="Enter your Password" id="password" required>             
                            @error('password')
                                 <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                    
                        </p>
                        <p>   
                            <label>Confirm Passwords <span style="color:red;">*</span></label>
                            <input type="password" name="confirmpassword" placeholder="Confirm Password" id="ccpassword" required>
                            @error('confirmpassword')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </p>
                       <!-- <label for="captcha">Please enter the CAPTCHA:</label>
                            <div>
                                <img src="{{ captcha_src() }}" alt="CAPTCHA Image" class="captcha-img">
                                <button type="button" onclick="refreshCaptcha()">Refresh</button>
                            </div>

                            <input type="text" name="captcha" required placeholder="Enter CAPTCHA"><br>   
                            @if ($errors->has('captcha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('captcha') }}</strong>
                                                </span>
                                            @endif-->
                        <div class="login_submit">
                            <button type="submit">Register</button>
                        </div>
                    </form>
                </div>    
            </div>
            <!--register area end-->

               
            </div>
        </div>    
    </div>
    <!-- customer login end -->
@endsection
@section('scripts')
<script type="text/javascript">
              function refreshCaptcha() {
        document.querySelector('.captcha-img').src = "{{ captcha_src() }}" + "?" + Math.random();
    }
    </script>
@endsection