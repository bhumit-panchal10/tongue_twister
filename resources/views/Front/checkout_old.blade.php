@extends('layouts.front')
@section('content')
<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h1>Checkout</h1>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
    @include('common.alert')

     <!--Checkout page section-->
     <div class="Checkout_section ">
        <div class="container">
             <div class="row">
                <div class="col-lg-12">
                     <div class="user-actions">
                         <!--<h3> -->
                         <!--    <i class="fa fa-file-o" aria-hidden="true"></i>-->
                         <!--    Returning customer?-->
                         <!--    <a class="Returning" href="#checkout_login" data-bs-toggle="collapse" aria-expanded="true">Click here to login</a>     -->
 
                         <!--</h3>-->
                          <div id="checkout_login" class="collapse" data-parent="#accordion">
                             <div class="checkout_info">
                                 <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing & Shipping section.</p>  
                                 <form action="#">  
                                     <div class="form_group">
                                         <label>Username or email <span>*</span></label>
                                         <input type="text">     
                                     </div>
                                     <div class="form_group">
                                         <label>Password  <span>*</span></label>
                                         <input type="text">     
                                     </div> 
                                     <div class="form_group group_3 ">
                                         <button type="submit">Login</button>
                                         <label for="remember_box">
                                             <input id="remember_box" type="checkbox">
                                             <span> Remember me </span>
                                         </label>     
                                     </div>
                                     <a href="#">Lost your password?</a>
                                 </form>          
                             </div>
                         </div>    
                     </div>
                       
                </div>
                   
             </div>
                   
             <div class="checkout_form">
                 <div class="row">

                     <div class="col-lg-6 col-md-6">
                         <form class="bg0" action="{{ route('checkoutstore') }}" method="post">
                         @csrf
                             <h3>Billing Details</h3>
                             <div class="row">
 
                                 <div class="col-lg-6 mb-20">
                                     <label>First Name <span>*</span></label>
                                        <input type="text" name="billFirstName" value="{{ old('billFirstName') }}" required autocomplete="off" />
                                 </div>
                                 <div class="col-lg-6 mb-20">
                                     <label>Last Name  <span>*</span></label>
                                        <input type="text" name="billLastName" value="{{ old('billLastName') }}" required autocomplete="off" />
                                 </div>
                                 <div class="col-lg-6 mb-20">
                                    <label>Phone<span>*</span></label>
                                        <input type="tel" name="billPhone" value="{{ old('billPhone') }}" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="10" minlength="10" required autocomplete="off" />
                                </div> 
                                 <div class="col-lg-6 mb-20">
                                    <label> Email Address   <span>*</span></label>
                                         <input type="email" name="billEmail" value="{{ old('billEmail') }}" required autocomplete="off" />
                                </div> 
                                 <div class="col-lg-6 mb-20">
                                     <label>Company Name</label>
                                     <input type="text" name="billCompanyName" value="{{ old('billCompanyName') }}" />
                                 </div>
                            <div class="col-lg-6 mb-20">
                                     <label>Town / City <span>*</span></label>
                                    <input type="text" name="billCity" id="billCity" value="{{ old('billCity') }}" required autocomplete="off" />                       
                                  </div> 
                                  <div class="col-lg-6 mb-20">
                                     <label>State  <span>*</span></label>
                                        <select class="select_option nice-select"  name="billState"  id="billState" required>
                                            <option value="">Select State</option>
                                            @foreach ($State as $state)
                                                <option value="{{ $state->stateId }}">{{ $state->stateName }}</option>
                                            @endforeach                                
                                         
                                     </select>
                                    </div> 
                                 <div class="col-6 mb-20">
                                     <label>Pincode  <span>*</span></label>
                                    <input type="text" name="billPinCode" value="{{ old('billPinCode') }}" required autocomplete="off" />
                                 </div>
                                 <div class="col-12 mb-20">
                                     <label>Street address  <span>*</span></label>
                                    <input type="text" name="billStreetAddress1" value="{{ old('billStreetAddress1') }}" required autocomplete="off" />
                                 </div>
                                 <div class="col-12 mb-20">
                                    <label>Apartment, suite, unit etc. (optional)</label>
                                     <input class="w-100 mt-3" type="text" name="billStreetAddress2" />
                                 </div>

                                 
                                    <div class="col-lg-12 mb-20">
                                     <label>Order notes (optional)  <span>*</span></label>
                                        <input class="w-100 mt-3 " name="billNotes" value="{{ old('billNotes') }}">
                                    </div>
                                 
                                 <!-- <div class="col-12 mb-20">
                                     <input id="account" type="checkbox" data-target="createp_account" />
                                     <a data-bs-toggle="collapse" href="#collapseOne"  aria-controls="collapseOne">Create an account?</a>
                                     <div id="collapseOne" class="collapse one" data-parent="#accordion">
                                         <div class="card-body1">
                                            <label> Account password   <span>*</span></label>
                                             <input placeholder="password" type="password">  
                                         </div>
                                     </div>
                                 </div> -->
                                 <!-- <div class="col-12 mb-20">
                                     <input id="address" type="checkbox" data-target="createp_account" />
                                      <a class="righ_0" href="#collapsetwo" data-bs-toggle="collapse" aria-controls="collapsetwo">Ship to a different address?</a>   
                                     <div id="collapsetwo" class="collapse one" data-parent="#accordion">
                                        <div class="row">
                                             <div class="col-lg-6 mb-20">
                                                 <label>First Name <span>*</span></label>
                                                 <input type="text">    
                                             </div>
                                             <div class="col-lg-6 mb-20">
                                                 <label>Last Name  <span>*</span></label>
                                                 <input type="text"> 
                                             </div>
                                             <div class="col-12 mb-20">
                                                 <label>Company Name</label>
                                                 <input type="text">     
                                             </div>
                                             <div class="col-12 mb-20">
                                                 <div class="select_form_select">
                                                     <label for="countru_name">country <span>*</span></label>
                                                     <select class="select_option" name="cuntry" id="countru_name"> 
                                                         <option value="2">bangladesh</option>      
                                                         <option value="3">Algeria</option> 
                                                         <option value="4">Afghanistan</option>    
                                                         <option value="5">Ghana</option>    
                                                         <option value="6">Albania</option>    
                                                         <option value="7">Bahrain</option>    
                                                         <option value="8">Colombia</option>    
                                                         <option value="9">Dominican Republic</option>   
 
                                                     </select>
                                                 </div> 
                                             </div>
 
                                             <div class="col-12 mb-20">
                                                 <label>Street address  <span>*</span></label>
                                                 <input placeholder="House number and street name" type="text">     
                                             </div>
                                             <div class="col-12 mb-20">
                                                 <input placeholder="Apartment, suite, unit etc. (optional)" type="text">     
                                             </div>
                                             <div class="col-12 mb-20">
                                                 <label>Town / City <span>*</span></label>
                                                 <input  type="text">    
                                             </div> 
                                              <div class="col-12 mb-20">
                                                 <label>State / County <span>*</span></label>
                                                 <input type="text">    
                                             </div> 
                                             <div class="col-lg-6 mb-20">
                                                 <label>Phone<span>*</span></label>
                                                 <input type="text"> 
 
                                             </div> 
                                              <div class="col-lg-6">
                                                 <label> Email Address   <span>*</span></label>
                                                   <input type="text"> 
 
                                             </div> 
                                         </div>
                                     </div>
                                 </div> -->
                                  	    	    	    	    	    	    
                             </div>
                     </div>
                     <div class="col-lg-6 col-md-6">
                          <div class="col-lg-12 pb-3">
                    <?php $total = Cart::getTotal(); ?>
                        <form action="{{ route('couponcodeapply') }}" method="post">
                         @csrf
                            <div class="coupon_code rigt">
                                <h3>Coupon</h3>
                                <div class="coupon_inner">   
                                <input type="hidden" value="{{ $total }}" name="totalAmount">
                                    <p>Enter your coupon code if you have one.</p>                                
                                    <input placeholder="Coupon code" type="text" name="coupon" required>
                                    <button type="submit">Apply coupon</button>
                                </div>    
                            </div>
                        </form>
                    </div>
                             <h3>Your order</h3> 
                             <div class="order_table table-responsive">
                                <?php
                            $cartItems = \Cart::getContent();
                            ?>
                                 <table>
                                     <thead>
                                         <tr>
                                             <th>Product</th>
                                             <th>Total</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                        @foreach ($cartItems as $item)
                                         <tr>
                                             <td> {{ $item->name }}<strong> × {{ $item->quantity }}</strong></td>
                                             <td>₹{{ $item->price * $item->quantity }}</td>
                                         </tr>
                                         @endforeach
                                     </tbody>
                                     <tfoot>
                                         <tr>
                                             <th>Cart Subtotal</th>
                                             <td><strong> ₹ <span id="Subtotal">{{ Cart::getTotal() }}</span></strong></td>
                                         </tr>
                                         @php
                                        $Total = 0;
                                    @endphp
                                    <input type="hidden" name="discount" id="discount" value="{{ $Coupon['result'] ?? 0 }}">
                                    @if (!empty($Coupon))
                                        @php
                                            $Total = \Cart::getTotal() + $Shipping->rate - $Coupon->result;
                                        @endphp
                                        <tr>
                                             <th>Discount Of Coupon</th>
                                             <td><strong>₹ {{ $Coupon['result'] }}</strong></td>
                                         </tr>
                                        @else
                                        @php
                                            $Total = \Cart::getTotal() + $Shipping->rate;
                                        @endphp
                                        @if ($Total <= 0)
                                        <tr>
                                            <td>Sorry,this coupon code cannot be applicable on this order !</td>
                                        </tr>
                                        @endif
                                        @endif
                                         <tr>
                                             <th>Shipping</th>
                                             <td><strong>₹<span id="shippinrate">{{ $Shipping->rate }}</span></strong></td>
                                         </tr>
                                          @if (!empty($Coupon))
                                                @php
                                                    $Total = \Cart::getTotal() + $Shipping->rate - $Coupon['result'];
                                                @endphp
                                            @else
                                                @php
                                                    $Total = \Cart::getTotal() + $Shipping->rate;
                                                @endphp
                                            @endif
                                         <tr class="order_total">
                                             <th>Order Total</th>
                                             <td><strong>₹ <span id="OrderTotal">{{ $Total }}</span></strong></td>
                                         </tr>
                                     </tfoot>
                                 </table>     
                             </div>
                        <input type="hidden" name="netamount" id="OrderNetAmount">
                        <input type="hidden" name="shippingcharges" id="OrderShippingCharges">
                        <?php
                                $count = \Cart::getContent()->count();
                                if($count){
                            ?>

                             <div class="payment_method">
                                 <div class="order_button">
                                     <button  type="submit">Proceed to Pay</button> 
                                 </div>    
                             </div> 
                             <?php } ?>
                         </form>         
                     </div>
                 </div> 
             </div> 
         </div>       
     </div>
     <!--Checkout page section end-->
@endsection
@section('scripts')
    <script>
        function increaseCount(a, b) {
            var input = b.previousElementSibling;
            var value = parseInt(input.value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            input.value = value;

            totalamountcal = (input.value * 1) * (1499 * 1)
            // alert(totalamountcal);

            $('#totalamount').val(totalamountcal);

            // count = $('#count').val();
        }

        function decreaseCount(a, b) {
            var input = b.nextElementSibling;
            var value = parseInt(input.value, 10);
            // alert(value);
            if (value > 1) {
                value = isNaN(value) ? 0 : value;
                value--;
                input.value = value;
            }
            totalamountcal = (input.value * 1) * (1499 * 1)
            // alert(totalamountcal);

            $('#totalamount').val(totalamountcal);
        }
    </script>


    <script>
        $('#billState').on('change', function() { 
            state();
        });
        $('#billCity').on('blur', function() {
            state();
        });

        function state() { 
            var state = $('#billState').val();
            var city = $('#billCity').val();
            var Subtotal = $("#Subtotal").html();
            var discount = $("#discount").val();
            var Total = 0;
            var cartItems = <?php echo json_encode(\Cart::getContent()); ?>;
            var cartItemsArray = Object.values(cartItems);
            var totalweight = 0;
            var shippingCharges = 0;
            var CheckCategory = false;

            // cartItemsArray.forEach(function(item) 
            // {
            //     if (item.categoryId == "9") {
            //         CheckCategory = true;
            //     }
            // });
            /*if (CheckCategory == false) 
            {*/
                if (state === "1") {
                    if (city.toLowerCase() === 'ahmedabad') 
                    {
                        var iCounter = 1;
                        cartItemsArray.forEach(function(item) {
                            var explode = parseFloat(item.weight.replace('g', '').replace('Kg', ''));
                            if (item.weight.indexOf('g') != -1) {
                                //totalweight += explode * 1000 * parseInt(item.quantity);
                                //totalweight += explode * parseInt(item.quantity);
                                totalweight += (explode * 1) * parseInt(item.quantity);
                            } else {
                                totalweight += (explode * 1) * parseInt(item.quantity);
                            }
                            iCounter++;
                        });
                        if (totalweight < 800) {
                            shippingCharges = 0;
                        } else 
                        {
                            /*var roundTotalWeight = Math.ceil(totalweight / 1000);
                            var iCounter = 1;
                            var kCounter = 0;
                            for (iCounter = 0; iCounter <= roundTotalWeight; iCounter++) {
                                //kCounter = roundTotalWeight * 1000;
                                if (roundTotalWeight == iCounter) {
                                    kCounter = (roundTotalWeight * 1) * 1000 - 200;
                                    if ((kCounter - 1000) < totalweight && kCounter > totalweight) {
                                        shippingCharges = (iCounter * 1) * 40;
                                    }
                                }
                            }*/
                            var NewToalWeight = totalweight - 800;
                            var ExtraWeight = 0;
                            ExtraWeight = Math.floor(NewToalWeight * 1 / 1000);
                            if (NewToalWeight % 1000 > 0) {
                                ExtraWeight = (ExtraWeight * 1) + 1;
                            }
                            shippingCharges = (ExtraWeight * 1 * 40);
                        }
                    } else {
                        cartItemsArray.forEach(function(item) {
                            var explode = parseFloat(item.weight.replace('g', '').replace('Kg', ''));
                            totalweight += (explode * 1) * parseInt(item.quantity);
                        });
                        var roundTotalWeight = Math.ceil((totalweight *1) / 1000);
                        shippingCharges += roundTotalWeight * 60;
                    }
                } else if (state === "6" || state === "8" || state === "11") {
                    cartItemsArray.forEach(function(item) {
                        var explode = parseFloat(item.weight.replace('g', '').replace('Kg', ''));
                        totalweight += (explode * 1) * parseInt(item.quantity);
                    });
                    var roundTotalWeight = Math.ceil((totalweight * 1) / 1000);
                    shippingCharges += roundTotalWeight * 60;
                } else {
                    cartItemsArray.forEach(function(item) {
                        var explode = parseFloat(item.weight.replace('g', '').replace('Kg', ''));
                        totalweight += (explode * 1) * parseInt(item.quantity);
                    });
                    var roundTotalWeight = Math.ceil((totalweight * 1) / 1000);
                    shippingCharges += roundTotalWeight * 150;
                }
            // } else {
            //     shippingCharges = 0;
            // }

            $('#shippinrate').html(shippingCharges);
            Total = (Subtotal * 1) + (shippingCharges * 1) - (discount * 1);
            $("#OrderTotal").html(Total);
            $("#OrderNetAmount").val(Total);
            $("#OrderShippingCharges").val(shippingCharges);

        }
    </script>
@endsection
