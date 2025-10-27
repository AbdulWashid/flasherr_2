@extends('user.layouts.master')

@section('title', 'Home')

@section('content')

    <div class="page-content">
        <div class="main-bnr">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-7 col-md-6">
                        <h1 class="wow fadeInUp" data-wow-delay="0.2s">Buy & Sell <span class="text-line">USDT
                                Instantly</span><br>with Unmatched Speed</h1>
                        <p class="text text-primary wow fadeInUp" data-wow-delay="0.4s">
                            The fastest and most secure way to buy & sell USDT. Powered by Flasherr.
                        </p>

                        <div class="contant-box style-1 wow fadeInUp" data-wow-delay="0.6s">
                            <a href="#buy-sell-btn" class="btn btn-lg  btn-shadow btn-primary m-r30"
                                onclick="scrollToCenter(event)">START</a>
                            {{-- <a class="video-btn style-1 popup-youtube" href="https://www.youtube.com/watch?v=cfmQFW1DpA0">
                                <i class="fa fa-play"></i>
                                <span class="text">How it work</span>
                            </a> --}}
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-6">
                        <div class="banner-media">
                            <img class="media  wow bounceInRight center" data-wow-delay="0.8s"
                                src="{{ asset('user/images/home-banner/shape/digitalwallet.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <img class="shape1" src="{{ asset('user/images/home-banner/shape1.svg') }}" alt="">
        </div>

        <div class="crypto-wrapper bg-light overflow-hidden" id="buy-sell-btn">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 m-b30">
                        <div class="crypto-box wow fadeInUp buy-btn" data-wow-delay="1.0s">
                            <div class="crypto-media">
                                <img src="{{ asset('user/images/coins/coin7.png') }}" alt="">
                            </div>
                            <div class="crypto-info">
                                <h5>Buy USDT</h5>
                                <a href="{{ route('buy') }}" class="btn btn-square btn-primary ">

                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.1665 10H15.8332" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M10 4.16666L15.8333 9.99999L10 15.8333" stroke="white" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 m-b30">
                        <div class="crypto-box wow fadeInUp sell-btn" data-wow-delay="1.2s">
                            <div class="crypto-media">
                                <img src="{{ asset('user/images/coins/coin3.png') }}" alt="">
                            </div>
                            <div class="crypto-info">
                                <h5>Sell USDT</h5>
                                <a href="{{ route('sale') }}" class="btn btn-square btn-primary">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.1665 10H15.8332" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M10 4.16666L15.8333 9.99999L10 15.8333" stroke="white" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="content-inner coins-wrapper bg-light overflow-hidden">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 m-b30">
                        <div class="section-head wow fadeInUp" data-wow-delay="0.2s">
                            <h2 class="title">With <span class="text-primary">Flasherr</span><br> buy famous crypto coins
                                easily</h2>
                        </div>
                        <h5 class="sub-title text-primary wow fadeInUp" data-wow-delay="0.4s">Get started in a few minutes
                        </h5>
                        <ul class="list-style-1">
                            <li class="wow fadeInUp" data-wow-delay="0.6s">Create and verify your account in minutes</li>
                            <li class="wow fadeInUp" data-wow-delay="0.8s">Securely transfer funds from your bank</li>
                            <li class="wow fadeInUp" data-wow-delay="1.0s">Buy or sell USDT and other crypto easily</li>
                        </ul>
                        <a href="https://finlab.dexignlab.com/xhtml/crypto.html"
                            class="btn btn-lg  btn-shadow btn-primary wow fadeInUp" data-wow-delay="1.2s" target="blank">BUY
                            USDT NOW</a>
                    </div>
                    <div class="col-lg-6 m-b30">
                        <div class="coins-media-wrapper">
                            <div class="main-circle1">
                                <div class="circle-box" data-350="transform:scale(0) rotate(0deg);"
                                    data-550="transform:scale(1) rotate(360deg);"></div>
                                <ul class="coin-list">
                                    <li data-400="left: 50%; top:50%; transform: scale(0);"
                                        data-700="transform: scale(1); left:1.5%; top:50%;"><img
                                            src="{{ asset('user/images/coins/coin8.png') }}" alt=""></li>
                                    <li data-420="left: 50%; top:50%; transform: scale(0);"
                                        data-700="transform: scale(1); left: 16%; top:16%;"><img
                                            src="{{ asset('user/images/coins/coin2.png') }}" alt=""></li>
                                    <li data-440="left: 50%; top:50%; transform: scale(0);"
                                        data-700="transform: scale(1); left: 50%; top:1.5%;"><img
                                            src="{{ asset('user/images/coins/coin3.png') }}" alt=""></li>
                                    <li data-460="left: 50%; top:50%; transform: scale(0);"
                                        data-700="transform: scale(1); left: 84%; top:16%;"><img
                                            src="{{ asset('user/images/coins/coin4.png') }}" alt=""></li>
                                    <li data-480="left: 50%; top:50%; transform: scale(0);"
                                        data-700="transform: scale(1); left: 98%; top:50%;"><img
                                            src="{{ asset('user/images/coins/coin5.png') }}" alt=""></li>
                                    <li data-500="left: 50%; top:50%; transform: scale(0);"
                                        data-700="transform: scale(1); left: 84%; top:84%;"><img
                                            src="{{ asset('user/images/coins/coin1.png') }}" alt=""></li>
                                    <li data-520="left: 50%; top:50%; transform: scale(0);"
                                        data-700="transform: scale(1); left: 50%; top:98%;"><img
                                            src="{{ asset('user/images/coins/coin6.png') }}" alt=""></li>
                                    <li data-540="left: 50%; top:50%; transform: scale(0);"
                                        data-700="transform: scale(1); left: 16%; top:84%;"><img
                                            src="{{ asset('user/images/coins/coin7.png') }}" alt=""></li>
                                </ul>
                            </div>
                            <div class="center-media">
                                <img data-350="transform:scale(0) rotate(0deg);"
                                    data-550="transform:scale(1) rotate(360deg);"
                                    src="{{ asset('user/images/logo-icon.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="coin-wave">
                <div class="flex-coin1" data-400="transform:translateY(500px); opacity:0;"
                    data-800="transform:translateY(0); opacity:1;">
                    <img src="{{ asset('user/images/coins/coin2.png') }}" alt="">
                </div>
                <div class="flex-coin2" data-350="transform:translateY(200px); opacity:0;"
                    data-750="transform:translateY(0); opacity:1;">
                    <img src="{{ asset('user/images/coins/coin4.png') }}" alt="">
                </div>
                <div class="flex-coin3" data-400="transform:translateY(300px); opacity:0;"
                    data-800="transform:translateY(0); opacity:1;">
                    <img src="{{ asset('user/images/coins/coin1.png') }}" alt="">
                </div>
                <div class="flex-coin4" data-300="transform:translateY(350px); opacity:0;"
                    data-700="transform:translateY(0); opacity:1;">
                    <img src="{{ asset('user/images/coins/coin3.png') }}" alt="">
                </div>
                <div class="flex-coin5" data-400="transform:translateY(300px); opacity:0;"
                    data-800="transform:translateY(0); opacity:1;">
                    <img src="{{ asset('user/images/coins/coin5.png') }}" alt="">
                </div>
            </div>
        </section>

        <section class="content-inner-2 content-bx style-1 ">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 m-b30 ">
                        <div class="dz-media">
                            <img src="{{ asset('user/images/about/pic1.jpg') }}" alt="image" class="rounded">
                            <div class="content-box wow bounceInLeft" data-wow-delay="0.6s">
                                <h6 class="m-a0">Access real-time analytical <br>market & price data for USDT</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 m-b30">
                        <div class="inner-content">
                            <div class="section-head">
                                <h3 class="title wow fadeInUp" data-wow-delay="0.6s">The World’s 1st ICO <br>Platform That
                                    Offers<br> Rewards</h3>
                                <p class="font-text wow fadeInUp" data-wow-delay="0.8s">Discover exclusive ICO opportunities and earn rewards. Our platform provides in-depth analysis to help you make informed decisions in the crypto market.</p>
                            </div>

                            <div class="contant-box style-1 p-t60" data-wow-delay="1.0s">
                                <a href="contact-us.html" class="btn btn-primary m-r30">PURCHASE TOKENS</a>
                                <a class="video-btn style-1 popup-youtube"
                                    href="https://www.youtube.com/watch?v=cfmQFW1DpA0">
                                    <i class="fa fa-play"></i>
                                    <span class="text">How it work</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-inner overflow-hidden">
            <div class="container">
                <div class="section-head text-center">
                    <h2 class="title wow fadeInUp" data-wow-delay="0.4s">Why Choose <span class="text-primary">Flasherr</span> for USDT?
                    </h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 m-b30">
                        <div class="icon-bx-wraper style-1 box-hover text-center wow fadeInUp" data-wow-delay="0.6s">
                            <div class="icon-media">
                                <img src="{{ asset('user/images/icons/icon3.svg') }}" alt="">
                            </div>
                            <div class="icon-content">
                                <h4 class="title">Lower fees & no <br>hidden costs</h4>
                                <p>Trade USDT with transparent pricing and minimal fees, maximizing your returns.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 m-b30">
                        <div class="icon-bx-wraper active style-1 box-hover text-center  wow fadeInUp"
                            data-wow-delay="0.8s">
                            <div class="icon-media">
                                <img src="{{ asset('user/images/icons/icon4.svg') }}" alt="">
                            </div>
                            <div class="icon-content">
                                <h4 class="title">Dedicated <br>Multi-language Support</h4>
                                <p>Our team is here to assist you in your preferred language, ensuring a smooth trading experience.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 m-b30 ">
                        <div class="icon-bx-wraper style-1 box-hover text-center wow fadeInUp" data-wow-delay="1.0s">
                            <div class="icon-media">
                                <img src="{{ asset('user/images/icons/icon5.svg') }}" alt="">
                            </div>
                            <div class="icon-content">
                                <h4 class="title">Your Simple Gateway<br> to USDT Trading</h4>
                                <p>Easily access the USDT market with our intuitive platform, designed for all users.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-inner bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-12">
                        <div class="section-head">
                            <h2 class="title wow fadeInUp" data-wow-delay="0.2s">Latest Crypto News</h2>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 m-b30 text-end d-none d-lg-block ">
                        <a href="contact-us.html" class="btn btn-primary wow fadeInUp" data-wow-delay="0.4s">View All
                            News</a>
                    </div>
                </div>
            </div>
            <div class="container position-relative">
                <div class="swiper recent-blog1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="dz-card style-1 wow fadeInUp" data-wow-delay="0.6s"
                                style="background-image:url('{{ asset('user/images/blog/blog-slider/pic1.jpg') }}');">
                                <div class="dz-info">
                                    <div class="dz-meta">
                                        <ul>
                                            <li class="post-author">
                                                <img src="{{ asset('user/images/avatar/avatar1.jpg') }}" alt="">
                                                By Jone Doe
                                            </li>
                                            <li class="post-comments">20 Comments</li>
                                            <li class="post-date">
                                                <span class="day">20</span>
                                                <span class="month">January</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <h5 class="dz-title"><a href="blog-details.html">Five Things To Avoid In
                                                Cryptocurrency.</a></h5>
                                    <p>Nostrud tem exrcitation duis laboris nisi ut aliquip sed duis aute.</p>
                                    <a href="blog-details.html" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="dz-card style-1 wow fadeInUp" data-wow-delay="0.8s"
                                style="background-image:url('{{ asset('user/images/blog/blog-slider/pic2.jpg') }}');">
                                <div class="dz-info">
                                    <div class="dz-meta">
                                        <ul>
                                            <li class="post-author">
                                                <img src="{{ asset('user/images/avatar/avatar2.jpg') }}" alt="">
                                                By Jone Doe
                                            </li>
                                            <li class="post-comments">20 Comments</li>
                                            <li class="post-date">
                                                <span class="day">07</span>
                                                <span class="month">January</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <h5 class="dz-title"><a href="blog-details.html">Things That Make You Love
                                                Cryptocurrency.</a></h5>
                                    <p>Nostrud tem exrcitation duis laboris nisi ut aliquip sed duis aute.</p>
                                    <a href="blog-details.html" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="dz-card style-1 wow fadeInUp" data-wow-delay="1.0s"
                                style="background-image:url('{{ asset('user/images/blog/blog-slider/pic3.jpg') }}');">
                                <div class="dz-info">
                                    <div class="dz-meta">
                                        <ul>
                                            <li class="post-author">
                                                <img src="{{ asset('user/images/avatar/avatar3.jpg') }}" alt="">
                                                By Jone Doe
                                            </li>
                                            <li class="post-comments">20 Comments</li>
                                            <li class="post-date">
                                                <span class="day">24</span>
                                                <span class="month">January</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <h5 class="dz-title"><a href="blog-details.html">Directly support individuals
                                                Crypto</a></h5>
                                    <p>Nostrud tem exrcitation duis laboris nisi ut aliquip sed duis aute.</p>
                                    <a href="blog-details.html" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="dz-card style-1 wow fadeInUp" data-wow-delay="1.2s"
                                style="background-image:url('{{ asset('user/images/blog/blog-slider/pic1.jpg') }}');">
                                <div class="dz-info">
                                    <div class="dz-meta">
                                        <ul>
                                            <li class="post-author">
                                                <img src="{{ asset('user/images/avatar/avatar1.jpg') }}" alt="">
                                                By Jone Doe
                                            </li>
                                            <li class="post-comments">20 Comments</li>
                                            <li class="post-date">
                                                <span class="day">20</span>
                                                <span class="month">January</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <h5 class="dz-title"><a href="blog-details.html">Five Things To Avoid In
                                                Cryptocurrency.</a></h5>
                                    <p>Nostrud tem exrcitation duis laboris nisi ut aliquip sed duis aute.</p>
                                    <a href="blog-details.html" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="dz-card style-1 wow fadeInUp" data-wow-delay="1.6s"
                                style="background-image:url('{{ asset('user/images/blog/blog-slider/pic2.jpg') }}');">
                                <div class="dz-info">
                                    <div class="dz-meta">
                                        <ul>
                                            <li class="post-author">
                                                <img src="{{ asset('user/images/avatar/avatar2.jpg') }}" alt="">
                                                By Jone Doe
                                            </li>
                                            <li class="post-comments">20 Comments</li>
                                            <li class="post-date">
                                                <span class="day">07</span>
                                                <span class="month">January</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <h5 class="dz-title"><a href="blog-details.html">Things That Make You Love
                                                Cryptocurrency.</a></h5>
                                    <p>Nostrud tem exrcitation duis laboris nisi ut aliquip sed duis aute.</p>
                                    <a href="blog-details.html" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="dz-card style-1 wow fadeInUp" data-wow-delay="1.8s"
                                style="background-image:url('{{ asset('user/images/blog/blog-slider/pic3.jpg') }}');">
                                <div class="dz-info">
                                    <div class="dz-meta">
                                        <ul>
                                            <li class="post-author">
                                                <img src="{{ asset('user/images/avatar/avatar3.jpg') }}" alt="">
                                                By Jone Doe
                                            </li>
                                            <li class="post-comments">20 Comments</li>
                                            <li class="post-date">
                                                <span class="day">24</span>
                                                <span class="month">January</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <h5 class="dz-title"><a href="blog-details.html">Directly support individuals
                                                Crypto</a></h5>
                                    <p>Nostrud tem exrcitation duis laboris nisi ut aliquip sed duis aute.</p>
                                    <a href="blog-details.html" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-btn swiper-btn-center-lr">
                    <div class="swiper-button-prev btn-prev style-1"><i class="flaticon-left-arrow-1"></i></div>
                    <div class="swiper-button-next btn-next style-1"><i class="flaticon-next"></i></div>
                </div>
            </div>
        </section>

        <section class=" bg-light call-to-action">
            <div class="container">
                <h2 class="title text-capitalize text-center p-b15 wow fadeInUp" data-wow-delay="0.6s">Cryptocurrency
                    Calculator <br> For Any Kind Of Currency</h2>
                <div class="text-center">
                    <a href="contact-us.html" class="btn btn-primary btn-lg wow fadeInUp" data-wow-delay="0.8s">Try Our
                        Calculator</a>
                </div>
            </div>
        </section>

        <section class="content-inner-3 bg-light">
            <div class="container">
                <div class="swiper clients-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="clients-logo wow fadeInUp" data-wow-delay="0.4s">
                                <a href="javascript:void(0)"><img class="logo-main "
                                        src="{{ asset('user/images/clients-logo/logo1.png') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="clients-logo wow fadeInUp" data-wow-delay="0.6s">
                                <a href="javascript:void(0)"><img class="logo-main "
                                        src="{{ asset('user/images/clients-logo/logo2.png') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="clients-logo wow fadeInUp" data-wow-delay="0.8s">
                                <a href="javascript:void(0)"><img class="logo-main "
                                        src="{{ asset('user/images/clients-logo/logo3.png') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="clients-logo wow fadeInUp" data-wow-delay="0.10s">
                                <a href="javascript:void(0)"><img class="logo-main "
                                        src="{{ asset('user/images/clients-logo/logo4.png') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="clients-logo wow fadeInUp" data-wow-delay="1.0s">
                                <a href="javascript:void(0)"><img class="logo-main "
                                        src="{{ asset('user/images/clients-logo/logo5.png') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="clients-logo wow fadeInUp" data-wow-delay="1.2s">
                                <a href="javascript:void(0)"><img class="logo-main "
                                        src="{{ asset('user/images/clients-logo/logo1.png') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="clients-logo wow fadeInUp" data-wow-delay="1.4s">
                                <a href="javascript:void(0)"><img class="logo-main "
                                        src="{{ asset('user/images/clients-logo/logo1.png') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- footer form --}}
        <section class="bg-primary content-inner-3 form-wrapper1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="section-head wow fadeInUp" data-wow-delay="0.2s">
                            <h6 class="sub-title text-white">JOIN US</h6>
                            <h4 class="title text-white">Stay Updated with Flasherr</h4>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <form class="dzForm" method="POST" action="{{ route('contact.store') }}">
                            <div class="dzFormMsg"></div>
                            <input type="hidden" class="form-control" name="dzToDo" value="Contact">
                            <input type="hidden" class="form-control" name="reCaptchaEnable" value="0">

                            <div class="row g-4 m-b30">
                                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.4s">
                                    <input name="first_name" required="" type="text" class="form-control"
                                        placeholder="First Name">
                                </div>
                                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.6s">
                                    <input name="last_name" required="" type="text" class="form-control"
                                        placeholder="Last Name">
                                </div>
                                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.8s">
                                    <input name="email" required="" type="text" class="form-control"
                                        placeholder="Email Address">
                                </div>
                                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.0s">
                                    <input name="phone_number" required="" type="number" class="form-control"
                                        placeholder="Phone Number">
                                </div>
                                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.2s">
                                    <input name="message" required="" type="text" class="form-control"
                                        placeholder="Your Message">
                                </div>
                                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.4s">
                                    <button name="submit" type="submit" value="Submit"
                                        class="btn btn-dark btn-block w-100 h-100">Subscribe</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        </div>

@endsection
@push('scripts')
    <script>
        function scrollToCenter(event) {
            event.preventDefault();
            const target = document.getElementById("buy-sell-btn");
            target.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });
        }
        $(document).ready(function() {
            $('.buy-btn').click(function(){
                window.location.href = "{{ route('buy') }}";
            });
            $('.sell-btn').click(function(){
                window.location.href = "{{ route('sale') }}";
            });
        });
    </script>
@endpush
