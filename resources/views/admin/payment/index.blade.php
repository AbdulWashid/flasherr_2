@extends('admin.layouts.master')

@section('title', 'Manage Payment Details')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Payment Configuration</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Payment Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Details Card -->
        <div class="row justify-content-center pt-5">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-4">

                    <div class="card-body p-4">
                        <form action="{{ route('admin.payment.update', $payments->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="vpa" class="form-label fw-bold">Virtual Payment Address (VPA)</label>
                                <input type="text"
                                       class="form-control form-control-lg @error('vpa') is-invalid @enderror"
                                       id="vpa"
                                       name="vpa"
                                       value="{{ old('vpa', $payments->vpa) }}"
                                       placeholder="e.g., yourname@bankname"
                                       required>
                                @error('vpa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4 pt-2 text-center">
                                <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                    <i class="fas fa-save me-2"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
