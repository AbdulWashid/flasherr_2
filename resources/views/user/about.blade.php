@extends('user.layouts.master')

@section('title', 'About Us')

@section('content')
    <div class="page-content">

        <div class="dz-bnr-inr dz-bnr-inr-sm text-center position-relative"
            style="background-image:url('{{ asset('user/images/background/bg2.jpg') }}');">
            <div class="container">
                <div class="dz-bnr-inr-entry">
                    <h1>About Us</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-row m-t15">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About Us</li>
                        </ul>
                    </nav>
                </div>
            </div>
            <img class="shape1" src="{{ asset('user/images/home-banner/shape1.svg') }}" alt="">
        </div>
        <section class="content-inner-1 content-bx style-1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 m-b30 ">
                        <div class="dz-media">
                            <img src="{{ asset('user/images/about/pic1.jpg') }}" alt="image" class="rounded">
                        </div>
                    </div>
                    <div class="col-lg-6 m-b30">
                        <div class="inner-content">
                            <div class="section-head">
                                <h3 class="title wow fadeInUp" data-wow-delay="0.6s">About Us</h3>
                                <p class="font-text wow fadeInUp" data-wow-delay="0.8s">
                                    At {{ $domainName }}, we’re building the world’s first crypto platform where buyers
                                    and sellers can trade both online and offline with complete security and transparency.
                                </p>
                                <p class="wow fadeInUp" data-wow-delay="1.0s">
                                    Every verified user provides proper ID proof — including passport, contact number,
                                    WhatsApp backup, wallet screenshots, and screen recordings — to ensure real and trusted
                                    connections.
                                </p>
                                <p class="wow fadeInUp" data-wow-delay="1.2s">
                                    We guarantee a 100% refund policy if you’re not satisfied with any transaction, making
                                    your trading experience completely risk-free.
                                </p>
                                <p class="wow fadeInUp" data-wow-delay="1.4s">
                                    Our platform also offers the world’s cheapest rates for popular cryptos like USDT,
                                    giving you maximum value with minimum cost.
                                </p>
                                <h5 class="wow fadeInUp" data-wow-delay="1.6s" style="font-style: italic;">
                                    {{ $domainName }} — Where real people trade real crypto, safely and affordably.
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="content-inner bg-light overflow-hidden">
            <div class="container">
                <div class="section-head">
                    <h3 class="title text-center wow fadeInUp" data-wow-delay="1.0s">Awesome Service<br> that Works for You!</h3>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 m-b30">
                        <div class="icon-bx-wraper style-2 box-hover text-center wow fadeInUp" data-wow-delay="1.0s">
                            <div class="icon-media p-tb15">
                                <img src="{{ asset('user/images/icons/icon6.svg') }}" alt="">
                            </div>
                            <div class="icon-content">
                                <h4 class="title p-t15">Instant Trading</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesg indtrysum has been the Ipsum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 m-b30">
                        <div class="icon-bx-wraper style-2 box-hover text-center wow fadeInUp" data-wow-delay="1.2s">
                            <div class="icon-media p-tb15">
                                <img src="{{ asset('user/images/icons/icon7.svg') }}" alt="">
                            </div>
                            <div class="icon-content">
                                <h4 class="title p-t15">Recurring Buying</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesg indtrysum has been the Ipsum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 m-b30">
                        <div class="icon-bx-wraper style-2 box-hover text-center wow fadeInUp" data-wow-delay="1.4s">
                            <div class="icon-media p-tb15">
                                <img src="{{ asset('user/images/icons/icon8.svg') }}" alt="">
                            </div>
                            <div class="icon-content">
                                <h4 class="title p-t15">Safe And Secure</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesg indtrysum has been the Ipsum.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-bx style-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 ">
                        <div class="inner-content ">
                            <div class="section-head">
                                <h3 class="title wow fadeInUp" data-wow-delay="0.2s">Our Mission</h3>
                                <p class="font-text text-dark font-w500 wow fadeInUp" data-wow-delay="0.4s">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit perferendis aliquam, ducimus explicabo voluptas odit.</p>
                                <p class="wow fadeInUp" data-wow-delay="0.6s">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                            </div>
                            <a href="#" class="btn btn-primary m-r30 wow fadeInUp" data-wow-delay="0.8s">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dz-media inner-content wow bounceInRight rounded" data-wow-delay="1.0s">
                            <img src="{{ asset('user/images/about/pic2.jpg') }}" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </div>
@endsection
