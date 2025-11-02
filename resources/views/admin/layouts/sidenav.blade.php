<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('admin/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">{{ $domainName }}</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.sale-request.index') }}"
                        class="nav-link {{ request()->routeIs('admin.sale-request.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cash-coin"></i>
                        <p>
                            Sale Requests
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.sale.index')}}"
                        class="nav-link {{ request()->routeIs('admin.sale.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-megaphone"></i>
                        <p>Sale Ads</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.buy-requests.index')}}"
                        class="nav-link {{ request()->routeIs('admin.buy-requests.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-shop"></i>
                        <p>Buy Requests</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.contact.index')}}"
                        class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-chat-dots"></i>
                        <p>Contact Messages</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
