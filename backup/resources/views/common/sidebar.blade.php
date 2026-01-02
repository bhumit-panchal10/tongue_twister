<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">


    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu"></span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link @if (request()->routeIs('home')) {{ 'active' }} @endif"
                        href="{{ route('home') }}">
                        <i class="mdi mdi-speedometer"></i>
                        <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                        aria-expanded="true" aria-controls="sidebarMore">
                        <i class="ri-briefcase-2-line"></i> Master Entry </a>
                    <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('category.index')) {{ 'active' }} @endif"
                                    href="{{ route('category.index') }}">
                                    <i class="fa-regular fa-rectangle-list"></i>
                                    <span data-key="t-dashboards">Category</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('product.index')) {{ 'active' }} @endif"
                                    href="{{ route('product.index') }}">
                                    <i class="fa-solid fa-box-open"></i>
                                    <span data-key="t-dashboards">Product</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('attribute.index')) {{ 'active' }} @endif"
                                    href="{{ route('attribute.index') }}">
                                    <i class="fa-solid fa-box-open"></i>
                                    <span data-key="t-dashboards">Attribute</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('offer.index')) {{ 'active' }} @endif"
                                    href="{{ route('offer.index') }}">
                                    <i class="fa-solid fa-gift"></i>
                                    <span data-key="t-dashboards">Offer</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('courier.index')) {{ 'active' }} @endif"
                                    href="{{ route('courier.index') }}">
                                    <i class="fa-solid fa-truck-ramp-box"></i>
                                    <span data-key="t-dashboards">Courier</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('banner.index')) {{ 'active' }} @endif"
                                    href="{{ route('banner.index') }}">
                                    <i class="fa-regular fa-rectangle-list"></i>
                                    <span data-key="t-dashboards">Banner</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('faq.index')) {{ 'active' }} @endif"
                                    href="{{ route('faq.index') }}">
                                    <i class="fa-solid fa-building"></i>
                                    <span data-key="t-dashboards">Faq</span>
                                </a>
                            </li>
                            <!--<li class="nav-item">-->
                            <!--    <a class="nav-link menu-link @if (request()->routeIs('shipping.index')) {{ 'active' }} @endif"-->
                            <!--        href="{{ route('shipping.index') }}">-->
                            <!--        <i class="fa-solid fa-truck fa-lg"></i>-->
                            <!--        <span data-key="t-dashboards">Shipping</span>-->
                            <!--    </a>-->
                            <!--</li>-->
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('testimonial.index')) {{ 'active' }} @endif"
                                    href="{{ route('testimonial.index') }}">
                                    <i class="fa-solid fa-star"></i>
                                    <span data-key="t-dashboards">Testimonial</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('review.index')) {{ 'active' }} @endif"
                                    href="{{ route('review.index') }}">
                                    <i class="fa-solid fa-star fa-lg"></i>
                                    <span data-key="t-dashboards">Review</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                        aria-expanded="true" aria-controls="sidebarMore">
                        <i class="ri-briefcase-2-line"></i> Order </a>
                    <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('order.pending')) {{ 'active' }} @endif"
                                    href="{{ route('order.pending') }}">
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                    <span data-key="t-dashboards">Order</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('order.paymentpendingOrder')) {{ 'active' }} @endif"
                                    href="{{ route('order.paymentpendingOrder') }}">
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                    <span data-key="t-dashboards">Payment Pending</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                        aria-expanded="true" aria-controls="sidebarMore">
                        <i class="ri-briefcase-2-line"></i> Reports </a>
                    <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('setting.index')) {{ 'active' }} @endif"
                                    href="{{ route('report.paymentReport') }}">
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                    <span data-key="t-dashboards">Payment Report</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link @if (request()->routeIs('otherpages.index')) {{ 'active' }} @endif"
                                    href="{{ route('report.orderTracking') }}">
                                    <i class="fas fa-shipping-fast"></i>
                                    <span data-key="t-dashboards">Order Tracking</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!--<li class="nav-item">-->
                <!--    <a class="nav-link menu-link @if (request()->routeIs('order.index')) {{ 'active' }} @endif"-->
                <!--        href="{{ route('order.pending') }}">-->
                <!--        <i class="fa-solid fa-cart-shopping"></i>-->
                <!--        <span data-key="t-dashboards">Order</span>-->
                <!--    </a>-->
                <!--</li>-->


                <li class="nav-item">
                    <a class="nav-link menu-link @if (request()->routeIs('metaData.index')) {{ 'active' }} @endif"
                        href="{{ route('metaData.index') }}">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span data-key="t-dashboards">Seo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if (request()->routeIs('pages.index')) {{ 'active' }} @endif"
                        href="{{ route('pages.index') }}">
                        <i class="fa-solid fa fa-file"></i>
                        <span data-key="t-dashboards">Pages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if (request()->routeIs('Inquiry.index')) {{ 'active' }} @endif"
                        href="{{ route('Inquiry.index') }}">
                        <i class="fa-solid fa-circle-question"></i>
                        <span data-key="t-dashboards">Inquiry</span>
                    </a>
                </li>

                


                <li class="nav-item">
                    <a class="nav-link menu-link @if (request()->routeIs('setting.index')) {{ 'active' }} @endif"
                        href="{{ route('setting.index') }}">
                        <i class="fa-solid fa-gear"></i>
                        <span data-key="t-dashboards">Settings</span>
                    </a>
                </li>



            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>