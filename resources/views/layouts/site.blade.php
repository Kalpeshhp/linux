<!DOCTYPE html>
<html lang="en">
    @include('layouts.site.partials._head')
    <body>
        @include('layouts.site.partials._nav')
            @yield('content')
            @include('layouts.site.partials._footer')
        </div>
    </body>
</html>