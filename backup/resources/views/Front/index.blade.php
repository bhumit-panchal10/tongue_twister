@extends('layouts.front')
@section('content')
<style>
.action_links ul li button {
        font-size: 16px;
        display: inline-block;
        width: 33px;
        height: 33px;
        line-height: 36px;
        text-align: center;
        background: #fff;
        border-radius: 50%;
        border: none;
    }
.action_links ul li button:hover {
        background: #b80000;
        color: #fff;
    }
</style>
    <!--slider area start-->
    <section class="slider_section">
        <div class="slider_area owl-carousel">
            @foreach($Banner as $b)
            <div class="single_slider d-flex align-items-center" data-bgimg="{{ asset('/Banner/').'/'.$b->strPhoto }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="slider_content">
                                <h1>Mukhwas Big Sale</h1>
                                <h2>Fresh Products</h2>
                                <p>
                                    100% certified organic mix .
                                </p>
                                @if ($b->iProductId == '' || $b->iProductId == 0 || $b->iProductId == null)
                                <a href="{{ route('FrontProduct') }}">Shop Now </a>
                                @else
                                <a href="{{ route('productdetail', [$b->categoryslug, $b->slugname]) }}">Shop Now </a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <!--slider area end-->

    <!--shipping area start-->
    <section class="shipping_area py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="single_shipping">
                        <div class="shipping_icone">
                            <img src="{{asset('assets/frontassets/img/about/shipping9.jpg')}}" alt="">
                        </div>
                        <div class="shipping_content">
                            <h3>Free Shipping</h3>
                            <p>Free shipping on all US order or order above $200</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single_shipping col_2">
                        <div class="shipping_icone">
                            <img src="{{asset('assets/frontassets/img/about/shipping10.jpg')}}" alt="">
                        </div>
                        <div class="shipping_content">
                            <h3>Support 24/7</h3>
                            <p>Contact us 24 hours a day, 7 days a week</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single_shipping col_3">
                        <div class="shipping_icone">
                            <img src="{{asset('assets/frontassets/img/about/shipping11.jpg')}}" alt="">
                        </div>
                        <div class="shipping_content">
                            <h3>30 Days Return</h3>
                            <p>Simply return it within 30 days for an exchange</p>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single_shipping col_4">
                        <div class="shipping_icone">
                            <img src="{{asset('assets/frontassets/img/about/shipping12.jpg')}}" alt="">
                        </div>
                        <div class="shipping_content">
                            <h3>100% Payment Secure</h3>
                            <p>We ensure secure payment with PEV</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--shipping area end-->

                                         @include('common.frontalert')

    <!--product area start-->
    <section class="product_area product_area-1  mb-64">
        <div class="container">
            @if($tranding != 0)
            <div class="row">
                <div class="col-12">
                    <div class="product_header">
                        <div class="section_title">
                            <p>Shop By Category</p>
                            <h2>Trending Products</h2>
                        </div>
                        <div class="product_tab_btn">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="product_container">
                <div class="row">
                    <div class="col-12">
                    
                        <div class="tab-content">
                             <?php

                                $Productdata = App\Models\Product::select('product.*',DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                                 DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'))->where(['product.iStatus' => 1, 'product.isDelete' => 0,'isFeatures'=>1])
                                        ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                                        //->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                                        ->orderBy('productname', 'asc')
                                        ->get();

                              ?>

                            <div class="tab-pane fade active show"  role="tabpanel">
                                <div class="product_carousel row">
                                    @if(sizeof($Productdata) != 0)
                            @foreach ($Productdata as $product)
                            
                                    <div class="product_items col-lg-3">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}">
                                                        <img src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                                    <a class="secondary_img" href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}">
                                                        <img src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                                    <div class="label_product">
                                                        <!-- <span class="label_sale">Sale</span> -->
                                                        <span class="label_new">New</span>
                                                    </div>
                                                    <div class="action_links">
                                                        <ul>
                                                            <?php if($product->isStock == 1){ ?>
                                                            <form action="{{ route('cart.store') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" value="1" name="quantity">
                                                                <input type="hidden" value="{{ $product->categoryId }}" name="categoryId">
                                                                <input type="hidden" value="{{ $product->productId }}" name="productid">
                                                                <input type="hidden" value="{{ $product->productname }}" name="productname">
                                                                <input type="hidden" value="{{ $product->rate }}" name="price">
                                                                <input type="hidden" value="{{ $product->photo }}" name="image">
                                                                <input type="hidden" value="{{ $product->weight }}" name="weight">
                                                                <li class="add_to_cart"><button href="cart#" data-tippy="Add to cart"
                                                                            data-tippy-placement="top" data-tippy-arrow="true"
                                                                            data-tippy-inertia="true"> <span class="lnr lnr-cart"></span></button>
                                                                </li>
                                                            </form>
                                                            <?php } ?>

                                                                    <li class="quick_button"><a href="#" data-tippy="quick view" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-bs-toggle="modal" data-bs-target="#modal_product_{{$product->productId}}"> <span  class="lnr lnr-magnifier"></span></a></li>
                                                                
                                                        </ul>
                                                    </div>
                                                </div>
                                                <figcaption class="product_content">
                                                    <h4 class="product_name"><a href="product-details#">{{$product->productname}}</a></h4>
                                                    <p><a href="#">{{$product->weight}}</a></p>
                                                    <div class="price_box">
                                                        <span class="current_price">&#8377; {{$product->rate}}</span>
                                                        <!-- <span class="old_price">&#8377; 62.00</span> -->
                                                    </div>
                                                </figcaption>
                                            </figure>
                                        </article>

                                    </div>
                                    <!----quick view of product start  ---->
                    <div class="modal fade" id="modal_product_{{$product->productId}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="icon-x"></i></span>
                                </button>
                                <div class="modal_body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-12">
                                                <div class="modal_tab">
                                                    <div class="tab-content product-details-large">
                                                        <div class="tab-pane fade active show" id="tab1" role="tabpanel">
                                                            <div class="modal_tab_img">
                                                                <a href="#"><img src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal_tab_button">
                                                            <ul class="nav product_navactive owl-carousel" role="tablist">
                                                            <li>
                                                                <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab"
                                                                    aria-controls="tab1" aria-selected="false"><img
                                                                        src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-12">
                                                <div class="modal_right">
                                                    <div class="modal_title mb-10">
                                                        <h2>{{ $product->productname }}</h2>
                                                    </div>
                                                    <div class="modal_price mb-10">
                                                        <span class="new_price">&#8377;{{ $product->rate }}</span>
                                                        <!-- <span class="old_price">&#8377;78.99</span> -->
                                                    </div>
                                                    <div class="modal_description mb-15">
                                                        <p>{!! $product->description !!} </p>
                                                    </div>
                                                    <div class="variants_selects">
                                                        <div class="modal_add_to_cart">

                                                             <?php if($product->isStock == 1){ ?>
                                                            <form action="{{ route('cart.store') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input min="1" max="100" step="1" value="1" type="number" name="quantity">

                                                                <!-- <input type="hidden" value="1" name="quantity"> -->
                                                                <input type="hidden" value="{{ $product->categoryId }}" name="categoryId">
                                                                <input type="hidden" value="{{ $product->productId }}" name="productid">
                                                                <input type="hidden" value="{{ $product->productname }}" name="productname">
                                                                <input type="hidden" value="{{ $product->rate }}" name="price">
                                                                <input type="hidden" value="{{ $product->photo }}" name="image">
                                                                <input type="hidden" value="{{ $product->weight }}" name="weight">
                                                                <button type="submit">add to cart</button>

                                                                </li>
                                                            </form>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <!--<div class="modal_social">
                                                        <h2>Share this product</h2>
                                                        <ul>
                                                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a>
                                                            </li>
                                                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                                        </ul>
                                                    </div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            @endforeach
                            @else
                                <div class="product_items col-lg-12">
                                    <article class="single_product">
                                        <figure>
                                            <div class="">
                                            <h4  class="product_name text-center">No Product data found</h4>
                                        </figure>
                                    </article>
                                </div>
                            @endif
                            </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    <!--product area end-->

    <!--banner area start-->
    <section class="banner_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="single_banner">
                        <div class="banner_thumb">
                            <a href="shop#"><img src="{{asset('assets/frontassets/img/bg/banner1.jpg')}}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="single_banner">
                        <div class="banner_thumb">
                            <a href="shop#"><img src="{{asset('assets/frontassets/img/bg/banner2.jpg')}}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--banner area end-->


    <!--product area start-->
    <section class="product_area  mb-64">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_header">
                        <div class="section_title">
                            <p>Shop with us</p>
                            <h2>Our Products</h2>
                        </div>

                    </div>
                </div>
            </div>
            <div class="product_container">
                <div class="row">

            @foreach ($Product as $product)
                    <div class="product_items col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}">
                                        <img  src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                    <a class="secondary_img" href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}">
                                        <img  src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
<!--                                     <div class="label_product">
                                        <span class="label_new">New</span>
                                    </div> -->
                                    <div class="action_links">
                                        <ul>
                                    <?php if($product->isStock == 1){ ?>
                                    <form action="{{ route('cart.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="1" name="quantity">
                                        <input type="hidden" value="{{ $product->categoryId }}" name="categoryId">
                                        <input type="hidden" value="{{ $product->productId }}" name="productid">
                                        <input type="hidden" value="{{ $product->productname }}" name="productname">
                                        <input type="hidden" value="{{ $product->rate }}" name="price">
                                        <input type="hidden" value="{{ $product->photo }}" name="image">
                                        <input type="hidden" value="{{ $product->weight }}" name="weight">
                                        <li class="add_to_cart"><button href="cart#" data-tippy="Add to cart"
                                                    data-tippy-placement="top" data-tippy-arrow="true"
                                                    data-tippy-inertia="true"> <span class="lnr lnr-cart"></span></button>
                                        </li>
                                    </form>
                                    <?php } ?>

                                            <li class="quick_button"><a href="#" data-tippy="quick view" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-bs-toggle="modal" data-bs-target="#modal_box_{{$product->productId}}"> <span  class="lnr lnr-magnifier"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <figcaption class="product_content">
                                    <h4 class="product_name"><a href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}">{{ $product->productname }}</a></h4>
                                    <p><a href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}">{{ $product->weight }}</a></p>
                                    <div class="price_box">
                                        <span class="current_price">&#8377; {{ $product->rate }}</span>
                                        <!-- <span class="old_price">&#8377; 62.00</span> -->
                                    </div>
                                </figcaption>
                            </figure>
                        </article>
                    </div>

                    <!----quick view of product start  ---->
                    <div class="modal fade" id="modal_box_{{$product->productId}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="icon-x"></i></span>
                                </button>
                                <div class="modal_body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-12">
                                                <div class="modal_tab">
                                                    <div class="tab-content product-details-large">
                                                        <div class="tab-pane fade active show" id="tab1" role="tabpanel">
                                                            <div class="modal_tab_img">
                                                                <a href="#"><img src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal_tab_button">
                                                            <ul class="nav product_navactive owl-carousel" role="tablist">
                                                            <li>
                                                                <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab"
                                                                    aria-controls="tab1" aria-selected="false"><img
                                                                        src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-12">
                                                <div class="modal_right">
                                                    <div class="modal_title mb-10">
                                                        <h2>{{ $product->productname }}</h2>
                                                    </div>
                                                    <div class="modal_price mb-10">
                                                        <span class="new_price">&#8377;{{ $product->rate }}</span>
                                                        <!-- <span class="old_price">&#8377;78.99</span> -->
                                                    </div>
                                                    <div class="modal_description mb-15">
                                                        <p>{!! $product->description !!} </p>
                                                    </div>
                                                    <div class="variants_selects">
                                                        <div class="modal_add_to_cart">

                                                             <?php if($product->isStock == 1){ ?>
                                                            <form action="{{ route('cart.store') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input min="1" max="100" step="1" value="1" type="number" name="quantity">

                                                                <!-- <input type="hidden" value="1" name="quantity"> -->
                                                                <input type="hidden" value="{{ $product->categoryId }}" name="categoryId">
                                                                <input type="hidden" value="{{ $product->productId }}" name="productid">
                                                                <input type="hidden" value="{{ $product->productname }}" name="productname">
                                                                <input type="hidden" value="{{ $product->rate }}" name="price">
                                                                <input type="hidden" value="{{ $product->photo }}" name="image">
                                                                <input type="hidden" value="{{ $product->weight }}" name="weight">
                                                                <button type="submit">add to cart</button>

                                                                </li>
                                                            </form>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal_social">
                                                        <h2>Share this product</h2>
                                                        <ul>
                                                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a>
                                                            </li>
                                                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----quick view of product end  ---->

                   @endforeach

                </div>
            </div>
        </div>
    </section>
    <!--product area end-->

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
                            <div id="faq-collapse_{{$faq->faqid}}" class="collapse" role="tabpanel" data-parent="#faq-five">
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

    <!--banner fullwidth area satrt-->
   
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
                        <h3>Sale {{ $Offer->type }}% Off  On
                        <span>all products</span>
                        <span><p> Minimum Purchase of Rs. {{ $Offer->minvalue }}</p>
                                <p class="offer-txt">Use the Offer Code:-
                                <strong>{{ $Offer->offercode }}</strong>
                                </p>
                        </span>
                        <span>Offer Valid Till {{ date('d-m-Y', strtotime($Offer->enddate)) }}</span>
                    </h3>
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


@section('scripts')
    <script src="{{ asset('assets/frontassets/js/owl.carousel.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
    // Add click event listener to all category tabs
    $('.category-tab').on('click', function (e) {
        e.preventDefault(); // Prevent the default action (for smooth navigation)

        // Remove the 'active' class from all tabs and tab panes
        $('.category-tab').removeClass('active');
        $('.tab-pane').removeClass('active show');

        // Add the 'active' class to the clicked tab
        $(this).addClass('active');

        // Get the target tab-pane ID from the href attribute of the clicked tab
        var targetPane = $(this).attr('href');

        // Add the 'active' and 'show' classes to the corresponding tab-pane
        $(targetPane).addClass('active show');
    });
});

</script>
@endsection