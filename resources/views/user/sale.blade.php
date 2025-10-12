@extends('user.layouts.master')

@section('title', 'USDT Sale Request')

@section('content')
    <div class="page-content bg-light">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card border-0 shadow-lg p-4 p-md-5 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body">
                            <h1 class="card-title text-center fw-bold mb-3">
                                Request to Sell <span class="text-primary">USDT</span>
                            </h1>
                            <p class="card-text text-center text-muted mb-4">
                                Fill out the form below to submit your USDT sale request. Our team will review it shortly.
                            </p>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @error('form')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                            <form action="{{ route('sale.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="John Doe"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="you@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="tel" name="phone_number" id="phone_number"
                                        value="{{ old('phone_number') }}"
                                        class="form-control @error('phone_number') is-invalid @enderror"
                                        placeholder="+1234567890" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="whatsapp_number" class="form-label">WhatsApp Number (Optional)</label>
                                    <input type="tel" name="whatsapp_number" id="whatsapp_number"
                                        value="{{ old('whatsapp_number') }}"
                                        class="form-control @error('whatsapp_number') is-invalid @enderror"
                                        placeholder="+1234567890">
                                    @error('whatsapp_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="wallet_address" class="form-label">USDT Wallet Address</label>
                                    <input type="text" name="wallet_address" id="wallet_address"
                                        value="{{ old('wallet_address') }}"
                                        class="form-control @error('wallet_address') is-invalid @enderror"
                                        placeholder="Wallet Address" required>
                                    @error('wallet_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="quantity" class="form-label">Quantity of USDT to Sell</label>
                                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}"
                                            step="0.01" min="1"
                                            class="form-control @error('quantity') is-invalid @enderror"
                                            placeholder="e.g., 100.00" required>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="min_selling_qty" class="form-label">Minimum Selling Quantity</label>
                                    <input type="number" id="min_selling_qty" value="10.00" class="form-control">
                                </div>

                                <div class="mb-4">
                                    <label for="documents" class="form-label">Upload Identification Documents (for Verification)</label>
                                    <input type="file" name="documents[]" id="documents" multiple
                                        class="form-control @error('documents') is-invalid @enderror @error('documents.*') is-invalid @enderror">
                                    <div class="form-text">Please upload images or PDFs of your ID for verification (e.g.,
                                        Passport, Driver's License).</div>
                                    @error('documents')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('documents.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        Submit Sale Request
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush

@push('styles')
    <style>
        .wow {
            visibility: hidden;
        }

        .wow.animated {
            visibility: visible;
        }
    </style>
@endpush
