@extends('layouts.front')
@section('title', $seo->metaTitle)
@section('opTag')

<meta name="description" content="{{ $seo->metaDescription }}" />
<meta name="keywords" content="{{ $seo->metaKeyword }}" />
<?php echo $seo->head; ?>
<?php echo $seo->body; ?>
@endsection

@section('content')

<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <h3>About Us</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>about us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
                                       @include('common.frontalert')

    <!--about section area -->
    <section class="about_section"> 
       <div class="container">
            <div class="row">
                <div class="col-12">
                            <h1>{{$data->Title}}</h1>
                            <p> {!! $data->Description !!} </p>
                           
                </div>    
            </div>  
        </div> 
    </section>
    <!--about section end-->
    

<!--testimonial area start-->
    <div class="faq-client-say-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="faq-client_title">
                        <h2>What can we do for you ?</h2>
                    </div>
                    <div class="faq-style-wrap" id="faq-five">

                        @foreach ($Faq as $faq)
                         <!-- Panel-default -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a class="collapsed" role="button" data-bs-toggle="collapse" href="#faq-collapse_{{$faq->faqid}}"
                                        aria-expanded="false" aria-controls="faq-collapse4"> <span
                                            class="button-faq"></span>{{ $faq->question }}</a>
                                </h5>
                            </div>
                            <div id="faq-collapse_{{$faq->faqid}}" class="collapse" role="tabpanel" data-parent="#faq-four">
                                <div class="panel-body">
                                    <p>{{ $faq->answer }}</p>

                                </div>
                            </div>
                        </div>
                        <!--// Panel-default -->
                        @endforeach
                        
                       
                    </div>

                </div>
                <div class="col-lg-6 col-md-6">
                    <!--testimonial area start-->
                    <div class="testimonial_area  testimonial_about">
                        <div class="section_title">
                            <h2>What Our Customers Says ?</h2>
                        </div>
                        <div class="testimonial_container">
                            <div class="testimonial_carousel testimonial-two owl-carousel">
                                @foreach ($Testimonial as $testimonial)
                                <div class="single_testimonial">
                                    <!-- <div class="testimonial_thumb">
                                        <a href="#"><img src="{{asset('assets/frontassets/img/about/testimonial1.png')}}" alt=""></a>
                                    </div> -->
                                    <div class="testimonial_content">
                                        <!-- <div class="testimonial_icon_img">
                                            <img src="{{asset('assets/frontassets/img/about/testimonials-icon.png')}}" alt="">
                                        </div> -->
                                        <p>{!! $testimonial->description !!}</p>
                                        <a href="#">– {{ $testimonial->name }}.

                                        </a>
                                    </div>
                                </div>
                               @endforeach
                            </div>
                        </div>
                    </div>
                    <!--testimonial area end-->
                </div>
            </div>
        </div>
    </div>
    <!--testimonial area end-->

@foreach ($Offers as $Offer)
 <?php
    $Today = date('Y-m-d');
    if (($Today >= $Offer->startdate) && ($Today <= $Offer->enddate)) { ?>
    <!--banner fullwidth area satrt-->
    <section class="banner_fullwidth">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="banner_full_content">
                        <p>Offer !</p>
                        <h5>Sale {{ $Offer->type }}% Off  On
                        <span>all products</span>
                        <span><p> Minimum Purchase of Rs. {{ $Offer->minvalue }}</p>
                                <p class="offer-txt">Use the Offer Code:-
                                <strong>{{ $Offer->offercode }}</strong>
                                </p>
                        </span>
                        <span>Offer Valid Till {{ date('d-m-Y', strtotime($Offer->enddate)) }}</span>
                    </h5>
                        <a href="{{ route('searchproduct') }}">discover now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
     <?php } ?>        
@endforeach
    <!--banner fullwidth area end-->
@endsection