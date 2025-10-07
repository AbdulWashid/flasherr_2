@extends('admin.layouts.master')

@section('title', 'Sale List')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">All Sale List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sale List</li>
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
                            <form action="{{ route('admin.sale.index') }}" method="GET" class="mb-4">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control" placeholder="Search"
                                            value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="status" class="form-select">
                                            <option value="">All Statuses</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold
                                            </option>
                                            <option value="cancelled"
                                                {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('admin.sale.index') }}" class="btn btn-secondary ms-2">Reset</a>
                                        <a href="{{ route('admin.sale.create') }}" class="btn btn-success ms-2">Create</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Wallet Address</th>
                                            <th>Quantity</th>
                                            <th>Sale Status</th>
                                            <th>Display Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sales as $request)
                                            <tr class="{{ $request->is_read ? '' : 'fw-bold' }}">
                                                <td>{{ $sales->firstItem() + $loop->index }}</td>
                                                <td>
                                                    <a class="text-decoration-none"
                                                        href="{{ route('admin.sale-request.show', $request->saleRequest->id) }}">
                                                        {{ $request->saleRequest->name }}
                                                    </a>
                                                </td>
                                                <td>{{ Str::limit($request->saleRequest->wallet_address, 20) }}</td>
                                                <td>{{ rtrim(rtrim(number_format($request->quantity, 8), '0'), '.') }}</td>

                                                <td>
                                                    @php
                                                        $borderColorClass = '';
                                                        if ($request->status == 'sold') {
                                                            $borderColorClass = 'border-success';
                                                        } elseif ($request->status == 'cancelled') {
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
                                                            Pending</option>
                                                        <option value="sold"
                                                            {{ $request->status == 'sold' ? 'selected' : '' }}>
                                                            Sold</option>
                                                        <option value="cancelled"
                                                            {{ $request->status == 'cancelled' ? 'selected' : '' }}>
                                                            Cancelled</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input display-status-toggle"
                                                            type="checkbox" role="switch"
                                                            id="displayStatusSwitch-{{ $request->id }}"
                                                            data-id="{{ $request->id }}"
                                                            {{ $request->display_status ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td>{{ $request->created_at->format('d M, Y') }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('admin.sale.show', $request->id) }}"
                                                        class="btn btn-sm text-primary" title="View"><i
                                                            class="bi bi-eye"></i></a>
                                                    <a href="{{ route('admin.sale.edit', $request->id) }}"
                                                        class="btn btn-sm text-warning ms-1" title="Edit"><i
                                                            class="bi bi-pencil-square"></i></a>
                                                    <button class="btn btn-sm text-danger ms-1 delete-btn"
                                                        data-id="{{ $request->id }}" title="Delete"><i
                                                            class="bi bi-trash"></i></button>
                                                    <form id="delete-form-{{ $request->id }}"
                                                        action="{{ route('admin.sale.destroy', $request->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
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
                                {{ $sales->links() }}
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

            $('.status-change-dropdown').on('change', function() {
                let saleId = $(this).data('id');
                let newStatus = $(this).val();
                let url = "{{ route('admin.sale.updateStatus', ':id') }}".replace(':id', saleId);
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
                                title: 'Status updated!',
                                showConfirmButton: false,
                                timer: 2000
                            });

                            selectElement.removeClass(
                                'border-success border-danger border-warning');
                            if (newStatus === 'sold') {
                                selectElement.addClass('border-success');
                            } else if (newStatus === 'cancelled') {
                                selectElement.addClass('border-danger');
                            } else {
                                selectElement.addClass('border-warning');
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
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

            $('.display-status-toggle').on('change', function() {
                let saleId = $(this).data('id');
                let newDisplayStatus = $(this).is(':checked') ? 1 : 0;
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
                        $(this).prop('checked', !newDisplayStatus);
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
