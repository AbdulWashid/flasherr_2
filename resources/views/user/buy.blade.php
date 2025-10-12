@extends('user.layouts.master')

@section('title', 'Available USDT Sales')

@section('content')

    <div class="page-content">
        <!-- Main Banner Section - Similar to your homepage banner -->
        {{-- <div class="main-bnr style-1" style="background-image: url('{{ asset('user/images/background/bg2.jpg') }}');">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="text-white wow fadeInUp" data-wow-delay="0.2s">Explore <span class="text-line">USDT</span> for Sale</h1>
                        <p class="text-white wow fadeInUp" data-wow-delay="0.4s">
                            Connect directly with sellers for instant USDT transactions.
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Sales Grid Section -->
        <section class="content-inner-2 coins-wrapper bg-light overflow-hidden">
            <div class="container">
                <div class="section-head text-center wow fadeInUp" data-wow-delay="0.2s">
                    <h2 class="title">Available <span class="text-primary">USDT</span> Listings</h2>
                    <p>Browse through the latest USDT listings from our trusted sellers.</p>
                </div>

                <div class="row justify-content-center">
                    @forelse ($sales as $sale)
                        <div class="col-xl-4 col-md-6 m-b30 bordered">
                            <div class="icon-bx-wraper style-1 box-hover text-center wow fadeInUp" data-wow-delay="0.{{ $loop->iteration + 2 }}s">
                                <div class="icon-media m-b20">
                                    <img src="{{ asset('user/images/coins/coin3.png') }}" alt="USDT Coin">
                                </div>
                                <div class="icon-content">
                                    <h4 class="title">Quantity: <span class="text-primary">{{ rtrim(rtrim(number_format($sale->quantity, 8), '0'), '.') }} USDT</span></h4>
                                    <p class="font-16 m-b10">
                                        Seller: {{ $sale->saleRequest->name }}
                                        @if ($sale->is_verified)
                                            <span class="text-success ms-1" title="Verified Seller">
                                                {{-- Bootstrap Icon for a checkmark --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-check-fill align-text-bottom" viewBox="0 0 16 16">
                                                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                                </svg>
                                            </span>
                                        @endif
                                    </p>
                                    <p class="text-muted">Listed: {{ $sale->created_at->diffForHumans() }}</p>
                                    {{-- Link to a more detailed page for the sale --}}
                                    <a href="{{ route('buy.detail', $sale->id) }}" class="btn btn-primary btn-sm m-t20">
                                        View Details <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Message when no sales are available --}}
                        <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.6s">
                            <img src="{{ asset('user/images/no-data.png') }}" alt="No sales found" class="img-fluid m-b20" style="max-width: 300px;">
                            <h4 class="title">No USDT sales currently available.</h4>
                            <p>We are actively sourcing new listings. Please check back soon!</p>
                            <a href="{{ route('home') }}" class="btn btn-primary m-t30">Back to Home</a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination Links --}}
                <div class="row m-t50 wow fadeInUp" data-wow-delay="1.0s">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $sales->links('pagination::bootstrap-5') }} {{-- Using Bootstrap 5 for pagination styling --}}
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@push('scripts')
    {{-- Any page-specific scripts for this view, if needed --}}
@endpush
@push('styles')
    <style>
        .icon-bx-wraper.style-1:hover{
            background: linear-gradient(180deg, #74b5db 0%, rgba(233, 247, 255, 0.1) 100%);
        }
    </style>
@endpush
