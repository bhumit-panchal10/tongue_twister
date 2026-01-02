@extends('layouts.front')
@section('content')

<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h3>My Account</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>My Account</li>
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
                                <li><a href="{{ route('myaccount') }}" class="nav-link active">Dashboard</a></li>
                                <li> <a href="{{ route('myorders') }}"  class="nav-link">Orders</a></li>
                                
                                <li><a href="{{ route('changepassword') }}"  class="nav-link">Change password</a></li>
                                <li><a href="{{route('logout')}}" class="nav-link">logout</a></li>
                            </ul>
                        </div>    
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade show active" id="account-details">
                                <h3>Account details </h3>
                                <div class="login">
                                    <div class="login_form_container">
                                        <div class="account_login_form">
                                            <form id="myForm" action="{{ route('myaccountedit') }}" method="post">
                                            @csrf
                                                <label>Name</label>
                                                    <input class="w-100" type="text" name="customername" id="customername"  placeholder="Enter Your Name" value="{{ Session::get('customername') ?? '' }}">
                                                @error('customername')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror<br>

                                                <label>Email</label>
                                                <input class="w-100" type="email" name="customeremail" id="customeremail" placeholder="Enter Your Email" value="{{ Session::get('customeremail') ?? '' }}">
                                                @error('customeremail')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror<br>

                                                <label>Phone</label>
                                                  <input class="w-100" type="text" name="customermobile" id="customermobile" maxlength="10" minlength="10" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" placeholder="Enter your Mobile number" value="{{Session::get('customermobile') ?? '' }}">
                                                  @error('customermobile')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror<br>
                                                <div class="save_button primary_btn default_button">
                                                   <button type="submit" class="button">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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