<nav class="navbar-inverse">
    <div class="container-fluid">

        {{-- Logo --}}
        <div class="navbar-header">
            <a href="{{ URL::route('index') }}">
                {{ HTML::image('img/cdkeysfast.svg') }}
            </a>
        </div>

        <div class="col-md-6">            
            {{-- Busqueda --}}
            {{ Form::open(['route' => ['search.show'],
                       'method' => 'GET',
                       'class' => 'navbar-form text-center',
                       'role' => 'search']) }} 
            <div class="form-group">

                <div class="input-group">
                    {{ Form::text('name', null, ['placeholder' => 'Buscar productos', 'class' => 'form-control']) }}
                    <div class="input-group-btn btn-group">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#advanced_search">Busqueda avanzada</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>

        {{-- Perfil y logout --}}
        @if (Auth::check())
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#edit">{{Auth::user()->name}}</a></li>
                <li>
                    {{ Form::open(['route' => ['session.destroy', Auth::id()],
                                        'method' => 'DELETE',
                                        'class' => 'navbar-form',
                                        'role' => 'logout']) }}

                    {{ Form::submit('Cerrar sesión', ['class' => 'btn btn-link']) }}
                    {{ Form::close() }}
                </li>
            </ul>
        </div>


        {{-- Registro y login --}}
        @else
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">

                <li>
                    {{ Form::open(['route' => ['user.create'],
                                        'method' => 'GET',
                                        'class' => 'navbar-form',
                                        'role' => 'register']) }}

                    {{ Form::submit('Registrarse', ['class' => 'btn btn-link']) }}
                    {{ Form::close() }}
                </li>

                <li class="dropdown">
                    <a data-placement="bottom" data-toggle="login" data-container="body" class='btn'>Iniciar sesión</a>
                    @include('client.includes.login')
                </li>
            </ul>
        </div>
        @endif

    </div>
</nav>
