@extends('layouts.front')
@section('title', 'Thank You')

@section('content')
    <style>
        

  .bg-black{
        background-color: black;
    }

    .tx-txt{
        color: black;
    font-size: 42px;
    font-weight: 600;
    text-transform: uppercase;
    margin: 15px 0px 10px 0px;
    }
    </style>
 <!--breadcrumbs area start-->
<div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <h3>Thank You</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>Thank You</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->



		

<section class="text-center pt-5 pb-5">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-12">
                <h1 class="tx-txt">Thank you</h1>
    <p>Thank you for ontacting us , we will respond you soon.thanks for giving us your valuable time.</p>

    <a href="{{ route('FrontIndex') }}" class="save_button"><button class="">
        Go Back
     </button></a>
            </div>
            <!--<div class="col-lg-4">-->
            <!--    <img src="assets/frontimages/thank_you.png" class="img-fluid" />-->
            <!--</div>-->
        </div>
    </div>
    

</section>
@endsection
