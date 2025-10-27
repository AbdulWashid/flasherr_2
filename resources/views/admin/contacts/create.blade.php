@extends('admin.layouts.master')

@section('title', 'Create Sale')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Add New Sale</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">Sales</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sale Details</h3>
                        </div>
                        <form action="{{ route('admin.sale.store') }}" method="POST">
                            @csrf
                            <div class="card-body">

                                {{-- Sale Request Dropdown --}}
                                <div class="mb-3">
                                    <label for="sale_request_id" class="form-label">Parent Sale Request</label>
                                    <select name="sale_request_id" id="sale_request_id"
                                        class="form-select @error('sale_request_id') is-invalid @enderror"
                                        style="width: 100%;">
                                        <option value="">Select a Sale Request</option>
                                        @foreach ($saleRequests as $saleRequest)
                                            <option value="{{ $saleRequest->id }}"
                                                {{-- Pre-select the correct request if it's passed from the controller --}}
                                                {{ old('sale_request_id', $saleRequestFrom->id ?? null) == $saleRequest->id ? 'selected' : '' }}>
                                                {{ $saleRequest->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sale_request_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    {{-- Quantity Input --}}
                                    <div class="mb-3 col-md-6">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" step="0.00000001"
                                            class="form-control @error('quantity') is-invalid @enderror"
                                            {{-- Pre-fill the quantity from the sale request --}}
                                            value="{{ old('quantity', $saleRequestFrom->quantity ?? '') }}"
                                            placeholder="Enter quantity">
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Status Dropdown --}}
                                    <div class="mb-3 col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                            <option value="pending"
                                                {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold
                                            </option>
                                            <option value="cancelled"
                                                {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                                                Cancelled
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                {{-- Checkboxes --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-3">
                                            <input type="hidden" name="is_verified" value="0">
                                            <input class="form-check-input" type="checkbox" name="is_verified"
                                                value="1" id="is_verified"
                                                {{ old('is_verified', 1) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_verified">
                                                Is Verified?
                                            </label>
                                            @error('is_verified')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-3">
                                            <input type="hidden" name="display_status" value="0">
                                            <input class="form-check-input" type="checkbox" name="display_status"
                                                value="1" id="display_status"
                                                {{ old('display_status', 1) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="display_status">
                                                Display on Site?
                                            </label>
                                            @error('display_status')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{ route('admin.sale.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
