@extends('user.layouts.master')

@section('title', 'Buy USDT')

@section('content')

    <div class="page-content">
        <section class="content-inner-2 bg-light" style="padding-top: 80px;">
            <div class="container">
                <div class="row justify-content-center">

                    {{-- Buyer Information Form --}}
                    <div class="col-lg-8 col-md-10 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-header bg-primary text-white text-center rounded-top-4 py-3">
                                <h4 class="mb-0">Purchase USDT</h4>
                                <p class="mb-0 small fw-light">Complete the form to buy from Listing #{{ $sale->id }}
                                </p>
                            </div>
                            <div class="card-body p-4">

                                {{-- Contextual Information --}}
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
                                        <span
                                            class="fw-bold text-primary">{{ rtrim(rtrim(number_format($sale->quantity, 8), '0'), '.') }}
                                            USDT</span>
                                    </div>
                                </div>


                                <form action="{{ route('buy.request.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                                    {{-- Personal Information --}}
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
                                        <input type="tel"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                            placeholder="Enter your mobile number" required>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Address Information --}}
                                    <hr class="my-4">
                                    <h5 class="mb-3">Address Information</h5>
                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <select class="form-select @error('country') is-invalid @enderror" id="country"
                                            name="country" required>
                                            <option value="" selected disabled>-- Select Your Country --</option>
                                            <option value="IN" {{ old('country') == 'IN' ? 'selected' : '' }}>India
                                            </option>
                                            <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United
                                                States</option>
                                            <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>United
                                                Kingdom</option>
                                            {{-- Add other countries as needed --}}
                                        </select>
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                                id="city" name="city" value="{{ old('city') }}"
                                                placeholder="e.g., New Delhi" required>
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Street Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                            placeholder="1234 Main St, Apartment, studio, or floor" required>{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    {{-- Purchase Details --}}
                                    <hr class="my-4">
                                    <h5 class="mb-3">Purchase Details</h5>
                                    <div class="mb-3">
                                        <label for="network_type" class="form-label">USDT Network Type</label>
                                        <select class="form-select @error('network_type') is-invalid @enderror"
                                            id="network_type" name="network_type" required>
                                            <option value="" selected disabled>-- Select Network --</option>
                                            <option value="trc20" {{ old('network_type') == 'trc20' ? 'selected' : '' }}>
                                                TRC20 (Tron)</option>
                                            <option value="bep20" {{ old('network_type') == 'bep20' ? 'selected' : '' }}>
                                                BEP20 (BNB Smart Chain)</option>
                                            <option value="erc20" {{ old('network_type') == 'erc20' ? 'selected' : '' }}>
                                                ERC20 (Ethereum)</option>
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
                                            value="{{ old('wallet_address') }}"
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
                                        <div class="form-text">Maximum available:
                                            {{ rtrim(rtrim(number_format($sale->quantity, 8), '0'), '.') }} USDT</div>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Document Uploads --}}
                                    <hr class="my-4">
                                    <h5 class="mb-3">KYC Documents</h5>
                                    <div class="mb-3">
                                        <label for="document" class="form-label">Identification Document</label>
                                        <input class="form-control @error('document') is-invalid @enderror" type="file"
                                            id="document" name="document" required>
                                        <div class="form-text">e.g., Passport, National ID Card, Driver's License.</div>
                                        @error('document')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="photo" class="form-label">Your Photo (Selfie)</label>
                                        <input class="form-control @error('photo') is-invalid @enderror" type="file"
                                            id="photo" name="photo" required>
                                        <div class="form-text">A clear, recent photo of yourself.</div>
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="address_proof" class="form-label">Address Proof</label>
                                        <input class="form-control @error('address_proof') is-invalid @enderror"
                                            type="file" id="address_proof" name="address_proof" required>
                                        <div class="form-text">e.g., Utility bill, bank statement (not older than 3
                                            months).</div>
                                        @error('address_proof')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4 pt-2">
                                        <button type="submit" class="btn btn-success btn-lg px-4">Submit Purchase
                                            Request</button>
                                        <a href="{{ route('buy') }}" class="btn btn-secondary btn-lg px-4">Cancel</a>
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
    {{-- Scripts are no longer required for this page's functionality --}}
@endpush
