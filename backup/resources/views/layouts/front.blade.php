<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
<?php header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0 "); // Proxies.
?>
@include('common.fronthead')

<body id="page-top">



    @include('common.frontheader')


    @yield('content')

    @include('common.frontfooter')

    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    @include('common.frontfooterjs')

    @yield('scripts')


</body>



</html>
