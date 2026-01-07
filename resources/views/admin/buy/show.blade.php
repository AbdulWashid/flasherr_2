@extends('admin.layouts.master')

@section('title', 'Buy Request Details')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Buy Request #{{ $buyRequest->id }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.buy-requests.index') }}">Buy Requests</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                {{-- Main Details Column --}}
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><i class="bi bi-person-circle me-2"></i>Buyer Information</h5> <br>
                            <dl class="row">
                                <dt class="col-sm-3">Name</dt>
                                <dd class="col-sm-9">{{ $buyRequest->name }}</dd>

                                <dt class="col-sm-3">Email</dt>
                                <dd class="col-sm-9">{{ $buyRequest->email }}</dd>

                                <dt class="col-sm-3">Phone</dt>
                                <dd class="col-sm-9">{{ $buyRequest->phone_number }}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><i class="bi bi-file-earmark-text me-2"></i>Request Details</h5>
                            <br>
                            <dl class="row">
                                <dt class="col-sm-3">Transaction ID</dt>
                                <dd class="col-sm-9">
                                    {{ $buyRequest->transaction_id }}
                                </dd>
                                <dt class="col-sm-3">Requested Quantity</dt>
                                <dd class="col-sm-9">
                                    {{ rtrim(rtrim(number_format($buyRequest->quantity, 8), '0'), '.') }} USDT
                                </dd>
                                <dt class="col-sm-3">Rate</dt>
                                <dd class="col-sm-9">
                                    <span class="text-success">{{ number_format($buyRequest->sale->rate, 2) }} INR</span>
                                </dd>

                                <dt class="col-sm-3">Network</dt>
                                <dd class="col-sm-9">
                                    <span class="badge bg-secondary">{{ strtoupper($buyRequest->network_type) }}</span>
                                </dd>

                                <dt class="col-sm-3">Buyer's Wallet</dt>
                                <dd class="col-sm-9">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control"
                                            value="{{ $buyRequest->wallet_address }}" readonly id="buyerWallet">
                                        {{-- Removed onclick, added class and data-target --}}
                                        <button class="btn btn-outline-secondary btn-copy" type="button"
                                            data-target="#buyerWallet">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </dd>

                                <dt class="col-sm-3">Seller's Wallet</dt>
                                <dd class="col-sm-9">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control"
                                            value="{{ $buyRequest->sale->saleRequest->wallet_address }}" readonly
                                            id="sellerWallet">
                                        {{-- Removed onclick, added class and data-target --}}
                                        <button class="btn btn-outline-secondary btn-copy" type="button"
                                            data-target="#sellerWallet">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                    <small>
                                        <a href="{{ route('admin.sale.show', $buyRequest->sale->id) }}"
                                            target="_blank">View Original Sale Post</a>
                                    </small>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Status & Actions Column --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-check-circle-fill me-2"></i>Status & Documents</h5> <br>

                            <div class="my-3">
                                <strong>Status:</strong>
                                {{-- Added id="statusBadge" for dynamic updates --}}
                                @if ($buyRequest->status == 'pending')
                                    <span id="statusBadge" class="badge fs-6 bg-warning text-dark">Pending</span>
                                @elseif ($buyRequest->status == 'completed')
                                    <span id="statusBadge" class="badge fs-6 bg-success">Completed</span>
                                @else
                                    <span id="statusBadge" class="badge fs-6 bg-danger">Rejected</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <strong>Payment Proof:</strong><br>
                                @if ($buyRequest->payment_proof)
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#documentModal"
                                        data-doc-url="{{ Storage::url($buyRequest->payment_proof) }}">
                                        <i class="bi bi-eye me-1"></i> View Document
                                    </button>
                                @else
                                    <span class="text-muted">Not Provided</span>
                                @endif
                            </div>
                            <hr>

                            {{-- Admin Actions --}}
                            <h5 class="card-title mb-3"><i class="bi bi-pencil-square me-2"></i>Actions</h5> <br>

                            {{-- Added id="pendingActions" wrapper for dynamic hiding --}}
                            @if ($buyRequest->status == 'pending')
                                <div id="pendingActions" class="d-grid gap-2 mb-2">
                                    {{-- APPROVE FORM --}}
                                    <form action="{{ route('admin.buy-requests.updateStatus', $buyRequest->id) }}"
                                        method="POST" id="approve-form-{{ $buyRequest->id }}" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="status" value="completed">
                                    </form>
                                    <button type="button" class="btn btn-success w-100 status-action-btn"
                                        data-form-id="approve-form-{{ $buyRequest->id }}"
                                        data-message="Are you sure you want to approve this request?">
                                        <i class="bi bi-check-circle me-1"></i> Approve
                                    </button>

                                    {{-- REJECT FORM --}}
                                    <form action="{{ route('admin.buy-requests.updateStatus', $buyRequest->id) }}"
                                        method="POST" id="reject-form-{{ $buyRequest->id }}" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                    </form>
                                    <button type="button" class="btn btn-danger w-100 status-action-btn"
                                        data-form-id="reject-form-{{ $buyRequest->id }}"
                                        data-message="Are you sure you want to reject this request?">
                                        <i class="bi bi-x-circle me-1"></i> Reject
                                    </button>
                                </div>
                            @endif

                            <a href="{{ route('admin.buy-requests.edit', $buyRequest->id) }}"
                                class="btn btn-outline-primary w-100">
                                <i class="bi bi-pencil me-1"></i> Edit Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentModalLabel">View Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid rounded" alt="Document"
                        style="display: none;">
                    <iframe src="" id="modalIframe"
                        style="width: 100%; height: 70vh; border: none; display: none;"></iframe>
                    <p id="modalError" class="text-danger" style="display: none;">Could not load document preview.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            //============================================
            // 1. jQuery Script for Click-to-Copy
            //============================================

            // Helper function for copy success
            function showCopySuccess($button) {
                const originalIcon = $button.html();
                $button.html('<i class="bi bi-check-lg text-success"></i>');
                $button.prop('disabled', true);

                setTimeout(() => {
                    $button.html(originalIcon);
                    $button.prop('disabled', false);
                }, 2000);
            }

            // Click handler for all copy buttons
            $('.btn-copy').on('click', function() {
                const $button = $(this);
                const targetId = $button.data('target');
                const $copyText = $(targetId);

                if (!$copyText.length) {
                    return;
                }

                // Select the text
                $copyText[0].select();
                $copyText[0].setSelectionRange(0, 99999);

                try {
                    // Modern clipboard API
                    navigator.clipboard.writeText($copyText.val()).then(() => {
                        showCopySuccess($button);
                    }).catch(() => {
                        document.execCommand("copy"); // Fallback
                        showCopySuccess($button);
                    });
                } catch (err) {
                    document.execCommand("copy"); // Older fallback
                    showCopySuccess($button);
                }
            });

            //============================================
            // 2. jQuery Script for Document Modal
            //============================================

            $('#documentModal').on('show.bs.modal', function(event) {
                const $button = $(event.relatedTarget);
                const docUrl = $button.data('doc-url');
                const $modal = $(this);

                const $modalImage = $modal.find('#modalImage');
                const $modalIframe = $modal.find('#modalIframe');
                const $modalError = $modal.find('#modalError');

                // Reset all elements
                $modalImage.hide().attr('src', '');
                $modalIframe.hide().attr('src', '');
                $modalError.hide();

                if (/\.(jpeg|jpg|gif|png|webp|bmp|svg)$/i.test(docUrl)) {
                    $modalImage.attr('src', docUrl).show();
                } else if (/\.(pdf)$/i.test(docUrl)) {
                    $modalIframe.attr('src', docUrl).show();
                } else {
                    $modalError.html('Preview not available. <a href="' + docUrl +
                        '" target="_blank">Download Document</a>');
                    $modalError.show();
                }
            });

            // Clear src when modal is hidden
            $('#documentModal').on('hidden.bs.modal', function() {
                $(this).find('#modalImage').attr('src', '');
                $(this).find('#modalIframe').attr('src', '');
            });

            //============================================
            // 3. jQuery/AJAX Script for Status Actions
            //============================================

            $('.status-action-btn').on('click', function(e) {
                e.preventDefault();

                const $clickedButton = $(this);
                const formId = $clickedButton.data('form-id');
                const message = $clickedButton.data('message');
                const $form = $('#' + formId);

                if (!$form.length) {
                    return;
                }

                const url = $form.attr('action');
                const newStatus = $form.find('input[name="status"]').val();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                const confirmButtonText = $clickedButton.hasClass('btn-success') ? 'Yes, approve it!' :
                    'Yes, reject it!';
                const icon = $clickedButton.hasClass('btn-success') ? 'question' : 'warning';

                Swal.fire({
                    title: 'Are you sure?',
                    text: message,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: $clickedButton.hasClass('btn-success') ? '#28a745' : '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: confirmButtonText
                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire({
                            title: 'Processing...',
                            text: 'Updating request status.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: csrfToken,
                                // _method: 'PATCH', // Laravel route patching
                                status: newStatus
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Updated!',
                                        'The request has been ' + newStatus + '.',
                                        'success'
                                    );

                                    // Dynamically update the page
                                    const $badge = $('#statusBadge');
                                    const $actionsDiv = $('#pendingActions');

                                    if (newStatus === 'completed') {
                                        $badge.attr('class', 'badge fs-6 bg-success')
                                            .text('Completed');
                                    } else if (newStatus === 'rejected') {
                                        $badge.attr('class', 'badge fs-6 bg-danger')
                                            .text('Rejected');
                                    }

                                    // Hide the approve/reject buttons
                                    $actionsDiv.slideUp().remove();

                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message ||
                                        'An unknown error occurred.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                const errorMsg = xhr.responseJSON?.message || error;
                                Swal.fire(
                                    'AJAX Error!',
                                    'Failed to update status: ' + errorMsg,
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
