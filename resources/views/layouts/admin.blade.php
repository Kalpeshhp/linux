<!DOCTYPE html>
<html lang="en">
    @include('layouts.partials._head')
    <body>
        @include('layouts.partials._nav')
        <div class="page-content">
            @include('layouts.partials._sidebar')
            <!-- Main content -->
            <div class="content-wrapper">
                @yield('content')
                @include('layouts.partials._footer')
            </div>
            <!-- /main content -->
        </div>
    </body>
</html>