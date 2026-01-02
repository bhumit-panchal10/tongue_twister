@extends('layouts.front')

@section('opTag')
@section('title', $seo->metaTitle)
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
                        <h3>Shipping and Delivery</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>shipping and delivery</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
      @include('common.frontalert')

    
    <!--about section area -->
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
    <!--about section end-->

@endsection