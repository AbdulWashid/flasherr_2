<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Securely buy, sell, and trade USDT (Tether) in India at the best rates. Our platform offers instant transactions, low fees, and multiple payment options including UPI and bank transfer." />
    <meta name="keywords"
        content="buy USDT, sell USDT, USDT exchange, Tether, USDT India, buy Tether, sell Tether, USDT price INR, crypto exchange India, buy stablecoin, P2P USDT, buy crypto with UPI, secure USDT trading" />
    <link rel="preload" href="{{ asset('admin/css/adminlte.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('admin/css/fontsource.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/overlayscrollbars.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/cropper.min.css') }}" />
    <link rel="shortcut icon" href="{{ asset('admin/assets/img/AdminLTELogo.png') }}" type="image/x-icon">
    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
        @include('admin.layouts.header')
        @include('admin.layouts.sidenav')
        <main class="app-main">
            @yield('content')
        </main>
        @include('admin.layouts.footer')
    </div>
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="profileUpdateForm" enctype="multipart/form-data">
                        <input type="hidden" name="cropped_image" id="croppedImage">

                        <div class="text-center mb-3">
                            <label for="profileImageInput" class="form-label">Profile Picture</label>
                            <div>
                                <img id="imagePreview" src="{{ Storage::url(Auth::user()->image) }}"
                                    alt="Profile Preview" class="rounded-circle shadow"
                                    style="width: 160px; height: 160px; object-fit: cover; cursor: pointer;">
                            </div>
                            <input type="file" class="d-none" id="profileImageInput"
                                accept="image/png, image/jpeg, image/gif">
                            <small class="form-text text-muted">Click image to upload a new one.</small>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="profile_name" name="profile_name"
                                value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="profile_email" name="profile_email"
                                value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password (optional)</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text text-muted">Leave blank to keep current password.</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveProfileButton" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropperModalLabel">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <img id="imageToCrop" src="" alt="Crop Source" style="max-width: 100%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="cropButton" class="btn btn-primary">Crop</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/js/overlayscrollbars.min.js') }}"></script>
    <script src="{{ asset('admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/js/adminlte.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/cropper.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    <script>
        $(document).ready(function() {
            'use strict';

            /** -----------------------------
             * 1️⃣ Sidebar Scrollbar Init
             * ----------------------------- */
            var SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
            var Default = {
                scrollbarTheme: 'os-theme-light',
                scrollbarAutoHide: 'leave',
                scrollbarClickScroll: true,
            };

            var $sidebarWrapper = $(SELECTOR_SIDEBAR_WRAPPER);

            if ($sidebarWrapper.length && typeof OverlayScrollbarsGlobal !== 'undefined' && OverlayScrollbarsGlobal
                .OverlayScrollbars) {
                OverlayScrollbarsGlobal.OverlayScrollbars($sidebarWrapper[0], {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }

            /** -----------------------------
             * 2️⃣ Theme Switcher
             * ----------------------------- */
            var storedTheme = localStorage.getItem("theme");

            function getPreferredTheme() {
                if (storedTheme) return storedTheme;
                return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }

            function setTheme(theme) {
                var themeToSet = (theme === "auto" && window.matchMedia("(prefers-color-scheme: dark)").matches) ?
                    "dark" :
                    theme;
                $("html").attr("data-bs-theme", themeToSet);
            }

            function showActiveTheme(theme, focus) {
                var $themeSwitcher = $("#bd-theme");
                if (!$themeSwitcher.length) return;

                var $themeSwitcherText = $("#bd-theme-text");
                var $activeThemeIcon = $(".theme-icon-active i");
                var $btnToActive = $('[data-bs-theme-value="' + theme + '"]');
                var svgOfActiveBtn = $btnToActive.find("i").attr("class");

                $("[data-bs-theme-value]").removeClass("active").attr("aria-pressed", "false");
                $btnToActive.addClass("active").attr("aria-pressed", "true");
                $activeThemeIcon.attr("class", svgOfActiveBtn);

                var themeSwitcherLabel = $themeSwitcherText.text() + " (" + $btnToActive.data("bs-theme-value") +
                    ")";
                $themeSwitcher.attr("aria-label", themeSwitcherLabel);

                if (focus) {
                    $themeSwitcher.trigger("focus");
                }
            }

            setTheme(getPreferredTheme());
            showActiveTheme(getPreferredTheme());

            // Handle OS color scheme change
            window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", function(e) {
                if (e.matches && (storedTheme !== "light" && storedTheme !== "dark")) {
                    setTheme(getPreferredTheme());
                }
            });

            $("[data-bs-theme-value]").on("click", function() {
                var theme = $(this).data("bs-theme-value");
                localStorage.setItem("theme", theme);
                setTheme(theme);
                showActiveTheme(theme, true);
            });

            /** -----------------------------
             * 3️⃣ Profile Image Cropper
             * ----------------------------- */
            var cropper;
            var profileModal = new bootstrap.Modal($('#profileModal')[0]);
            var cropperModal = new bootstrap.Modal($('#cropperModal')[0]);

            var $imageToCrop = $('#imageToCrop');
            var $imagePreview = $('#imagePreview');
            var $profileImageInput = $('#profileImageInput');

            // Open file dialog
            $imagePreview.on('click', function() {
                $profileImageInput.trigger('click');
            });

            // Handle image file input
            $profileImageInput.on('change', function(e) {
                var files = e.target.files;
                if (files && files.length > 0) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $imageToCrop.attr('src', event.target.result);
                        cropperModal.show();
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            // Init Cropper when modal shown
            $('#cropperModal').on('shown.bs.modal', function() {
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper($imageToCrop[0], {
                    aspectRatio: 1 / 1,
                    viewMode: 1,
                    autoCropArea: 0.9,
                    movable: false,
                    scalable: false,
                    zoomable: false,
                });
            });

            // Crop image
            $('#cropButton').on('click', function() {
                var canvas = cropper.getCroppedCanvas({
                    width: 160,
                    height: 160,
                });
                var croppedImageData = canvas.toDataURL('image/jpeg');
                $imagePreview.attr('src', croppedImageData);
                $('#croppedImage').val(croppedImageData);
                cropperModal.hide();
            });

            /** -----------------------------
             * 4️⃣ Profile Save AJAX
             * ----------------------------- */
            $('#saveProfileButton').on('click', function(e) {
                e.preventDefault();

                var formData = new FormData($('#profileUpdateForm')[0]);

                $.ajax({
                    url: "{{ route('admin.profile.update') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        profileModal.hide();
                        location.reload();
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMsg = "An error occurred:\n";
                        $.each(errors, function(key, value) {
                            errorMsg += value[0] + "\n";
                        });
                        alert(errorMsg);
                    }
                });
            });
        });
    </script>

    @stack('scripts')
    @include('sweetalert::alert')
</body>

</html>
