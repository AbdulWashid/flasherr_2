@extends('user.layouts.master')

@section('title', 'USDT Sale Details')

@section('content')

    <div class="page-content">
        <section class="content-inner-2 bg-light" style="padding-top: 80px;">
            <div class="container">
                <div class="row justify-content-center">
                    {{-- Sale Details Card --}}
                    <div class="col-lg-8 col-md-10 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card shadow-sm border-0 rounded-4 mb-4">
                            <div class="card-header bg-primary text-white text-center rounded-top-4 py-3">
                                <h4 class="mb-0">Sale Listing #{{ $sale->id }}</h4>
                            </div>
                            <div class="card-body p-4">
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Available Quantity:</div>
                                    <div class="col-sm-8 h5 text-primary">
                                        {{ rtrim(rtrim(number_format($sale->quantity, 8), '0'), '.') }} USDT</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Seller:</div>
                                    <div class="col-sm-8 h5">
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
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Status:</div>
                                    <div class="col-sm-8">
                                        @php
                                            $badgeClass =
                                                $sale->status == 'sold' ? 'bg-success' : 'bg-warning text-dark';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($sale->status) }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 text-muted">Listed On:</div>
                                    <div class="col-sm-8">{{ $sale->created_at->format('d M, Y') }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="text-center">
                            <button id="proceedToBuyBtn" class="btn btn-primary btn-lg me-3">Proceed to Buy</button>
                            <a href="{{ route('buy') }}" class="btn btn-secondary btn-lg">Back to
                                Sales</a>
                        </div>
                    </div>

                    {{-- Buyer Information Form (Initially Hidden) --}}
                    <div id="buyFormContainer" class="col-lg-8 col-md-10 wow fadeInUp" data-wow-delay="0.4s"
                        style="display: none; margin-top: 30px;">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-header bg-dark text-white text-center rounded-top-4 py-3">
                                <h4 class="mb-0">Buyer Information</h4>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('buy.request.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="sale_id" value="{{ $sale->id }}">

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
                                        <label for="phone_number" class="form-label">Mobile Number</label>
                                        <input type="tel"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                            placeholder="Enter your mobile number" required>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="wallet_address" class="form-label">Your USDT Wallet Address</label>
                                        <input type="text"
                                            class="form-control @error('wallet_address') is-invalid @enderror"
                                            id="wallet_address" name="wallet_address" value="{{ old('wallet_address') }}"
                                            placeholder="Enter the address to receive USDT" required>
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
                                        <div class="form-text">
                                            Maximum available:
                                            {{ rtrim(rtrim(number_format($sale->quantity, 8), '0'), '.') }} USDT
                                        </div>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-success btn-lg">Submit Purchase
                                            Request</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const proceedBtn = document.getElementById('proceedToBuyBtn');
            const buyFormContainer = document.getElementById('buyFormContainer');
            const nameInput = document.getElementById('name');

            proceedBtn.addEventListener('click', function() {
                // Hide the details card and button to avoid clutter
                const detailsCard = document.querySelector('.card');
                this.style.display = 'none'; // Hide the "Proceed to Buy" button
                document.querySelector('a.btn-secondary').style.display = 'none'; // Hide "Back to Sales"

                // Show the form
                buyFormContainer.style.display = 'block';

                // Scroll to the form and focus on the first input field for better UX
                buyFormContainer.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                setTimeout(() => nameInput.focus(), 500); // Small delay for scroll to finish
            });

            // If there are validation errors on page load, the form should be visible
            @if($errors->any())
                buyFormContainer.style.display = 'block';
                const detailsCard = document.querySelector('.card');
                proceedBtn.style.display = 'none';
                document.querySelector('a.btn-secondary').style.display = 'none';
            @endif
        });
    </script>
@endpush
