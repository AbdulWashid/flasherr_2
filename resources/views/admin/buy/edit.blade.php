@extends('admin.layouts.master')

@section('title', 'Edit Buy Request')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Buy Request #{{ $buyRequest->id }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.buy-requests.index') }}">Buy Requests</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.buy-requests.show', $buyRequest->id) }}">Details</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        {{-- This is the placeholder for our AJAX-powered alerts --}}
        <div id="ajaxAlertPlaceholder" class="position-fixed top-0 end-0 p-3" style="z-index: 1100"></div>

        <div class="container-fluid">
            {{-- This main form now handles all details *except* status, which is handled by AJAX --}}
            <form action="{{ route('admin.buy-requests.update', $buyRequest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Main Details Column --}}
                    <div class="col-lg-8">
                        <!-- Buyer Information Card -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="bi bi-person-circle me-2"></i>Buyer Information</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $buyRequest->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $buyRequest->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $buyRequest->phone_number) }}" required>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country', $buyRequest->country) }}" required>
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $buyRequest->city) }}" required>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $buyRequest->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Request Details Card -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="bi bi-file-earmark-text me-2"></i>Request Details</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="network_type" class="form-label">Network Type</label>
                                        <select class="form-select @error('network_type') is-invalid @enderror" id="network_type" name="network_type" required>
                                            <option value="trc20" {{ old('network_type', $buyRequest->network_type) == 'trc20' ? 'selected' : '' }}>TRC20</option>
                                            <option value="bep20" {{ old('network_type', $buyRequest->network_type) == 'bep20' ? 'selected' : '' }}>BEP20</option>
                                            <option value="erc20" {{ old('network_type', $buyRequest->network_type) == 'erc20' ? 'selected' : '' }}>ERC20</option>
                                        </select>
                                        @error('network_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="wallet_address" class="form-label">Wallet Address</label>
                                        <input type="text" class="form-control @error('wallet_address') is-invalid @enderror" id="wallet_address" name="wallet_address" value="{{ old('wallet_address', $buyRequest->wallet_address) }}" required>
                                        @error('wallet_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="quantity" class="form-label">Quantity (USDT)</label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $buyRequest->quantity) }}" step="0.00000001" required>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status & Documents Column --}}
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="bi bi-gear-fill me-2"></i>Status & Documents</h5>

                                <!-- Status (Handled by AJAX) -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    {{-- Note: name="status" is removed from select, it's not part of the main PUT form --}}
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" required>
                                        <option value="pending" {{ old('status', $buyRequest->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ old('status', $buyRequest->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="rejected" {{ old('status', $buyRequest->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>

                                <!-- ID Document -->
                                <div class="mb-3">
                                    <label for="document" class="form-label">ID Document</label>
                                    <div id="document_preview_wrapper" class="mb-2 text-center">
                                        @if ($buyRequest->document_path)
                                            @if (in_array(strtolower(pathinfo($buyRequest->document_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']))
                                                {{-- It's an image, show thumbnail --}}
                                                <a href="{{ Storage::url($buyRequest->document_path) }}" target="_blank" title="View full image in new tab">
                                                    <img id="document_preview" src="{{ Storage::url($buyRequest->document_path) }}" alt="Current ID Document" class="img-thumbnail" style="max-height: 200px;">
                                                </a>
                                                <span id="document_new_filename" class="ms-2 d-block"></span>
                                            @else
                                                {{-- It's not an image (e.g., PDF), show button and placeholder --}}
                                                <img id="document_preview" src="https://placehold.co/200x200/eee/ccc?text=Document" alt="Document Placeholder" class="img-thumbnail" style="max-height: 200px; display: none;">
                                                <a href="{{ Storage::url($buyRequest->document_path) }}" target="_blank" class="btn btn-sm btn-outline-primary d-block mb-2">
                                                    <i class="bi bi-file-earmark-text me-1"></i> View Current Document ({{ strtoupper(pathinfo($buyRequest->document_path, PATHINFO_EXTENSION)) }})
                                                </a>
                                                <span id="document_new_filename" class="ms-2"></span>
                                            @endif
                                        @else
                                            {{-- No document, show placeholder --}}
                                            <img id="document_preview" src="https://placehold.co/200x200/eee/ccc?text=No+Document" alt="No Document" class="img-thumbnail" style="max-height: 200px;">
                                            <span id="document_new_filename" class="ms-2 d-block"></span>
                                        @endif
                                    </div>
                                    <input class="form-control file-preview-input @error('document') is-invalid @enderror" type="file" id="document" name="document" accept="image/*,application/pdf,.doc,.docx" data-preview-img="#document_preview" data-preview-span="#document_new_filename">
                                    <small class="form-text">Upload to replace current.</small>
                                    @error('document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>

                                <!-- Photo (Selfie) -->
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Photo (Selfie)</label>
                                    <div id="photo_preview_wrapper" class="mb-2 text-center">
                                        @if ($buyRequest->photo_path)
                                            <a href="{{ Storage::url($buyRequest->photo_path) }}" target="_blank" title="View full image in new tab">
                                                <img id="photo_preview" src="{{ Storage::url($buyRequest->photo_path) }}" alt="Current Photo" class="img-thumbnail" style="max-height: 200px;">
                                            </a>
                                            <span id="photo_new_filename" class="ms-2 d-block"></span>
                                        @else
                                            <img id="photo_preview" src="https://placehold.co/200x200/eee/ccc?text=No+Photo" alt="No Photo" class="img-thumbnail" style="max-height: 200px;">
                                            <span id="photo_new_filename" class="ms-2 d-block"></span>
                                        @endif
                                    </div>
                                    <input class="form-control file-preview-input @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" accept="image/*" data-preview-img="#photo_preview" data-preview-span="#photo_new_filename">
                                    <small class="form-text">Upload to replace current.</small>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>

                                <!-- Address Proof -->
                                <div class="mb-3">
                                    <label for="address_proof" class="form-label">Address Proof</label>
                                    <div id="address_proof_preview_wrapper" class="mb-2 text-center">
                                        @if ($buyRequest->address_proof_path)
                                             @if (in_array(strtolower(pathinfo($buyRequest->address_proof_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']))
                                                {{-- It's an image, show thumbnail --}}
                                                <a href="{{ Storage::url($buyRequest->address_proof_path) }}" target="_blank" title="View full image in new tab">
                                                    <img id="address_proof_preview" src="{{ Storage::url($buyRequest->address_proof_path) }}" alt="Current Address Proof" class="img-thumbnail" style="max-height: 200px;">
                                                </a>
                                                <span id="address_proof_new_filename" class="ms-2 d-block"></span>
                                            @else
                                                {{-- It's not an image (e.g., PDF), show button and placeholder --}}
                                                <img id="address_proof_preview" src="https://placehold.co/200x200/eee/ccc?text=Document" alt="Document Placeholder" class="img-thumbnail" style="max-height: 200px; display: none;">
                                                <a href="{{ Storage::url($buyRequest->address_proof_path) }}" target="_blank" class="btn btn-sm btn-outline-primary d-block mb-2">
                                                    <i class="bi bi-file-earmark-text me-1"></i> View Current Proof ({{ strtoupper(pathinfo($buyRequest->address_proof_path, PATHINFO_EXTENSION)) }})
                                                </a>
                                                <span id="address_proof_new_filename" class="ms-2"></span>
                                            @endif
                                        @else
                                            {{-- No document, show placeholder --}}
                                            <img id="address_proof_preview" src="https://placehold.co/200x200/eee/ccc?text=No+Proof" alt="No Proof" class="img-thumbnail" style="max-height: 200px;">
                                            <span id="address_proof_new_filename" class="ms-2 d-block"></span>
                                        @endif
                                    </div>
                                    <input class="form-control file-preview-input @error('address_proof') is-invalid @enderror" type="file" id="address_proof" name="address_proof" accept="image/*,application/pdf,.doc,.docx" data-preview-img="#address_proof_preview" data-preview-span="#address_proof_new_filename">
                                    <small class="form-text">Upload to replace current.</small>
                                    @error('address_proof')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success me-2">
                                    <i class="bi bi-check-circle me-1"></i> Update Request Details
                                </button>
                                <a href="{{ route('admin.buy-requests.show', $buyRequest->id) }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
{{-- This script is now 100% jQuery --}}
<script>
    $(document).ready(function() {

        //============================================
        // 1. jQuery File Preview Handlers
        //============================================

        // Store original src for all preview images
        $('.file-preview-input').each(function() {
            const $previewImg = $($(this).data('preview-img'));
            if ($previewImg.length) {
                $previewImg.data('original-src', $previewImg.attr('src'));
            }
        });

        // Unified handler for all file inputs with class 'file-preview-input'
        $('.file-preview-input').on('change', function() {
            const $input = $(this);
            const $previewImg = $($input.data('preview-img'));
            const $previewSpan = $($input.data('preview-span'));
            const $wrapper = $input.closest('.mb-3');
            const $originalLink = $wrapper.find('a[target="_blank"]');
            const file = this.files ? this.files[0] : null;

            // Clear the span
            if ($previewSpan.length) {
                $previewSpan.text('').removeClass('text-success fw-bold');
            }

            if (file) {
                // Hide original link
                $originalLink.hide();

                if (file.type.startsWith('image/')) {
                    // Handle Image Preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if ($previewImg.length) {
                            $previewImg.attr('src', e.target.result).show();
                        }
                    }
                    reader.readAsDataURL(file);

                    if ($previewSpan.length) {
                        $previewSpan.text('New: ' + file.name).addClass('text-success fw-bold');
                    }
                } else {
                    // Handle Non-Image File Preview (e.g., PDF)
                    if ($previewImg.length) {
                         $previewImg.hide(); // Hide image preview
                    }
                    if ($previewSpan.length) {
                        $previewSpan.text('New: ' + file.name).addClass('text-success fw-bold');
                    }
                }
            } else {
                // No file selected - reset
                $originalLink.show(); // Show original link/button
                if ($previewImg.length) {
                    // Reset to original src and visibility
                    const originalSrc = $previewImg.data('original-src');
                    $previewImg.attr('src', originalSrc);

                    // Show/hide based on what was originally present
                    if ($originalLink.length > 0 && !$originalLink.find('img').length) {
                        // Original was a button (not an image), so keep img hidden
                        $previewImg.hide();
                    } else {
                        // Original was an image or placeholder, show it
                        $previewImg.show();
                    }
                }
            }
        });

        //============================================
        // 2. AJAX Status Change Handler
        //============================================

        let originalStatus;
        const $statusDropdown = $('#status');
        const $ajaxAlertPlaceholder = $('#ajaxAlertPlaceholder');

        // This route *must* be defined in your routes file (see other file)
        // Using your POST route structure
        const updateUrl = "{{ route('admin.buy-requests.updateStatus', $buyRequest->id) }}";
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Store original value on focus
        $statusDropdown.on('focus', function() {
            originalStatus = $(this).val();
        });

        // Handle status change via AJAX
        $statusDropdown.on('change', function() {
            const newStatus = $(this).val();

            // Show loading state
            $statusDropdown.prop('disabled', true);

            $.ajax({
                url: updateUrl,
                type: 'POST', // Using POST as per your route definition
                data: {
                    _token: csrfToken,
                    // _method: 'PATCH', // Not needed for a Route::post
                    status: newStatus
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showAjaxAlert('Status updated to <strong>' + newStatus + '</strong>', 'success');
                        originalStatus = newStatus; // Set new original status
                    } else {
                        showAjaxAlert('Error: ' + (response.message || 'Unknown error'), 'danger');
                        $statusDropdown.val(originalStatus); // Revert
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error updating status:", error);
                    const errorMessage = xhr.responseJSON?.message || error;
                    showAjaxAlert('Failed to update status: ' + errorMessage, 'danger');
                    // Revert dropdown
                    $statusDropdown.val(originalStatus);
                },
                complete: function() {
                    // Re-enable dropdown
                    $statusDropdown.prop('disabled', false);
                }
            });
        });

        // Helper function to show Bootstrap Toast alerts
        function showAjaxAlert(message, type) {
            const alertId = 'ajaxAlert-' + new Date().getTime();
            const alertHtml = `
                <div id="${alertId}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            $ajaxAlertPlaceholder.append(alertHtml);

            const $newAlert = $('#' + alertId);
            // Ensure Bootstrap 5 toast is initialized
            var toast = new bootstrap.Toast($newAlert, { delay: 5000 }); // Show for 5 seconds
            toast.show();

            // Remove from DOM after it's hidden
            $newAlert.on('hidden.bs.toast', function () {
                $(this).remove();
            });
        }
    });
</script>
@endpush

