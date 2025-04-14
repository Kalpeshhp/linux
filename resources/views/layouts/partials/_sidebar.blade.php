<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        <span class="font-weight-semibold">Navigation</span>
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="sidebar-user-material-body">
                <div class="card-body text-center">
                    {{-- <a href="#">
                        <img src="../../../../images/demo/users/face6.jpg" class="img-fluid rounded-circle shadow-1 mb-3" width="80" height="80" alt="">
                    </a> --}}
                    <h6 class="mb-0 text-white text-shadow-dark text-dark">Welcome </h6>
                    <span class="font-size-sm text-white text-shadow-dark text-dark">{{ Auth::user()->name }}</span>
                </div>
                                            
                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle text-dark" data-toggle="collapse"><span>My account</span></a>
                </div>
            </div>

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">
                   <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-user-plus"></i>
                            <span>My profile</span>
                        </a>
                    </li>-->
                    <li class="nav-item">
                        <a href="{{ route('show.profile',Auth::user()->vendor_id) }}" class="nav-link">
                            <i class="icon-user"></i>
                            <span>My Account</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="{{route('vendor.package.elements')}}" class="nav-link">
                            <i class="icon-package"></i>
                            <span>My package</span>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a href="{{route('changePassword')}}" class="nav-link">
                            <i class="icon-key"></i>
                            <span>Change Password</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="icon-switch2"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs text-dark">Main</div> <i class="icon-menu" title="Main"></i></li>
                {{-- <li class="nav-item">
                    <a href="index.html" class="nav-link active">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li> --}}
                <!-- /main -->

                <!-- Forms -->
                @can('admin-only', auth()->user())
                    <li class="nav-item">
                        <a href="{{route('vendor.index')}}" class="nav-link">
                            <i class="icon-home4"></i>
                            <span>
                                Vendors
                            </span>
                        </a>
                    </li>
                @endcan
                
                @can('admin-only', auth()->user())
                    <li class="nav-item">
                        <a href="{{route('fabric.index')}}" class="nav-link">
                            <i class="icon-home4"></i>
                            <span>
                                Fabrics
                            </span>
                        </a>
                    </li>
                @endcan
                    
                <li class="nav-item">
                    <a href="{{route('fabric.grid.get')}}" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>
                            Fabrics Grid
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('tailori.garment.configurator')}}" class="nav-link">
                        <i class="icon-cogs"></i>
                        <span>
                            Garment configurator
                        </span>
                    </a>
                </li>
                
                
                {{-- <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-pencil3"></i> <span>Form components</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Form components">
                        <li class="nav-item"><a href="form_inputs.html" class="nav-link">Basic inputs</a></li>
                        <li class="nav-item"><a href="form_checkboxes_radios.html" class="nav-link">Checkboxes &amp; radios</a></li>
                    </ul>
                </li> --}}
                <!-- /forms -->
                
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->
    
</div>
<!-- /main sidebar -->
