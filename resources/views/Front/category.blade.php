@extends('layouts.front')
@if($seo->meta_title)
    @section('title', $seo->meta_title)
@endif    
@section('opTag')
<meta name="description" content="{{ $seo->meta_description }}" />
<meta name="keywords" content="{{ $seo->meta_keyword }}" />
@endsection


@section('head')
    {!! $seo->head ?? '' !!}
@endsection


@section('body')
    @if (!empty($seo->body))
        <script type="text/javascript">
            {!! $seo->body !!}
        </script>
    @endif
@endsection
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
<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h1>Product</h1>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>Product</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
                                       @include('common.frontalert')


   
    <!--product area start-->
    <section class="product_area bg-white  mb-64">
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

                    <?php if($ProductCount == 0){ ?>
                    <div class="col-md-12 col-sm-6">
                        <h2 class="text-center">No data Found!</h2>
                    </div>
                    <?php }else{ ?>
                    @foreach ($Product as $product)
                    <div class="product_items col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{ route('productdetail', [$id, $product->slugname]) }}">
                                        <img src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                    <a class="secondary_img" href="{{ route('productdetail', [$id, $product->slugname]) }}">
                                        <img src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                    <div class="label_product">
                                        <!-- <span class="label_sale">Sale</span> -->
                                        <!-- <span class="label_new">New</span> -->
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
                                                <li class="quick_button"><a href="#" data-tippy="quick view" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-bs-toggle="modal" data-bs-target="#modal_box_{{ $product->productId }}"> <span  class="lnr lnr-magnifier"></span></a></li>

                                            <!-- <li class="wishlist"><a href="wishlist#" data-tippy="Add to Wishlist" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true"><span class="lnr lnr-heart"></span></a></li>   -->

                                        </ul>
                                    </div>
                                </div>
                                <figcaption class="product_content">
                                    <h4 class="product_name"><a href="{{ route('productdetail', [$id, $product->slugname]) }}">
                                        {{ $product->productname }}</a></h4>
                                    <p><a href="#">{{ $product->weight }}</a></p>
                                    <div class="price_box">
                                        <span class="current_price">&#8377; {{ $product->rate }}</span>
                                        <!-- <span class="old_price">&#8377; 62.00</span> -->
                                    </div>
                                </figcaption>
                            </figure>
                        </article>

                    </div>

                                        <!----quick view of product start  ---->
                    <div class="modal fade" id="modal_box_{{ $product->productId }}" tabindex="-1" role="dialog" aria-hidden="true">
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

                                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                                            <div class="modal_tab_img">
                                                                <a href="#"><img src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                                            </div>
                                                        </div>
                                                        <?php if($product->backphoto){ ?>
                                                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                                                            <div class="modal_tab_img">
                                                                <a href="#"><img src="{{ asset('Product/Thumbnail/') . '/' . $product->backphoto }}" alt=""></a>
                                                            </div>
                                                        </div>
                                                        <?php }else{ ?>
                                                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                                                            <div class="modal_tab_img">
                                                                <a href="#"><img src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                                            </div>
                                                        </div>
                                                         <?php } ?>
                                                    </div>
                                                    <div class="modal_tab_button">
                                                        <ul class="nav product_navactive owl-carousel" role="tablist">
                                                            <li>
                                                                <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab"
                                                                    aria-controls="tab1" aria-selected="false"><img
                                                                        src="assets/img/product/product1.jpg" alt=""></a>
                                                            </li>
                                                            <li>
                                                                <a class="nav-link" data-toggle="tab" href="#tab2" role="tab"
                                                                    aria-controls="tab2" aria-selected="false"><img
                                                                        src="assets/img/product/product6.jpg" alt=""></a>
                                                            </li>
                                                            <li>
                                                                <a class="nav-link button_three" data-toggle="tab" href="#tab3"
                                                                    role="tab" aria-controls="tab3" aria-selected="false"><img
                                                                        src="assets/img/product/product2.jpg" alt=""></a>
                                                            </li>
                                                            <li>
                                                                <a class="nav-link" data-toggle="tab" href="#tab4" role="tab"
                                                                    aria-controls="tab4" aria-selected="false"><img
                                                                        src="assets/img/product/product7.jpg" alt=""></a>
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

                    <?php } ?>
                </div>
                <?php if(!empty($ProductCount)){ ?>
                <div class="d-flex justify-content-center mt-3 pg-links">
                    {{ $Product->appends(request()->except('page'))->links() }}
                </div>
                <?php } ?>
            </div>
                </div>
            </div>
        </div>
    </section>
    <!--product area end-->
    
    
    
   
    @endsection