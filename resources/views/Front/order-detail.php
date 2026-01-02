<!doctype html>
<html class="no-js" lang="en">



<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Tongue Twister</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS 
    ========================= -->
    <!--bootstrap min css-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!--owl carousel min css-->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <!--slick min css-->
    <link rel="stylesheet" href="assets/css/slick.css">
    <!--magnific popup min css-->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <!--font awesome css-->
    <link rel="stylesheet" href="assets/css/font.awesome.css">
    <!--ionicons css-->
    <link rel="stylesheet" href="assets/css/ionicons.min.css">
    <!--linearicons css-->
    <link rel="stylesheet" href="assets/css/linearicons.css">
    <!--animate css-->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!--jquery ui min css-->
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <!--slinky menu css-->
    <link rel="stylesheet" href="assets/css/slinky.menu.css">
    <!--plugins css-->
    <link rel="stylesheet" href="assets/css/plugins.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!--modernizr min js here-->
    <script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>
</head>

<body>
<?php include 'header.php';?>
<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h3>My Account</h3>
                        <ul>
                            <li><a href="index.html">home</a></li>
                            <li>My Account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->

    <!-- my account start  -->
    <section class="main_content_area">
        <div class="container">   
            <div class="account_dashboard">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <!-- Nav tabs -->
                        <div class="dashboard_tab_button">
                            <ul class="nav flex-column dashboard-list" >
                                <li><a href="#dashboard"  class="nav-link active">Dashboard</a></li>
                                <li> <a href="#orders"  class="nav-link">Orders</a></li>
                                
                                <li><a href="#address"  class="nav-link">Addresses</a></li>
                                <li><a href="#account-details"  class="nav-link">Account details</a></li>
                                <li><a href="login.html" class="nav-link">logout</a></li>
                            </ul>
                        </div>    
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            
                            <div class=" " id="orders-detail">
                                <h3>Orders</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Order Date</th>
                                                <th>Product Name</th>
                                                <th>Product Image</th>
                                                <th>QTY</th>
                                                <th>Ammount</th>	 	 	 	
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="min-width:100px">1</td>
                                                <td>May 10, 2018</td>
                                                <td><span class="success">Til Gotli Mukhwas</span></td>
                                                <td><img src="assets/img/product/tilgotli.jpg" /></td>
                                                <td style="width:50px">1  </td>
                                                <td>₹ 25.00 </td>
                                            </tr>
                                            <tr>
                                            <td>2</td>
                                                <td>May 10, 2018</td>
                                                <td><span class="success">Sun Flower Seeds</span></td>
                                                <td><img src="assets/img/product/sunflowerseeds.jpg" /></td>
                                                <td>1  </td>
                                                <td>₹ 38.00 </td>
                                            </tr>
                                            <tr><td colspan="5" class="text-right">Total Ammount</td><td>₹ 63.00</td></tr>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>  
        </div>        	
    </section>			
    <!-- my account end   --> 

     <?php include 'footer.php';?>

</body>
</html>