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
<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h3>Product </h3>
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
            @if(sizeof($Product) != 0)
            <div class="product_container">
                <div class="row">
                @foreach ($Product as $product)
                    <div class="product_items col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}"><img
                                            src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
                                    <a class="secondary_img" href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}"><img
                                            src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=""></a>
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
                                                <li class="quick_button"><a href="#" data-tippy="quick view" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-bs-toggle="modal" data-bs-target="#modal_box_{{ $product->productId }}"> <span  class="lnr lnr-magnifier"></span></a></li>

                                            <!-- <li class="wishlist"><a href="wishlist#" data-tippy="Add to Wishlist" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true"><span class="lnr lnr-heart"></span></a></li>   -->

                                        </ul>
                                    </div>
                                </div>
                                <figcaption class="product_content">
                                    <h4 class="product_name"><a href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}">{{ $product->productname }}</a></h4>
                                    <p><a href="#">{{ $product->weight }}</a></p>
                                    <div class="price_box">
                                        <span class="current_price">&#8377; {{ $product->rate }}</span>
                                    </div>
                                </figcaption>
                            </figure>
                        </article>

                    </div>
                    @endforeach

                </div>
            </div>
            @else
             <div class="product_container">
                <div class="row">
                    <h3 class="text-center">No Product Found</h3><
                    </div>
                    </div>
                    
            @endif
        </div>
    </section>
    <!--product area end-->
    @endsection