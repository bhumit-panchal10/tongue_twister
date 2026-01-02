@extends('layouts.front')

@if($ProductDetail->meta_title)
    @section('title', $ProductDetail->meta_title)
@else    
    @section('title', 'Product Detail')
@endif    
@section('opTag')
<meta name="description" content="{{ $ProductDetail->meta_description }}" />
<meta name="keywords" content="{{ $ProductDetail->meta_keyword }}" />
<?php echo $ProductDetail->head; ?>
<?php echo $ProductDetail->body; ?>
@endsection

@section('content')

<style type="text/css">
    /* Wrapper for the buttons and input */
.wrap-num-product {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 150px; /* Adjust this width as per your design */
    border: 1px solid #ddd;
    padding: 5px;
    border-radius: 5px;
}

/* Style for the buttons */
.btn-num-product-down,
.btn-num-product-up {
    background-color: #f3f3f3;
    border: none;
    width: 40px; /* Width of the buttons */
    height: 40px; /* Height of the buttons */
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border-radius: 5px;
}

.btn-num-product-down:hover,
.btn-num-product-up:hover {
    background-color: #ddd; /* Change the background on hover */
}

/* Icon inside the button */
.btn-num-product-down i,
.btn-num-product-up i {
    font-size: 16px; /* Icon size */
    color: #333; /* Icon color */
}

/* Style for the quantity input */
.num-product {
    width: 60px; /* Adjust width */
    text-align: center;
    border: none;
    background-color: transparent;
    font-size: 16px;
    color: #333;
    pointer-events: none; /* Readonly effect */
}

</style>
<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h3>Product - Detail</h3>
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


   
    <!--product details start-->
    <div class="product_details pt-70 mb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="product-details-tab">
                        @foreach ($Photos as $photos)
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="{{ asset('Product/Thumbnail/') . '/' . $photos->strphoto }}" data-zoom-image="{{ asset('Product/Thumbnail/') . '/' . $photos->strphoto }}" class="img-fluid" alt="big-1">
                            </a>
                        </div>
                       @endforeach
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <div class="product_d_right">
                           
                            <h1><a href="#"> {{ $ProductDetail->productname }}</a></h1>
                           
                            <!--<div class=" product_ratting">-->
                            <!--    <ul class="d-flex">-->
                            <!--        <li><a href="#"><i class="fa fa-star"></i></a></li>-->
                            <!--       <li><a href="#"><i class="fa fa-star"></i></a></li>-->
                            <!--       <li><a href="#"><i class="fa fa-star"></i></a></li>-->
                            <!--       <li><a href="#"><i class="fa-regular fa-star"></i></li>-->
                            <!--       <li><a href="#"><i class="fa-regular fa-star"></i></a></li>-->
                            <!--        <li class="review"><a href="#"> (customer review ) </a></li>-->
                            <!--    </ul>-->
                                
                            <!--</div>-->
                <input type="hidden" name="productid" id="getproductid" value="{{ $ProductDetail->productId }}">

                            <div class="price_box"><span class="current_price"> ₹ </span>
                                <span class="current_price" id="setprice">
                                   {{ $ProductDetail->rate }}</span>
                                <!-- <span class="old_price">&#8377; 80.00</span> -->
                                
                            </div>
                            <div class="product_desc">
                                <!--<p>{!! $ProductDetail->description !!}</p>-->
                            </div>
                           
                            
                                <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="product_variant quantity">
                                     <label>Weight</label> &nbsp;
                                        <select class="select_option" name="weight" id="getproductweight" onchange="getcartweight();">
                                                    <option selected value="0">
                                                        {{ $ProductDetail->weight }}
                                                    </option>
                                                    @foreach ($Attribute as $ProductWeights)
                                                        <option value="{{ $ProductWeights->id }}">
                                                            {{ $ProductWeights->product_attribute_weight }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            <!-- <div class="dropDownSelect2"></div> -->
                                   </div>
                                    <div class="product_variant quantity">
                                    <label>quantity</label> &nbsp;
                                        <div onclick='decreaseCount(event, this)'
                                                class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                -
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                 value="1" name="quantity" id="quantity" min="1" max="100" maxlength="4">

                                            <div onclick='increaseCount(event, this)'
                                                class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                +
                                            </div>
                                        </div>

                                    <!-- <input type="hidden" value="1" name="quantity" id="quantity"> -->

                                    <input type="hidden" value="{{ $ProductDetail->categoryId }}" name="categoryId">
                                    <input type="hidden" value="{{ $ProductDetail->productId }}" name="productid">
                                    <input type="hidden" value="{{ $ProductDetail->productname }}" name="productname">
                                    <input type="hidden" value="{{ $ProductDetail->photo }}" name="image">
                                    <input type="hidden" id="cartweight" name="weight"
                                        value="{{ $ProductDetail->weight }}" />
                                    <input type="hidden" id="cartPrice" name="price">


                                    <button class="button" type="submit">add to cart</button>
                                </form>
                                <!-- <button class="button" type="submit">add to cart</button>   -->
                    </div>
                </div>
            </div>
        </div>    
    </div>
    <!--product details end-->
    
    <!--product info start-->
    <div class="product_d_info mb-65">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner">   
                        <div class="product_info_button">    
                            <ul class="nav" role="tablist" id="nav-tab">
                                <li >
                                    <a class="active" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Description</a>
                                </li>
                                <!-- <li>
                                     <a data-bs-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">Specification</a>
                                </li> -->
                                <!--<li>-->
                                <!--   <a data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews ({{ $productcount  }})</a>-->
                                <!--</li>-->
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" >
                                <div class="product_info_content">
                                    <p>{!! $ProductDetail->description !!}</p>
                                </div>    
                            </div>
                           <!--  <div class="tab-pane fade" id="sheet" role="tabpanel" >
                                <div class="product_d_table">
                                   <form action="#">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="first_child">Compositions</td>
                                                    <td>Amla</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">Category</td>
                                                    <td>Candy</td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="product_info_content">
                                    <p>eget velit. Donec ac tempus ante. Fusce ultricies massa massa. Fusce aliquam, purus eget sagittis vulputate, sapien libero hendrerit est, sed commodo augue nisi non neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempor, lorem et placerat vestibulum, metus nisi posuere nisl.</p>
                                </div>    
                            </div> -->

                            <div class="tab-pane fade" id="reviews" role="tabpanel" >
                                <div class="reviews_wrapper">
                                     @if(sizeof($productreview) != 0)
                                        <h2>{{$productcount}} review for {{$ProductDetail->productname }}</h2>
                                        <div class="reviews_comment_box">
                                        <div class="comment_thmb">
                                            <img src="assets/img/blog/comment2.jpg" alt="">
                                        </div>
                                       
                                             @foreach($productreview as $review)
                                        <div class="comment_text">
                                            <div class="reviews_meta">
                                                <div class="star_rating">
                                                    @php
                                                        $rating = $review->rating; // This is where you'd pass the rating value from your database
                                                    @endphp

                                                    <ul>
                                                        @for($i = 0; $i < 5; $i++)
                                                            <li>
                                                                <a href="#">
                                                                    @if($i < $rating)
                                                                        <i class="fa fa-star"></i> <!-- Filled star -->
                                                                    @else
                                                                        <i class="fa fa-star-o"></i> <!-- Empty star -->
                                                                    @endif
                                                                </a>
                                                            </li>
                                                        @endfor
                                                    </ul>

                                                </div>
                                                <p><strong>{{ $review->author }} </strong>- {!! $review->comment !!}</p>
                                                
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                          
                                </div>     
                            </div>
                        </div>
                    </div>     
                </div>
            </div>
        </div>    
    </div>  
    <!--product info end-->
    
    @if(sizeof($RelatedProduct) != 0) 
    <!--product area start-->
    <section class="product_area related_products">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-12">
                    <div class="product_carousel product_column5 owl-carousel">
                        @foreach ($RelatedProduct as $product)
                        <div class="single-product">
                            <div class="card2" data-aos="zoom-in" data-aos-duration="500">
                                <a href="{{ route('productdetail', [$category, $product->slugname]) }}">
                                    <img src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" alt=" " class="img-fluid">
                                </a>
                                <div class="info1">
                                    <p>{{ $product->productname }}</p>
                                    <p>Weight: {{ $product->weight }} <br> Price:  &#8377;{{ $product->rate }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>  
        </div>
    </section>
    @endif
    <!--product area end-->
@endsection
@section('scripts')
    
    <script>
        function increaseCount(a, b) {
            var input = b.previousElementSibling;
            var value = parseInt(input.value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            {{--  alert(value);  --}}
            {{--  input.value = value;  --}}

            $('#quantity').val(value);

        }

        function decreaseCount(a, b) { 
            var input = b.nextElementSibling;
            var value = parseInt(input.value, 10);
            // alert(value);
            if (value > 1) {
                value = isNaN(value) ? 0 : value;
                value--;
                {{--  input.value = value;  --}}
            }
            $('#quantity').val(value);
        }
        $('#getproductweight').on('change', function() {
            weightvalidation();
        });


        function weightvalidation() {
            var Weight = $('#getproductweight').val();
            var productid = $('#getproductid').val();
            var productprice = $('#setprice').val();
            {{--  alert(productprice);  --}}
            var url = "{{ route('productweight.weightBind') }}";


            if (Weight) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        Weight: Weight,
                        productid: productid
                    },
                    success: function(data) {
                        var obj = JSON.parse(data);
                        if (obj.product_attribute_price == null) {
                            $('#setprice').html(obj.rate);
                            $('#cartweight').val(obj.weight);
                        } else {
                            $('#setprice').html(obj.product_attribute_price);
                            $('#cartweight').val(obj.product_attribute_weight);

                        }
                        getcartweight();
                    }
                });
            }
        }

        $('document').ready(function() {
            weightvalidation();
            getcartweight();
        })
    </script>
    <script>
        function getcartweight() {
            var CartWeight = $('#cartweight').val();
            var CartPrice = $('#setprice').html();
            $('#cartweight').val(CartWeight);
            $('#cartPrice').val(CartPrice);
        }
    </script>
    @endsection