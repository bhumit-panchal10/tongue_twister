@extends('layouts.front')
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
                        <h3>Cart</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
                                       @include('common.frontalert')


    
    <div class="shopping_cart_area mt-70">
        <div class="container">  
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="cart_page">
                                <table>
                            <thead>
                                <tr>
                                    
                                    <th class="product_thumb">Image</th>
                                    <th class="product_name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product_quantity">Weight</th>
                                    <th class="product_quantity">Quantity</th>
                                    <th class="product_total">Total</th>
                                    <th class="product_remove">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0; ?>
                                @foreach ($cartItems as $item)

                                <tr>
                                   
                                    <td class="product_thumb"><a href="#"><img src="{{ asset('Product') . '/' . $item->attributes->image }}" class="img-fluid" alt=""></a></td>
                                    <td class="product_name"><a href="#">{{ $item->name }}</a></td>
                                    <td class="product-price">&#8377; {{ $item->price }}</td>
                                    <td class="product-price"> {{ $item->weight }}</td>
                                    <td class="product_quantity">
                                       <form action="{{ route('cart.update') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <div class="wrap-num-product flex-w m-l-auto m-r-0">

                                                   <button onClick='decreaseCount(event, this)' class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" type="button"> - </button>

                                                    <input type="number" readonly name="quantity" value="{{ $item->quantity }}" class="num-product" min="1" max="100" maxlength="4">
                                                
                                                    <button onClick='increaseCount(event, this)' class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" type="button"> + </button>

                                                </div>
                                            </form>
                                     <!-- <input min="1" max="100" value="1" type="number"></td> -->
                                    <td class="product_total">&#8377;{{ $item->price * $item->quantity }}</td>

                                    <form action="{{ route('cart.remove') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">

                                    <td class="product_remove"><button type="submit" style="border: none;background: transparent;">
                                        <i class="fa fa-trash"></i></button></td>
                                    </form>


                                </tr>
                                <?php $total += $item->price * $item->quantity; ?>
                                @endforeach
                                <?php if($total ){ ?>
                                <tr>
                                    <td colspan="7" class="cart-cn text-right">Total :- ₹{{ $total }}</td>
                                </tr>
                                <?php } ?>
                                

                            </tbody>
                        </table>   
                            </div>  
                                 
                        </div>
                     </div>
                 </div>
                  <div class="row">
                        <div class="col-lg-12 col-md-6 text-right">
                                <div class="checkout_btn d-inline">
                                   <a href="{{ route('searchproduct') }}">Continue Shopping</a>
                               </div>
                            <?php
                            $count = \Cart::getContent()->count();
                            if($count){
                            ?>
                                
                                <div class="checkout_btn  d-inline">
                                   <a href="{{ route('checkout') }}">Proceed to Checkout</a>
                               </div>
                                    
                            <?php } ?>
                    </div>
                </div>

    </div>
</div>
@endsection
@section('scripts')

    <script>
      function increaseCount(event, button) {
    event.preventDefault(); // Prevent default button behavior
    
    var form = button.closest('form');       // Find the closest form element
    var input = button.previousElementSibling; // Get the related input
    var value = parseInt(input.value, 10);   // Get current value
    value = isNaN(value) ? 0 : value;        // Fallback to 0 if NaN
    value++;
    input.value = value;                     // Update input value

    form.submit();                           // Submit the form
}

function decreaseCount(event, button) {
    event.preventDefault(); // Prevent default button behavior
    
    var form = button.closest('form');       // Find the closest form element
    var input = button.nextElementSibling;   // Get the related input
    var value = parseInt(input.value, 10);   // Get current value
    if (value > 1) {                         // Prevent going below 1
        value = isNaN(value) ? 0 : value;
        value--;
        input.value = value;                 // Update input value
    }

    form.submit();                           // Submit the form
}

    </script>

@endsection