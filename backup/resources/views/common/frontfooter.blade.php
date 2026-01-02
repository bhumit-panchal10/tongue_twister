
    <!--footer area start-->
    <footer class="footer_widgets">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-7">
                        <div class="widgets_container contact_us">
                            <div class="footer_logo w-50">
                                <a href="{{route('FrontIndex')}}"><img src="{{ asset('assets/frontassets/img/logo/logo.png')}}" alt=""></a>
                            </div>
                            <p class="footer_desc">We are a team of designers and developers that create high quality
                                eCommerce, WordPress, Shopify .</p>

                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-5">
                        <div class="widgets_container widget_menu">
                            <h3>Information</h3>
                            <div class="footer_menu">

                                <ul>
                                    <li><a href="{{route('FrontIndex')}}">Home</a></li>
                                    <li>
                                        <a href="{{route('FrontAbout')}}">About Us</a>
                                    </li>
                                    <li>
                                        <a href="{{route('cart.list')}}">Cart</a>
                                    </li>
                                    <?php
                                        $session = Session::get('customerid');
                                        $sessionname = Session::get('customername');
                                        if($session){
                                        ?>
                                    <li>
                                                <a href="{{ route('myaccount') }}">
                                                    My Account</a>
                                            </li>
                                <?php } ?>
                                    <li>
                                        <a href="{{route('FrontContactUs')}}">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="widgets_container widget_menu">
                            <h3>Pages</h3>
                            <div class="footer_menu">
                                <ul>
                                   <!--  <?php
                                                  $Category = App\Models\Category::orderBy('categoryname', 'asc')
                                                      ->where(['iStatus' => 1, 'isDelete' => 0,'subcategoryid'=>0])
                                                      ->skip(0)->take(4)->get();
                                                 ?>
                                                @foreach ($Category as $category)
                                        <li><a href="{{ route('FrontCategory', $category->slugname) }}">{{$category->categoryname}}</a></li>

                                    @endforeach -->
                                    <li><a href="{{route('privacypolicy')}}">Privacy Policy</a></li>
                                    <li><a href="{{route('termandcondition')}}"> Terms & Condition</a></li>
                                    <li><a href="{{route('refundpolicy')}}">Refund Policy</a></li>
                                    <li><a href="{{route('ShippingandDelivery')}}">Shipping and Delivery</a></li>
                                    <?php
                                        $session = Session::get('customerid');
                                        $sessionname = Session::get('customername');
                                        if($session){
                                        ?>
                                    <li><a href="{{route('myorders')}}"> Order History</a></li>
                                <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <h3>Contact us</h3>
                        <p><span>Address:</span> F-80, F-81, Tulsi Industrial Estate ,
                            Opp Bhagyoday Hotel,
                            Changodhar,
                            Gujarat 362213</p>
                        <p><span>Email:</span> <a href="mailto:info@tonguetwister.com">info@tonguetwister.com</a></p>
                        <p><span>Call us:</span> <a href="tel:(+91)8780418312">+91 8780418312</a> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-7">
                        <div class="copyright_area">
                            <p>Copyright © 2024 <a href="{{route('FrontIndex')}}">Tongue Twister</a> . All Rights Reserved. <br>Powered by <a
                                    href="#">Phoenix Medicaments Private Limited</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="footer_payment">
                            <ul>
                                <li><a href="#"><img src="{{ asset('assets/frontassets/img/icon/paypal1.jpg')}}" alt=""></a></li>
                                <li><a href="#"><img src="{{ asset('assets/frontassets/img/icon/paypal2.jpg')}}" alt=""></a></li>
                                <li><a href="#"><img src="{{ asset('assets/frontassets/img/icon/paypal3.jpg')}}" alt=""></a></li>
                                <li><a href="#"><img src="{{ asset('assets/frontassets/img/icon/paypal4.jpg')}}" alt=""></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--footer area end-->

   

