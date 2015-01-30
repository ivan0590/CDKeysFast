<!DOCTYPE html>
<html>
    <head>
        @include('client.includes.head')
    </head>

    <body class="container">
        <header class="row">
            @include('client.includes.header')
        </header>

        <div class="row">
            @yield('content')
        </div>
        
        <header class="row">
            @include('client.includes.footer')
        </header>
    </body>
</html>
