@extends('admin.layouts.master')

@section('title', 'Contact Details')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Contact Details</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.contact.index') }}">Contacts</a></li>
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
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Contact #{{ $contact->id }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 25%;">First Name</th>
                                            <td>{{ $contact->first_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Name</th>
                                            <td>{{ $contact->last_name ?? '—' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $contact->email ?? '—' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone Number</th>
                                            <td>{{ $contact->phone_number ?? '—' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Message</th>
                                            <td>{{ $contact->message ?? '—' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ $contact->created_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
