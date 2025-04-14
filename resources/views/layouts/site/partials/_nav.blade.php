<!-- Header Section Start -->
    <header class="header wsmenucontainer">
        <div class="overlapblackbg"></div>
        <div class="page-container">
            <div class="header-sec">
                <!-- Logo -->
                <div class="logo">
                    <img src="images/tailori-images/logo.png">
                </div>
                <!-- Menu -->
                <div class="navigation">
                    <nav class="full-width navigation">
                        <ul class="full-width togle-menu">
                            <li><a href="/">Home</a></li>
                            <li><a href="">About</a></li>
                            <li><a href="">Support</a></li>
                            {{-- <li><a class="{{ Request::segment(1) == 'pricing' ? "active" : "" }}" href="{{url('pricing')}}">Pricing</a></li> --}}
                            @if (Route::has('login'))
                                <li class="visible-991-xs">
                                    @auth
                                        <a href="{{url('home')}}">Dashboard</a>
                                    @else
                                        <a href="{{url('login')}}">Login</a>
                                    @endauth
                                </li>
                            @endif
                            <li class="visible-991-xs"><a href="" class="purple-btn">Demo</a></li>
                        </ul>
                    </nav>
                    <div class="mobile-menu visible-991-xs">
                        <a href="javascript:void('0')" class="hamburger hamburger--squeeze js-hamburger">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- Customer Login -->
                <div class="user-login hidden-991-xs ">
                    <ul>
                        @if (Route::has('login'))
                            <li>
                                @auth
                                    <a href="{{url('home')}}">Dashboard</a>
                                @else
                                    <a href="{{url('login')}}">Login</a>
                                @endauth
                            </li>
                        @endif
                        <li><a href="" class="purple-btn">Demo</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
