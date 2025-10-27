@extends('admin.layouts.master')

@section('title', 'Contact Messages')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">All Contact Messages</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Contact Messages</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search by name or email" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary">Search</button>
                                <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contacts as $contact)
                                <tr>
                                    <td>{{ $contacts->firstItem() + $loop->index }}</td>
                                    <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone_number }}</td>
                                    <td>{{ Str::limit($contact->message, 40) }}</td>
                                    <td>{{ $contact->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.contact.show', $contact->id) }}"
                                            class="btn btn-sm text-primary"><i class="bi bi-eye"></i></a>
                                        <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-danger"
                                                onclick="return confirm('Delete this message?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No messages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
