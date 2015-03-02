<!DOCTYPE html>
<html>
    <head>
        @include('admin.includes.head')
    </head>

    <body>
        <div class="container">

            <header class="row">
                @include('admin.includes.header')
            </header>
            
            {{ $breadcrumbs }}
            
            <div class="row">
                @yield('content')
            </div>

            <footer class="row">
                @include('admin.includes.footer')
            </footer>
        </div>
    </body>
</html>
