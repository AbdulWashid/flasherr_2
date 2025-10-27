@extends('admin.layouts.master')

@section('title', 'Edit Sale Request')

@push('styles')
    <style>
        .document-thumbnail {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 10px;
        }

        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Added for the info card */
        .info-card .list-group-item {
            border: none;
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }
    </style>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Request #{{ $request->id }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.sale-request.index') }}">Sale Requests</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                {{-- Form Column --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Request Information</h3>
                        </div>
                        <form action="{{ route('admin.sale-request.update', $request->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $request->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', $request->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Phone Number</label>
                                            <input type="text" name="phone_number" id="phone_number"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                value="{{ old('phone_number', $request->phone_number) }}">
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                                            <input type="text" name="whatsapp_number" id="whatsapp_number"
                                                class="form-control @error('whatsapp_number') is-invalid @enderror"
                                                value="{{ old('whatsapp_number', $request->whatsapp_number) }}">
                                            @error('whatsapp_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="wallet_address" class="form-label">Wallet Address</label>
                                    <input type="text" name="wallet_address" id="wallet_address"
                                        class="form-control @error('wallet_address') is-invalid @enderror"
                                        value="{{ old('wallet_address', $request->wallet_address) }}">
                                    @error('wallet_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity (USDT)</label>
                                            <input type="number" step="any" name="quantity" id="quantity"
                                                class="form-control @error('quantity') is-invalid @enderror"
                                                value="{{ old('quantity', $request->quantity) }}">
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="min_quantity" class="form-label">Min Quantity (USDT)</label>
                                            <input type="number" step="any" name="min_quantity" id="min_quantity"
                                                class="form-control @error('min_quantity') is-invalid @enderror"
                                                value="{{ old('min_quantity', $request->min_quantity ?? 10) }}">
                                            @error('min_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="rate" class="form-label">Rate</label>
                                            <input type="number" step="any" name="rate" id="rate"
                                                class="form-control @error('rate') is-invalid @enderror"
                                                value="{{ old('rate', $request->rate) }}">
                                            @error('rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                        <option value="pending"
                                            {{ old('status', $request->status) == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="approved"
                                            {{ old('status', $request->status) == 'approved' ? 'selected' : '' }}>Approved
                                        </option>
                                        <option value="rejected"
                                            {{ old('status', $request->status) == 'rejected' ? 'selected' : '' }}>Rejected
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="{{ route('admin.sale-request.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Info & Documents Column --}}
                <div class="col-md-4">


                    {{-- Documents Card --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Documents</h3>
                        </div>
                        <div class="card-body">
                            @php
                                $documents = is_array($request->documents_paths)
                                    ? $request->documents_paths
                                    : json_decode($request->documents_paths, true) ?? [];
                            @endphp
                            @if (is_array($documents) && count($documents) > 0)
                                <ul class="list-group">
                                    @foreach ($documents as $path)
                                        <li class="list-group-item">
                                            <div>
                                                @if (in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ Storage::url($path) }}" class="document-thumbnail"
                                                        alt="doc">
                                                @endif
                                                <a href="{{ Storage::url($path) }}" target="_blank">
                                                    {{ Str::limit(basename($path), 20) }}
                                                </a>
                                            </div>
                                            <form id="delete-doc-form-{{ $loop->index }}"
                                                action="{{ route('admin.sale-request.document.delete', $request->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="document_path" value="{{ $path }}">
                                                <button type="button" class="btn btn-danger btn-sm delete-doc-btn"
                                                    data-form-id="{{ $loop->index }}" title="Remove Document">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No documents were uploaded.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- ADDED: SweetAlert2 CDN and custom script --}}
    <script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.delete-doc-btn').on('click', function(e) {
                e.preventDefault();
                var formId = $(this).data('form-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this document!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-doc-form-' + formId).submit();
                    }
                })
            });
        });
    </script>
@endpush
