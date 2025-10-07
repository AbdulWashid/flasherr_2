<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords"
        content="USDT, Tether, Buy USDT, Sell USDT, USDT trading, Flasherr, Crypto exchange, USDT to INR, INR to USDT">
    <meta name="author" content="Flasherr">
    <meta name="robots" content="index, follow">
    <meta name="description"
        content="Flasherr - Fast and secure platform to buy and sell USDT (Tether). Trade USDT instantly with INR at the best market rates.">

    <meta property="og:title" content="Flasherr - Buy & Sell USDT Instantly">
    <meta property="og:description"
        content="Trade USDT (Tether) quickly and securely on Flasherr. Buy or sell USDT with INR at the best market prices.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ URL::to('/') }}">
    <meta property="og:image" content="{{ URL::to('user/images/favicon.png') }}">


    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title -->
    <title>Flasherr | @yield('title')</title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" href="{{ asset('user/images/favicon.png') }}">

    <!-- Stylesheet -->
    <link href="{{ asset('user/vendor/animate/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('user/vendor/magnific-popup/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('user/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    @stack('styles')

</head>

<body>
    <div id="loading-area" class="loading-page-1">
        <div class="loader">
            <div class="border one"></div>
            <div class="border two"></div>
            <div class="border three"></div>
            <div class="border four"></div>
            <div class="border five"></div>
            <div class="border six"></div>
            <div class="border seven"></div>
            <div class="border eight"></div>
            <div class="border nine"></div>
        </div>
    </div>

    <div class="page-wraper">

        @include('user.layouts.header')
        @yield('content')
        @include('user.layouts.footer')

        <button class="scroltop icon-up" type="button"><i class="fas fa-arrow-up"></i></button>
    </div>
    <!-- JAVASCRIPT FILES ========================================= -->
    <script src="{{ asset('user/js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->
    <script src="{{ asset('user/vendor/wow/wow.js') }}"></script><!-- WOW.JS -->
    <script src="{{ asset('user/vendor/swiper/swiper-bundle.min.js') }}"></script><!-- OWL silder -->
    <script src="{{ asset('user/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script><!-- WOW.JS -->
    <script src="{{ asset('user/vendor/skrollr/skrollr.js') }}"></script><!-- OWL SLIDER -->
    <script src="{{ asset('user/vendor/magnific-popup/magnific-popup.js') }}"></script><!-- OWL SLIDER -->
    <script src="{{ asset('user/js/dz.carousel.js') }}"></script><!-- OWL SLIDER -->
    <script src="{{ asset('user/js/dz.ajax.js') }}"></script><!-- AJAX -->
    <script src="{{ asset('user/js/custom.js') }}"></script><!-- CUSTOM JS -->
    <script>
        var s = skrollr.init({
            edgeStrategy: 'set',
            forceHeight: false,
            easing: {
                WTF: Math.random,
                inverted: function(p) {
                    return 1 - p;
                }
            }
        });

        // disable skrollr if the window is resized below 960px wide
        jQuery(window).on('load resize', function() {
            skrollr.init({
                forceHeight: false
            });

            if (jQuery(window).width() > 300) {
                skrollr.init({
                    forceHeight: false
                });
            } else {
                skrollr.init().destroy(); // skrollr.init() returns the singleton created above
            }

            jQuery('.skrollr-mobile, .skrollr-mobile > body').removeAttr('style');
        });
    </script>
    @stack('scripts')
    @include('sweetalert::alert')
</body>

</html>
