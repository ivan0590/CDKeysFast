<!DOCTYPE html>
<html lang="es">
    <head>
        @include('client.includes.head')
    </head>

    <body>
        <div class="wrap">
            <div>
                <header>
                    @include('client.includes.header')
                </header>

                <nav id="platforms">
                    @include('client.includes.nav')
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
            @include('client.includes.footer')
        </footer>
    </div>
</body>
</html>
