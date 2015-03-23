<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">

        {{-- Logo --}}
        <div class="col-sm-3 col-md-4 navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-hide" aria-expanded="false" aria-controls="header-hide">
                <span class="sr-only">CDKeysFast</span>
                <span class="glyphicon glyphicon-chevron-down"></span>
            </button>
            <div class="navbar-left navbar-link navbar-btn">

                <a href="{{{ URL::route('index') }}}" class="hidden-sm hidden-xs">
                    {{ HTML::image('img/cdkeysfast.svg', 'CDKeysFast', ['class' => 'img-responsive']) }}
                </a>

                <a href="{{{ URL::route('index') }}}" class="h2 hidden-md hidden-lg">
                    CDKeysFast
                </a>
            </div>
        </div>


        <div id="header-hide" class="navbar-collapse collapse">

            {{-- Busqueda --}}
            {{ Form::open(['route' => ['search.simple'],
                       'method' => 'GET',
                       'class' => 'navbar-form text-center col-sm-5 col-md-4 hidden-xs',
                       'role' => 'search']) }} 
            <div class="form-group">

                <div class="input-group col-xs-12">
                    {{ Form::text('ss-name', null, ['placeholder' => 'Buscar productos', 'class' => 'form-control']) }}

                    <div class="input-group-btn">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                        </div>

                        <div class="input-group-btn">
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    {{ HTML::linkRoute('search.advanced', 'Búsqueda avanzada') }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
            
            {{ Form::open(['route' => ['search.simple'],
                       'method' => 'GET',
                       'class' => 'navbar-text hidden-sm hidden-md hidden-lg',
                       'role' => 'search']) }} 
            <div class="form-group">

                <div class="input-group col-xs-12">
                    {{ Form::text('ss-name', null, ['placeholder' => 'Buscar productos', 'class' => 'form-control']) }}

                    <div class="input-group-btn">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                        </div>

                        <div class="input-group-btn">
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    {{ HTML::linkRoute('search.advanced', 'Búsqueda avanzada') }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}

            <ul class="nav navbar-nav navbar-right col-sm-4">

                {{-- Perfil y logout --}}
                @if (Auth::check())
                <li  class="col-sm-6 text-right">
                    {{ HTML::linkRoute('user.edit',
                                       Auth::user()->name ?: Auth::user()->email,
                                       Auth::id()) }}
                </li>

                <li  class="col-xs-12 col-sm-6 text-right hidden-xs">
                    {{ Form::open(['route' => ['session.destroy', Auth::id()],
                                        'method' => 'DELETE',
                                        'class' => 'navbar-form']) }}

                    {{ Form::submit('Cerrar sesión', ['class' => 'btn btn-link']) }}
                    {{ Form::close() }}
                </li>
                <li  class="col-xs-12 col-sm-6 text-right hidden-sm hidden-md hidden-lg">
                    {{ Form::open(['route' => ['session.destroy', Auth::id()],
                                        'method' => 'DELETE']) }}

                    {{ Form::submit('Cerrar sesión', ['class' => 'btn btn-link']) }}
                    {{ Form::close() }}
                </li>

                {{-- Registro y login --}}
                @else
                <li class="col-xs-12 col-sm-6 text-right">
                    {{ HTML::linkRoute('user.create', 'Registrarse') }}
                </li>
                <li class="col-xs-12 col-sm-6 text-right hidden-sm hidden-md hidden-lg">
                    {{ HTML::linkRoute('login', 'Iniciar sesión') }}
                </li>

                <li class="dropdown col-sm-6 text-right hidden-xs">
                    <a data-placement="bottom" data-toggle="login" data-container="body" class='btn'>Iniciar sesión</a>
                    <div class="dropdown-menu" id="login">
                        @include('client.includes.login')
                    </div>
                </li>

                @endif

            </ul>
        </div>

    </div>
</nav>