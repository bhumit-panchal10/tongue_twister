@extends('layouts.front')
@section('content')

<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h3>NEW PASSWORD</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>NEW PASSWORD</li>
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
                    <img src="{{asset('assets/frontassets/img/reset-password.png')}}" class="img-fluid" />
                </div>
               <!--login area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form">
                        <h2>NEW PASSWORD</h2>
                            <form id="myForm" action="{{ route('newpasswordsubmit') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                            <p>   
                                <label>Password <span style="color:red">*</span></label>
                                <span class="lnr lnr-lock ps2-cion-cpass"></span>

                                <input type="password" name="newpassword" id="newpassword" placeholder="Enter your Password" id="sfpassword" required>
                             </p>
                             <p>   
                                <label>Confirm Password <span style="color:red">*</span></label>
                                                                            <span class="lnr lnr-lock pscn2-cion-cpass2"></span>

                                <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Enter your Password" id="ccpassword" required>
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
@section('scripts')

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

 <script>
        $(document).ready(function() {
            $("#myForm").validate({
                rules: {
                    newpassword: {
                        required: true,
                        minlength: 5
                    },
                    confirmpassword: {
                        required: true,
                        equalTo: "#newpassword"
                    }
                },
                messages: {
                    newpassword: {
                        required: "Password is required",
                        minlength: "Password must be at least 5 characters",
                    },
                    confirmpassword: {
                        required: "Confirm password is required",
                        equalTo: "Password and confirm password should same",
                    },
                }
            });
        });
    </script>
@endsection
