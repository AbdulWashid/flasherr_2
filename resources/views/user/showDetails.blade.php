@extends('user.layouts.master')

@section('title', 'Buy USDT')

@section('content')
<div class="page-content">
    <section class="content-inner-2 bg-light" style="padding-top: 80px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-primary text-white text-center rounded-top-4 py-3">
                            <h4 class="mb-0">USDT Sale Details</h4>
                            <p class="mb-0 small fw-light">Listing #{{ $sale->id }}</p>
                        </div>

                        {{-- =========================
                             SALE DETAILS SECTION
                        ========================== --}}
                        <div class="card-body p-4" id="saleDetailsSection">
                            <div class="alert alert-secondary bg-light border-2 mb-4">
                                <div class="d-flex justify-content-between">
                                    <strong>Seller:</strong>
                                    <span>
                                        {{ $sale->saleRequest->name }}
                                        @if ($sale->is_verified)
                                            <span class="text-success ms-1" title="Verified Seller">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-patch-check-fill align-text-bottom"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                                </svg>
                                            </span>
                                        @endif
                                    </span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between">
                                    <strong>Available to Buy:</strong>
                                    <span class="fw-bold text-primary">
                                        {{ rtrim(rtrim(number_format($sale->quantity, 8), '0'), '.') }} USDT
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <strong>Rate:</strong>
                                    <span class="fw-bold text-success">{{ number_format($sale->saleRequest->rate, 2) }} INR</span>
                                </div>
                            </div>

                            <div class="text-center">
                                <button id="proceedBtn" class="btn btn-success btn-lg px-4">
                                    Proceed to Buy
                                </button>
                                <a href="{{ route('buy') }}" class="btn btn-secondary btn-lg px-4">
                                    Cancel
                                </a>
                            </div>
                        </div>

                        {{-- =========================
                             PURCHASE FORM SECTION
                        ========================== --}}
                        <div class="card-body p-4 d-none" id="buyFormSection">
                            <form action="{{ route('buy.request.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                                <h5 class="mb-3">Personal Information</h5>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Enter your full name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="you@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Mobile Number</label>
                                    <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                                        id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                        placeholder="Enter your mobile number" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr class="my-4">
                                <h5 class="mb-3">Purchase Details</h5>

                                <div class="mb-3">
                                    <label for="network_type" class="form-label">USDT Network Type</label>
                                    <select class="form-select @error('network_type') is-invalid @enderror"
                                        id="network_type" name="network_type" required>
                                        <option value="" selected disabled>-- Select Network --</option>
                                        <option value="trc20">TRC20 (Tron)</option>
                                        <option value="bep20">BEP20 (BNB Smart Chain)</option>
                                        <option value="erc20">ERC20 (Ethereum)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="wallet_address" class="form-label">Your USDT Wallet Address</label>
                                    <input type="text" class="form-control" id="wallet_address" name="wallet_address"
                                        value="{{ old('wallet_address') }}" placeholder="Enter your USDT wallet" required>
                                </div>

                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Required Quantity</label>
                                    <input type="number" step="0.00000001" class="form-control" id="quantity"
                                        name="quantity" value="{{ old('quantity') }}" placeholder="e.g., 500.00" required>
                                    <div class="form-text">Maximum available:
                                        {{ rtrim(rtrim(number_format($sale->quantity, 8), '0'), '.') }} USDT
                                    </div>
                                </div>

                                <div class="text-center mt-4 pt-2">
                                    <button type="submit" class="btn btn-success btn-lg px-4">Submit Purchase Request</button>
                                    <button type="button" id="backBtn" class="btn btn-outline-secondary btn-lg px-4">
                                        Back to Details
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#proceedBtn').click(function() {
            $('#saleDetailsSection').slideUp(300);
            $('#buyFormSection').removeClass('d-none').hide().slideDown(400);
        });

        $('#backBtn').click(function() {
            $('#buyFormSection').slideUp(300, function() {
                $('#saleDetailsSection').slideDown(400);
            });
        });
    });
</script>
@endpush
