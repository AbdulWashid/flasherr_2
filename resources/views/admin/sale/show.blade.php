@extends('admin.layouts.master')

@section('title', 'Sale Details')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Sale Details</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">Sales</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
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
                            <h3 class="card-title">Sale #{{ $sale->id }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 25%;">Parent Request Name</th>
                                            <td>
                                                <a
                                                    href="{{ route('admin.sale-request.show', $sale->saleRequest->id) }}">{{ $sale->saleRequest->name }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Wallet Address</th>
                                            <td>{{ $sale->saleRequest->wallet_address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Quantity</th>
                                            <td>{{ rtrim(rtrim(number_format($sale->quantity, 8), '0'), '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sale Status</th>
                                            <td>
                                                @php
                                                    $statusClass = '';
                                                    if ($sale->status == 'sold') {
                                                        $statusClass = 'bg-success';
                                                    } elseif ($sale->status == 'cancelled') {
                                                        $statusClass = 'bg-danger';
                                                    } else {
                                                        $statusClass = 'bg-warning text-dark';
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ ucfirst($sale->status) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Is Verified?</th>
                                            <td>
                                                @if ($sale->is_verified)
                                                    <span class="badge bg-primary">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Display on Site?</th>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input display-status-toggle" type="checkbox"
                                                        role="switch" id="displayStatusSwitch-{{ $sale->id }}"
                                                        data-id="{{ $sale->id }}"
                                                        {{ $sale->display_status ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ $sale->created_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('admin.sale.edit', $sale->id) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="{{ route('admin.sale.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.display-status-toggle').on('change', function() {
                let saleId = $(this).data('id');
                let newDisplayStatus = $(this).is(':checked') ? 1 : 0;
                // Note: Make sure this route exists in your web.php
                let url = "{{ route('admin.sale.updateDisplayStatus', ':id') }}".replace(':id', saleId);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        display_status: newDisplayStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Display status updated!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $(this).prop('checked', !newDisplayStatus); // Revert on failure
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Update failed!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });
        });
    </script>
@endpush
