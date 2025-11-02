@extends('admin.layouts.master')

@section('title', 'Buy Requests')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">All Buy Requests</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Buy Requests</li>
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
                            <form action="{{ route('admin.buy-requests.index') }}" method="GET" class="mb-4">
                                <div class="row g-2">
                                    <div class="col-md-5">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search by buyer name, phone, or wallet..."
                                            value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <select name="status" class="form-select">
                                            <option value="">All Statuses</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="completed"
                                                {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                                            </option>
                                            <option value="rejected"
                                                {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('admin.buy-requests.index') }}"
                                            class="btn btn-secondary ms-2">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Buyer Name</th>
                                            <th>Buyer Wallet</th>
                                            <th>Req. Qty</th>
                                            <th>Seller Wallet</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($buyRequests as $request)
                                            <tr>
                                                <td>{{ $buyRequests->firstItem() + $loop->index }}</td>
                                                <td>{{ $request->name }}</td>
                                                <td>{{ Str::limit($request->wallet_address, 20) }}</td>
                                                <td>{{ rtrim(rtrim(number_format($request->quantity, 8), '0'), '.') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.sale.show', $request->sale->id) }}"
                                                        class="text-decoration-none" title="View Original Sale">
                                                        {{ Str::limit($request->sale->saleRequest->wallet_address, 20) }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @php
                                                        $borderColorClass = 'border-warning'; // Default for pending
                                                        if ($request->status == 'completed') {
                                                            $borderColorClass = 'border-success';
                                                        } elseif ($request->status == 'rejected') {
                                                            $borderColorClass = 'border-danger';
                                                        }
                                                    @endphp
                                                    <select
                                                        class="form-select form-select-sm status-change-dropdown border-bottom {{ $borderColorClass }}"
                                                        style="border-width: 2px;" data-id="{{ $request->id }}"
                                                        aria-label="Update Status">
                                                        <option value="pending"
                                                            {{ $request->status == 'pending' ? 'selected' : '' }}>
                                                            Pending</option>
                                                        <option value="completed"
                                                            {{ $request->status == 'completed' ? 'selected' : '' }}>
                                                            Completed</option>
                                                        <option value="rejected"
                                                            {{ $request->status == 'rejected' ? 'selected' : '' }}>
                                                            Rejected</option>
                                                    </select>
                                                </td>
                                                <td>{{ $request->created_at->format('d M, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.buy-requests.show', $request->id) }}"
                                                        class="btn btn-sm text-info" title="View"><i
                                                            class="bi bi-eye"></i></a>
                                                    <a href="{{ route('admin.buy-requests.edit', $request->id) }}"
                                                        class="btn btn-sm text-primary" title="Edit"><i
                                                            class="bi bi-pencil"></i></a>

                                                    <button class="btn btn-sm text-danger ms-1 delete-btn"
                                                        data-id="{{ $request->id }}" title="Delete"><i
                                                            class="bi bi-trash"></i></button>

                                                    <form id="delete-form-{{ $request->id }}"
                                                        action="{{ route('admin.buy-requests.destroy', $request->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No buy requests found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                {{ $buyRequests->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // AJAX for Status Change
            $('.status-change-dropdown').on('change', function() {
                let requestId = $(this).data('id');
                let newStatus = $(this).val();
                let url = "{{ route('admin.buy-requests.updateStatus', ':id') }}".replace(':id',
                    requestId);
                let selectElement = $(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                            selectElement.removeClass(
                                'border-success border-danger border-warning');
                            if (newStatus === 'completed') {
                                selectElement.addClass('border-success');
                            } else if (newStatus === 'rejected') {
                                selectElement.addClass('border-danger');
                            } else {
                                selectElement.addClass('border-warning');
                            }
                        }
                    },
                    error: function() {
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

            // SweetAlert for Delete Confirmation
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
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
                        $('#delete-form-' + id).submit();
                    }
                });
            });
        });
    </script>
@endpush
