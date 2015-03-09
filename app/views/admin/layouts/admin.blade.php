<!DOCTYPE html>
<html lang="es">
    <head>
        @include('admin.includes.head')
        @yield('specific_head')
    </head>

    <body>
        <div class="wrap">
            <div>
                <header>
                    @include('admin.includes.header')
                </header>

                {{ $breadcrumbs }}

                <div class="container">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        <footer class="clearfix">
            @include('admin.includes.footer')
        </footer>
    </body>
</html>
