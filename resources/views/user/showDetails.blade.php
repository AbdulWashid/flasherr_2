@extends('user.layouts.master')

@section('title', 'Buy USDT')

@section('content')
    <div class="page-content">
        <section class="content-inner-2 bg-light py-5">
            <div class="container" style="margin-top: 35px;">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="card shadow-lg border-0 rounded-4">
                            <div class="card-header bg-primary text-white text-center rounded-top-4 py-3">
                                <h4 class="mb-0">USDT Purchase Request</h4>
                                <p class="mb-0 small fw-light">Listing #{{ $sale->id }}</p>
                            </div>

                            {{-- =========================
                                SALE DETAILS SECTION (STEP 1)
                            ========================== --}}
                            <div class="card-body p-4" id="saleDetailsSection">
                                <h5 class="card-title text-primary mb-3">Listing Details</h5>
                                <div class="alert alert-secondary bg-light border-2 mb-4">
                                    <div class="d-flex justify-content-between my-2">
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
                                    <div class="d-flex justify-content-between my-2">
                                        <strong>Available to Buy:</strong>
                                        <span class="fw-bold text-primary">
                                            {{ rtrim(rtrim(number_format($sale->quantity, 8), '0'), '.') }} USDT
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between my-2">
                                        <strong>Address:</strong>
                                        <span class="fw-bold text-primary">
                                            {{ $sale->city }}, {{ $sale->state }}, {{ $sale->country }}
                                        </span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between pt-2">
                                        <strong class="h5 mb-0">Price to Unlock:</strong>
                                        <span class="h5 fw-bold text-danger mb-0">
                                            INR {{ number_format($sale->price, 2) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="text-center mt-4 pt-2">
                                    <button id="proceedBtn" class="btn btn-success btn-lg px-4 shadow-sm">
                                        Proceed to Pay
                                    </button>
                                    <a href="{{ route('buy') }}" class="btn btn-secondary btn-lg px-4 shadow-sm">
                                        Cancel
                                    </a>
                                </div>
                            </div>

                            {{-- =========================
                                QR CODE PAYMENT SECTION (STEP 2)
                            ========================== --}}
                            <div class="card-body p-4 d-none" id="paymentQrSection">
                                <h5 class="text-center text-dark mb-4 fw-bold">Scan to Pay (INR)</h5>

                                <div class="alert alert-warning border-2 text-center mb-4">
                                    <p class="mb-0 small fw-bold">Pay the exact amount shown below. This amount is
                                        non-negotiable.</p>
                                </div>

                                <div class="text-center mb-4">
                                    <p class="text-muted mb-1">Amount Due:</p>
                                    <span class="display-6 fw-bold text-danger">
                                        INR {{ number_format($sale->price, 2) }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-center p-3 mb-4 bg-light border rounded-3 shadow-sm">
                                    <div id="qrCodeContainer" class="p-2 border bg-white rounded-3">
                                        {{--
                                            // -----------------------------------------------------
                                            // PHP/Laravel QR Code Generation (Example Logic)
                                            // -----------------------------------------------------
                                            // The QR code would encode the seller's UPI ID/bank details
                                            // and the total INR amount required.
                                        --}}
                                        @php

                                            $totalAmount = $sale->price;
                                            $paymentData =
                                                'upi://pay?pa=' .
                                                $paymentDetail->vpa .
                                                '&am=' .
                                                $totalAmount .
                                                '&cu=INR' .
                                                '&pn=' .
                                                urlencode($sale->saleRequest->name) .
                                                '&tr=' .
                                                urlencode('SALE' . $sale->id);
                                            echo QrCode::size(200)->generate($paymentData);
                                        @endphp
                                    </div>
                                </div>
                                <p class="text-center text-muted small">Scan this code with your payment app (UPI/Bank
                                    Transfer).</p>

                                <div class="text-center mt-4 pt-2">
                                    <button id="paidBtn" class="btn btn-primary btn-lg px-4 shadow-sm">
                                        I Have Paid, Proceed to Submit Proof
                                    </button>
                                    <button type="button" id="backToDetailsBtn"
                                        class="btn btn-outline-secondary btn-lg px-4 shadow-sm">
                                        &larr; Back
                                    </button>
                                </div>
                            </div>

                            {{-- =========================
                                PURCHASE FORM SECTION (STEP 3)
                            ========================== --}}
                            <div class="card-body p-4 d-none" id="purchaseFormSection">
                                <form action="{{ route('buy.request.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                                    {{-- PAYMENT PROOF FIELDS (NEW) --}}
                                    <div class="bg-success-subtle p-3 rounded-3 mb-4 border border-success">
                                        <h5 class="mb-3 fw-bold">1. Payment Verification</h5>

                                        <div class="mb-3">
                                            <label for="transaction_id" class="form-label">Transaction ID / Reference
                                                No.</label>
                                            <input type="text"
                                                class="form-control @error('transaction_id') is-invalid @enderror"
                                                id="transaction_id" name="transaction_id"
                                                value="{{ old('transaction_id') }}"
                                                placeholder="Enter UPI or Bank Transaction ID" required>
                                            @error('transaction_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-0">
                                            <label for="payment_proof" class="form-label">Payment Screenshot</label>
                                            <input class="form-control @error('payment_proof') is-invalid @enderror"
                                                type="file" id="payment_proof" name="payment_proof" accept="image/*"
                                                required>
                                            <div class="form-text">Upload a clear screenshot of your successful payment.
                                            </div>
                                            @error('payment_proof')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- PERSONAL INFORMATION --}}
                                    <h5 class="mb-3 mt-4 border-bottom pb-2">2. Personal Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name') }}"
                                                placeholder="Enter your full name" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email') }}"
                                                placeholder="you@example.com" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone_number" class="form-label">Mobile Number</label>
                                        <input type="tel"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                            placeholder="Enter your mobile number" required>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- PURCHASE DETAILS --}}
                                    <hr class="my-4">
                                    <h5 class="mb-3">3. Purchase Details</h5>
                                    <div class="mb-3">
                                        <label for="network_type" class="form-label">USDT Network Type</label>
                                        <select class="form-select @error('network_type') is-invalid @enderror"
                                            id="network_type" name="network_type" required>
                                            <option value="" selected disabled>-- Select Network --</option>
                                            <option value="trc20" {{ old('network_type') == 'trc20' ? 'selected' : '' }}>
                                                TRC20 (Tron)</option>
                                            <option value="bep20" {{ old('network_type') == 'bep20' ? 'selected' : '' }}>
                                                BEP20 (BNB Smart Chain)
                                            </option>
                                            <option value="erc20" {{ old('network_type') == 'erc20' ? 'selected' : '' }}>
                                                ERC20 (Ethereum)
                                            </option>
                                            <option value="other" {{ old('network_type') == 'other' ? 'selected' : '' }}>
                                                Other
                                            </option>
                                        </select>
                                        @error('network_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="wallet_address" class="form-label">Your USDT Wallet Address</label>
                                        <input type="text"
                                            class="form-control @error('wallet_address') is-invalid @enderror"
                                            id="wallet_address" name="wallet_address"
                                            value="{{ old('wallet_address') }}" placeholder="Enter your USDT wallet"
                                            required>
                                        @error('wallet_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Required Quantity</label>
                                        <input type="number" step="0.00000001"
                                            class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                            name="quantity" value="{{ old('quantity') }}" placeholder="e.g., 500.00"
                                            required>
                                        <div class="form-text">Maximum available:
                                            {{ rtrim(rtrim(number_format($sale->quantity, 8), '0'), '.') }} USDT
                                        </div>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-center mt-5 pt-3 border-top">
                                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">
                                            Confirm & Submit Request
                                        </button>
                                        <button type="button" id="backToQrBtn"
                                            class="btn btn-outline-secondary btn-lg px-4 shadow-sm">
                                            &larr; Back to Payment
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
            const saleDetailsSection = $('#saleDetailsSection');
            const paymentQrSection = $('#paymentQrSection');
            const purchaseFormSection = $('#purchaseFormSection');

            $('#proceedBtn').click(function() {
                saleDetailsSection.slideUp(300, function() {
                    paymentQrSection.removeClass('d-none').hide().slideDown(400);
                });
            });

            $('#paidBtn').click(function() {
                paymentQrSection.slideUp(300, function() {
                    purchaseFormSection.removeClass('d-none').hide().slideDown(400);
                });
            });

            $('#backToDetailsBtn').click(function() {
                paymentQrSection.slideUp(300, function() {
                    saleDetailsSection.slideDown(400);
                });
            });

            $('#backToQrBtn').click(function() {
                purchaseFormSection.slideUp(300, function() {
                    paymentQrSection.slideDown(400);
                });
            });

        });
    </script>
    @if ($errors->any())
        <script>
            $(document).ready(function() {

                $('#saleDetailsSection').hide();
                $('#paymentQrSection').hide();

                $('#purchaseFormSection')
                    .removeClass('d-none')
                    .show();

                setTimeout(function() {
                    let firstError = $('.is-invalid').first();

                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 120
                        }, 700);

                        firstError.addClass('border-danger shadow-sm');
                    }
                }, 300);

            });
        </script>
    @endif
@endpush
