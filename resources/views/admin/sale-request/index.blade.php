@extends('admin.layouts.master')

@section('title', 'Sale Requests')

@push('styles')
    <style>
        .document-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin: 2px;
            border: 1px solid #ddd;
        }

        .is_read {
            border-radius: 100%;
            width: 5px;
            height: 5px;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">All Sale Requests</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sale Requests</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.sale-request.index') }}" method="GET" class="mb-4">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search by name, phone, wallet..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="status" class="form-select">
                                            <option value="">All Statuses</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="approved"
                                                {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected"
                                                {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('admin.sale-request.index') }}"
                                            class="btn btn-secondary ms-2">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Wallet Address</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($saleRequests as $request)
                                            <tr class="{{ $request->is_read ? '' : 'fw-bold' }}">
                                                <td class="is_reads">{{ $saleRequests->firstItem() + $loop->index }}
                                                    @if (!$request->is_read)
                                                        <div class="is_read bg-primary"></div>
                                                    @endif
                                                </td>
                                                <td>

                                                    {{ $request->name }}
                                                </td>
                                                <td>{{ $request->phone_number }}</td>
                                                <td>{{ Str::limit($request->wallet_address, 20) }}</td>
                                                <td>{{ rtrim(rtrim(number_format($request->quantity, 8), '0'), '.') }}</td>

                                                <td>
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
                                                </td>
                                                <td>{{ $request->created_at->format('d M, Y') }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('admin.sale-request.show', $request->id) }}"
                                                        class="btn btn-sm text-primary" title="View"><i
                                                            class="bi bi-eye"></i></a>
                                                    <a href="{{ route('admin.sale-request.edit', $request->id) }}"
                                                        class="btn btn-sm text-warning ms-1" title="Edit"><i
                                                            class="bi bi-pencil-square"></i></a>
                                                    <button class="btn btn-sm text-danger ms-1 delete-btn"
                                                        data-id="{{ $request->id }}" title="Delete"><i
                                                            class="bi bi-trash"></i></button>
                                                    <form id="delete-form-{{ $request->id }}"
                                                        action="{{ route('admin.sale-request.destroy', $request->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a href="{{ route('admin.sale.createFromRequest', $request->id) }}"
                                                        class="btn btn-sm text-info ms-1" title="Add for Sale">
                                                        <i class="bi bi-shop"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No sale requests found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                {{ $saleRequests->links() }}
                            </div>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.status-change-dropdown').on('change', function() {
                let dropdown = $(this);
                let status = $(this).val();
                let requestId = $(this).data('id');
                let url = `/admin/sale-request/${requestId}/update-status`;
                $.ajax({
                    type: 'PATCH',
                    url: url,
                    data: {
                        status: status
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
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
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Something went wrong. Please try again.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });

            });
        });

        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            var requestId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + requestId).submit();
                }
            })
        });
    </script>
@endpush
