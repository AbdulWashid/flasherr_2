<!-- Header -->
<header class="site-header mo-left header header-transparent ">
    <!-- Main Header -->
    <div class="sticky-header main-bar-wraper navbar-expand-lg">
        <div class="main-bar clearfix ">
            <div class="container clearfix">

                <!-- Website Logo -->
                <div class="logo-header">
                    <a href="{{route('home')}}" class="logo-light"><img src="{{asset('user/images/logo.png')}}" alt=""></a>
                    <a href="{{route('home')}}" class="logo-dark"><img src="{{asset('user/images/logo-dark.png')}}" alt=""></a>
                </div>

                <!-- Nav Toggle Button -->
                <button class="navbar-toggler collapsed navicon justify-content-end" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Extra Nav -->

                <!-- Header Nav -->
                <div class="header-nav navbar-collapse collapse justify-content-end" id="navbarNavDropdown">
                    <div class="logo-header">
                        <a href="{{route('home')}}" class="logo-dark"><img src="{{asset('user/images/logo-dark.png')}}" alt=""></a>
                    </div>
                    <ul class="nav navbar-nav navbar navbar-left">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="#">About Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Header End -->
</header>
<!-- Header End -->
