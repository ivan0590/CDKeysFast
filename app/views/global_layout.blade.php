<!DOCTYPE html>
<html lang="es">
    <head>
        @yield('common_head')
        @yield('specific_head')
    </head>

    <body>
        <div class="wrap">
            <div>
                <header>
                    @yield('header')
                </header>

                <nav id="platforms">
                    @yield('nav')
                </nav>

                {{ $breadcrumbs }}

                <div class="container">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        <footer class="clearfix">
            @yield('footer')
        </footer>

    </body>
</html>
