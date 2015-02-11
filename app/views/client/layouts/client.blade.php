<!DOCTYPE html>
<html>
    <head>
        @include('client.includes.head')
    </head>

    <body>
        <div class="container">

            <header class="row">
                @include('client.includes.header')
            </header>

            <nav>
                @include('client.includes.nav')
            </nav>

            <div class="row">
                @yield('content')
            </div>

            <footer class="row">
                @include('client.includes.footer')
            </footer>
        </div>
    </body>
</html>
