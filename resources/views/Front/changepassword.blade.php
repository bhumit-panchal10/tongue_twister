@extends('layouts.front')
@section('content')

<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h1>Change password</h1>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>Change password</li>
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
                                <li> <a href="{{ route('myorders') }}"  class="nav-link">Orders</a></li>
                                
                                <li><a href="{{ route('changepassword') }}"  class="nav-link active">Change password</a></li>
                                <li><a href="{{route('logout')}}" class="nav-link">logout</a></li>
                            </ul>
                        </div>    
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade show active" id="account-details">
                                <h3>Change password </h3>
                                <div class="login">
                                    <div class="login_form_container">
                                        <div class="account_login_form">
                                            <form action="{{ route('changepasswordsubmit') }}" method="post">
                              			  @csrf
                                                <label>Password <span style="color:red">*</span></label>
										<input class="w-100" type="password" name="newpassword" id="newpassword" placeholder="New Password" required>                                               
										 @error('newpassword')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                   @enderror<br>

                                                <label>Confirm Password <span style="color:red">*</span></label>
                                                <input class="w-100" type="password" name="confirmpassword" id="confirmpassword" placeholder="confirm New Password" required>
                                                @error('confirmpassword')
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