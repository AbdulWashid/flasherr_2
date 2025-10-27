@extends('admin.layouts.master')

@section('title', 'View Sale Request')

@push('styles')
    <style>
        .detail-card .list-group-item {
            border: none;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .document-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .document-link {
            font-size: 1.2rem;
        }

        .status-change-dropdown {
            width: auto;
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }

        /* Ensure columns have some spacing on smaller screens if they stack */
        @media (max-width: 767.98px) {
            .detail-card .row .col-md-6:last-child {
                margin-top: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Request #{{ $request->id }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.sale-request.index') }}">Sale Requests</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card detail-card">
                        <div class="card-header">
                            <h3 class="card-title">Request Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item py-3"><strong>Name:</strong> {{ $request->name }}</li>
                                        <li class="list-group-item py-3"><strong>Email:</strong> {{ $request->email }}</li>
                                        <li class="list-group-item py-3"><strong>Phone Number:</strong>
                                            {{ $request->phone_number }}</li>
                                        <li class="list-group-item py-3"><strong>WhatsApp Number:</strong>
                                            {{ $request->whatsapp_number ?? 'N/A' }}</li>
                                        <li class="list-group-item py-3"><strong>Submitted On:</strong>
                                            {{ $request->created_at->format('d M, Y h:i:s A') }}</li>

                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item py-3"><strong>Wallet Address :</strong>
                                            {{ $request->wallet_address }}</li>
                                        <li class="list-group-item py-3"><strong>Quantity:</strong>
                                            {{ rtrim(rtrim(number_format($request->quantity, 8), '0'), '.') }} USDT</li>
                                        <li class="list-group-item py-3"><strong>Rate:</strong>
                                            {{ rtrim(rtrim(number_format($request->rate, 8), '0'), '.') }}</li>
                                        <li class="list-group-item py-3"><strong>Status:</strong>
                                            @php
                                                $borderColorClass = '';
                                                if ($request->status == 'approved') {
                                                    $borderColorClass = 'border-success';
                                                } elseif ($request->status == 'rejected') {
                                                    $borderColorClass = 'border-danger';
                                                } elseif ($request->status == 'pending') {
                                                    $borderColorClass = 'border-warning';
                                                }
                                            @endphp

                                            <select
                                                class="form-select form-select-sm status-change-dropdown border-bottom {{ $borderColorClass }}"
                                                style="border-width: 2px;" data-id="{{ $request->id }}"
                                                aria-label="Update Status">
                                                <option value="pending"
                                                    {{ $request->status == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="approved"
                                                    {{ $request->status == 'approved' ? 'selected' : '' }}>
                                                    Approved
                                                </option>
                                                <option value="rejected"
                                                    {{ $request->status == 'rejected' ? 'selected' : '' }}>
                                                    Rejected
                                                </option>
                                            </select>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.sale-request.index') }}" class="btn btn-secondary">Back to List</a>
                            <a href="{{ route('admin.sale-request.edit', $request->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Uploaded Documents</h3>
                        </div>
                        <div class="card-body">
                            {{-- FIX: Decode the JSON string and check if it's a valid array --}}
                            @php $documents = is_string($request->documents_paths) ? json_decode($request->documents_paths, true) : $request->documents_paths; @endphp

                            @if (is_array($documents) && count($documents) > 0)
                                @foreach ($documents as $path)
                                    @php $extension = pathinfo($path, PATHINFO_EXTENSION); @endphp
                                    <div class="mb-3">
                                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                            <a href="{{ Storage::url($path) }}" target="_blank">
                                                <img src="{{ Storage::url($path) }}" alt="Document" class="document-image">
                                            </a>
                                        @else
                                            <a href="{{ Storage::url($path) }}" target="_blank" class="document-link">
                                                <i class="bi bi-file-earmark-text"></i> View Document
                                                ({{ strtoupper($extension) }})
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
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
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        $(document).ready(function() {
            // CSRF Token Setup for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Status change event handler
            $('.status-change-dropdown').on('change', function() {
                let dropdown = $(this);
                let status = $(this).val();
                let requestId = $(this).data('id');
                let url = `/admin/sale-request/${requestId}/update-status`; // The URL for our new route

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to change the status to "${status}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'PATCH',
                            url: url,
                            data: {
                                status: status
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Updated!',
                                    response.message,
                                    'success'
                                );
                                dropdown.removeClass(
                                    'border-success border-danger border-warning');
                                if (status === 'approved') {
                                    dropdown.addClass('border-success');
                                } else if (status === 'rejected') {
                                    dropdown.addClass('border-danger');
                                } else if (status === 'pending') {
                                    dropdown.addClass('border-warning');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong. Please try again.',
                                    'error'
                                );
                            }
                        });
                    } else {
                        // If user cancels, revert the dropdown to its original value
                        // Find the previously selected option and set it back
                        dropdown.val(dropdown.find('option[selected]').val());
                    }
                });
            });
        });
    </script>
@endpush
